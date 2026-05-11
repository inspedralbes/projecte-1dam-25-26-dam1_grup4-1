<?php
// ─── Connexió i Recuperació de dades (Consum Departaments) ──────────────
$mysqli = include_once "../connexio.php";

// Consulta de consum per departaments (MySQL)
$resultat = $mysqli->query("SELECT nomDepartament AS nom, tempsTotalDedicat AS temps, nombreIncidencies AS numInc FROM vista_consum_departaments");
$departaments = $resultat->fetch_all(MYSQLI_ASSOC);

$tempsArray = array();
$deptsArray = array();

foreach ($departaments as $unDepartament) {
    $tempsArray[] = $unDepartament["temps"];
    $deptsArray[] = $unDepartament["nom"];
}

// ─── Consulta d'Incidències (Corregida) ──────────────────────────────────
$resInc = $mysqli->query("
    SELECT ID_INCIDENCIA AS idInc, 
           nomTecnic AS aula, 
           descripcioIncidencia AS descripcio,
           DATE(dataInici) AS dataIni, 
           PRIORITAT AS prioritat 
    FROM vista_informe_tecnics 
    ORDER BY FIELD(PRIORITAT, 'urgent', 'alta', 'mitja', 'baixa'), dataInici ASC
");
// Hem eliminat la línia: WHERE dataFi IS NULL
$incidencies = $resInc->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panell d'Administració - Bootstrap</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        /* Estils per a les files d'incidència basats en el teu requeriment */
        .incidencia-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .incidencia-row {
            transition: transform 0.2s;
            border-left: 5px solid;
            background-color: #ffffff;
        }

        .incidencia-row:hover {
            transform: translateX(5px);
            background-color: #f1f1f1;
        }

        /* Colors de prioritat */
        .prioritaturgent {
            border-left-color: #dc3545 ! exhaustion;
        }

        .prioritalta {
            border-left-color: #fd7e14;
        }

        .prioritmitja {
            border-left-color: #ffc107;
        }

        .prioritbaixa {
            border-left-color: #198754;
        }

        .llegenda-dot {
            height: 12px;
            width: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <span class="navbar-brand mb-0 h1">📊 Gestió d'Incidències</span>
        </div>
    </nav>

    <div class="container">
        <div class="row mb-4">
            <!-- Taula de Departaments -->
            <div class="col-md-8">
                <div class="card h-100">
                    <div class="card-header bg-white font-weight-bold">Consum per Departament</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Departament</th>
                                        <th>Temps</th>
                                        <th>Incidències</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($departaments as $unDepartament): ?>
                                        <tr>
                                            <th scope="row"><?= $unDepartament["nom"] ?></th>
                                            <td><span class="badge bg-primary text-white"><?= $unDepartament["temps"] ?> minuts</span></td>
                                            <td><?= $unDepartament["numInc"] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gràfic -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header bg-white font-weight-bold">Distribució de Temps</div>
                    <div class="card-body d-flex align-items-center">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secció d'Incidències -->
        <div class="card mb-5">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Incidències Obertes</h5>
                <div class="small">
                    <span class="me-2"><span class="llegenda-dot bg-danger"></span> Urgent</span>
                    <span class="me-2"><span class="llegenda-dot bg-warning"></span> Alta</span>
                    <span class="me-2"><span class="llegenda-dot bg-info"></span> Mitja</span>
                    <span><span class="llegenda-dot bg-success"></span> Baixa</span>
                </div>
            </div>
            <div class="card-body bg-light">
                <!-- Capçalera de llista -->
                <div class="row g-0 fw-bold p-2 text-secondary small text-uppercase">
                    <div class="col-1">ID</div>
                    <div class="col-2">Dept.</div>
                    <div class="col-7">Descripció</div>
                    <div class="col-2 text-end">Data Inici</div>
                </div>

                <div class="cajaIncidencias">
                    <?php foreach ($incidencies as $unaIncidencia):
                        $prioClass = "priorit" . strtolower($unaIncidencia["prioritat"]);
                    ?>
                        <a href="modificar_incidencia.php?id=<?= $unaIncidencia["idInc"] ?>" class="incidencia-link mb-2">
                            <div class="row g-0 p-3 shadow-sm rounded incidencia-row <?= $prioClass ?> align-items-center">
                                <div class="col-1 fw-bold text-primary">#<?= $unaIncidencia["idInc"] ?></div>
                                <div class="col-2 fw-semibold"><?= $unaIncidencia["aula"] ?></div>
                                <div class="col-7 text-truncate"><?= $unaIncidencia["descripcio"] ?></div>
                                <div class="col-2 text-end text-muted small"><?= $unaIncidencia["dataIni"] ?></div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Configuració del Gràfic de Pastís
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?= json_encode($deptsArray); ?>,
                datasets: [{
                    data: <?= json_encode($tempsArray); ?>,
                    backgroundColor: [
                        '#0d6efd', '#6610f2', '#6f42c1', '#d63384', '#dc3545', '#fd7e14', '#ffc107', '#198754'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>