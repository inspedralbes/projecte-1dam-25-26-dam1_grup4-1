<?php
$host = "db";
$dbname = "projecte_gip3";
$username = "usuari";
$password = "1234";
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// 1. Recollim paràmetres de la URL o posem valors per defecte
$sort = $_GET['sort'] ?? 'DATA_CREACIO';
$order = $_GET['order'] ?? 'DESC';

// 2. SQL amb l'ordenació dinàmica (Variables $sort i $order)
$sql = "SELECT  
            i.ID_INCIDENCIA,
            i.DATA_CREACIO,
            i.DATA_INICI,
            i.DESCRIPCIO,
            d.NOM
        FROM INCIDENCIA i
        LEFT JOIN DEPARTAMENT d ON i.ID_DEPARTAMENT = d.ID_DEPARTAMENT
        ORDER BY $sort $order";

$incidencies = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pàgina del administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: sans-serif;
        }

        main {
            max-width: 1200px;

            margin: 0 auto;

            padding: 0 40px;

        }

        header {
            background-color: #f0f2f5;
            font-family: sans-serif;
            padding: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        thead th {
            background: white;
            color: red;
            padding: 12px 14px;
            font-size: 0.85rem;
            text-align: left;
        }

        tbody td {
            padding: 11px 14px;
            font-size: 0.87rem;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background-color: #f9fafb;
        }

        td.id {
            font-weight: bold;
            color: #0d6cf1;
        }

        td.data {
            color: #065dea;
            font-size: 0.8rem;
        }

        td.descripcio {
            max-width: 200px;
            line-height: 1.5;
        }

        select {
            padding: 8px 6px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            background-color: #fff;
            font-size: 0.8rem;
            width: 100%;
        }


        .order-link {
            text-decoration: none;
            font-size: 0.7rem;
            margin-left: 2px;
        }
    </style>
</head>

<body>
    <main>
        <header>
            <h1>Gestió d'Incidències</h1>
            <span>Clica el ID Per gestionar una incidència</span>
        </header>
        <table>
            <thead>
                <tr>
                    <th>
                        #ID
                        <a href="?sort=ID_INCIDENCIA&order=asc" class="order-link">↑</a>
                        <a href="?sort=ID_INCIDENCIA&order=desc" class="order-link">↓</a>
                    </th>
                    <th>
                        Data creació
                        <a href="?sort=DATA_CREACIO&order=asc" class="order-link">↑</a>
                        <a href="?sort=DATA_CREACIO&order=desc" class="order-link">↓</a>
                    </th>
                    <th>
                        Data inici
                        <a href="?sort=DATA_INICI&order=asc" class="order-link">↑</a>
                        <a href="?sort=DATA_INICI&order=desc" class="order-link">↓</a>
                    </th>
                    <th>
                        Descripció
                        <a href="?sort=DESCRIPCIO&order=asc" class="order-link">↑</a>
                        <a href="?sort=DESCRIPCIO&order=desc" class="order-link">↓</a>
                    </th>
                    <th>
                        Departament
                        <a href="?sort=NOM&order=asc" class="order-link">↑</a>
                        <a href="?sort=NOM&order=desc" class="order-link">↓</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($incidencies)): ?>
                    <tr>
                        <td colspan="5" class="empty">No hi ha incidències registrades.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($incidencies as $inc): ?>
                        <tr>
                            <td class="id">
                                <a href="gestionar.php?id=<?= $inc['ID_INCIDENCIA'] ?>"
                                    title="Clica per gestionar aquesta incidència"
                                    style="color:blue;text-decoration:none;font-weight:bold;">
                                    #<?= $inc['ID_INCIDENCIA'] ?>
                                </a>
                            </td>
                            <td class="data"><?= $inc['DATA_CREACIO'] ? htmlspecialchars($inc['DATA_CREACIO']) : '—' ?></td>
                            <td class="data"><?= $inc['DATA_INICI'] ? htmlspecialchars($inc['DATA_INICI']) : '—' ?></td>
                            <td class="descripcio"><?= $inc['DESCRIPCIO'] ? htmlspecialchars($inc['DESCRIPCIO']) : '—' ?></td>
                            <td class="departament"><?= $inc['NOM'] ? htmlspecialchars($inc['NOM']) : '—' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="fixed-bottom p-4">
            <a href="index.php" class="btn btn-secondary px-4 shadow-sm">← Tornar</a>
        </div>
    </main>

</body>

</html>