<?php
$host = "db";
$dbname = "projecte_gip3";
$username = "usuari";
$password = "1234";
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$idTecnic = 3; // ID del tècnic Maria López
$stmt = $pdo->prepare("SELECT 
                            i.ID_INCIDENCIA,
                            i.DATA_CREACIO,
                            i.DATA_INICI,
                            i.DESCRIPCIO,
                            d.NOM
                        FROM INCIDENCIA i
                        LEFT JOIN DEPARTAMENT d ON i.ID_DEPARTAMENT = d.ID_DEPARTAMENT
                        WHERE i.ID_TECNIC = ?
                        ORDER BY i.DATA_CREACIO DESC");
$stmt->execute([$idTecnic]);
$incidencies = $stmt->fetchAll();
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
                    <th>Descripció</th>
                    <th>Departament</th>
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
                                <a href="registrar_actuacio.php?id=<?= $inc['ID_INCIDENCIA'] ?>"
                                    title="Clica per gestionar aquesta incidència"
                                    style="color:blue;text-decoration:none;font-weight:bold;">
                                    #<?= $inc['ID_INCIDENCIA'] ?>
                                </a>
                            </td>
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