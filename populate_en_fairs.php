<?php
define('LARAVEL_START', microtime(true));
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;
use App\Models\Fair;

function getEnFairs() {
    $html = Http::withoutVerifying()->get('https://www.istexpo.com/en/exhibitions')->body();
    preg_match_all('/<div class="fuar-list-card-content">\s*<img[^>]*>\s*<h5>(.*?)<\/h5>.*?<p>(.*?)<\/p>.*?<p>(.*?)<\/p>/is', $html, $blocks, PREG_SET_ORDER);
    
    $fairs = [];
    foreach ($blocks as $m) {
        $name = trim(strip_tags($m[1]));
        $summary = trim(strip_tags($m[3]));
        if ($name && $summary) {
            $fairs[strtolower($name)] = [
                'name_en' => $name,
                'description_en' => $summary,
            ];
        }
    }
    return $fairs;
}

$enFairsMap = getEnFairs();

$fairs = Fair::all();
$count = 0;

foreach ($fairs as $fair) {
    $searchName = strtolower(trim($fair->name));
    
    if (isset($enFairsMap[$searchName])) {
        $fair->name_en = $enFairsMap[$searchName]['name_en'];
        $fair->description_en = $enFairsMap[$searchName]['description_en'];
        // For exhibitor_profile, we might just copy it over if no English exists, but wait, usually it's a generic text.
        // We will just let it be null for now, and handle the fallback in the view.
        $fair->save();
        $count++;
        echo "Updated EN fields for: {$fair->name}\n";
    }
}

echo "$count fairs updated with English data.\n";
