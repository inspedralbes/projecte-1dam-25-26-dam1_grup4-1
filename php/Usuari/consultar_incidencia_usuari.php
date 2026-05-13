<?php
// Carrega el logger per guardar a MongoDB qui entra a la pàgina
require_once __DIR__ . '/../logger.php';

// Connecta a la base de dades MySQL
$mysqli = include_once "../connexio.php";

// Agafa de la URL per quina columna ordenar, per defecte per data
$sort = $_GET['sort'] ?? 'DATA_CREACIO';
// Agafa de la URL si ordre ascendent o descendent, per defecte descendent
$order = $_GET['order'] ?? 'DESC';
// Agafa la pàgina actual de la URL, mínim 1
$page  = max(1, intval($_GET['page'] ?? 1));
// Mostra maxim 20 incidències per pàgina
$limit = 20;
// Calcula quantes files saltar segons la pàgina
$offset = ($page - 1) * $limit;
// Agafa l'ID buscat per l'usuari, si no ha buscat res esta buit
$search_id = $_GET['search_id'] ?? '';


// Si l'usuari ha buscat un ID, crea el filtre WHERE per la consulta
$where = '';

if ($search_id !== '') {
    $where = "WHERE ID_INCIDENCIA = " . intval($search_id);
}

// Compta quantes incidències hi ha en total
$total = $mysqli->query("SELECT COUNT(*) as total FROM INCIDENCIA $where")->fetch_assoc()['total'];

// Calcula quantes pàgines hi ha en total
$total_pages = max(1, ceil($total / $limit));

// Calcula quina és la primera incidència que es mostra
$from = $total > 0 ? $offset + 1 : 0;

// Calcula quina és la última incidència que es mostra
$to   = min($offset + $limit, $total);

// Agafa les incidències de la pàgina actual amb l'ordenació triada
$query = "SELECT ID_INCIDENCIA, DESCRIPCIO, DATA_CREACIO, ESTAT FROM INCIDENCIA $where ORDER BY $sort $order LIMIT $limit OFFSET $offset";
$resultat = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidències Registrades</title>
    <!-- estils de bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- font de bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <!-- icones de bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* font i imatge */
        body {
            font-family: 'Montserrat', sans-serif;
            background-image: url('../Imatges/fons.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
        }

        /* capçalera */
        .bg-custom-dark {
            background-color: #1e3a5f;
        }

        /* Fijar altura mínima de cabecera y alinear flechas */
        thead th {
            white-space: nowrap;
            vertical-align: middle;
        }

        /* Limitar el ancho de la columna descripción */
        td:nth-child(2) {
            max-width: 300px;
            word-wrap: break-word;
        }

        /* Colores forçats per sobre de Bootstrap */
        tr.table-warning {
            background-color: #fff3cd;
        }

        tr.table-info {
            background-color: #cff4fc;
        }

        tr.table-success {
            background-color: #d1e7dd;
        }
    </style>
</head>

<body class="min-vh-100 d-flex flex-column bg-secondary bg-opacity-10">

    <!-- Capçalera amb  logo i títol de la pàgina -->
    <header class="w-100 text-center py-4 shadow-sm mb-5 bg-custom-dark position-relative">
        <!-- Logo només visible en pantalles mitjanes o grans -->
        <img src="../Imatges/logo.png" alt="Logo" class="position-absolute top-0 start-0 mt-3 ms-3 d-none d-md-block" style="width: 120px;">
        <h1 class="fs-3 fw-bold mb-1 text-white">INCIDÈNCIES REGISTRADES</h1>
        <p class="text-white-50 mb-0">Llistat de totes les incidències registrades</p>
        <link rel="icon" href="../Imatges/favicon.jpg" type="image/jpeg">
    </header>

    <div class="container">

        <!-- Barra superior amb el cercador d'ID i els botons de paginació -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

            <!-- Formulari per buscar una incidència per ID -->
            <form method="GET" class="d-flex gap-2 align-items-center">
                <!-- mantenir l'ordenació actual quan es fa una cerca -->
                <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
                <input type="hidden" name="order" value="<?= htmlspecialchars($order) ?>">
                <!-- Torna  a la pàgina 1 quan es fa una cerca nova -->
                <input type="hidden" name="page" value="1">
                <!-- Camp on l'usuari escriu l'ID a buscar -->
                <input type="number" name="search_id" class="form-control form-control-sm" placeholder="Buscar per #ID..." value="<?= htmlspecialchars($search_id) ?>" min="1" style="width: 180px;">
                <button type="submit" class="btn btn-primary btn-sm px-3"><i class="bi bi-search"></i> Cercar</button>
                <!-- Botó per netejar la cerca, només  si hi ha una cerca -->
                <?php if ($search_id !== ''): ?>
                    <a href="?sort=<?= urlencode($sort) ?>&order=<?= urlencode($order) ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x"></i> Netejar</a>
                <?php endif; ?>
            </form>

            <!-- incidències visibles i botons per canviar de pàgina -->
            <div class="d-flex align-items-center gap-2">
                <!-- Exemple: "1-20 de 53" -->
                <span class="text-muted small"><?= $from ?>–<?= $to ?> de <?= $total ?></span>
                <!-- Botó pàgina anterior, desactivat si ja estem a la primera -->
                <a href="?sort=<?= urlencode($sort) ?>&order=<?= urlencode($order) ?>&page=<?= $page - 1 ?>&search_id=<?= urlencode($search_id) ?>" class="btn btn-sm btn-outline-secondary <?= $page <= 1 ? 'disabled' : '' ?>"><i class="bi bi-chevron-left"></i></a>
                <!-- Botó pàgina següent, desactivat si ja estem a l'última -->
                <a href="?sort=<?= urlencode($sort) ?>&order=<?= urlencode($order) ?>&page=<?= $page + 1 ?>&search_id=<?= urlencode($search_id) ?>" class="btn btn-sm btn-outline-secondary <?= $page >= $total_pages ? 'disabled' : '' ?>"><i class="bi bi-chevron-right"></i></a>
            </div>
        </div>

        <p class="text-muted mb-4">Aquesta és la llista de totes les incidències registrades.</p>

        <!-- Taula d'incidencies-->
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <!-- Cada columna té dues fletxes per ordenar de forma ascendent o descendent -->
                    <th style="white-space: nowrap;">ID
                        <a href="?sort=ID_INCIDENCIA&order=asc&page=1&search_id=<?= urlencode($search_id) ?>" class="text-decoration-none ms-1">↑</a>
                        <a href="?sort=ID_INCIDENCIA&order=desc&page=1&search_id=<?= urlencode($search_id) ?>" class="text-decoration-none">↓</a>
                    </th>
                    <th style="white-space: nowrap;">Descripció
                        <a href="?sort=DESCRIPCIO&order=asc&page=1&search_id=<?= urlencode($search_id) ?>" class="text-decoration-none ms-1">↑</a>
                        <a href="?sort=DESCRIPCIO&order=desc&page=1&search_id=<?= urlencode($search_id) ?>" class="text-decoration-none">↓</a>
                    </th>
                    <th style="white-space: nowrap;">Data de Creació
                        <a href="?sort=DATA_CREACIO&order=asc&page=1&search_id=<?= urlencode($search_id) ?>" class="text-decoration-none ms-1">↑</a>
                        <a href="?sort=DATA_CREACIO&order=desc&page=1&search_id=<?= urlencode($search_id) ?>" class="text-decoration-none">↓</a>
                    </th>
                    <th style="white-space: nowrap;">Estat
                        <a href="?sort=ESTAT&order=asc&page=1&search_id=<?= urlencode($search_id) ?>" class="text-decoration-none ms-1">↑</a>
                        <a href="?sort=ESTAT&order=desc&page=1&search_id=<?= urlencode($search_id) ?>" class="text-decoration-none">↓</a>
                    </th>
                    <th style="white-space: nowrap;">Actuacions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Recorre totes les incidències  -->
                <?php foreach ($resultat as $inc):
                    // Posa color de fons
                    $color = '';
                    if ($inc['ESTAT'] === 'OBERTA') $color = 'table-warning';
                    elseif ($inc['ESTAT'] === 'EN_PROCES') $color = 'table-info';
                    elseif ($inc['ESTAT'] === 'TANCADA') $color = 'table-success';

                    // Busca les actuacions visibles d'aquesta incidència a la base de dades
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
                            <!-- Si no té actuacions mostra un missatge, sino les llista totes -->
                            <?php if (empty($acts)): ?>
                                <span class="text-muted">Sense actuacions</span>
                            <?php else: ?>
                                <?php foreach ($acts as $a): ?>
                                    <div class="mb-1"><?= htmlspecialchars($a['DESCRIPCIO']) ?></div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Peu de pàgina -->
    <footer class="bg-white bg-opacity-75 border-top mt-auto py-3">
        <p class="text-center text-muted mb-1">&copy; <?php echo date('Y'); ?> INS PEDRALBES</p>
        <p class="text-center text-muted mb-0 small">Jawad Mohdith and Sergi Martinez</p>
    </footer>

    <!-- Botó per tornar-->
    <div class="fixed-bottom p-4">
        <a href="usuari.php" class="btn btn-secondary px-4 shadow-sm">← Tornar</a>
    </div>

    <!-- JavaScript de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>