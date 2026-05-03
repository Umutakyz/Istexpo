<?php

namespace App\Console\Commands;

use App\Models\Representation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ImportRepresentations extends Command
{
    protected $signature = 'import:representations';
    protected $description = 'Import representations from istexpo.com';

    public function handle()
    {
        $this->info('Fetching representations from istexpo.com...');
        
        $response = Http::withoutVerifying()->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
        ])->get('https://www.istexpo.com/temsilciliklerimiz');

        if (!$response->successful()) {
            $this->error('Could not fetch the page.');
            return;
        }

        $html = $response->body();
        
        // Temsilcilik bölümlerini ayır (h3 veya h2 başlıklarına göre)
        $sections = preg_split('/<h[23](.*?)>(.*?)<\/h[23]>/s', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        
        $count = 0;
        // $sections[2] = Başlık, $sections[3] = İçerik (bir sonraki başlığa kadar)
        for ($i = 2; $i < count($sections); $i += 3) {
            $name = trim(strip_tags($sections[$i]));
            $content = $sections[$i+1];

            if (empty($name) || strlen($name) < 3) continue;
            // Bazı menü başlıklarını ele
            if (in_array(strtoupper($name), ['MENÜ', 'TR', 'EN', 'ANASAYFA', 'HAKKIMIZDA', 'TEMSİLCİLİKLERİMİZ', 'FUARLAR', 'DEVLET DESTEKLERİ', 'HABERLER', 'İLETİŞİM', 'SOSYAL MEDYA', 'BİZE ULAŞIN'])) continue;

            $data = $this->parseContent($name, $content);
            if ($data) {
                $data['order'] = $count;
                $this->saveRepresentation($data);
                $count++;
            }
        }

        $this->info("Imported $count representations successfully.");
    }

    protected function parseContent($name, $content)
    {
        // Logo
        preg_match('/<img.*?src="(.*?)"/s', $content, $imgMatch);
        $logoUrl = isset($imgMatch[1]) ? $imgMatch[1] : null;

        // Website
        preg_match('/href="(http.*?)"/s', $content, $webMatch);
        $website = isset($webMatch[1]) ? $webMatch[1] : null;

        // Description: Daha esnek bir temizleme yapalım
        // HTML etiketlerini temizle, linkleri ve resimleri çıkar, kalan metni al
        $description = preg_replace('/<img.*?>/s', '', $content);
        $description = preg_replace('/<a.*?>.*?<\/a>/s', '', $description);
        $description = trim(strip_tags($description));
        
        // Fazla boşlukları temizle
        $description = preg_replace('/\s+/', ' ', $description);

        return [
            'name' => $name,
            'logo_url' => $logoUrl,
            'description' => $description,
            'website' => $website
        ];
    }

    protected function saveRepresentation($data)
    {
        $localLogoPath = null;
        if ($data['logo_url']) {
            $fullUrl = strpos($data['logo_url'], 'http') === 0 ? $data['logo_url'] : 'https://www.istexpo.com' . $data['logo_url'];
            $imageResponse = Http::withoutVerifying()->get($fullUrl);
            if ($imageResponse->successful()) {
                $path = "representations/" . time() . "_" . basename($data['logo_url']);
                Storage::disk('public')->put($path, $imageResponse->body());
                $localLogoPath = $path;
            }
        }

        Representation::updateOrCreate(
            ['name' => $data['name']],
            [
                'logo' => $localLogoPath,
                'description' => $data['description'],
                'website' => $data['website'],
                'order' => $data['order']
            ]
        );

        $this->line("Processed: " . $data['name']);
    }
}
