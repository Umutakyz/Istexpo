<?php
define('LARAVEL_START', microtime(true));
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

Storage::disk('public')->makeDirectory('news');

function fetchDetail($id) {
    $url = "https://www.istexpo.com/haberler/detay/{$id}";
    try {
        $html = Http::withoutVerifying()->timeout(20)->get($url)->body();
    } catch (\Exception $e) { return null; }

    $title = '';
    if (preg_match('/<h4[^>]*>(.*?)<\/h4>/is', $html, $m)) {
        $title = html_entity_decode(trim(strip_tags($m[1])), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    $content = '';
    if (preg_match('/<div class="about-us-container">(.*?)<\/div>\s*<\/div>\s*<\/article>/is', $html, $m)) {
        $content = trim($m[1]);
    }

    $image = '';
    if (preg_match_all('/<img[^>]+src="(https?:\/\/[^"]+)"[^>]*>/i', $html, $imgs)) {
        foreach ($imgs[1] as $src) {
            if (strpos($src, 'logo') === false && strpos($src, 'icon') === false) {
                $image = $src; break;
            }
        }
        if (!$image && !empty($imgs[1])) $image = $imgs[1][0];
    }

    return compact('title', 'content', 'image');
}

function downloadImage($url, $newsId) {
    try {
        $response = Http::withoutVerifying()->timeout(15)->get($url);
        if ($response->successful()) {
            $ext = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg');
            $ext = explode('?', $ext)[0];
            if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) $ext = 'jpg';
            $filename = "news/news_{$newsId}.{$ext}";
            Storage::disk('public')->put($filename, $response->body());
            return $filename;
        }
    } catch (\Exception $e) {}
    return null;
}

echo "Canlı haber listesi cekiliyor...\n";
$listHtml = Http::withoutVerifying()->timeout(20)->get('https://www.istexpo.com/haberler')->body();
preg_match_all('/\/haberler\/detay\/(\d+)/', $listHtml, $m);
$liveIds = array_unique($m[1]);
echo count($liveIds) . " ID bulundu.\n";

echo "Detaylar cekiliyor...\n";
$liveMap = [];
foreach ($liveIds as $liveId) {
    echo "  ID $liveId\n";
    $data = fetchDetail($liveId);
    if ($data && $data['title']) {
        $normalized = mb_strtolower(trim($data['title']));
        $liveMap[$normalized] = array_merge($data, ['live_id' => $liveId]);
    }
    usleep(300000);
}
echo count($liveMap) . " canlı haber islendi.\n\n";

$dbNews = App\Models\News::all();
$updated = 0;
foreach ($dbNews as $news) {
    $cleanTitle = html_entity_decode($news->title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $normalizedDb = mb_strtolower(trim($cleanTitle));
    $news->title = $cleanTitle;

    $match = null;
    if (isset($liveMap[$normalizedDb])) {
        $match = $liveMap[$normalizedDb];
    } else {
        $bestPct = 0; $bestKey = null;
        foreach ($liveMap as $key => $data) {
            similar_text($normalizedDb, $key, $pct);
            if ($pct > $bestPct) { $bestPct = $pct; $bestKey = $key; }
        }
        if ($bestPct >= 65 && $bestKey) $match = $liveMap[$bestKey];
    }

    if ($match) {
        echo "OK (ID:{$match['live_id']}): " . substr($cleanTitle, 0, 50) . "\n";
        if (!empty($match['content'])) {
            $news->content = $match['content'];
            $news->summary = Str::limit(strip_tags($match['content']), 200);
        }
        if (!$news->image && !empty($match['image'])) {
            $local = downloadImage($match['image'], $news->id);
            if ($local) { $news->image = $local; echo "  Gorsel: $local\n"; }
        }
        $updated++;
    } else {
        echo "MISS: " . substr($cleanTitle, 0, 50) . "\n";
    }
    $news->save();
}

echo "\n$updated / " . $dbNews->count() . " haber guncellendi.\n";
