<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$fair = App\Models\Fair::where('slug', 'international-security-expo-international-cyber-expo')->first();
echo "EN: " . $fair->description_en . "\n";
echo "TR: " . $fair->description . "\n";
