<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
use Illuminate\Support\Facades\Schema;
print_r(Schema::getColumnListing('news'));
print_r(Schema::getColumnListing('sectors'));
print_r(Schema::getColumnListing('services'));
