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

$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

$navegador = 'Desconegut';

if (strpos($userAgent, 'Firefox') !== false) {
    $navegador = 'Firefox';
} elseif (strpos($userAgent, 'Edg') !== false) {
    $navegador = 'Edge';
} elseif (strpos($userAgent, 'Chrome') !== false) {
    $navegador = 'Chrome';
} elseif (strpos($userAgent, 'Safari') !== false) {
    $navegador = 'Safari';
} elseif (strpos($userAgent, 'Opera') !== false || strpos($userAgent, 'OPR') !== false) {
    $navegador = 'Opera';
}

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    ? 'https://'
    : 'http://';

$log = [
    'url'        => $protocol .
        ($_SERVER['HTTP_HOST'] ?? 'unknown') .
        ($_SERVER['REQUEST_URI'] ?? '/'),

    'metode'     => $_SERVER['REQUEST_METHOD'] ?? 'unknown',
    'usuari'     => null,
    'timestamp'  => new MongoDB\BSON\UTCDateTime(),

    'navegador'  => $navegador,
    'user_agent' => $userAgent,

    'ip'         => $ip,
];

$collection->insertOne($log);
