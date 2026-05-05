<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Fair;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

$months = [
    'Ocak' => '01', 'Şubat' => '02', 'Mart' => '03', 'Nisan' => '04',
    'Mayıs' => '05', 'Haziran' => '06', 'Temmuz' => '07', 'Ağustos' => '08',
    'Eylül' => '09', 'Ekim' => '10', 'Kasım' => '11', 'Aralık' => '12'
];

// Fairs with wrong dates (2026-05-05)
$fairs = Fair::whereDate('start_date', '2026-05-05')->get();

echo "Found " . $fairs->count() . " fairs to fix.\n";

foreach ($fairs as $fair) {
    echo "Processing: {$fair->name}...\n";
    
    // Attempt to find the detail page on istexpo.com
    // We can try to guess the URL or search for it.
    // Given the previous files, they have IDs like 15-dairy-tech.
    // Let's try to fetch the main list and find the link.
    
    $searchSlug = str_replace('+', '-', strtolower($fair->slug));
    if ($fair->slug == 'dairy-tech') $searchSlug = 'dairy-tech';
    
    // We'll fetch the main list to find the correct detail URL
    $response = Http::withoutVerifying()->get('https://www.istexpo.com/fuarlar');
    if (!$response->successful()) {
        echo "Could not fetch main list.\n";
        continue;
    }
    
    $html = $response->body();
    // Find link containing the name or slug
    // e.g. <a href="/fuarlar/15-dairy-tech">
    preg_match('/href="(\/fuarlar\/\d+-[^"]*' . preg_quote(Str::slug($fair->name)) . '[^"]*)"/i', $html, $linkMatch);
    
    if (!$linkMatch) {
        // Try fallback with partial name
        $partial = substr(Str::slug($fair->name), 0, 5);
        preg_match('/href="(\/fuarlar\/\d+-[^"]*' . preg_quote($partial) . '[^"]*)"/i', $html, $linkMatch);
    }

    if ($linkMatch) {
        $detailUrl = 'https://www.istexpo.com' . $linkMatch[1];
        echo "Found URL: $detailUrl\n";
        
        $detailResponse = Http::withoutVerifying()->get($detailUrl);
        if ($detailResponse->successful()) {
            $detailHtml = $detailResponse->body();
            
            // 1. Fix Date
            preg_match('/Düzenlenme Tarihi:.*?<\/li>/s', $detailHtml, $dateMatch);
            if (isset($dateMatch[0])) {
                $dateStr = trim(strip_tags($dateMatch[0]));
                $dateStr = str_replace('Düzenlenme Tarihi:', '', $dateStr);
                $dateStr = trim($dateStr);
                echo "Parsed Date String: $dateStr\n";
                
                // Format: "21 - 23 Ocak 2025" or "19 - 22 Ekim 2023"
                $parts = array_values(array_filter(explode(' ', str_replace(["\r", "\n", "\t"], ' ', $dateStr))));
                if (count($parts) >= 5) {
                    $year = end($parts);
                    $monthName = $parts[count($parts)-2];
                    $month = $months[$monthName] ?? '01';
                    $startDay = $parts[0];
                    $endDay = $parts[2];
                    
                    try {
                        $startDate = Carbon::createFromFormat('Y-m-d', "$year-$month-$startDay");
                        $endDate = Carbon::createFromFormat('Y-m-d', "$year-$month-$endDay");
                        
                        $fair->start_date = $startDate;
                        $fair->end_date = $endDate;
                        echo "New Dates: " . $startDate->toDateString() . " - " . $endDate->toDateString() . "\n";
                    } catch (\Exception $e) {
                        echo "Date creation failed: " . $e->getMessage() . "\n";
                    }
                }
            }
            
            // 2. Fix Description
            preg_match('/<div class="fuar-detail-parag">(.*?)<\/div>/s', $detailHtml, $descMatch);
            if (isset($descMatch[1])) {
                $desc = $descMatch[1];
                $desc = preg_replace('/<h2>.*?<\/h2>/s', '', $desc);
                $desc = trim($desc);
                if (strlen($desc) > 50) {
                    $fair->description = $desc;
                    echo "Description updated.\n";
                }
            }
            
            // 3. Fix Other Fields
            preg_match('/Şehir - Ülke:<\/b>\s*(.*?)<\/li>/', $detailHtml, $locMatch);
            if (!$locMatch) preg_match('/Ülke-Şehir:<\/b>\s*(.*?)<\/li>/', $detailHtml, $locMatch);
            if ($locMatch) $fair->location = trim(strip_tags($locMatch[1]));

            preg_match('/Fuar Alanı:<\/b>\s*(.*?)<\/li>/', $detailHtml, $venueMatch);
            if ($venueMatch) $fair->venue = trim(strip_tags($venueMatch[1]));

            preg_match('/Organizatör:<\/b>\s*(.*?)<\/li>/', $detailHtml, $orgMatch);
            if ($orgMatch) $fair->organizer = trim(strip_tags($orgMatch[1]));

            preg_match('/Düzenlenme Sayısı:<\/b>\s*(.*?)<\/li>/', $detailHtml, $edMatch);
            if ($edMatch) $fair->edition = trim(strip_tags($edMatch[1]));

            preg_match('/Web Sitesi:.*?href="(.*?)"/', $detailHtml, $webMatch);
            if ($webMatch) $fair->website = $webMatch[1];

            // Katılımcı Profili
            preg_match('/<div class="fuar-detail-visitor-profile">.*?<ul>(.*?)<\/ul>/s', $detailHtml, $profMatch);
            if ($profMatch) {
                $fair->exhibitor_profile = trim($profMatch[1]);
            }

            $fair->save();
            echo "Fair saved.\n";
        }
    } else {
        echo "Could not find URL for {$fair->name}\n";
    }
    echo "-------------------\n";
}
