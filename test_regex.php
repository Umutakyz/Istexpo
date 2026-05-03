<?php
$html = file_get_contents('test_news.html');
preg_match_all('/<div class="fuar-list-card-content">(.*?)<\/h5>/is', $html, $m);
if (!empty($m[0])) {
    echo $m[0][0];
} else {
    echo "No match found.";
}
