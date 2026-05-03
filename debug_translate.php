<?php
define('LARAVEL_START', microtime(true));
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

$trHtml = Http::withoutVerifying()->get('https://www.istexpo.com/fuarlar')->body();
preg_match_all('/<h5>(.*?)<\/h5>/i', $trHtml, $m1);
preg_match_all('/<p>(.*?)<\/p>/i', $trHtml, $m2);

echo "TR H5 Count: " . count($m1[0]) . "\n";
echo "TR P Count: " . count($m2[0]) . "\n";

$enHtml = Http::withoutVerifying()->get('https://www.istexpo.com/en/exhibitions')->body();
preg_match_all('/<h5>(.*?)<\/h5>/i', $enHtml, $m3);
preg_match_all('/<p>(.*?)<\/p>/i', $enHtml, $m4);

echo "EN H5 Count: " . count($m3[0]) . "\n";
echo "EN P Count: " . count($m4[0]) . "\n";
