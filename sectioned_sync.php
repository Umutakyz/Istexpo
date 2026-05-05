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

echo "Starting SECTIONED Fair Sync...\n";

$response = Http::withoutVerifying()->get('https://www.istexpo.com/fuarlar');
if (!$response->successful()) {
    die("Could not fetch main list.\n");
}
$mainHtml = $response->body();

// Split by Geçmiş Fuarlar
$parts = explode('Geçmiş Fuarlar', $mainHtml);
$internationalHtml = $parts[0];
$pastHtml = isset($parts[1]) ? $parts[1] : '';

preg_match_all('/href="(\/fuarlar\/\d+-[^"]+)"/i', $internationalHtml, $intlMatches);
preg_match_all('/href="(\/fuarlar\/\d+-[^"]+)"/i', $pastHtml, $pastMatches);

$intlUrls = array_unique($intlMatches[1]);
$pastUrls = array_unique($pastMatches[1]);

echo "Found " . count($intlUrls) . " international and " . count($pastUrls) . " past fairs.\n";

function processFair($url, $type, $tr, $months) {
    $fullUrl = 'https://www.istexpo.com' . $url;
    echo "Processing ($type): $fullUrl\n";
    
    try {
        $detailResponse = Http::withoutVerifying()->get($fullUrl);
        if (!$detailResponse->successful()) return;
        $html = $detailResponse->body();
        
        preg_match('/<div class="fuar-detail-card-logo">.*?<h4>(.*?)<\/h4>/s', $html, $nameMatch);
        if (!isset($nameMatch[1])) preg_match('/<h1.*?>(.*?)<\/h1>/s', $html, $nameMatch);
        $name = isset($nameMatch[1]) ? trim(strip_tags($nameMatch[1])) : 'Unknown';
        
        if ($name === 'Unknown') {
            preg_match('/<title>(.*?) - ISTexpo/s', $html, $titleMatch);
            if (isset($titleMatch[1])) $name = trim(explode(' - ', $titleMatch[1])[0]);
        }

        $slug = Str::slug($name);
        $fair = Fair::where('slug', $slug)->first() ?: new Fair(['slug' => $slug]);
        $fair->name = $name;
        $fair->type = $type;
        $fair->location = $fair->location ?: 'International';

        // Date
        preg_match('/Düzenlenme Tarihi:.*?<\/li>/s', $html, $dateLiMatch);
        if (isset($dateLiMatch[0])) {
            $dateStr = trim(strip_tags($dateLiMatch[0]));
            $dateStr = str_replace('Düzenlenme Tarihi:', '', $dateStr);
            $parts = array_values(array_filter(explode(' ', str_replace(["\r", "\n", "\t"], ' ', trim($dateStr)))));
            if (count($parts) >= 5) {
                $year = end($parts);
                $month = $months[$parts[count($parts)-2]] ?? '01';
                try {
                    $fair->start_date = Carbon::createFromFormat('Y-m-d', "$year-$month-{$parts[0]}");
                    $fair->end_date = Carbon::createFromFormat('Y-m-d', "$year-$month-{$parts[2]}");
                } catch (\Exception $e) {}
            }
        }
        if (!$fair->start_date) { $fair->start_date = Carbon::now(); $fair->end_date = Carbon::now(); }

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
                preg_match('/' . preg_quote($label) . '.*?<span>(.*?)<\/span>/s', $html, $m);
                if (!isset($m[1])) preg_match('/' . preg_quote($label) . '\s*(.*?)<\/li>/s', $html, $m);
                if (isset($m[1])) {
                    $val = trim(strip_tags($m[1]));
                    if ($val) { $fair->$field = $val; break; }
                }
            }
        }

        preg_match('/Web Sitesi:.*?href="(.*?)"/', $html, $m);
        if ($m) $fair->website = $m[1];

        preg_match('/<div class="fuar-detail-parag">(.*?)<\/div>/s', $html, $descMatch);
        if (isset($descMatch[1])) {
            $desc = trim(preg_replace('/<h2>.*?<\/h2>/s', '', $descMatch[1]));
            if ($desc) $fair->description = $desc;
        }

        preg_match('/Katılımcı Profili<\/h4>\s*<ul.*?>(.*?)<\/ul>/s', $html, $profMatch);
        if (isset($profMatch[1])) $fair->exhibitor_profile = trim($profMatch[1]);

        // Images
        if (empty($fair->image)) {
            preg_match('/<div class="fuar-detail-card-image".*?url\((.*?)\)/s', $html, $imgMatch);
            if (isset($imgMatch[1])) {
                $imgUrl = 'https://www.istexpo.com' . trim($imgMatch[1], '\' "');
                $imgPath = 'fairs/' . basename($imgUrl);
                \Illuminate\Support\Facades\Storage::disk('public')->put($imgPath, Http::withoutVerifying()->get($imgUrl)->body());
                $fair->image = $imgPath;
            }
        }

        // Translation
        try {
            $fair->name_en = $tr->translate($fair->name);
            if ($fair->description) $fair->description_en = $tr->translate($fair->description);
            if ($fair->location) $fair->location_en = $tr->translate($fair->location);
        } catch (\Exception $e) {}

        $fair->save();
        echo "Saved: {$fair->name}\n";
    } catch (\Exception $e) { echo "Error for $url: " . $e->getMessage() . "\n"; }
}

foreach ($intlUrls as $url) processFair($url, 'international', $tr, $months);
foreach ($pastUrls as $url) processFair($url, 'past', $tr, $months);

echo "SECTIONED Sync Completed!\n";
