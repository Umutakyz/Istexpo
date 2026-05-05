<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$dupes = Illuminate\Support\Facades\DB::table('fairs')->select('name', Illuminate\Support\Facades\DB::raw('count(*) as count'))->groupBy('name')->having('count', '>', 1)->get();
echo "Duplicate Names:\n";
print_r($dupes);
