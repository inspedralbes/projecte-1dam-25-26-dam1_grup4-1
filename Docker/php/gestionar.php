<?php
$host = "db";
$dbname = "projecte_gip3";
$username = "usuari";
$password = "1234";
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$id = $_GET['id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tecnic    = $_POST['tecnic'];
    $prioritat = $_POST['prioritat'];


    $stmt = $pdo->prepare("UPDATE INCIDENCIA SET ID_TECNIC = ?, PRIORITAT = ?  WHERE ID_INCIDENCIA = ?");
    $stmt->execute([$tecnic, $prioritat, $id]);

    $missatge = "Incidència actualitzada!";
}

// Carregar dades de la incidència
$stmt = $pdo->prepare("SELECT * FROM INCIDENCIA WHERE ID_INCIDENCIA = ?");
$stmt->execute([$id]);
$inc = $stmt->fetch();

// Carregar tècnics
$tecnics = $pdo->query("SELECT * FROM TECNIC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title>Gestionar Incidència #<?= $id ?></title>
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

        select {
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
    </style>
</head>

<body>

    <header>

        <h1>Gestionar Incidència #<?= $id ?></h1>
    </header>

    <?php if (isset($missatge)): ?>
        <div class="missatge"><?= $missatge ?></div>
    <?php endif; ?>


    <div class="caixa">
        <h5>Informació</h5>
        <p><strong>Data creació:</strong> <?= $inc['DATA_CREACIO'] ?></p>
        <p><strong>Data inici:</strong> <?= $inc['DATA_INICI'] ?? '—' ?></p>
        <p><strong>Descripció:</strong> <?= $inc['DESCRIPCIO'] ?></p>
    </div>


    <div class="caixa">
        <h5>Assignar tècnic i prioritat</h5>
        <form method="POST">

            <label>Tècnic:</label>
            <select name="tecnic">
                <option value="">— Selecciona —</option>
                <?php foreach ($tecnics as $t): ?>
                    <option value="<?= $t['ID_TECNIC'] ?>" <?= $inc['ID_TECNIC'] == $t['ID_TECNIC'] ? 'selected' : '' ?>>
                        <?= $t['NOM'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Prioritat:</label>
            <select name="prioritat">
                <?php foreach (['ALTA', 'MITJANA', 'BAIXA'] as $p): ?>
                    <option value="<?= $p ?>" <?= $inc['PRIORITAT'] === $p ? 'selected' : '' ?>>
                        <?= $p ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn-save">Guardar</button>
        </form>
       <div class="fixed-bottom p-4">
      <a href="index.php" class="btn btn-secondary px-4 shadow-sm">← Tornar</a>
   </div>
</body>

</html>