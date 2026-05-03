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
            $filename = "news/news_thumb_{$newsId}.{$ext}";
            Storage::disk('public')->put($filename, $response->body());
            return $filename;
        }
    } catch (\Exception $e) {
        // silently ignore
    }
    return null;
}

$html = file_get_contents('https://www.istexpo.com/haberler');

preg_match_all('/<img[^>]+src="([^"]+uploads\/news[^"]+)"[^>]*>.*?<h[1-6][^>]*>(.*?)<\/h[1-6]>/is', $html, $matches);

$liveNewsMap = [];
for ($i=0; $i < count($matches[1]); $i++) {
    $imgUrl = trim($matches[1][$i]);
    $title = trim(strip_tags($matches[2][$i]));
    
    if (strpos($imgUrl, 'http') === false) {
        $imgUrl = 'https://www.istexpo.com' . (str_starts_with($imgUrl, '/') ? '' : '/') . $imgUrl;
    }
    $liveNewsMap[strtolower($title)] = $imgUrl;
}

$news = News::all();
$count = 0;

foreach ($news as $item) {
    // skip if already has an image? Actually let's overwrite if we find a good thumbnail
    $searchTitle = strtolower(trim(html_entity_decode($item->title, ENT_QUOTES | ENT_HTML5, 'UTF-8')));
    
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
        echo "Match: [{$item->id}] $searchTitle ($bestPercent%)\n  IMG: $imgUrl\n";
        
        $local = downloadImage($imgUrl, $item->id);
        if ($local) {
            $item->image = $local;
            $item->save();
            $count++;
            echo "  ✓ Saved: $local\n";
        }
    }
}

echo "\nCompleted. Downloaded $count thumbnails.\n";
