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
        /* Solo lo que Bootstrap no puede hacer */
        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>

<body class="bg-light min-vh-100">

    <!-- Header -->
    <div class="w-100 text-center py-4 shadow-sm mb-5" style="background-color: rgba(144, 178, 216, 0.8);">
        <h1 class="fs-3 fw-bold mb-1">GESTIÓ D'INCIDÈNCIES</h1>
        <h1 class="fs-3 fw-bold mb-0">Les meves incidències</h1>
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
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultat as $inc):
                    $color = '';
                    if ($inc['ESTAT'] === 'OBERTA') $color = 'table-warning';
                    elseif ($inc['ESTAT'] === 'EN_PROCES') $color = 'table-info';
                    elseif ($inc['ESTAT'] === 'TANCADA') $color = 'table-success';
                ?>
                    <tr class="<?= $color ?>">
                        <td><?= $inc['ID_INCIDENCIA'] ?></td>
                        <td><?= htmlspecialchars($inc['DESCRIPCIO']) ?></td>
                        <td><?= $inc['DATA_CREACIO'] ?></td>
                        <td><?= $inc['ESTAT'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>