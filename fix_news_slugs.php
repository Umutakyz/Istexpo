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
        $response = Http::withoutVerifying()->timeout(20)->get($url);
        if ($response->successful() && strlen($response->body()) > 5000) {
            $ext = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg');
            $ext = strtok($ext, '?&');
            if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) $ext = 'jpg';
            $filename = "news/news_{$newsId}.{$ext}";
            Storage::disk('public')->put($filename, $response->body());
            echo "  IMG OK: $filename\n";
            return $filename;
        }
    } catch (\Exception $e) {
        echo "  IMG FAIL: " . $e->getMessage() . "\n";
    }
    return null;
}

// 1) Aynı başlıktaki duplicate'leri sil - içerik olan olanı tut
$all = App\Models\News::orderBy('id')->get();
$seenTitles = [];
foreach ($all as $item) {
    $cleanTitle = html_entity_decode($item->title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $key = mb_strtolower(trim($cleanTitle));
    if (isset($seenTitles[$key])) {
        // Hangisi daha iyi içeriğe sahip?
        $existing = App\Models\News::find($seenTitles[$key]);
        if (strlen($item->content ?? '') > strlen($existing->content ?? '')) {
            // Yeni olan daha iyi, eskiyi sil
            echo "DEL duplicate ID {$existing->id}: " . substr($cleanTitle, 0, 50) . "\n";
            $existing->delete();
            $seenTitles[$key] = $item->id;
        } else {
            echo "DEL duplicate ID {$item->id}: " . substr($cleanTitle, 0, 50) . "\n";
            $item->delete();
        }
    } else {
        $seenTitles[$key] = $item->id;
    }
}

// 2) Kalan haberleri düzelt
$news = App\Models\News::all();
echo "\n" . $news->count() . " haber kaldı.\n\n";

$usedSlugs = [];
foreach ($news as $item) {
    $cleanTitle = html_entity_decode($item->title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $baseSlug = Str::slug($cleanTitle);
    // Unique slug
    $slug = $baseSlug;
    $i = 2;
    while (isset($usedSlugs[$slug]) && $usedSlugs[$slug] !== $item->id) {
        $slug = $baseSlug . '-' . $i++;
    }
    $usedSlugs[$slug] = $item->id;

    $changed = false;
    if ($item->title !== $cleanTitle || $item->slug !== $slug) {
        $item->title = $cleanTitle;
        $item->slug = $slug;
        $changed = true;
        echo "FIX [{$item->id}]: " . substr($cleanTitle, 0, 50) . " -> slug: " . substr($slug, 0, 40) . "\n";
    }

    // Görsel - önce content içinden bul
    if (!$item->image && $item->content) {
        if (preg_match_all('/<img[^>]+src="(https?:\/\/[^"]+)"[^>]*>/i', $item->content, $imgs)) {
            foreach ($imgs[1] as $imgUrl) {
                // Logo olmayan ilk resmi al
                if (strpos($imgUrl, 'logo') === false) {
                    $local = downloadImage($imgUrl, $item->id);
                    if ($local) { $item->image = $local; $changed = true; break; }
                }
            }
        }
    }

    if ($changed) $item->save();
}

$withImg = App\Models\News::whereNotNull('image')->count();
echo "\nTamamlandi! $withImg / " . App\Models\News::count() . " haberde gorsel var.\n";

// Son durumu listele
foreach (App\Models\News::select('id','title','slug','image')->get() as $n) {
    echo $n->id . ": " . substr($n->title, 0, 50) . " | " . ($n->image ? '✓' : '✗') . " | " . substr($n->slug, 0, 35) . "\n";
}
