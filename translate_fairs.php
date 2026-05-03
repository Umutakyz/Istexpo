<?php
define('LARAVEL_START', microtime(true));
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

function getFairs($url) {
    $html = Http::withoutVerifying()->get($url)->body();
    // Her bir fuar kartını ayrı ayrı yakalayalım
    preg_match_all('/<div class="fuar-list-card-content">(.*?)<\/div>/is', $html, $blocks);
    
    $fairs = [];
    foreach ($blocks[1] as $block) {
        if (preg_match('/<h5>(.*?)<\/h5>/is', $block, $nm) && preg_match_all('/<p>(.*?)<\/p>/is', $block, $pm)) {
            $name = trim(strip_tags($nm[1]));
            // 2. veya 3. p etiketi genellikle açıklamadır (ilk p boş olabiliyor)
            $summary = "";
            foreach ($pm[1] as $ptext) {
                $clean = trim(strip_tags($ptext));
                if (strlen($clean) > 20) { // Kısa olmayan ilk p'yi açıklama sayalım
                    $summary = $clean;
                    break;
                }
            }
            if ($name && $summary) {
                $fairs[$name] = $summary;
            }
        }
    }
    return $fairs;
}

echo "Veriler çekiliyor...\n";
$trFairs = getFairs('https://www.istexpo.com/fuarlar');
$enFairs = getFairs('https://www.istexpo.com/en/exhibitions');

echo "TR: " . count($trFairs) . " fair found.\n";
echo "EN: " . count($enFairs) . " fair found.\n";

$enJsonPath = base_path('lang/en.json');
$translations = json_decode(file_get_contents($enJsonPath), true);

$count = 0;
foreach ($trFairs as $name => $trSummary) {
    if (isset($enFairs[$name])) {
        $enSummary = $enFairs[$name];
        if ($trSummary !== $enSummary) {
            $translations[$trSummary] = $enSummary;
            $count++;
        }
    }
}

file_put_contents($enJsonPath, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "$count yeni çeviri en.json'a eklendi.\n";
