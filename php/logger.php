<?php
$autoloadCandidates = [
    __DIR__ . '/vendor/autoload.php',
    __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../../vendor/autoload.php',
    ($_SERVER['DOCUMENT_ROOT'] ?? '') . '/vendor/autoload.php',
    ($_SERVER['DOCUMENT_ROOT'] ?? '') . '/php/vendor/autoload.php',
];

$autoloadLoaded = false;
foreach ($autoloadCandidates as $path) {
    if ($path && is_file($path)) {
        require_once $path;
        $autoloadLoaded = true;
        break;
    }
}

if (!$autoloadLoaded) {
    trigger_error('No se ha encontrado vendor/autoload.php desde logger.php', E_USER_WARNING);
    return;
}

$mongodbUri = getenv('MONGODB_URI') ?: 'mongodb+srv://a25jawmohbou_db_user:Jawad123@projectegip3.qszzchv.mongodb.net/?appName=PROJECTEGIP3';
$mongodbDb  = getenv('MONGODB_DB') ?: 'projecte_gip3';

$client     = new MongoDB\Client($mongodbUri);
$collection = $client->selectCollection($mongodbDb, 'logs');

$log = [
    'url'       => ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http')
        . '://' . ($_SERVER['HTTP_HOST'] ?? 'unknown')
        . ($_SERVER['REQUEST_URI'] ?? '/'),
    'metode'    => $_SERVER['REQUEST_METHOD'] ?? 'unknown',
    'usuari'    => null,
    'timestamp' => new MongoDB\BSON\UTCDateTime(),
    'navegador' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
    'ip'        => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
];

$collection->insertOne($log);
