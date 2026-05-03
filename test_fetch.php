<?php
require 'vendor/autoload.php';
$html = file_get_contents('https://www.istexpo.com/en/exhibitions/international-security-expo-international-cyber-expo');
file_put_contents('test.html', $html);
