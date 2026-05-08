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
    $tipu      = $_POST['tipu'];

    $stmt = $pdo->prepare("UPDATE INCIDENCIA SET ID_TECNIC = ?, PRIORITAT = ?, ID_TIPU = ? WHERE ID_INCIDENCIA = ?");
    $stmt->execute([$tecnic, $prioritat, $tipu, $id]);

    $missatge = "Incidència actualitzada!";
}

$stmt = $pdo->prepare("SELECT  
                            i.ID_INCIDENCIA,
                            i.DATA_CREACIO,
                            i.DESCRIPCIO,
                            i.ID_TECNIC,
                            i.PRIORITAT,
                            i.ID_TIPU,
                            d.NOM                            
                        FROM INCIDENCIA i
                        LEFT JOIN DEPARTAMENT d ON i.ID_DEPARTAMENT = d.ID_DEPARTAMENT
                        WHERE i.ID_INCIDENCIA = ?");
$stmt->execute([$id]);
$inc = $stmt->fetch();

$tecnics = $pdo->query("SELECT * FROM TECNIC")->fetchAll();
$tipus   = $pdo->query("SELECT * FROM TIPU")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Incidència #<?= $id ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>

<body class="bg-light min-vh-100">

    <!-- Header -->
    <div class="w-100 text-center py-4 shadow-sm mb-5 position-relative" style="background-color: #1e3a5f;">
        <img src="../Imatges/logo.png" alt="Logo" class="position-absolute top-0 start-0 mt-3 ms-3" style="width: 150px;">
        <h1 class="fs-3 fw-bold mb-1 " style="color: white;">GESTIONAR INCIDÈNCIES</h1>
        <h1 class="fs-3 fw-bold mb-0" style="color: white;">ADMINISTRADOR</h1>
        <link rel="icon" href="../Imatges/favicon.jpg" type="image/png">
        <div class="position-absolute top-50 translate-middle-y d-flex gap-4" style="right: 10%;"> <a href="Usuari/usuari.php" class="text-white text-decoration-none fw-bold">Usuari</a>
            <a href="Tecnic/tecnic.php" class="text-white text-decoration-none fw-bold">Tècnic</a>
            <a href="Administrador/administrador.php" class="text-white text-decoration-none fw-bold">Admin</a>
        </div>
    </div>



    <div class="container-md pb-5">

        <!-- Missatge OK -->
        <?php if (isset($missatge)): ?>
            <div class="alert alert-success fw-bold mb-4"><?= $missatge ?></div>
        <?php endif; ?>

        <!-- Informació -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Informació</h5>
                <p class="mb-1"><strong>Data creació:</strong> <?= $inc['DATA_CREACIO'] ?></p>
                <p class="mb-1"><strong>Departament:</strong> <?= $inc['NOM'] ?? '—' ?></p>
                <p class="mb-0"><strong>Descripció:</strong> <?= $inc['DESCRIPCIO'] ?></p>
            </div>
        </div>

        <!-- Formulari -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-4">Assignar tècnic i prioritat</h5>
                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tècnic:</label>
                        <select name="tecnic" class="form-select">
                            <option value="">— Selecciona —</option>
                            <?php foreach ($tecnics as $t): ?>
                                <option value="<?= $t['ID_TECNIC'] ?>" <?= $inc['ID_TECNIC'] == $t['ID_TECNIC'] ? 'selected' : '' ?>>
                                    <?= $t['NOM'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tipus d'incidència:</label>
                        <select name="tipu" class="form-select">
                            <option value="">— Selecciona —</option>
                            <?php foreach ($tipus as $t): ?>
                                <option value="<?= $t['ID_TIPU'] ?>" <?= $inc['ID_TIPU'] == $t['ID_TIPU'] ? 'selected' : '' ?>>
                                    <?= $t['NOM'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Prioritat:</label>
                        <select name="prioritat" class="form-select">
                            <option value="">— Selecciona —</option>
                            <?php foreach (['ALTA', 'MITJANA', 'BAIXA'] as $p): ?>
                                <option value="<?= $p ?>" <?= $inc['PRIORITAT'] == $p ? 'selected' : '' ?>>
                                    <?= $p ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary px-4 fw-bold">Guardar</button>

                </form>
            </div>
        </div>

    </div>

    <!-- Botó tornar -->
    <div class="fixed-bottom p-4">
        <a href="llistar.php" class="btn btn-secondary px-4 shadow-sm">← Tornar</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>