<?php
$html = file_get_contents('https://www.istexpo.com/fuarlar/296-sirha-bake-and-snack');
preg_match('/<div class="fuar-detail-parag">(.*?)<\/div>/s', $html, $m);
if (isset($m[1])) {
    echo "--- START --- \n";
    echo $m[1];
    echo "\n --- END --- \n";
} else {
    echo "Not found";
}
