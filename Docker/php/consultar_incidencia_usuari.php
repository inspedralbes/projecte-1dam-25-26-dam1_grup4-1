<?php 

$mysqli = include_once "connexio.php";

//SELECT de les 3 columnes que necessitem (id, descripcio, data i estat) de la taula incidencies

$resultat = $mysqli->query('
SELECT ID_INCIDENCIA, DESCRIPCIO, DATA_CREACIO, ESTAT FROM INCIDENCIA ORDER BY DATA_CREACIO DESC');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Incidències</title>
</head>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }
    h1 {
        text-align: center;
        color: #333;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
<body>
    <h1>Consultar Incidències</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Descripció</th>
            <th>Data de Creació</th>
            <th>Estat</th>
        </tr>
        <?php while ($fila = $resultat->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($fila['ID_INCIDENCIA']); ?></td>
            <td><?php echo htmlspecialchars($fila['DESCRIPCIO']); ?></td>
            <td><?php echo htmlspecialchars($fila['DATA_CREACIO']); ?></td>
            <td><?php echo htmlspecialchars($fila['ESTAT']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>