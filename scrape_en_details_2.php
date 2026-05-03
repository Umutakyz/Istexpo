<?php
define('LARAVEL_START', microtime(true));
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Fair;

$html = Http::withoutVerifying()->get('https://www.istexpo.com/en/exhibitions')->body();
preg_match_all('/<a[^>]+href="([^"]+)"[^>]*>.*?<\/h5>/is', $html, $matches);
$urls = array_unique($matches[1]);

$fairs = Fair::all();
$count = 0;

foreach ($fairs as $fair) {
    // find the matching URL
    $targetUrl = null;
    $slugClean = str_replace('-', '', $fair->slug); // simplified matching
    
    foreach ($urls as $u) {
        $uClean = str_replace('-', '', basename($u));
        // check if url contains our slug or vice versa
        if (strpos($uClean, $slugClean) !== false || strpos($slugClean, preg_replace('/^\d+/', '', $uClean)) !== false) {
            $targetUrl = 'https://www.istexpo.com' . $u;
            break;
        }
    }
    
    if ($targetUrl) {
        echo "Fetching: $targetUrl\n";
        try {
            $response = Http::withoutVerifying()->timeout(10)->get($targetUrl);
            if ($response->successful()) {
                $detailHtml = $response->body();
                
                // Old site structure
                if (preg_match('/<div class="col-lg-8 col-md-12">(.*?)<div class="col-lg-4 col-md-12">/is', $detailHtml, $m)) {
                    $mainContent = $m[1];
                    
                    if (preg_match('/<h5>About.*?<\/h5>(.*?)(?:<h5>|$)/is', $mainContent, $descMatch)) {
                        $enDesc = trim($descMatch[1]);
                        if (strlen($enDesc) > 50) {
                            $fair->description_en = $enDesc;
                            echo "  -> Found DESC\n";
                        }
                    }
                    
                    if (preg_match('/<h5>Exhibitor.*?<\/h5>(.*?)(?:<h5>|$)/is', $mainContent, $profMatch)) {
                        $enProf = trim($profMatch[1]);
                        if (strlen($enProf) > 20) {
                            $fair->exhibitor_profile_en = $enProf;
                            echo "  -> Found PROFILE\n";
                        }
                    }
                    
                    $fair->save();
                    $count++;
                } else {
                     if (preg_match('/<h5>About.*?<\/h5>(.*?)(?:<h5>|<div)/is', $detailHtml, $descMatch)) {
                          $enDesc = trim($descMatch[1]);
                          if(strlen($enDesc) > 50) {
                              $fair->description_en = $enDesc;
                              $fair->save();
                              echo "  -> Found DESC (alt)\n";
                          }
                     }
                }
            }
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    } else {
        echo "No matching URL for {$fair->slug}\n";
    }
    
    // Fallback if still empty or very short
    if (strlen($fair->description_en) < 50) {
        $fair->description_en = $fair->description; // fallback to Turkish so layout isn't broken
        $fair->save();
        echo "  -> Fallback to TR for {$fair->slug}\n";
    }
    if (!$fair->exhibitor_profile_en && $fair->exhibitor_profile) {
        $fair->exhibitor_profile_en = $fair->exhibitor_profile;
        $fair->save();
    }
}

echo "\nProcessed $count detail pages.\n";
