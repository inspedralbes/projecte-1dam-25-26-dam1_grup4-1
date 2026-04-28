<?php

$mysqli = include_once "connexio.php";

//SELECT de les 3 columnes que necessitem (id, descripcio, data i estat) de la taula incidencies

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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8fafc;
        }

        .header-container {
            background-color: rgba(144, 178, 216, 0.8);
            width: 100%;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }
    </style>
</head>

<body>


    <div class="header-container">
        <h1>GESTIÓ D'INCIDÈNCIES</h1>
        <h1>Les meves incidències</h1>
    </div>
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

            <?php foreach ($resultat as $inc) {
                $color = '';
                if ($inc['ESTAT'] === 'OBERTA') $color = 'table-warning';
                elseif ($inc['ESTAT'] === 'EN_PROCES') $color = 'table-info';
                elseif ($inc['ESTAT'] === 'TANCADA') $color = 'table-success';
            ?>
                <tr class="<?php echo $color; ?>">
                    <td><?php echo $inc['ID_INCIDENCIA']; ?></td>
                    <td><?php echo htmlspecialchars($inc['DESCRIPCIO']); ?></td>
                    <td><?php echo $inc['DATA_CREACIO']; ?></td>
                    <td><?php echo $inc['ESTAT']; ?></td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
    </div>
</body>

</html>