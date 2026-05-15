<?php
// Carrega el logger per guardar a MongoDB qui entra a la pàgina
require_once __DIR__ . '/../logger.php';

// Carrega l'autoloader de Composer per poder usar MongoDB
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// Agafa les credencials de MongoDB de les variables d'entorn, si no hi ha usa les de per defecte
$mongodbUri = getenv('MONGODB_URI') ?: 'mongodb+srv://a25jawmohbou_db_user:Jawad123@projectegip3.qszzchv.mongodb.net/?appName=PROJECTEGIP3';
$mongodbDb  = getenv('MONGODB_DB') ?: 'projecte_gip3';

// Connecta a MongoDB i selecciona la col·lecció de logs
$client     = new MongoDB\Client($mongodbUri);
$collection = $client->selectCollection($mongodbDb, 'logs');

// Agafa els filtres de la URL, si no hi ha cap filtre queden a null
$filtreData   = $_GET['data']   ?? null;
$filtreUsuari = $_GET['usuari'] ?? null;
$filtrePagina = $_GET['pagina'] ?? null;

// Construeix el filtre de cerca segons el que ha posat l'usuari, es poden combinar
$match = [];
if ($filtreData) {
    // Converteix la data a timestamps de MongoDB (inici i fi del dia)
    $inici = new MongoDB\BSON\UTCDateTime(strtotime($filtreData) * 1000);
    $fi    = new MongoDB\BSON\UTCDateTime((strtotime($filtreData) + 86400) * 1000);
    $match['timestamp'] = ['$gte' => $inici, '$lt' => $fi];
}
// Afegeix filtre per usuari si s'ha escrit
if ($filtreUsuari) $match['usuari'] = $filtreUsuari;
// Afegeix filtre per URL si s'ha escrit
if ($filtrePagina) $match['url']    = ['$regex' => $filtrePagina, '$options' => 'i'];

// Prepara l'etapa de filtre per les consultes agregades
$matchStage = ['$match' => (object)$match];

// Compta el total d'accessos amb els filtres aplicats
$totalAccessos = $collection->countDocuments($match ?: []);

// Agrupa els logs per URL i compta quantes vegades s'ha visitat cada pàgina, mostra les 20 més visitades
$paginesMesVisitades = $collection->aggregate([
    $matchStage,
    [
        '$group' => [
            '_id' => [
                'url' => '$url',
                'ip'  => '$ip',
                'navegador' => '$navegador'
            ],
            'total' => ['$sum' => 1]
        ]
    ],
    ['$sort' => ['total' => -1]],
    ['$limit' => 20],
])->toArray();

// Agrupa els logs per usuari i compta els seus accessos, mostra els 10 més actius
$usuarisMesActius = $collection->aggregate([
    $matchStage,
    ['$match'  => ['usuari' => ['$ne' => null]]],
    ['$group'  => ['_id' => '$usuari', 'total' => ['$sum' => 1]]],
    ['$sort'   => ['total' => -1]],
    ['$limit'  => 10],
])->toArray();

// Agrupa els logs per dia i compta quants accessos hi ha hagut cada dia
$accessosPerDia = $collection->aggregate([
    $matchStage,
    ['$group' => [
        '_id'   => ['$dateToString' => ['format' => '%Y-%m-%d', 'date' => '$timestamp']],
        'total' => ['$sum' => 1],
    ]],
    ['$sort'  => ['_id' => 1]],
])->toArray();

// Connecta a MySQL per les dades de departaments i incidències
$mysqli = include_once "../connexio.php";

// Agafa el temps total dedicat i el nombre d'incidències de cada departament
$resultat = $mysqli->query("SELECT nomDepartament AS nom, tempsTotalDedicat AS temps, nombreIncidencies AS numInc FROM vista_consum_departaments");
$departaments = $resultat->fetch_all(MYSQLI_ASSOC);

// Prepara els arrays de temps i departaments per el gràfic de pastís
$tempsArray = array();
$deptsArray = array();
foreach ($departaments as $unDepartament) {
    $tempsArray[] = $unDepartament["temps"];
    $deptsArray[] = $unDepartament["nom"];
}

// Agafa les incidències obertes ordenades per prioritat (alta > mitjana > baixa) i data
$resInc = $mysqli->query("
    SELECT ID_INCIDENCIA AS idInc, nomTecnic AS aula, descripcioIncidencia AS descripcio,
           DATE(dataInici) AS dataIni, PRIORITAT AS prioritat 
    FROM vista_informe_tecnics 
    ORDER BY FIELD(PRIORITAT, 'alta', 'mitjana', 'baixa'), dataInici DESC
");
$incidencies = $resInc->fetch_all(MYSQLI_ASSOC);

// Mapa de colors per pintar cada prioritat amb el seu color de Bootstrap
$mapaColors = ['alta' => 'danger', 'mitjana' => 'secondary', 'baixa' => 'success'];

// Agafa el temps total que ha dedicat cada tècnic sumant totes les seves actuacions

$resTecnics = $mysqli->query("
    SELECT 
        t.NOM AS nomTecnic,
        COUNT(DISTINCT i.ID_INCIDENCIA) AS totalIncidencies,
        IFNULL(SUM(a.TEMPS_ACTUACIO_MIN), 0) AS tempsTotal,
        ROUND(AVG(a.TEMPS_ACTUACIO_MIN), 0) AS tempsMitja
    FROM TECNIC t
    LEFT JOIN INCIDENCIA i ON t.ID_TECNIC = i.ID_TECNIC
    LEFT JOIN ACTUACIO a ON i.ID_INCIDENCIA = a.ID_INCIDENCIA
    GROUP BY t.ID_TECNIC, t.NOM
    ORDER BY tempsTotal DESC
");
$tecnicsTotalTemps = $resTecnics->fetch_all(MYSQLI_ASSOC);

?>


<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estadístiques</title>
    <!-- Estils de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Carrega Chart.js per fer el gràfic de pastís -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Font i imatge de fons */
        body {
            font-family: 'Montserrat', sans-serif;
            background-image: url('../Imatges/fons.jpg');
            background-size: cover;
            background-position: center;
        }

        /* Color blau fosc per la capçalera */
        .bg-custom-dark {
            background-color: #1e3a5f;
        }
    </style>
</head>


<body class="min-vh-100 bg-secondary bg-opacity-10 d-flex flex-column">

    <!-- Capçalera amb logo i títol -->
    <header class="w-100 text-center py-4 shadow-sm mb-5 bg-custom-dark position-relative">
        <!-- Logo només visible en pantalles mitjanes o grans -->
        <img src="../Imatges/logo.png" alt="Logo" class="position-absolute top-0 start-0 mt-3 ms-3 d-none d-md-block" style="width: 120px;">
        <h1 class="fs-3 fw-bold mb-1 text-white">ESTADÍSTIQUES</h1>
        <p class="text-white-50 mb-0">Logs de Sistema / Departaments / Tècnics</p>
        <link rel="icon" href="../Imatges/favicon.jpg" type="image/jpeg">
    </header>


    <div class="row g-4 mb-5 px-4">
        <div class="col-4">
            <a href="#seccio-logs" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center py-4 bg-white bg-opacity-75 h-100"
                    style="cursor:pointer; transition: transform 0.2s, box-shadow 0.2s;">
                    <h2 class="fw-bold mb-0 text-danger">Logs</h2>

                </div>
            </a>
        </div>
        <div class="col-4">
            <a href="#seccio-departaments" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center py-4 bg-white bg-opacity-75 h-100"
                    style="cursor:pointer; transition: transform 0.2s, box-shadow 0.2s;">
                    <h2 class="fw-bold mb-0 text-warning">Departaments</h2>

                </div>
            </a>
        </div>
        <div class="col-4">
            <a href="#seccio-tecnics" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center py-4 bg-white bg-opacity-75 h-100"
                    style="cursor:pointer; transition: transform 0.2s, box-shadow 0.2s;">
                    <h2 class="fw-bold mb-0 text-success">Tècnics</h2>

                </div>
            </a>
        </div>
    </div>


    <div class="container mb-5">

        <!-- SECCIÓ FILTRES MONGODB -->
        <div id="seccio-logs" class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-filter"></i> Filtres de Logs </h6>
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
                        <!-- Botó per netejar tots els filtres -->
                        <button type="button" onclick="location.href='estadistiques.php'" class="btn btn-outline-secondary w-100">Netejar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Mostra el total d'accessos trobats amb els filtres aplicats -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-primary text-white p-3 text-center">
                    <h2 class="display-5 fw-bold mb-0"><?= $totalAccessos ?></h2>
                    <p class="mb-0 text-uppercase small opacity-75">Total d'Accessos</p>
                </div>
            </div>
        </div>

        <!-- Taules amb les pàgines més visitades i els usuaris més actius -->
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white fw-bold">Pàgines més visitades</div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>URL</th>
                                    <th>IP</th>
                                    <th>NAVEGADOR</th>
                                    <th class="text-end">Visites</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Recorre i mostra cada pàgina amb el seu nombre de visites -->
                                <?php foreach ($paginesMesVisitades as $fila): ?>
                                    <tr>
                                        <td class="small" style="max-width:300px; word-break:break-word;">
                                            <?= htmlspecialchars($fila['_id']['url']) ?>
                                        </td>

                                        <td class="small" style="max-width:300px; word-break:break-word;">
                                            <?= htmlspecialchars($fila['_id']['ip']) ?>
                                        </td>

                                        <td class="small text-truncate" style="max-width:250px;">
                                            <?= htmlspecialchars($fila['_id']['navegador']) ?>
                                        </td>

                                        <td class="text-end fw-bold">
                                            <?= $fila['total'] ?>
                                        </td>
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
                                <!-- Recorre i mostra cada usuari amb el seu nombre d'accessos -->
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

        <!-- SECCIÓ MYSQL -->
        <div id="seccio-departaments" class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold">Consum per Departament</h6>
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
                                    <!-- Recorre i mostra cada departament amb el seu temps i nombre d'incidències -->
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

            <!-- Gràfic de pastís amb la distribució de temps per departament -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <h6 class="fw-bold mb-3">Distribució de Temps</h6>
                    <div style="position: relative; height: 350px;">
                        <canvas id="myChart"></canvas>
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

        <!-- SECCIÓ TÈCNICS -->

        <div id="seccio-tecnics" class="card border-0 shadow-sm mb-5">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold">Rendiment dels Tècnics</h5>
                <span class="badge bg-primary rounded-pill"><?= count($tecnicsTotalTemps) ?> tècnics</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3 small fw-bold">Tècnic</th>
                                <th class="text-center small fw-bold">Incidències</th>
                                <th class="small fw-bold">Temps Total</th>
                                <th class="small fw-bold">Temps Mitjà</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($tecnicsTotalTemps as $tecnic):
                            ?>
                                <tr>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold"
                                                style="width:36px; height:36px; font-size:14px; flex-shrink:0;">
                                                <?= strtoupper(substr($tecnic['nomTecnic'], 0, 1)) ?>
                                            </div>
                                            <span class="fw-semibold"><?= htmlspecialchars($tecnic['nomTecnic']) ?></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary rounded-pill px-3"><?= $tecnic['totalIncidencies'] ?></span>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill bg-info text-dark px-3"><?= $tecnic['tempsTotal'] ?> min</span>
                                    </td>
                                    <td>
                                        <?php if ($tecnic['tempsMitja']): ?>
                                            <span class="text-muted small"><?= $tecnic['tempsMitja'] ?> min/inc</span>
                                        <?php else: ?>
                                            <span class="text-muted small">—</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
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
    </div>
    <div class="fixed-bottom p-4">
        <a href="administrador.php" class="btn btn-secondary px-4 shadow-sm">← Tornar</a>
    </div>
    <footer class="bg-white bg-opacity-75 border-top mt-auto py-3">
        <p class="text-center text-muted mb-1">&copy; <?php echo date('Y'); ?> INS PEDRALBES</p>
        <p class="text-center text-muted mb-0 small">Jawad Mohdith and Sergi Martinez</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>