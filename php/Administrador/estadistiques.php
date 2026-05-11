<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$mongodbUri = getenv('MONGODB_URI') ?: 'mongodb+srv://a25jawmohbou_db_user:Jawad123@projectegip3.qszzchv.mongodb.net/?appName=PROJECTEGIP3';
$mongodbDb  = getenv('MONGODB_DB') ?: 'projecte_gip3';

$client     = new MongoDB\Client($mongodbUri);
$collection = $client->selectCollection($mongodbDb, 'logs');


$filtreData   = $_GET['data']   ?? null; 
$filtreUsuari = $_GET['usuari'] ?? null;
$filtrePagina = $_GET['pagina'] ?? null;

$match = [];

if ($filtreData) {
    $inici = new MongoDB\BSON\UTCDateTime(strtotime($filtreData) * 1000);
    $fi    = new MongoDB\BSON\UTCDateTime((strtotime($filtreData) + 86400) * 1000);
    $match['timestamp'] = ['$gte' => $inici, '$lt' => $fi];
}
if ($filtreUsuari) $match['usuari'] = $filtreUsuari;
if ($filtrePagina) $match['url']    = ['$regex' => $filtrePagina, '$options' => 'i'];

$matchStage = ['$match' => (object)$match];


$totalAccessos = $collection->countDocuments($match ?: []);


$paginesMesVisitades = $collection->aggregate([
    $matchStage,
    ['$group'  => ['_id' => '$url', 'total' => ['$sum' => 1]]],
    ['$sort'   => ['total' => -1]],
    ['$limit'  => 10],
])->toArray();


$usuarisMesActius = $collection->aggregate([
    $matchStage,
    ['$match'  => ['usuari' => ['$ne' => null]]],
    ['$group'  => ['_id' => '$usuari', 'total' => ['$sum' => 1]]],
    ['$sort'   => ['total' => -1]],
    ['$limit'  => 10],
])->toArray();


$accessosPerDia = $collection->aggregate([
    $matchStage,
    ['$group' => [
        '_id'   => ['$dateToString' => ['format' => '%Y-%m-%d', 'date' => '$timestamp']],
        'total' => ['$sum' => 1],
    ]],
    ['$sort'  => ['_id' => 1]],
])->toArray();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Panell d'administració</title>
    <style>
        body { font-family: sans-serif; max-width: 1000px; margin: 2rem auto; padding: 0 1rem; }
        h1, h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; }
        th, td { padding: .6rem 1rem; border: 1px solid #ddd; text-align: left; }
        th { background: #f5f5f5; }
        form { margin-bottom: 2rem; display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end; }
        label { display: flex; flex-direction: column; font-size: .85rem; gap: .3rem; }
        input { padding: .4rem .6rem; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: .45rem 1rem; background: #333; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        .total { font-size: 2rem; font-weight: bold; color: #333; }
    </style>
</head>
<body>

<h1> Panell d'estadístiques</h1>

<!-- FILTRES -->
<form method="GET">
    <label>Data
        <input type="date" name="data" value="<?= htmlspecialchars($filtreData ?? '') ?>">
    </label>
    <label>Usuari
        <input type="text" name="usuari" placeholder="nom d'usuari" value="<?= htmlspecialchars($filtreUsuari ?? '') ?>">
    </label>
    <label>Pàgina (URL)
        <input type="text" name="pagina" placeholder="/index.php" value="<?= htmlspecialchars($filtrePagina ?? '') ?>">
    </label>
    <button type="submit">Filtrar</button>
    <button type="button" onclick="location.href='estadistiques.php'">Netejar</button>
</form>

<!-- TOTAL -->
<h2>Total d'accessos</h2>
<p class="total"><?= $totalAccessos ?></p>

<!-- PÀGINES MÉS VISITADES -->
<h2>Pàgines més visitades</h2>
<table>
    <tr><th>URL</th><th>Visites</th></tr>
    <?php foreach ($paginesMesVisitades as $fila): ?>
    <tr>
        <td><?= htmlspecialchars($fila['_id']) ?></td>
        <td><?= $fila['total'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<!-- USUARIS MÉS ACTIUS -->
<h2>Usuaris més actius</h2>
<?php if (empty($usuarisMesActius)): ?>
    <p><em>Sense usuaris autenticats registrats.</em></p>
<?php else: ?>
<table>
    <tr><th>Usuari</th><th>Accessos</th></tr>
    <?php foreach ($usuarisMesActius as $fila): ?>
    <tr>
        <td><?= htmlspecialchars($fila['_id']) ?></td>
        <td><?= $fila['total'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>

<!-- ACCESSOS PER DIA -->
<h2>Accessos per dia</h2>
<table>
    <tr><th>Data</th><th>Accessos</th></tr>
    <?php foreach ($accessosPerDia as $fila): ?>
    <tr>
        <td><?= htmlspecialchars($fila['_id']) ?></td>
        <td><?= $fila['total'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>