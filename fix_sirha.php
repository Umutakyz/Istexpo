<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Fair;
use Stichoza\GoogleTranslate\GoogleTranslate;

$fair = Fair::where('slug', 'sirha-bake-snack')->first();

if (!$fair) {
    die("Fair not found.\n");
}

$tr_desc = "Sirha Bake & Snack (eski adıyla Sirha Europain), 1999 yılından bu yana Paris’te düzenlenen, Avrupa'nın fırıncılık, pastacılık, kahvaltı, kahve ve atıştırmalık sektörlerine odaklanan en prestijli ihtisas fuarlarından biridir.\n\nZanaatkâr işletmelerden endüstriyel üreticilere, otel ve restoran zincirlerinden perakendecilere kadar geniş bir katılımcı kitlesine hitap eden fuar, sektör profesyonellerine yenilik, ilham ve iş geliştirme fırsatları sunar.\n\nAvrupa pazarında markalaşmak, yeni iş ortaklıkları kurmak ve sektördeki son trendleri keşfetmek için en önemli uluslararası platformlardan biridir.";

$tr_profile = "<ul>
<li>Fırıncılık ve Pastacılık Ürünleri</li>
<li>Hamur ve Hazır Karışımlar</li>
<li>Paketleme</li>
<li>Kahve Zincirleri</li>
<li>Otel ve Restoran Grupları</li>
<li>Endüstriyel Üretim Makineleri</li>
</ul>";

$tr_subject = "Fırıncılık ve Atıştırmalığın Uluslararası Buluşma Noktası";

$fair->description = $tr_desc;
$fair->exhibitor_profile = $tr_profile;
$fair->subject = $tr_subject;
$fair->venue = "Porte de Versailles – Paris Expo";
$fair->organizer = "GL Events";
$fair->edition = "26";
$fair->website = "https://www.sirha-bakeandsnack.com/en";

// English Translation
try {
    $tr = new GoogleTranslate('en');
    $tr->setSource('tr');
    
    // Bypass SSL
    $tr->setOptions(['verify' => false]);
    
    $fair->name_en = $tr->translate($fair->name);
    $fair->description_en = $tr->translate($tr_desc);
    $fair->subject_en = $tr->translate($tr_subject);
    $fair->location_en = $tr->translate($fair->location);
    $fair->venue_en = $tr->translate($fair->venue);
    
    // Translate profile list
    $profile_items = [
        "Fırıncılık ve Pastacılık Ürünleri",
        "Hamur ve Hazır Karışımlar",
        "Paketleme",
        "Kahve Zincirleri",
        "Otel ve Restoran Grupları",
        "Endüstriyel Üretim Makineleri"
    ];
    $en_profile = "<ul>";
    foreach($profile_items as $item) {
        $en_profile .= "<li>" . $tr->translate($item) . "</li>";
    }
    $en_profile .= "</ul>";
    $fair->exhibitor_profile_en = $en_profile;
    
} catch (\Exception $e) {
    echo "Translation error: " . $e->getMessage() . "\n";
}

$fair->save();
echo "Sirha Bake & Snack updated and translated successfully.\n";
