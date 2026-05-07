<?php
$host = "db";
$dbname = "projecte_gip3";
$username = "usuari";
$password = "1234";
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$sort  = $_GET['sort']  ?? 'DATA_CREACIO';
$order = $_GET['order'] ?? 'DESC';

$sql = "SELECT  
            i.ID_INCIDENCIA,
            i.DATA_CREACIO,
            i.DATA_INICI,
            i.DESCRIPCIO,
            d.NOM
        FROM INCIDENCIA i 
        LEFT JOIN DEPARTAMENT d ON i.ID_DEPARTAMENT = d.ID_DEPARTAMENT
        WHERE i.ESTAT <> 'TANCADA'
        ORDER BY $sort $order";

$incidencies = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
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
        <h1 class="fs-3.5 fw-bold mb-3 " style="color: white;">Administrador</h1>
        <h1 class="fs-3 fw-bold mb-0" style="color: white;"> </h1>
        <link rel="icon" href="../Imatges/favicon.jpg" type="image/png">
    </div>

    <div class="container-md pb-5">

        <p class="text-muted mb-4">Clica el ID per gestionar una incidència</p>

        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover table-bordered bg-white mb-0">
                <thead class="table-light">
                    <tr>
                        <th>
                            #ID
                            <a href="?sort=ID_INCIDENCIA&order=asc" class="text-decoration-none ms-1">↑</a>
                            <a href="?sort=ID_INCIDENCIA&order=desc" class="text-decoration-none">↓</a>
                        </th>
                        <th>
                            Data creació
                            <a href="?sort=DATA_CREACIO&order=asc" class="text-decoration-none ms-1">↑</a>
                            <a href="?sort=DATA_CREACIO&order=desc" class="text-decoration-none">↓</a>
                        </th>
                        <th>
                            Data inici
                            <a href="?sort=DATA_INICI&order=asc" class="text-decoration-none ms-1">↑</a>
                            <a href="?sort=DATA_INICI&order=desc" class="text-decoration-none">↓</a>
                        </th>
                        <th>
                            Descripció
                            <a href="?sort=DESCRIPCIO&order=asc" class="text-decoration-none ms-1">↑</a>
                            <a href="?sort=DESCRIPCIO&order=desc" class="text-decoration-none">↓</a>
                        </th>
                        <th>
                            Departament
                            <a href="?sort=NOM&order=asc" class="text-decoration-none ms-1">↑</a>
                            <a href="?sort=NOM&order=desc" class="text-decoration-none">↓</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($incidencies)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No hi ha incidències registrades.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($incidencies as $inc): ?>
                            <tr>
                                <td>
                                    <a href="gestionar.php?id=<?= $inc['ID_INCIDENCIA'] ?>"
                                        class="fw-bold text-primary text-decoration-none">
                                        #<?= $inc['ID_INCIDENCIA'] ?>
                                    </a>
                                </td>
                                <td class="text-secondary small"><?= $inc['DATA_CREACIO'] ? htmlspecialchars($inc['DATA_CREACIO']) : '—' ?></td>
                                <td class="text-secondary small"><?= $inc['DATA_INICI']   ? htmlspecialchars($inc['DATA_INICI'])   : '—' ?></td>
                                <td><?= $inc['DESCRIPCIO'] ? htmlspecialchars($inc['DESCRIPCIO']) : '—' ?></td>
                                <td><?= $inc['NOM']        ? htmlspecialchars($inc['NOM'])        : '—' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Botó tornar -->
    <div class="fixed-bottom p-4">
        <a href="administrador.php" class="btn btn-secondary px-4 shadow-sm">← Tornar</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>