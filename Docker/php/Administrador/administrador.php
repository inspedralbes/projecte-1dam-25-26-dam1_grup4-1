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
        <img src="../Imatges/logo.png" alt="Logo" class="position-absolute top-0 start-0 mt-3 ms-3" style="width: 150px;">
        <h1 class="fs-3 fw-bold mb-1 " style="color: white;">GESTIÓ D'INCIDÈNCIES</h1>
        <h1 class="fs-3 fw-bold mb-0" style="color: white;">TÈCNICS</h1>
        <link rel="icon" href="../Imatges/favicon.jpg" type="image/png">
    </div>

    <div class="container pb-5" style="max-width: 900px;">
        <div class="row g-4 px-2">


            <div class="col-6">
                <a href="llistar.php" class="btn btn-primary btn-square btn-hover d-block text-white text-decoration-none py-5 px-4 text-center w-100">
                    <span class="d-block fs-4 mb-2">📋</span>
                    <span class="d-block fw-bold fs-6">LLISTAR INCIDÈNCIES</span>
                    <span class="d-block mt-2 fw-normal" style="font-size: 0.75rem; opacity: 0.8;">Veure i gestionar les incidències assignades</span>
                </a>
            </div>


            <div class="col-6">
                <a href="estadistiques.php" class="btn btn-orn btn-square btn-hover d-block text-white text-decoration-none py-5 px-4 text-center w-100" style="background-color: #ea580c; opacity: 0.9;">
                    <span class="d-block fs-4 mb-2">📊</span>
                    <span class="d-block fw-bold fs-6">ESTADÍSTIQUES</span>
                    <span class="d-block mt-2 fw-normal" style="font-size: 0.75rem; opacity: 0.8;">Visualitza dades de departaments i tècnics</span>
                </a>
            </div>

        </div>
    </div>
    </div>
    </div>

    <!-- Botó tornar -->
    <div class="fixed-bottom p-4">
        <a href="../index.php" class="btn btn-secondary px-4 shadow-sm">← Tornar</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>