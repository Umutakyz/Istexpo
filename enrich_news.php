<?php
define('LARAVEL_START', microtime(true));
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

function fetchNewsDetail($id) {
    $url = "https://www.istexpo.com/haberler/detay/{$id}";
    $html = Http::withoutVerifying()->timeout(30)->get($url)->body();

    $data = ['id' => $id, 'title' => '', 'image' => '', 'content' => ''];

    // Başlık - h4 içinde
    if (preg_match('/<h4[^>]*>(.*?)<\/h4>/is', $html, $m)) {
        $data['title'] = html_entity_decode(trim(strip_tags($m[1])), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    // İçerik - article > div > içerik
    if (preg_match('/<div class="about-us-container">(.*?)<\/div>\s*<\/div>\s*<\/article>/is', $html, $m)) {
        $data['content'] = trim($m[1]);
    }

    // İlk img (content içinden)
    if (preg_match('/<img[^>]+src="(https?:\/\/[^"]+)"[^>]*>/i', $html, $m)) {
        $data['image'] = $m[1];
    }

    return $data;
}

function downloadImage($url, $newsId) {
    try {
        $response = Http::withoutVerifying()->timeout(15)->get($url);
        if ($response->successful()) {
            $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
            $ext = $ext ?: 'jpg';
            $ext = strtolower(explode('?', $ext)[0]);
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) $ext = 'jpg';
            
            $filename = 'news/news_' . $newsId . '.' . $ext;
            Storage::disk('public')->put($filename, $response->body());
            return $filename;
        }
    } catch (\Exception $e) {
        echo "  Image download failed: " . $e->getMessage() . "\n";
    }
    return null;
}

Storage::disk('public')->makeDirectory('news');

// Canlı sitedeki tüm haber ID'lerini bul
echo "Haber listesi çekiliyor...\n";
$listHtml = Http::withoutVerifying()->timeout(30)->get('https://www.istexpo.com/haberler')->body();
preg_match_all('/\/haberler\/detay\/(\d+)/', $listHtml, $matches);
$liveIds = array_unique($matches[1]);
echo count($liveIds) . " haber ID'si bulundu: " . implode(', ', array_slice($liveIds, 0, 10)) . "...\n\n";

// DB haberlerini al
$dbNews = App\Models\News::all();
echo "DB'de " . $dbNews->count() . " haber var.\n\n";

// DB haberlerini title'a göre eşleştir
foreach ($dbNews as $news) {
    $cleanTitle = html_entity_decode($news->title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    
    // Önce title'ı düzelt
    if ($news->title !== $cleanTitle) {
        $news->title = $cleanTitle;
        echo "Title düzeltildi: " . substr($cleanTitle, 0, 50) . "\n";
    }

    // Zaten image var mı?
    if ($news->image) {
        $news->save();
        continue;
    }

    // Live ID'lerden birini dene - sırayla tüm ID'leri kontrol et
    foreach ($liveIds as $liveId) {
        $detail = fetchNewsDetail($liveId);
        if (empty($detail['title'])) continue;
        
        // Başlıklar benziyor mu?
        $liveClean = strtolower(trim($detail['title']));
        $dbClean   = strtolower(trim($cleanTitle));
        
        similar_text($liveClean, $dbClean, $pct);
        
        if ($pct > 70) {
            echo "Eşleşti: [{$liveId}] {$detail['title']}\n";
            
            // İçerik güncelle
            if (!empty($detail['content'])) {
                $news->content = $detail['content'];
                
                // Summary üret (content'ten ilk 200 char)
                $plainText = strip_tags($detail['content']);
                $news->summary = Str::limit($plainText, 200);
            }
            
            // Görsel indir
            if (!empty($detail['image'])) {
                $localPath = downloadImage($detail['image'], $news->id);
                if ($localPath) {
                    $news->image = $localPath;
                    echo "  Görsel indirildi: {$localPath}\n";
                }
            }
            
            $news->save();
            break;
        }
    }
    
    if (!$news->image) {
        echo "EŞLEŞME YOK: " . substr($cleanTitle, 0, 50) . "\n";
        $news->save(); // En azından title'ı kaydet
    }
}

echo "\nTamamlandı!\n";
