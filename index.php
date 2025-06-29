<?php

require_once 'config/config.php';
require_once 'cache/ICache.php';
require_once 'cache/FileCache.php';
require_once 'cache/RedisCache.php';
require_once 'counter/ICounter.php';
require_once 'counter/FileCounter.php';
require_once 'drivers/IElasticSearchDriver.php';
require_once 'drivers/IMySQLDriver.php';
require_once 'drivers/ElasticSearchDriver.php';
require_once 'drivers/MySQLDriver.php';
require_once 'controllers/ProductController.php';

$config = require 'config/config.php';

switch ($config['cache_driver']) {
    case 'redis':
        $cache = new RedisCache($config['redis']['host'], $config['redis']['port']);
        break;
    case 'file':
    default:
        $cache = new FileCache();
        break;
}

$cache = new FileCache();
$counter = new FileCounter();
$driver = $config['data_source'] === 'elastic'
    ? new ElasticSearchDriver()
    : new MySQLDriver();

$controller = new ProductController($cache, $counter, $driver);

//router
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//např. /produkt/abc123
if (preg_match('#^/produkt/([\w\-]+)$#', $requestUri, $matches)) {
    echo $controller->detailHtml($matches[1]);
    exit;
}

//JSON API: /api/product?id=abc123
if ($requestUri === '/api/product' && isset($_GET['id'])) {
    header('Content-Type: application/json; charset=utf-8');
    echo $controller->detail($_GET['id']);
    exit;
}

//404 fallback
http_response_code(404);
echo "<h1>404 – Stránka nenalezena</h1>";
