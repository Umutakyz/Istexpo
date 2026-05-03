<?php
$html = file_get_contents('test_news.html');

// Try to find ANY img tags and their parent elements to see the structure
preg_match_all('/<div class="haber[^>]*>.*?<img[^>]+src="([^"]+)"[^>]*>.*?<h[3-5][^>]*>(.*?)<\/h[3-5]>/is', $html, $matches);

if (empty($matches[0])) {
    // Let's just find ANY <img> tag in the page
    preg_match_all('/<img[^>]+src="([^"]+)"[^>]*>/i', $html, $imgs);
    echo "Found " . count($imgs[1]) . " images in total.\n";
    foreach(array_slice($imgs[1], 0, 10) as $img) {
        echo "- $img\n";
    }
} else {
    echo "Matched news structure!\n";
}

// Another possible structure for the old site:
// Sometimes news are under <div class="news-list-box"> or <div class="col-md-4 col-sm-6">
// Let's dump the first few links that contain 'haberler/' or 'news/'
preg_match_all('/<a[^>]+href="([^"]+)"[^>]*>(.*?)<\/a>/is', $html, $links);
echo "\nLinks:\n";
$i=0;
foreach($links[1] as $idx => $href) {
    if (strpos($href, 'haberler/detay') !== false) {
        echo "- $href : " . strip_tags($links[2][$idx]) . "\n";
        $i++;
        if ($i > 5) break;
    }
}
