<?php
define('LARAVEL_START', microtime(true));
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

$html = Http::withoutVerifying()->timeout(30)->get('https://www.istexpo.com/haberler/detay/73')->body();

// Find the article / main content zone
$start = strpos($html, 'side-pages-header-content');
$body = substr($html, $start ?: 0, 8000);
echo $body;
