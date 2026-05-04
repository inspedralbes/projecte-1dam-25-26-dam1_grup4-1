<?php
$host = "db";
$dbname = "projecte_gip3";
$username = "usuari";
$password = "1234";
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$id = $_GET['id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descripcio  = $_POST['descripcio'];
    $temps       = $_POST['temps'];
    $visible     = isset($_POST['visible']) ? 1 : 0;
    $finalitzada = isset($_POST['finalitzada']) ? 1 : 0;
    $data_fi     = !empty($_POST['data_fi']) ? $_POST['data_fi'] : date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("INSERT INTO ACTUACIO (ID_INCIDENCIA, DESCRIPCIO, TEMPS_ACTUACIO_MIN, VISIBLE) VALUES (?, ?, ?, ?)");
    $stmt->execute([$id, $descripcio, $temps, $visible]);

    if ($finalitzada) {
        $stmt2 = $pdo->prepare("UPDATE INCIDENCIA SET ESTAT = 'FINALITZADA', DATA_FI = ? WHERE ID_INCIDENCIA = ?");
        $stmt2->execute([$data_fi, $id]);
    }

    $missatge = "Actuació registrada!";
}

// Carregar actuacions existents
$stmt = $pdo->prepare("SELECT * FROM ACTUACIO WHERE ID_INCIDENCIA = ? ORDER BY ID_ACTUACIO DESC");
$stmt->execute([$id]);
$actuacions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title>Registrar Actuació #<?= $id ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: sans-serif;
        }

        header {
            padding: 30px;
        }

        .caixa {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 24px;
            margin: 0 30px 20px 30px;
        }

        label {
            font-weight: bold;
            font-size: 0.9rem;
        }

        textarea, input[type="number"], input[type="datetime-local"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            margin-bottom: 16px;
        }

        .btn-save {
            background-color: #4f46e5;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 8px 20px;
            cursor: pointer;
        }

        .btn-save:hover {
            background-color: #4338ca;
        }

        .missatge {
            background: #d1fae5;
            border: 1px solid #6ee7b7;
            color: #065f46;
            padding: 10px 16px;
            border-radius: 8px;
            margin: 0 30px 16px 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 10px 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.9rem;
        }

        th {
            background-color: #f9fafb;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <header>
        <h1>Registrar Actuació · Incidència #<?= $id ?></h1>
    </header>

    <?php if (isset($missatge)): ?>
        <div class="missatge"><?= $missatge ?></div>
    <?php endif; ?>

    <div class="caixa">
        <h5>Actuacions fins al moment</h5>
        <?php if (empty($actuacions)): ?>
            <p>Encara no hi ha actuacions registrades.</p>
        <?php else: ?>
            <table>
                <thead>
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
        <?php endif; ?>
    </div>

    <div class="caixa">
        <h5>Nova actuació</h5>
        <form method="POST">

            <label>Descripció:</label>
            <textarea name="descripcio" rows="4" required></textarea>

            <label>Temps dedicat (minuts):</label>
            <input type="number" name="temps" min="1" required>

            <label>Visible per a l'usuari:</label>
            <div style="margin-bottom: 16px;">
                <input type="checkbox" name="visible" value="1"> Sí
            </div>

            <label>Finalitzar incidència:</label>
            <div style="margin-bottom: 16px;">
                <input type="checkbox" name="finalitzada" value="1"> Marcar com a finalitzada
            </div>

           

            <button type="submit" class="btn-save">Guardar</button>
        </form>
    </div>

    <div class="fixed-bottom p-4">
        <a href="llistar.php" class="btn btn-secondary px-4 shadow-sm">← Tornar</a>
    </div>

</body>

</html>