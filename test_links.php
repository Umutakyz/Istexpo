<?php
$html = file_get_contents('https://www.istexpo.com/en/exhibitions');
preg_match_all('/<a[^>]+href="([^"]+)"[^>]*>.*?<\/h5>/is', $html, $matches);
print_r($matches[1]);
