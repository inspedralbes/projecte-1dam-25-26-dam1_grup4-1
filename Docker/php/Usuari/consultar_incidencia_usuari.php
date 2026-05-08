<?php
$mysqli = include_once "../connexio.php";
$resultat = $mysqli->query('
SELECT ID_INCIDENCIA, DESCRIPCIO, DATA_CREACIO, ESTAT FROM INCIDENCIA ORDER BY DATA_CREACIO DESC');
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
        }
    </style>
</head>

<body class="min-vh-100 d-flex flex-column bg-secondary bg-opacity-10">
    <!-- Header -->
    <div class="w-100 text-center py-4 shadow-sm mb-5 position-relative" style="background-color: #1e3a5f;">
        <img src="../Imatges/logo.png" alt="Logo" class="position-absolute top-0 start-0 mt-3 ms-3" style="width: 150px;">
        <h1 class="fs-3 fw-bold mb-1 " style="color: white;">INCIDÈNCIES REGISTRADES</h1>
        <h1 class="fs-3 fw-bold mb-0" style="color: white;">USUARIS</h1>
        <link rel="icon" href="../Imatges/favicon.jpg" type="image/png">
        <div class="position-absolute top-50 translate-middle-y d-flex gap-4" style="right: 10%;"> <a href="Usuari/usuari.php" class="text-white text-decoration-none fw-bold">Usuari</a>
            <a href="Tecnic/tecnic.php" class="text-white text-decoration-none fw-bold">Tècnic</a>
            <a href="Administrador/administrador.php" class="text-white text-decoration-none fw-bold">Admin</a>
        </div>
    </div>

    <!-- Taula -->
    <div class="container">
        <p class="text-muted mb-4">Aquesta és la llista de totes les incidències registrades.</p>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Descripció</th>
                    <th>Data de Creació</th>
                    <th>Estat</th>
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