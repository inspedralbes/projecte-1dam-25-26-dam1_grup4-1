<?php
require_once __DIR__ . '/../logger.php';
require_once __DIR__ . '/../connexio.php';
$pdo = new PDO("mysql:host=$host;dbname=$base_de_datos;charset=utf8mb4", $usuario, $contrasenia);

// Funció per comptar incidències pendents/assignades
function countIncidencies($pdo, $idTecnic)
{
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM INCIDENCIA WHERE ID_TECNIC = ? AND ESTAT != 'TANCADA'");
    $stmt->execute([$idTecnic]);
    return $stmt->fetchColumn();
}

// Funció per comptar incidències resoltes (Rendiment)
function countResoltes($pdo, $idTecnic)
{
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM INCIDENCIA WHERE ID_TECNIC = ? AND ESTAT = 'TANCADA'");
    $stmt->execute([$idTecnic]);
    return $stmt->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tècnic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-image: url('../Imatges/fons.jpg');
            background-size: cover;
            background-position: center;
        }

        .bg-custom-dark {
            background-color: #1e3a5f;
        }
    </style>
</head>

<body class="min-vh-100 d-flex flex-column bg-secondary bg-opacity-10">


    <header class="w-100 text-center py-4 shadow-sm mb-5 bg-custom-dark position-relative">
        <img src="../Imatges/logo.png" alt="Logo" class="position-absolute top-0 start-0 mt-3 ms-3 d-none d-md-block" style="width: 120px;">
        <h1 class="fs-3 fw-bold mb-1 text-white">TÈCNIC</h1>
        <p class="text-white-50 mb-0">Pàgina principal de tècnics</p>
        <link rel="icon" type="image/jpg" href="../Imatges/favicon.jpg">
    </header>

    <div class="container pb-5" style="max-width: 900px;">

        <p class="text-muted mb-4 text-center">Escull quin tècnic ets per veure les teves incidències assignades</p>

        <div class="row g-4">

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <i class="bi bi-person-circle fs-1 text-primary"></i>
                            <h5 class="fw-bold mb-0">Pere Portas</h5>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <a href="llistar_pere.php" class="btn btn-primary btn-sm px-3">
                                Veure incidències <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <i class="bi bi-person-circle fs-1 text-primary"></i>
                            <h5 class="fw-bold mb-0">Joan García</h5>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="llistar_joan.php" class="btn btn-primary btn-sm px-3">
                                Veure incidències <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <i class="bi bi-person-circle fs-1 text-primary"></i>
                            <h5 class="fw-bold mb-0">María López</h5>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="llistar_maria.php" class="btn btn-primary btn-sm px-3">
                                Veure incidències <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <footer class="bg-white bg-opacity-75 border-top mt-auto py-3">
        <p class="text-center text-muted mb-1">&copy; <?php echo date('Y'); ?> INS PEDRALBES</p>
        <p class="text-center text-muted mb-0 small">Jawad Mohdith and Sergi Martinez</p>
    </footer>

    <div class="fixed-bottom p-4">
        <a href="../index.php" class="btn btn-secondary px-4 shadow-sm">← Tornar</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>