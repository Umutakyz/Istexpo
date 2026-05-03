<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Service;
use Illuminate\Support\Str;

$services = [
    [
        'name' => 'Etkinlik Yönetimi',
        'description' => 'Dünya standartlarında fuarların ve ticari şovların uçtan uca planlanması ve yürütülmesi.',
        'icon' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M2 12h20"/></svg>'
    ],
    [
        'name' => 'Stratejik Danışmanlık',
        'description' => 'Küresel markalar için pazara giriş stratejileri ve ortaklık geliştirme.',
        'icon' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m16 12-4-4-4 4M12 16V8"/></svg>'
    ],
    [
        'name' => 'Katılımcı Desteği',
        'description' => 'Katılımcıların yatırım getirilerini ve varlıklarını en üst düzeye çıkarmalarına yardımcı olmak için kişiselleştirilmiş hizmetler.',
        'icon' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>'
    ]
];

foreach ($services as $s) {
    $serv = new Service();
    $serv->name = $s['name'];
    $serv->slug = Str::slug($s['name']);
    $serv->description = $s['description'];
    $serv->icon = $s['icon'];
    // saving will trigger google translate
    $serv->save();
    echo "Saved: " . $serv->name_en . "\n";
}
