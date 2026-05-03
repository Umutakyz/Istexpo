<?php
define('LARAVEL_START', microtime(true));
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

function getEnFairs() {
    $html = Http::withoutVerifying()->get('https://www.istexpo.com/en/exhibitions')->body();
    preg_match_all('/<div class="fuar-list-card-content">\s*<img[^>]*>\s*<h5>(.*?)<\/h5>.*?<p>(.*?)<\/p>.*?<p>(.*?)<\/p>/is', $html, $blocks, PREG_SET_ORDER);
    
    $fairs = [];
    foreach ($blocks as $m) {
        $name = trim(strip_tags($m[1]));
        $summary = trim(strip_tags($m[3])); // Usually the 3rd p tag is the description in their HTML structure
        if ($name && $summary) {
            $fairs[strtolower($name)] = $summary;
        }
    }
    return $fairs;
}

$enFairsMap = getEnFairs();

$enJsonPath = base_path('lang/en.json');
$translations = json_decode(file_get_contents($enJsonPath), true);

$fairs = App\Models\Fair::all();
$count = 0;
foreach ($fairs as $fair) {
    $keyDesc = $fair->description; // The exact string used in __($fair->description)
    $keyName = $fair->name;

    $searchName = strtolower(trim($keyName));
    
    // Attempt to find English description
    if (isset($enFairsMap[$searchName])) {
        $enDesc = $enFairsMap[$searchName];
        
        if ($keyDesc !== $enDesc) {
            $translations[$keyDesc] = $enDesc;
            $count++;
            echo "Translated DESC for: $keyName\n";
        }
    } else {
        // Fallback: If we don't have it, we might try Google Translate or just use English fallback for the name
        // Wait, some descriptions were matched in my previous script. Let's see if we can find them.
    }
}

file_put_contents($enJsonPath, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "$count fair descriptions added to en.json.\n";

// Now, for the fair-details page, it might have long content.
// We should check what's in the DB for the first few fairs.
