<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Fair;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Stichoza\GoogleTranslate\GoogleTranslate;

$tr = new GoogleTranslate('en');
$tr->setSource('tr');
$tr->setOptions(['verify' => false]);

$months = [
    'Ocak' => '01', 'Şubat' => '02', 'Mart' => '03', 'Nisan' => '04',
    'Mayıs' => '05', 'Haziran' => '06', 'Temmuz' => '07', 'Ağustos' => '08',
    'Eylül' => '09', 'Ekim' => '10', 'Kasım' => '11', 'Aralık' => '12'
];

echo "Starting ULTIMATE Fair Sync...\n";

$response = Http::withoutVerifying()->get('https://www.istexpo.com/fuarlar');
if (!$response->successful()) {
    die("Could not fetch main list.\n");
}
$mainHtml = $response->body();

// Extract all detail URLs
preg_match_all('/href="(\/fuarlar\/\d+-[^"]+)"/i', $mainHtml, $matches);
$urls = array_unique($matches[1]);

echo "Found " . count($urls) . " fairs to process.\n";

foreach ($urls as $url) {
    $fullUrl = 'https://www.istexpo.com' . $url;
    echo "Processing: $fullUrl\n";
    
    try {
        $detailResponse = Http::withoutVerifying()->get($fullUrl);
        if (!$detailResponse->successful()) {
            echo "Failed to fetch: $fullUrl\n";
            continue;
        }
        $html = $detailResponse->body();
        
        // Extract data
        // Try h4 first (it's inside the logo card)
        preg_match('/<div class="fuar-detail-card-logo">.*?<h4>(.*?)<\/h4>/s', $html, $nameMatch);
        if (!isset($nameMatch[1])) {
            preg_match('/<h1.*?>(.*?)<\/h1>/s', $html, $nameMatch);
        }
        $name = isset($nameMatch[1]) ? trim(strip_tags($nameMatch[1])) : 'Unknown';
        
        if ($name === 'Unknown') {
            // Fallback: try to extract from title
            preg_match('/<title>(.*?) - ISTexpo/s', $html, $titleMatch);
            if (isset($titleMatch[1])) {
                $parts = explode(' - ', $titleMatch[1]);
                $name = trim($parts[0]);
            }
        }

        $slug = Str::slug($name);
        $fair = Fair::where('slug', $slug)->first() ?: new Fair(['slug' => $slug]);
        $fair->name = $name;
        $fair->location = 'International'; 
        
        // Type
        if (strpos($url, 'gecmis-fuarlar') !== false) {
            $fair->type = 'past';
        } else {
            $fair->type = 'international';
        }

        // Date extraction (new method for better reliability)
        preg_match('/Düzenlenme Tarihi:.*?<\/li>/s', $html, $dateLiMatch);
        if (isset($dateLiMatch[0])) {
            $dateStr = trim(strip_tags($dateLiMatch[0]));
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
                    $fair->start_date = Carbon::createFromFormat('Y-m-d', "$year-$month-$startDay");
                    $fair->end_date = Carbon::createFromFormat('Y-m-d', "$year-$month-$endDay");
                } catch (\Exception $e) {}
            }
        }
        if (!$fair->start_date) {
            $fair->start_date = Carbon::now();
            $fair->end_date = Carbon::now();
        }

        // Robust Field Extraction
        $fields = [
            'subject' => ['Fuarın Konusu:', 'Fuar Konusu:'],
            'location' => ['Şehir - Ülke:', 'Ülke-Şehir:', 'Şehir-Ülke:', 'Lokasyon:'],
            'venue' => ['Fuar Alanı:', 'Mekan:'],
            'organizer' => ['Organizatör:'],
            'edition' => ['Düzenlenme Sayısı:', 'Kaçıncı Kez:'],
            'grant_amount' => ['Teşvik Rakamı:']
        ];

        foreach ($fields as $field => $labels) {
            foreach ($labels as $label) {
                // Try with span first, then without
                preg_match('/' . preg_quote($label) . '.*?<span>(.*?)<\/span>/s', $html, $m);
                if (!isset($m[1])) {
                    preg_match('/' . preg_quote($label) . '\s*(.*?)<\/li>/s', $html, $m);
                }
                
                if (isset($m[1])) {
                    $val = trim(strip_tags($m[1]));
                    if ($val) {
                        $fair->$field = $val;
                        break;
                    }
                }
            }
        }

        preg_match('/Web Sitesi:.*?href="(.*?)"/', $html, $m);
        if ($m) $fair->website = $m[1];

        // Description
        preg_match('/<div class="fuar-detail-parag">(.*?)<\/div>/s', $html, $descMatch);
        if (isset($descMatch[1])) {
            $desc = trim(preg_replace('/<h2>.*?<\/h2>/s', '', $descMatch[1]));
            if ($desc) $fair->description = $desc;
        }

        // Exhibitor Profile
        preg_match('/Katılımcı Profili<\/h4>\s*<ul.*?>(.*?)<\/ul>/s', $html, $profMatch);
        if (isset($profMatch[1])) {
            $fair->exhibitor_profile = trim($profMatch[1]);
        }

        // Image & Logo
        if (empty($fair->image)) {
            preg_match('/<div class="fuar-detail-card-image".*?url\((.*?)\)/s', $html, $imgMatch);
            if (isset($imgMatch[1])) {
                $imgUrl = 'https://www.istexpo.com' . trim($imgMatch[1], '\' "');
                $imgData = Http::withoutVerifying()->get($imgUrl)->body();
                $imgPath = 'fairs/' . basename($imgUrl);
                \Illuminate\Support\Facades\Storage::disk('public')->put($imgPath, $imgData);
                $fair->image = $imgPath;
            }
        }

        if (empty($fair->logo)) {
            preg_match('/<div class="fuar-detail-card-logo">.*?src="(.*?)"/s', $html, $logoMatch);
            if (isset($logoMatch[1])) {
                $logoUrl = 'https://www.istexpo.com' . $logoMatch[1];
                $logoData = Http::withoutVerifying()->get($logoUrl)->body();
                $logoPath = 'fairs/logos/' . basename($logoMatch[1]);
                \Illuminate\Support\Facades\Storage::disk('public')->put($logoPath, $logoData);
                $fair->logo = $logoPath;
            }
        }

        // Automatic Translation
        try {
            $fair->name_en = $tr->translate($fair->name);
            if ($fair->subject) $fair->subject_en = $tr->translate($fair->subject);
            if ($fair->location) $fair->location_en = $tr->translate($fair->location);
            if ($fair->venue) $fair->venue_en = $tr->translate($fair->venue);
            if ($fair->organizer) $fair->organizer_en = $tr->translate($fair->organizer);
            if ($fair->edition) $fair->edition_en = $tr->translate($fair->edition);
            if ($fair->description) $fair->description_en = $tr->translate($fair->description);
            if ($fair->exhibitor_profile) $fair->exhibitor_profile_en = $tr->translate($fair->exhibitor_profile);
        } catch (\Exception $e) {
            echo "Translation failed for {$fair->name}\n";
        }

        $fair->save();
        echo "Saved: {$fair->name}\n";
        
    } catch (\Exception $e) {
        echo "Global error for $fullUrl: " . $e->getMessage() . "\n";
    }
}

echo "ULTIMATE Sync Completed!\n";
