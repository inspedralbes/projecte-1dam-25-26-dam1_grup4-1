<?php
$mysqli = include_once "connexio.php";
$resultat = $mysqli->query('
SELECT ID_INCIDENCIA, DESCRIPCIO, DATA_CREACIO, ESTAT FROM INCIDENCIA ORDER BY DATA_CREACIO DESC');
$resultat = $resultat->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les meves incidències</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>

<body class="bg-light min-vh-100">

    <!-- Header -->
    <div class="w-100 text-center py-4 shadow-sm mb-5" style="background-color: #1e3a5f;">
        <h1 class="fs-3 fw-bold mb-1 text-white">GESTIÓ D'INCIDÈNCIES</h1>
        <h1 class="fs-3 fw-bold mb-0 text-white">Les meves incidències</h1>
        <img src="logo.png" alt="Logo" class="position-absolute top-0 start-0 mt-3 ms-3" style="width: 150px;">
    </div>

    <!-- Taula -->
    <div class="container">
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

    <div class="fixed-bottom p-4">
        <a href="usuari.php" class="btn btn-secondary px-4 shadow-sm">← Tornar</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>