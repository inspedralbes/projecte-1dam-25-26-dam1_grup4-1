<?php
$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (!is_file($autoloadPath)) {
    throw new RuntimeException('Autoload not found. Run: composer install');
}
require_once $autoloadPath;

$mongodbUri = getenv('MONGODB_URI') ?: 'mongodb+srv://a25jawmohbou_db_user:Jawad123@projectegip3.qszzchv.mongodb.net/?appName=PROJECTEGIP3';
$mongodbDb  = getenv('MONGODB_DB') ?: 'projecte_gip3';
$client     = new MongoDB\Client($mongodbUri);
$collection = $client->selectCollection($mongodbDb, 'logs');

$ip = $_SERVER['HTTP_X_FORWARDED_FOR']
    ?? $_SERVER['HTTP_X_REAL_IP']
    ?? $_SERVER['REMOTE_ADDR']
    ?? 'unknown';

if (str_contains($ip, ',')) {
    $ip = trim(explode(',', $ip)[0]);
}

$log = [
    'url'       => 'http://' . ($_SERVER['HTTP_HOST'] ?? 'unknown') . ($_SERVER['REQUEST_URI'] ?? '/'),
    'metode'    => $_SERVER['REQUEST_METHOD'] ?? 'unknown',
    'usuari'    => null,
    'timestamp' => new MongoDB\BSON\UTCDateTime(),
    'navegador' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
    'ip'        => $ip,
];

$collection->insertOne($log);
