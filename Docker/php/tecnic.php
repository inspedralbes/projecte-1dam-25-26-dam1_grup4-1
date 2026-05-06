<?php
$host = "db";
$dbname = "projecte_gip3";
$username = "usuari";
$password = "1234";
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

function countIncidencies($pdo, $idTecnic)
{
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM INCIDENCIA WHERE ID_TECNIC = ?");
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
        }
    </style>
</head>

<body class="min-vh-100 d-flex flex-column bg-secondary bg-opacity-10">

    <!-- Header -->
    <div class="w-100 text-center py-4 shadow-sm mb-5 position-relative" style="background-color: #1e3a5f;">
        <img src="logo.png" alt="Logo" class="position-absolute top-0 start-0 mt-3 ms-3" style="width: 150px;">
        <h1 class="fs-3 fw-bold mb-1 " style="color: white;">GESTIÓ D'INCIDÈNCIES</h1>
        <h1 class="fs-3 fw-bold mb-0" style="color: white;">TÈCNICS</h1>
        <link rel="icon" href="favicon.jpg" type="image/png">
    </div>

    <div class="container pb-5" style="max-width: 900px;">

        <p class="text-muted mb-4">Escull quin tècnic ets per veure les teves incidències assignades</p>

        <div class="row g-4">

            <div class="col-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <i class="bi bi-person-circle fs-1 text-primary"></i>
                            <h5 class="fw-bold mb-0">Pere Portas</h5>
                        </div>
                        <p class="text-muted mb-1"><i class="bi bi-tools me-2"></i>Xarxes i Comunicacions</p>
                        <p class="mb-0"><i class="bi bi-exclamation-circle me-2 text-warning"></i>Incidències: <?php echo countIncidencies($pdo, 1); ?></p>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="llistar_pere.php" class="btn btn-primary btn-sm">
                                Veure incidències <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <i class="bi bi-person-circle fs-1 text-primary"></i>
                            <h5 class="fw-bold mb-0">Joan Garcia</h5>
                        </div>
                        <p class="text-muted mb-1"><i class="bi bi-tools me-2"></i>Hardware i Manteniment</p>
                        <p class="mb-0"><i class="bi bi-exclamation-circle me-2 text-warning"></i>Incidències: <?php echo countIncidencies($pdo, 2); ?></p>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="llistar_joan.php" class="btn btn-primary btn-sm">
                                Veure incidències <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <i class="bi bi-person-circle fs-1 text-primary"></i>
                            <h5 class="fw-bold mb-0">Maria Lopez</h5>
                        </div>
                        <p class="text-muted mb-1"><i class="bi bi-tools me-2"></i>Software i Sistemes Operatius</p>
                        <p class="mb-0"><i class="bi bi-exclamation-circle me-2 text-warning"></i>Incidències: <?php echo countIncidencies($pdo, 3); ?></p>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="llistar_maria.php" class="btn btn-primary btn-sm">
                                Veure incidències <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Botó tornar -->
    <div class="fixed-bottom p-4">
        <a href="index.php" class="btn btn-secondary px-4 shadow-sm">← Tornar</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>