<?php
define('LARAVEL_START', microtime(true));
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;
use App\Models\Fair;

$fairs = Fair::all();
$count = 0;

foreach ($fairs as $fair) {
    // We try to fetch the detail page from the live site
    $url = 'https://www.istexpo.com/en/exhibitions/' . $fair->slug;
    
    try {
        $response = Http::withoutVerifying()->timeout(10)->get($url);
        
        if ($response->successful()) {
            $html = $response->body();
            
            // Try to extract the about fair section. In the old site, it's usually inside a specific div.
            // Let's look for "About Fair" or "Exhibitor Profile"
            
            // Old site structure:
            // <div class="fuar-detail-content"> ... </div> or something similar.
            if (preg_match('/<div class="col-lg-8 col-md-12">(.*?)<div class="col-lg-4 col-md-12">/is', $html, $m)) {
                $mainContent = $m[1]; // This contains description
                
                // Extract description: usually comes after <h5>About Fair</h5>
                if (preg_match('/<h5>About.*?<\/h5>(.*?)(?:<h5>|$)/is', $mainContent, $descMatch)) {
                    $enDesc = trim($descMatch[1]);
                    if (strlen($enDesc) > 50) {
                        $fair->description_en = $enDesc;
                        echo "Found DESC for {$fair->slug}\n";
                    }
                }
                
                // Extract exhibitor profile: usually comes after <h5>Exhibitor Profile</h5>
                if (preg_match('/<h5>Exhibitor.*?<\/h5>(.*?)(?:<h5>|$)/is', $mainContent, $profMatch)) {
                    $enProf = trim($profMatch[1]);
                    if (strlen($enProf) > 20) {
                        $fair->exhibitor_profile_en = $enProf;
                        echo "Found PROFILE for {$fair->slug}\n";
                    }
                }
                
                $fair->save();
                $count++;
            } else {
                 // Try another pattern
                 if (preg_match('/<h5>About.*?<\/h5>(.*?)(?:<h5>|<div)/is', $html, $descMatch)) {
                      $enDesc = trim($descMatch[1]);
                      $fair->description_en = $enDesc;
                      $fair->save();
                      echo "Found DESC (alt) for {$fair->slug}\n";
                 }
            }
        } else {
            // If the slug doesn't match the live site, we'll just leave it or fallback to TR description
            if (strlen($fair->description_en) < 50) {
                // If the current en desc is too short (like a date), fallback to TR description so it's not broken
                $fair->description_en = $fair->description;
                $fair->save();
                echo "Fallback to TR desc for {$fair->slug}\n";
            }
        }
    } catch (\Exception $e) {
        echo "Error fetching {$fair->slug}: " . $e->getMessage() . "\n";
    }
}

echo "\nDone processing fairs.\n";
