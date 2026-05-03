<?php
define('LARAVEL_START', microtime(true));
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

Storage::disk('public')->makeDirectory('news');

function downloadImage($url, $newsId) {
    try {
        $cleanUrl = html_entity_decode($url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $response = Http::withoutVerifying()->timeout(20)->get($cleanUrl);
        if ($response->successful() && strlen($response->body()) > 5000) {
            $ext = strtolower(pathinfo(parse_url($cleanUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg');
            $ext = strtok($ext, '?&');
            if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) $ext = 'jpg';
            $filename = "news/news_{$newsId}.{$ext}";
            Storage::disk('public')->put($filename, $response->body());
            echo "  ✓ IMG: $filename (" . number_format(strlen($response->body())/1024, 1) . " KB)\n";
            return $filename;
        } else {
            echo "  ✗ IMG too small or failed (" . strlen($response->body()) . " bytes)\n";
        }
    } catch (\Exception $e) {
        echo "  ✗ IMG ERR: " . $e->getMessage() . "\n";
    }
    return null;
}

$news = App\Models\News::whereNull('image')->get();
echo count($news) . " haberin görseli eksik.\n\n";

foreach ($news as $item) {
    echo "[{$item->id}] " . substr($item->title, 0, 50) . "\n";

    if (!$item->content) {
        echo "  NO CONTENT\n";
        continue;
    }

    // Content içindeki tüm img src'leri bul
    // HTML encoded olabilir: &lt;img src=&quot;...&quot; veya doğrudan <img src="...">
    $decodedContent = html_entity_decode($item->content, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    if (preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $decodedContent, $imgs)) {
        echo "  " . count($imgs[1]) . " img found in content\n";
        foreach ($imgs[1] as $imgUrl) {
            if (filter_var($imgUrl, FILTER_VALIDATE_URL)) {
                $local = downloadImage($imgUrl, $item->id);
                if ($local) {
                    $item->image = $local;
                    // Also decode content and store it cleaned
                    $item->content = $decodedContent;
                    $item->save();
                    break;
                }
            }
        }
    } else {
        echo "  No img tags in content\n";
    }
}

// Summary: how many have images now
$total = App\Models\News::count();
$withImg = App\Models\News::whereNotNull('image')->count();
echo "\nFinal: $withImg / $total haberde görsel var.\n";
