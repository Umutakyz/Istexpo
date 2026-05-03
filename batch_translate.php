<?php
define('LARAVEL_START', microtime(true));
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Fair;
use App\Models\News;
use App\Models\Sector;
use App\Models\Service;
use Stichoza\GoogleTranslate\GoogleTranslate;

$tr = new GoogleTranslate('en', 'tr');
$tr->setOptions(['verify' => false]);

echo "Starting batch translation...\n";

// Fairs
$fairs = Fair::all();
foreach ($fairs as $fair) {
    $updated = false;
    if (empty($fair->name_en) && !empty($fair->name)) {
        $fair->name_en = $tr->translate($fair->name);
        $updated = true;
    }
    // Only translate description if it's currently empty OR just contains the date (from previous failed scrape)
    if ((empty($fair->description_en) || preg_match('/^\d{1,2}\s*-\s*\d{1,2}/', $fair->description_en)) && !empty($fair->description)) {
        if (strlen($fair->description) > 0) {
            $fair->description_en = $tr->translate($fair->description);
            $updated = true;
        }
    }
    if (empty($fair->exhibitor_profile_en) && !empty($fair->exhibitor_profile)) {
        $fair->exhibitor_profile_en = $tr->translate($fair->exhibitor_profile);
        $updated = true;
    }
    if ($updated) {
        $fair->save();
        echo "Translated Fair: {$fair->name}\n";
    }
}

// News
$news = News::all();
foreach ($news as $item) {
    $updated = false;
    if (empty($item->title_en) && !empty($item->title)) {
        $item->title_en = $tr->translate($item->title);
        $updated = true;
    }
    if (empty($item->summary_en) && !empty($item->summary)) {
        $item->summary_en = $tr->translate($item->summary);
        $updated = true;
    }
    if (empty($item->content_en) && !empty($item->content)) {
        $item->content_en = $tr->translate($item->content);
        $updated = true;
    }
    if ($updated) {
        $item->save();
        echo "Translated News: {$item->title}\n";
    }
}

// Sectors
$sectors = Sector::all();
foreach ($sectors as $sector) {
    $updated = false;
    if (empty($sector->name_en) && !empty($sector->name)) {
        $sector->name_en = $tr->translate($sector->name);
        $updated = true;
    }
    if (empty($sector->description_en) && !empty($sector->description)) {
        $sector->description_en = $tr->translate($sector->description);
        $updated = true;
    }
    if ($updated) {
        $sector->save();
        echo "Translated Sector: {$sector->name}\n";
    }
}

echo "\nBatch translation completed.\n";
