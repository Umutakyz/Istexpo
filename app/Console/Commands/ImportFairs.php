<?php

namespace App\Console\Commands;

use App\Models\Fair;
use App\Models\Sector;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ImportFairs extends Command
{
    protected $signature = 'import:fairs';
    protected $description = 'Import fairs and their full details from istexpo.com with error resilience';

    protected $months = [
        'Ocak' => '01', 'Şubat' => '02', 'Mart' => '03', 'Nisan' => '04',
        'Mayıs' => '05', 'Haziran' => '06', 'Temmuz' => '07', 'Ağustos' => '08',
        'Eylül' => '09', 'Ekim' => '10', 'Kasım' => '11', 'Aralık' => '12'
    ];

    public function handle()
    {
        $this->info('Starting resilient deep import from istexpo.com...');
        
        try {
            $response = Http::withoutVerifying()->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            ])->timeout(30)->get('https://www.istexpo.com/fuarlar');
        } catch (\Exception $e) {
            $this->error('Main page connection failed: ' . $e->getMessage());
            return;
        }

        if (!$response->successful()) {
            $this->error('Could not fetch the list page.');
            return;
        }

        $html = $response->body();
        $sections = preg_split('/<h4 class="classic-title"><span>(.*?)<\/span><\/h4>/', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        
        $count = 0;
        for ($i = 1; $i < count($sections); $i += 2) {
            $sectionTitle = $sections[$i];
            $sectionHtml = $sections[$i+1];
            $type = (strpos($sectionTitle, 'Geçmiş') !== false) ? 'past' : 'international';
            
            $this->info("Section: $sectionTitle");

            preg_match_all('/<div class="fuar-list-card">.*?<\/div>\s*<\/div>\s*<\/div>/s', $sectionHtml, $matches);
            
            foreach ($matches[0] as $card) {
                try {
                    $data = $this->parseCard($card);
                    if ($data) {
                        $data['type'] = $type;
                        $this->processFair($data);
                        $count++;
                    }
                } catch (\Exception $e) {
                    $this->warn("Skipping a fair due to error: " . $e->getMessage());
                }
            }
        }

        $this->info("Successfully processed $count fairs.");
    }

    protected function parseCard($card)
    {
        preg_match('/<h5>(.*?)<\/h5>/', $card, $nameMatch);
        $name = isset($nameMatch[1]) ? trim($nameMatch[1]) : null;

        preg_match('/background-image:url\((.*?)\)/', $card, $imgMatch);
        $imageUrl = isset($imgMatch[1]) ? $imgMatch[1] : null;

        preg_match('/href="(.*?)"/', $card, $linkMatch);
        $detailUrl = isset($linkMatch[1]) ? $linkMatch[1] : null;

        if (!$name) return null;

        return [
            'name' => $name,
            'image_url' => $imageUrl,
            'detail_url' => $detailUrl ? 'https://www.istexpo.com' . $detailUrl : null
        ];
    }

    protected function processFair($data)
    {
        $this->line("Processing: " . $data['name']);
        
        $fullDescription = '';
        $location = 'International';
        $startDate = now();
        $endDate = now();

        if ($data['detail_url']) {
            try {
                $detailResponse = Http::withoutVerifying()->timeout(20)->get($data['detail_url']);
                if ($detailResponse->successful()) {
                    $detailHtml = $detailResponse->body();
                    
                    // Lokasyon
                    preg_match('/Şehir - Ülke:<\/b>\s*(.*?)<\/li>/', $detailHtml, $locMatch);
                    if (!$locMatch) preg_match('/Ülke-Şehir:<\/b>\s*(.*?)<\/li>/', $detailHtml, $locMatch);
                    $location = isset($locMatch[1]) ? trim(strip_tags($locMatch[1])) : 'International';

                    // Tarih
                    preg_match('/Düzenlenme Tarihi:<\/b>\s*<br>\s*(.*?)\s*<\/li>/s', $detailHtml, $dateMatch);
                    $dateStr = isset($dateMatch[1]) ? trim(strip_tags($dateMatch[1])) : null;
                    if ($dateStr) {
                        $parts = array_values(array_filter(explode(' ', str_replace(["\r", "\n", "\t"], ' ', $dateStr))));
                        if (count($parts) >= 5) {
                            $year = end($parts);
                            $month = $this->months[$parts[count($parts)-2]] ?? '01';
                            try {
                                $startDate = Carbon::parse("$year-$month-$parts[0]");
                                $endDate = Carbon::parse("$year-$month-$parts[2]");
                            } catch (\Exception $e) {}
                        }
                    }

                    // Doğru selector: fuar-detail-parag içindeki paragraflar
                    preg_match('/<div class="fuar-detail-parag">(.*?)<\/div>\s*<\/div>/s', $detailHtml, $descMatch);

                    if (isset($descMatch[1])) {
                        $rawContent = $descMatch[1];
                        // h2 başlığını kaldır
                        $rawContent = preg_replace('/<h2>.*?<\/h2>/s', '', $rawContent);
                        // Tüm paragrafları al ve HTML entities çöz
                        preg_match_all('/<p>(.*?)<\/p>/s', $rawContent, $pMatches);
                        $parts = [];
                        foreach ($pMatches[1] as $p) {
                            $text = html_entity_decode(strip_tags($p), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                            $text = trim($text);
                            if (!empty($text)) {
                                $parts[] = $text;
                            }
                        }
                        $fullDescription = implode("\n\n", $parts);
                    }
                }
            } catch (\Exception $e) {
                $this->warn("Could not fetch details for " . $data['name']);
            }
        }

        $localImagePath = null;
        if ($data['image_url']) {
            try {
                $imgUrl = 'https://www.istexpo.com' . $data['image_url'];
                $imageResponse = Http::withoutVerifying()->timeout(15)->get($imgUrl);
                if ($imageResponse->successful()) {
                    $path = "fairs/" . time() . "_" . basename($data['image_url']);
                    Storage::disk('public')->put($path, $imageResponse->body());
                    $localImagePath = $path;
                }
            } catch (\Exception $e) {
                $this->warn("Image download failed for " . $data['name']);
            }
        }

        $slug = Str::slug($data['name']);

        // Mevcut kaydı al
        $existing = Fair::where('slug', $slug)->first();

        // Güncelleme verilerini hazırla
        $updateData = [
            'name' => $data['name'],
            'sector_id' => 1,
            'type' => $data['type'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'location' => $location,
            'image' => $localImagePath ?? ($existing->image ?? null),
        ];

        // Sadece gerçek bir açıklama çekilebildiyse description'ı güncelle
        // Çekilemediyse mevcut açıklamayı koru (üzerine fuar adı yazma)
        if (strlen($fullDescription) > 20) {
            $updateData['description'] = $fullDescription;
        } elseif (!$existing || strlen($existing->description ?? '') < 20) {
            // Mevcut açıklama da yoksa en azından fuar adını yaz
            $updateData['description'] = $data['name'];
        }
        // Aksi halde mevcut description olduğu gibi kalır

        Fair::updateOrCreate(['slug' => $slug], $updateData);
    }
}
