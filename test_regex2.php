<?php
$html = file_get_contents('test_news.html');

// We need to group them. Look for common wrapper like <div class="news-item">
// In previous old site versions, it was <div class="col-md-4 col-sm-6">
// Let's explode by '<div class="col-' or similar, or just match <img ...> and nearest <h...
preg_match_all('/<img[^>]+src="([^"]+uploads\/news[^"]+)"[^>]*>.*?<h[1-6][^>]*>(.*?)<\/h[1-6]>/is', $html, $matches);

if (!empty($matches[1])) {
    echo "Found " . count($matches[1]) . " news with images!\n";
    for($i=0; $i<min(5, count($matches[1])); $i++) {
        echo trim(strip_tags($matches[2][$i])) . " -> " . $matches[1][$i] . "\n";
    }
} else {
    echo "Pattern 1 failed.\n";
    // Try h tags before image
    preg_match_all('/<h[1-6][^>]*>(.*?)<\/h[1-6]>.*?<img[^>]+src="([^"]+uploads\/news[^"]+)"[^>]*>/is', $html, $matches);
    if (!empty($matches[1])) {
        echo "Found " . count($matches[1]) . " news with images (pattern 2)!\n";
        for($i=0; $i<min(5, count($matches[1])); $i++) {
            echo trim(strip_tags($matches[1][$i])) . " -> " . $matches[2][$i] . "\n";
        }
    } else {
        echo "Pattern 2 failed.\n";
    }
}
