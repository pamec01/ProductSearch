<?php
$path = __DIR__ . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
if (is_file($path)) {
    return false;
}

require_once __DIR__ . '/index.php';
