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
    <link rel="icon" href="../Imatges/favicon.jpg" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-image: url('../Imatges/fons.png');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
        }

        .btn-orn {
            background-color: #ea580c;
        }

        .btn-orn:hover {
            background-color: #c2410c;
            color: white;
            opacity: 1;
        }

        .btn-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
            opacity: 1;
        }

        footer {
            margin-top: auto;
        }
    </style>
</head>

<body class="min-vh-100 bg-secondary bg-opacity-10">

    <!-- Header -->
    <div class="w-100 text-center py-4 shadow-sm mb-5 position-relative" style="background-color: #1e3a5f;">
        <img src="../Imatges/logo.png" alt="Logo" class="position-absolute top-0 start-0 mt-3 ms-3" style="width: 150px;">
        <h1 class="fs-3 fw-bold mb-1 " style="color: white;">INS PEDRALBES</h1>
        <h1 class="fs-3 fw-bold mb-0" style="color: white;">ADMINISTRADOR</h1>
        <link rel="icon" href="../Imatges/favicon.jpg" type="image/png">
        <div class="position-absolute top-50 translate-middle-y d-flex gap-4" style="right: 10%;"> <a href="Usuari/usuari.php" class="text-white text-decoration-none fw-bold">Usuari</a>
            <a href="Tecnic/tecnic.php" class="text-white text-decoration-none fw-bold">Tècnic</a>
            <a href="Administrador/administrador.php" class="text-white text-decoration-none fw-bold">Admin</a>
        </div>
    </div>

    <div class="container pb-5" style="max-width: 900px;">
        <div class="row g-4 px-2">
            <p class="text-muted mb-4">Els següents enllaços et permetran gestionar les incidències i visualitzar estadístiques.</p>

            <div class="row g-4">
                <div class="col-6">
                    <a href="llistar.php" class="btn btn-primary btn-hover d-block text-white text-decoration-none py-5 px-4 text-center w-100" style="background-color: #1e5f49;">
                        <i class="bi bi-clipboard-list d-block fs-2 mb-2"></i>
                        <span class="d-block fw-bold fs-6">GESTIONAR INCIDÈNCIES</span>
                        <span class="d-block mt-2 fw-normal" style="font-size: 0.75rem; opacity: 0.8;">Veure i gestionar les incidències assignades</span>
                    </a>
                </div>

                <div class="col-6">
                    <a href="estadistiques.php" class="btn btn-orn btn-hover d-block text-white text-decoration-none py-5 px-4 text-center w-100" style="background-color:rgb(227, 12, 234);">
                        <i class="bi bi-bar-chart-line d-block fs-2 mb-2"></i>
                        <span class="d-block fw-bold fs-6">ESTADÍSTIQUES</span>
                        <span class="d-block mt-2 fw-normal" style="font-size: 0.75rem; opacity: 0.8;">Visualitza dades de departaments i tècnics</span>
                    </a>
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
        <a href="../index.php" class="btn btn-secondary px-4 shadow-sm">← Tornar</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>