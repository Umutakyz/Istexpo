<?php
define('LARAVEL_START', microtime(true));
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$items = App\Models\News::select('id','title','slug','image','summary')->get();
foreach ($items as $n) {
    echo $n->id . ': ' . substr($n->title, 0, 60) . " | img:" . ($n->image ? 'YES' : 'NO') . " | slug:" . $n->slug . "\n";
}
