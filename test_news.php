<?php
require 'vendor/autoload.php';
$html = file_get_contents('https://www.istexpo.com/haberler');
file_put_contents('test_news.html', $html);
echo strlen($html) . " bytes\n";
