<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

function fetchHtml($url) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120.0.0.0 Safari/537.36',
    ]);
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}

$html = fetchHtml('https://www.istexpo.com/fuarlar');

libxml_use_internal_errors(true);
$dom = new DOMDocument();
$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
libxml_clear_errors();
$xpath = new DOMXPath($dom);

// Assuming fairs are in some <a> tags containing "/fuarlar/ID-slug"
$nodes = $xpath->query('//a[contains(@href, "/fuarlar/")]');

$links = [];
foreach ($nodes as $node) {
    $href = $node->getAttribute('href');
    if (preg_match('#/fuarlar/(\d+)-([^/]+)$#', $href, $matches)) {
        $slug = $matches[2];
        $links[$slug] = $href;
    }
}

echo "Found " . count($links) . " unique fair links on the live site.\n";

$localSlugs = App\Models\Fair::pluck('slug')->toArray();
echo "Local fairs count: " . count($localSlugs) . "\n";

$missing = [];
foreach ($links as $slug => $href) {
    if (!in_array($slug, $localSlugs)) {
        // Also check if it might be an exact match with some other slug structure
        $exists = App\Models\Fair::where('slug', 'like', "%$slug%")->exists();
        if (!$exists) {
            $missing[$slug] = $href;
        }
    }
}

echo "\nMissing Fairs (" . count($missing) . "):\n";
foreach ($missing as $slug => $href) {
    echo "- $slug: $href\n";
}
