<?php
require_once __DIR__ . '/../logger.php';

$mysqli = include_once "../connexio.php";

// Paràmetres d'ordenació
$sort = $_GET['sort'] ?? 'DATA_CREACIO';
$order = $_GET['order'] ?? 'DESC';

// Validar columnes permeses
$allowed_sorts = ['ID_INCIDENCIA', 'DESCRIPCIO', 'DATA_CREACIO', 'ESTAT'];
if (!in_array($sort, $allowed_sorts)) {
    $sort = 'DATA_CREACIO';
}

// Validar ordre
$order = strtoupper($order);
if ($order !== 'ASC' && $order !== 'DESC') {
    $order = 'DESC';
}

$query = "SELECT ID_INCIDENCIA, DESCRIPCIO, DATA_CREACIO, ESTAT FROM INCIDENCIA ORDER BY $sort $order";
$resultat = $mysqli->query($query);
$resultat = $resultat->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidències Registrades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-image: url('../Imatges/fons.png');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
        }

        footer {
            margin-top: auto;
        }
    </style>
</head>

<body class="min-vh-100 d-flex flex-column bg-secondary bg-opacity-10">
    <!-- Header -->
    <div class="w-100 text-center py-4 shadow-sm mb-5 position-sticky" style="background-color: #1e3a5f;">
        <img src="../Imatges/logo.png" alt="Logo" class="position-absolute top-0 start-0 mt-3 ms-3" style="width: 150px;">
        <h1 class="fs-3 fw-bold mb-1 " style="color: white;">INCIDÈNCIES REGISTRADES</h1>
        <h1 class="fs-3 fw-bold mb-0" style="color: white;">USUARIS</h1>
        <link rel="icon" href="../Imatges/favicon.jpg" type="image/png">
        <link rel="icon" href="../Imatges/favicon.jpg" type="image/png">
    </div>

    <!-- Taula -->
    <div class="container">
        <p class="text-muted mb-4">Aquesta és la llista de totes les incidències registrades.</p>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>ID
                        <a href="?sort=ID_INCIDENCIA&order=asc" class="text-decoration-none ms-1">↑</a>
                        <a href="?sort=ID_INCIDENCIA&order=desc" class="text-decoration-none">↓</a>
                    </th>
                    <th>Descripció
                        <a href="?sort=DESCRIPCIO&order=asc" class="text-decoration-none ms-1">↑</a>
                        <a href="?sort=DESCRIPCIO&order=desc" class="text-decoration-none">↓</a>
                    </th>
                    <th>Data de Creació
                        <a href="?sort=DATA_CREACIO&order=asc" class="text-decoration-none ms-1">↑</a>
                        <a href="?sort=DATA_CREACIO&order=desc" class="text-decoration-none">↓</a>
                    </th>
                    <th>Estat
                        <a href="?sort=ESTAT&order=asc" class="text-decoration-none ms-1">↑</a>
                        <a href="?sort=ESTAT&order=desc" class="text-decoration-none">↓</a>
                    </th>
                    <th>Actuacions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultat as $inc):
                    $color = '';
                    if ($inc['ESTAT'] === 'OBERTA') $color = 'table-warning';
                    elseif ($inc['ESTAT'] === 'EN_PROCES') $color = 'table-info';
                    elseif ($inc['ESTAT'] === 'TANCADA') $color = 'table-success';

                    // Carregar actuacions visibles d'aquesta incidència
                    $id_inc = $inc['ID_INCIDENCIA'];
                    $acts = $mysqli->query("SELECT DESCRIPCIO, TEMPS_ACTUACIO_MIN FROM ACTUACIO WHERE ID_INCIDENCIA = $id_inc AND VISIBLE = 1");
                    $acts = $acts->fetch_all(MYSQLI_ASSOC);
                ?>
                    <tr class="<?= $color ?>">
                        <td><?= $inc['ID_INCIDENCIA'] ?></td>
                        <td><?= htmlspecialchars($inc['DESCRIPCIO']) ?></td>
                        <td><?= $inc['DATA_CREACIO'] ?></td>
                        <td><?= $inc['ESTAT'] ?></td>
                        <td>
                            <?php if (empty($acts)): ?>
                                <span class="text-muted">Sense actuacions</span>
                            <?php else: ?>
                                <?php foreach ($acts as $a): ?>
                                    <div class="mb-1">
                                        <?= htmlspecialchars($a['DESCRIPCIO']) ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <footer class="bg-white bg-opacity-75 border-top mt-auto py-3">
        <p class="text-center text-muted mb-1">&copy; <?php echo date('Y'); ?> INS PEDRALBES</p>
        <p class="text-center text-muted mb-0 small">Jawad Mohdith and Sergi Martinez</p>
    </footer>
    <div class="fixed-bottom p-4">
        <a href="usuari.php" class="btn btn-secondary px-4 shadow-sm">← Tornar</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>