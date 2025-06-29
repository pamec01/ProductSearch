<?php
// Pokud existuje požadovaný soubor (např. CSS, obrázek…), vrať ho přímo
$path = __DIR__ . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
if (is_file($path)) {
    return false;
}

// Jinak vše obslouží index.php
require_once __DIR__ . '/index.php';
