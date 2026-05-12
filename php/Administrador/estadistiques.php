<?php
require_once __DIR__ . '/../logger.php';

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$mongodbUri = getenv('MONGODB_URI') ?: 'mongodb+srv://a25jawmohbou_db_user:Jawad123@projectegip3.qszzchv.mongodb.net/?appName=PROJECTEGIP3';
$mongodbDb  = getenv('MONGODB_DB') ?: 'projecte_gip3';

// connexio amb MongoDB

$client     = new MongoDB\Client($mongodbUri);
$collection = $client->selectCollection($mongodbDb, 'logs');

$filtreData   = $_GET['data']   ?? null;
$filtreUsuari = $_GET['usuari'] ?? null;
$filtrePagina = $_GET['pagina'] ?? null;

//filtres per buscar a MongoDB, es poden combinar entre ells, si no hi ha cap filtre es mostren tots els logs

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

//sumatori de accessos per pàgina i per usuari, ordenats de més a menys i limitats a 10 resultats

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

//sumatori dels accesos per dia

$accessosPerDia = $collection->aggregate([
    $matchStage,
    ['$group' => [
        '_id'   => ['$dateToString' => ['format' => '%Y-%m-%d', 'date' => '$timestamp']],
        'total' => ['$sum' => 1],
    ]],
    ['$sort'  => ['_id' => 1]],
])->toArray();

// Les estadistiques dels departaments i les incidencies es mostren a continuació, aquestes dades es treuen de MySQL, no de MongoDB

$mysqli = include_once "../connexio.php";

// Consulta per obtenir el consum total dedicat i el nombre d'incidències per cada departament

$resultat = $mysqli->query("SELECT nomDepartament AS nom, tempsTotalDedicat AS temps, nombreIncidencies AS numInc FROM vista_consum_departaments");
$departaments = $resultat->fetch_all(MYSQLI_ASSOC);

$tempsArray = array();
$deptsArray = array();
foreach ($departaments as $unDepartament) {
    $tempsArray[] = $unDepartament["temps"];
    $deptsArray[] = $unDepartament["nom"];
}

// Consulta per obtenir les incidències obertes, ordenades per prioritat i data d'inici

$resInc = $mysqli->query("
    SELECT ID_INCIDENCIA AS idInc, nomTecnic AS aula, descripcioIncidencia AS descripcio,
           DATE(dataInici) AS dataIni, PRIORITAT AS prioritat 
    FROM vista_informe_tecnics 
    ORDER BY FIELD(PRIORITAT, 'alta', 'mitja', 'baixa'), dataInici ASC
");
$incidencies = $resInc->fetch_all(MYSQLI_ASSOC);

// Mapa de colors per a les prioritats d'incidències

$mapaColors = ['alta' => 'danger', 'mitja' => 'secondary', 'baixa' => 'success'];
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panell d'Administració - Estadístiques</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: beige;
        }

        .bg-custom-dark {
            background-color: #1e3a5f;
        }
    </style>
</head>

<body class="min-vh-100 bg-secondary bg-opacity-10 d-flex flex-column">

    <!-- Header -->
    <header class="w-100 text-center py-4 shadow-sm mb-5 bg-custom-dark position-relative">
        <img src="../Imatges/logo.png" alt="Logo" class="position-absolute top-0 start-0 mt-3 ms-3 d-none d-md-block" style="width: 120px;">
        <h1 class="fs-3 fw-bold mb-1 text-white">ESTADÍSTIQUES</h1>
        <p class="text-white-50 mb-0">Logs de Sistema / Departaments / Tècnics</p>
        <link rel="icon" href="../Imatges/favicon.jpg" type="image/jpeg">

    </header>

    <div class="container mb-5">

        <!-- SECCIÓ FILTRES MONGODB -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-filter"></i> Filtres de Logs (MongoDB)</h6>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Data</label>
                        <input type="date" name="data" class="form-control" value="<?= htmlspecialchars($filtreData ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Usuari</label>
                        <input type="text" name="usuari" class="form-control" placeholder="Nom d'usuari" value="<?= htmlspecialchars($filtreUsuari ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Pàgina (URL)</label>
                        <input type="text" name="pagina" class="form-control" placeholder="/index.php" value="<?= htmlspecialchars($filtrePagina ?? '') ?>">
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Filtrar</button>
                        <button type="button" onclick="location.href='estadistiques.php'" class="btn btn-outline-secondary w-100">Netejar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- RESUM RÀPID -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-primary text-white p-3 text-center">
                    <h2 class="display-5 fw-bold mb-0"><?= $totalAccessos ?></h2>
                    <p class="mb-0 text-uppercase small opacity-75">Total d'Accessos</p>
                </div>
            </div>
        </div>

        <!-- TAULES MONGODB -->
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white fw-bold">Pàgines més visitades</div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>URL</th>
                                    <th class="text-end">Visites</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($paginesMesVisitades as $fila): ?>
                                    <tr>
                                        <td class="small"><?= htmlspecialchars($fila['_id']) ?></td>
                                        <td class="text-end fw-bold"><?= $fila['total'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white fw-bold">Usuaris més actius</div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Usuari</th>
                                    <th class="text-end">Accessos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarisMesActius as $fila): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($fila['_id']) ?></td>
                                        <td class="text-end fw-bold text-success"><?= $fila['total'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓ MYSQL (EXISTENT) -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold">Consum per Departament (MySQL)</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3 small fw-bold">Departament</th>
                                        <th class="small fw-bold">Temps</th>
                                        <th class="small fw-bold text-center">Incidències</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($departaments as $unDepartament): ?>
                                        <tr>
                                            <td class="ps-3 fw-semibold text-secondary"><?= $unDepartament["nom"] ?></td>
                                            <td><span class="badge rounded-pill bg-info text-dark px-3"><?= $unDepartament["temps"] ?> min</span></td>
                                            <td class="text-center fw-bold"><?= $unDepartament["numInc"] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100 text-center p-3">
                    <h6 class="fw-bold mb-3">Distribució de Temps</h6>
                    <canvas id="myChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>

        <!-- INCIDÈNCIES -->
        <div class="card border-0 shadow-sm mb-5">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold">Incidències Obertes</h5>
                <div class="small d-none d-md-flex gap-2">
                    <span class="badge bg-danger">Alta</span><span class="badge bg-secondary">Mitja</span><span class="badge bg-success">Baixa</span>
                </div>
            </div>
            <div class="card-body bg-light-subtle">
                <div class="list-group gap-2">
                    <?php foreach ($incidencies as $unaIncidencia):
                        $prioLower = strtolower($unaIncidencia["prioritat"]);
                        $color = $mapaColors[$prioLower] ?? 'secondary';
                    ?>
                        <a href="../Administrador/gestionar.php?id=<?= $unaIncidencia["idInc"] ?>" class="list-group-item list-group-item-action border-0 border-start border-5 border-<?= $color ?> shadow-sm rounded">
                            <div class="row align-items-center">
                                <div class="col-md-1 fw-bold text-primary">#<?= $unaIncidencia["idInc"] ?></div>
                                <div class="col-md-2 fw-semibold text-dark"><?= $unaIncidencia["aula"] ?></div>
                                <div class="col-md-7 text-truncate text-muted small"><?= $unaIncidencia["descripcio"] ?></div>
                                <div class="col-md-2 text-end small text-muted"><?= $unaIncidencia["dataIni"] ?></div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white bg-opacity-75 border-top mt-auto py-3">
        <p class="text-center text-muted mb-1">&copy; <?php echo date('Y'); ?> INS PEDRALBES</p>
        <p class="text-center text-muted mb-0 small">Jawad Mohdith and Sergi Martinez</p>
    </footer>
    <!-- Botó tornar -->
    <div class="fixed-bottom p-4">
        <a href="administrador.php" class="btn btn-secondary px-4 shadow-sm">← Tornar</a>
    </div>

    <script>
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?= json_encode($deptsArray); ?>,
                datasets: [{
                    data: <?= json_encode($tempsArray); ?>,
                    backgroundColor: ['#0d6efd', '#6610f2', '#a8a8a8', '#d63384', '#dc3545', '#fd7e14', '#ffc107', '#198754'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>