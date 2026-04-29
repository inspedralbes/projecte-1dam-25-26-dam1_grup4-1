<?php
$host = "db";
$dbname = "projecte_gip3";
$username = "usuari";
$password = "1234";
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$incidencies = $pdo->query("SELECT  
                                ID_INCIDENCIA,
                                DATA_CREACIO,
                                DATA_INICI,
                                DESCRIPCIO
FROM INCIDENCIA
ORDER BY DATA_CREACIO DESC")->fetchAll();
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
            font-size: 0.6rem;
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
                    <th>#ID</th>
                    <th>Data creació</th>
                    <th>Data inici</th>
                    <th>Descripció</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($incidencies)): ?>
                    <tr>
                        <td colspan="4" class="empty">No hi ha incidències registrades.</td>
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

                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>

</html>