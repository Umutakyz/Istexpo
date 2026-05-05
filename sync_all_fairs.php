<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Fair;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Str;

$months = [
    'Ocak' => '01', 'Şubat' => '02', 'Mart' => '03', 'Nisan' => '04',
    'Mayıs' => '05', 'Haziran' => '06', 'Temmuz' => '07', 'Ağustos' => '08',
    'Eylül' => '09', 'Ekim' => '10', 'Kasım' => '11', 'Aralık' => '12'
];

$fairs = Fair::all();

echo "Checking " . $fairs->count() . " fairs for date/desc accuracy...\n";

// Fetch main list once to avoid 80+ requests if possible
$response = Http::withoutVerifying()->get('https://www.istexpo.com/fuarlar');
if (!$response->successful()) {
    die("Could not fetch main list.\n");
}
$mainHtml = $response->body();

foreach ($fairs as $fair) {
    echo "Processing: {$fair->name} (Slug: {$fair->slug})...\n";
    
    // Find link in main list
    // Try by slug first
    $slugPart = Str::slug($fair->name);
    preg_match('/href="(\/fuarlar\/\d+-[^"]*' . preg_quote($slugPart) . '[^"]*)"/i', $mainHtml, $linkMatch);
    
    if (!$linkMatch) {
        // Try partial
        $partial = substr($slugPart, 0, 7);
        preg_match('/href="(\/fuarlar\/\d+-[^"]*' . preg_quote($partial) . '[^"]*)"/i', $mainHtml, $linkMatch);
    }

    if ($linkMatch) {
        $detailUrl = 'https://www.istexpo.com' . $linkMatch[1];
        echo "Found URL: $detailUrl\n";
        
        $detailResponse = Http::withoutVerifying()->get($detailUrl);
        if ($detailResponse->successful()) {
            $detailHtml = $detailResponse->body();
            
            // 1. Date Sync
            preg_match('/Düzenlenme Tarihi:.*?<\/li>/s', $detailHtml, $dateMatch);
            if (isset($dateMatch[0])) {
                $dateStr = trim(strip_tags($dateMatch[0]));
                $dateStr = str_replace('Düzenlenme Tarihi:', '', $dateStr);
                $dateStr = trim($dateStr);
                
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
                        
                        if ($fair->start_date->toDateString() !== $startDate->toDateString()) {
                            echo "Updating Date: " . $fair->start_date->toDateString() . " -> " . $startDate->toDateString() . "\n";
                            $fair->start_date = $startDate;
                            $fair->end_date = $endDate;
                        }
                    } catch (\Exception $e) {}
                }
            }
            
            // 2. Desc Sync (only if current is short or missing)
            if (strlen(strip_tags($fair->description)) < 100) {
                preg_match('/<div class="fuar-detail-parag">(.*?)<\/div>/s', $detailHtml, $descMatch);
                if (isset($descMatch[1])) {
                    $desc = trim(preg_replace('/<h2>.*?<\/h2>/s', '', $descMatch[1]));
                    if (strlen($desc) > 50) {
                        $fair->description = $desc;
                        echo "Description updated.\n";
                    }
                }
            }

            // 3. Other fields sync
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

            if ($fair->isDirty()) {
                $fair->save();
                echo "Fair updated.\n";
            }
        }
    } else {
        echo "URL not found for {$fair->name}\n";
    }
    echo "-------------------\n";
}
