<?php
define('LARAVEL_START', microtime(true));
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\News;

Storage::disk('public')->makeDirectory('news');

function downloadImage($url, $newsId) {
    try {
        $response = Http::withoutVerifying()->timeout(20)->get($url);
        if ($response->successful()) {
            $ext = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg');
            $ext = strtok($ext, '?&');
            if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) $ext = 'jpg';
            $filename = "news/news_{$newsId}.{$ext}";
            Storage::disk('public')->put($filename, $response->body());
            echo "  ✓ IMG OK: $filename\n";
            return $filename;
        }
    } catch (\Exception $e) {
        // fail silently
    }
    return null;
}

// Fetch TR news
$html = Http::withoutVerifying()->get('https://www.istexpo.com/haberler')->body();

// The news cards look like:
// <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
//     <div class="fuar-list-card">
//         <div class="fuar-list-card-content">
//             <img src="https://www.istexpo.com/upload/haberler/123.jpg" class="img-fluid" alt="">
//             <h5><a href="...">...</a></h5>

preg_match_all('/<div class="fuar-list-card-content">\s*<img[^>]+src="([^"]+)"[^>]*>\s*<h5>\s*<a[^>]*>(.*?)<\/a>\s*<\/h5>/is', $html, $matches, PREG_SET_ORDER);

$liveNewsMap = [];
foreach ($matches as $m) {
    $imgUrl = trim($m[1]);
    $title = trim(strip_tags($m[2]));
    // Sometimes URLs are relative
    if (strpos($imgUrl, 'http') === false) {
        $imgUrl = 'https://www.istexpo.com' . (str_starts_with($imgUrl, '/') ? '' : '/') . $imgUrl;
    }
    $liveNewsMap[strtolower($title)] = $imgUrl;
}

$news = News::all();
$count = 0;

foreach ($news as $item) {
    // If it already has an image, skip
    if ($item->image) continue;

    $searchTitle = strtolower(trim(html_entity_decode($item->title, ENT_QUOTES | ENT_HTML5, 'UTF-8')));
    
    // Find closest match because sometimes titles have small differences
    $bestMatchTitle = null;
    $bestPercent = 0;
    foreach ($liveNewsMap as $liveTitle => $img) {
        similar_text($searchTitle, $liveTitle, $percent);
        if ($percent > $bestPercent) {
            $bestPercent = $percent;
            $bestMatchTitle = $liveTitle;
        }
    }

    if ($bestPercent > 80 && $bestMatchTitle) {
        $imgUrl = $liveNewsMap[$bestMatchTitle];
        echo "Found thumbnail for [{$item->id}] $searchTitle\n  URL: $imgUrl\n";
        
        $local = downloadImage($imgUrl, $item->id);
        if ($local) {
            $item->image = $local;
            $item->save();
            $count++;
        }
    } else {
        echo "NO match for: $searchTitle (best was $bestPercent%)\n";
    }
}

echo "\nDone. Downloaded $count new thumbnails.\n";
