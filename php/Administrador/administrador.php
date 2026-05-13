<?php
require_once __DIR__ . '/../logger.php';
require_once __DIR__ . '/../connexio.php';

$pdo = new PDO("mysql:host=$host;dbname=$base_de_datos;charset=utf8mb4", $usuario, $contrasenia);
// Funció per comptar incidències per tècnic (Tarjeta tècnics)
function countIncidencies($pdo, $idTecnic)
{
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM INCIDENCIA WHERE ID_TECNIC = ?");
    $stmt->execute([$idTecnic]);
    return $stmt->fetchColumn();
}

$stmt = $pdo->query("SELECT ESTAT, COUNT(*) AS TOTAL FROM INCIDENCIA GROUP BY ESTAT");
$stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

$comptadors = ["OBERTA" => 0, "EN_PROCES" => 0, "TANCADA" => 0];
foreach ($stats as $stat) {
    $comptadors[$stat['ESTAT']] = $stat['TOTAL'];
}
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="icon" href="../Imatges/favicon.jpg" type="image/jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        .btn-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
            opacity: 1 !important;
        }
    </style>
</head>

<body class="min-vh-100 d-flex flex-column" style="background-image: url('../Imatges/fons.jpg'); background-size: cover; background-position: center;">

    <!-- Header -->
    <header class="w-100 text-center py-4 shadow-sm mb-5 position-relative" style="background-color: #1e3a5f;">
        <img src="../Imatges/logo.png" alt="Logo" class="position-absolute top-0 start-0 mt-3 ms-3 d-none d-md-block" style="width: 120px;">
        <h1 class="fs-3 fw-bold mb-1 text-white">ADMINISTRADOR</h1>
        <p class="text-white-50 mb-0">Pàgina principal de l'administrador</p>
    </header>

    <div class="container pb-5" style="max-width: 900px;">

        <!-- Targetes estadístiques -->
        <div class="row g-4 mb-5">
            <div class="col-4">
                <div class="card border-0 shadow-sm text-center py-4 bg-white bg-opacity-75">
                    <h2 class="fw-bold mb-0 text-danger"><?= $comptadors['OBERTA'] ?></h2>
                    <p class="text-muted small text-uppercase fw-bold mt-1 mb-0">Obertes</p>
                </div>
            </div>
            <div class="col-4">
                <div class="card border-0 shadow-sm text-center py-4 bg-white bg-opacity-75">
                    <h2 class="fw-bold mb-0 text-warning"><?= $comptadors['EN_PROCES'] ?></h2>
                    <p class="text-muted small text-uppercase fw-bold mt-1 mb-0">En procés</p>
                </div>
            </div>
            <div class="col-4">
                <div class="card border-0 shadow-sm text-center py-4 bg-white bg-opacity-75">
                    <h2 class="fw-bold mb-0 text-success"><?= $comptadors['TANCADA'] ?></h2>
                    <p class="text-muted small text-uppercase fw-bold mt-1 mb-0">Tancades</p>
                </div>
            </div>
        </div>

        <p class="text-muted mb-4">Els següents enllaços et permetran gestionar les incidències i visualitzar estadístiques.</p>

        <!-- Botons -->
        <div class="row g-4">
            <div class="col-6">
                <a href="llistar.php" class="btn btn-hover d-block text-white text-decoration-none py-5 px-4 text-center w-100" style="background-color: #1e5f49;">
                    <i class="bi bi-exclamation-circle-fill d-block fs-2 mb-2"></i>
                    <span class="d-block fw-bold fs-6">GESTIONAR INCIDÈNCIES</span>
                    <span class="d-block mt-2 fw-normal" style="font-size: 0.75rem; opacity: 0.8;">Veure i gestionar les incidències assignades</span>
                </a>
            </div>
            <div class="col-6">
                <a href="estadistiques.php" class="btn btn-hover d-block text-white text-decoration-none py-5 px-4 text-center w-100" style="background-color: rgb(227, 12, 234);">
                    <i class="bi bi-bar-chart-line d-block fs-2 mb-2"></i>
                    <span class="d-block fw-bold fs-6">ESTADÍSTIQUES</span>
                    <span class="d-block mt-2 fw-normal" style="font-size: 0.75rem; opacity: 0.8;">Visualitza dades de departaments i tècnics</span>
                </a>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-white bg-opacity-75 border-top mt-auto py-3">
        <p class="text-center text-muted mb-1">&copy; <?= date('Y') ?> INS PEDRALBES</p>
        <p class="text-center text-muted mb-0 small">Jawad Mohdith and Sergi Martinez</p>
    </footer>

    <!-- Botó tornar -->
    <div class="fixed-bottom p-4">
        <a href="../index.php" class="btn btn-secondary px-4 shadow-sm">← Tornar</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>