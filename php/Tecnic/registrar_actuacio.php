<?php
require_once __DIR__ . '/../logger.php';
require_once __DIR__ . '/../connexio.php';
$pdo = new PDO("mysql:host=$host;dbname=$base_de_datos;charset=utf8mb4", $usuario, $contrasenia);

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descripcio  = $_POST['descripcio'];
    $temps       = $_POST['temps'];
    $visible     = isset($_POST['visible']) ? 1 : 0;
    $finalitzada = isset($_POST['finalitzada']) ? 1 : 0;
    $data_fi     = !empty($_POST['data_fi']) ? $_POST['data_fi'] : date('Y-m-d H:i:s');

    $stmt = $pdo->prepare("INSERT INTO ACTUACIO (ID_INCIDENCIA, DESCRIPCIO, TEMPS_ACTUACIO_MIN, VISIBLE, ESTAT) VALUES (?, ?, ?, ?, ?)");
    $estat_actuacio = $finalitzada ? 'ACABAT' : 'PENDENT';
    $stmt->execute([$id, $descripcio, $temps, $visible, $estat_actuacio]);

    if ($finalitzada) {
        $stmt2 = $pdo->prepare("UPDATE INCIDENCIA SET ESTAT = 'TANCADA', DATA_FI = ? WHERE ID_INCIDENCIA = ?");
        $stmt2->execute([$data_fi, $id]);
    }

    $missatge = "Actuació registrada!";
}

$stmt = $pdo->prepare("SELECT * FROM ACTUACIO WHERE ID_INCIDENCIA = ? ORDER BY ID_ACTUACIO DESC");
$stmt->execute([$id]);
$actuacions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Actuació #<?= $id ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-image: url(../Imatges/fons.jpg);
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="min-vh-100 d-flex flex-column bg-secondary bg-opacity-10">

    <!-- Header -->

    <header class="w-100 text-center py-4 shadow-sm mb-5 bg-custom-dark position-relative" style="background-color: #1e3a5f;">
        <img src="../Imatges/logo.png" alt="Logo" class="position-absolute top-0 start-0 mt-3 ms-3 d-none d-md-block" style="width: 120px;">
        <h1 class="fs-3 fw-bold mb-1 text-white">REGISTRAR ACTUACIÓ</h1>
        <p class="text-white-50 mb-0">Registrar Actuació · Incidència #<?= $id ?></p>
        <link rel="icon" type="image/jpg" href="../Imatges/favicon.jpg">
    </header>

    <div class="container-md pb-5">

        <!-- Missatge OK -->
        <?php if (isset($missatge)): ?>
            <div class="alert alert-success fw-bold mb-4"><?= $missatge ?></div>
        <?php endif; ?>

        <!-- Actuacions existents -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body" style="background: rgba(226, 226, 226, 0.3)">
                <h5 class=" fw-bold mb-3 ">Actuacions fins al moment</h5>
                <?php if (empty($actuacions)): ?>
                    <p class=" text-muted">Encara no hi ha actuacions registrades.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Descripció</th>
                                    <th>Temps (min)</th>
                                    <th>Visible usuari</th>
                                    <th>Estat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($actuacions as $a): ?>
                                    <tr>
                                        <td><?= $a['DESCRIPCIO'] ?></td>
                                        <td><?= $a['TEMPS_ACTUACIO_MIN'] ?></td>
                                        <td><?= $a['VISIBLE'] ? 'Sí' : 'No' ?></td>
                                        <td><?= $a['ESTAT'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Nova actuació -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body" style="background: rgba(231, 231, 231, 0.3)">
                <h5 class="fw-bold mb-4">Nova actuació</h5>
                <form method="POST" id="formulariActuacio">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Descripció:</label>
                        <textarea name="descripcio" rows="4" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Temps dedicat (minuts):</label>
                        <input type="number" name="temps" min="1" class="form-control" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="visible" value="1" class="form-check-input" id="visible">
                        <label class="form-check-label fw-bold" for="visible">Visible per a l'usuari</label>
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" name="finalitzada" value="1" class="form-check-input" id="finalitzada">
                        <label class="form-check-label fw-bold" for="finalitzada">Marcar com a finalitzada</label>
                    </div>

                    <button type="submit" class="btn btn-primary px-4 fw-bold">Guardar</button>

                </form>
            </div>
        </div>

    </div>
    <footer class="bg-white bg-opacity-75 border-top mt-auto py-3">
        <p class="text-center text-muted mb-1">&copy; <?php echo date('Y'); ?> INS PEDRALBES</p>
        <p class="text-center text-muted mb-0 small">Jawad Mohdith and Sergi Martinez</p>
    </footer>
    <!-- Botó tornar -->
    <div class="fixed-bottom p-4">
        <a href="tecnic.php" class="btn btn-secondary px-4 shadow-sm">← Tornar</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>