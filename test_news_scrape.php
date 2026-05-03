<?php
define('LARAVEL_START', microtime(true));
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

// Canlı siteden haber listesini çek
function fetchNewsList() {
    $url = 'https://www.istexpo.com/haberler';
    $html = Http::withoutVerifying()->timeout(30)->get($url)->body();
    
    // Haber kartlarını yakalayalım
    preg_match_all('/<a[^>]+href="\/haberler\/detay\/(\d+)"[^>]*>(.*?)<\/a>/is', $html, $matches, PREG_SET_ORDER);
    
    $links = [];
    foreach ($matches as $m) {
        $id = $m[1];
        if (!in_array($id, array_column($links, 'id'))) {
            $links[] = ['id' => $id, 'href' => '/haberler/detay/' . $id];
        }
    }
    return $links;
}

function fetchNewsDetail($id) {
    $url = "https://www.istexpo.com/haberler/detay/{$id}";
    $html = Http::withoutVerifying()->timeout(30)->get($url)->body();
    
    $data = ['id' => $id, 'title' => '', 'image' => '', 'content' => '', 'summary' => ''];
    
    // Başlık
    if (preg_match('/<h1[^>]*>(.*?)<\/h1>/is', $html, $m)) {
        $data['title'] = html_entity_decode(trim(strip_tags($m[1])), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
    if (empty($data['title']) && preg_match('/<h2[^>]*class="[^"]*title[^"]*"[^>]*>(.*?)<\/h2>/is', $html, $m)) {
        $data['title'] = html_entity_decode(trim(strip_tags($m[1])), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
    
    // Görsel - img tag ara
    if (preg_match('/<img[^>]+src="([^"]*\/uploads\/[^"]+)"[^>]*>/i', $html, $m)) {
        $data['image'] = $m[1];
    }
    if (empty($data['image']) && preg_match('/<img[^>]+src="([^"]*haber[^"]*)"[^>]*>/i', $html, $m)) {
        $data['image'] = $m[1];
    }
    
    // İçerik
    if (preg_match('/<div[^>]+class="[^"]*haber[^"]*content[^"]*"[^>]*>(.*?)<\/div>/is', $html, $m)) {
        $data['content'] = trim($m[1]);
    }
    if (empty($data['content']) && preg_match('/<div[^>]+class="[^"]*news[^"]*detail[^"]*"[^>]*>(.*?)<\/div>/is', $html, $m)) {
        $data['content'] = trim($m[1]);
    }
    if (empty($data['content']) && preg_match('/<article[^>]*>(.*?)<\/article>/is', $html, $m)) {
        $data['content'] = trim($m[1]);
    }
    
    // Sayfa içeriğinin tamamını logla
    $data['raw'] = substr($html, 0, 3000);
    
    return $data;
}

// Sadece ilk haberi test et
echo "Test: ID 73 çekiliyor...\n";
$detail = fetchNewsDetail(73);
echo "Title: " . $detail['title'] . "\n";
echo "Image: " . $detail['image'] . "\n";
echo "Content length: " . strlen($detail['content']) . "\n";
echo "\n--- RAW HTML ---\n";
echo $detail['raw'];
