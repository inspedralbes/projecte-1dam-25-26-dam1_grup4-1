<?php
$host = "db";
$dbname = "projecte_gip3";
$username = "usuari";
$password = "1234";

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$missatge = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id        = (int) $_POST['id'];
    $prioritat = $_POST['prioritat'];
    $estat     = $_POST['estat'];

    $stmt = $pdo->prepare('UPDATE INCIDENCIA SET PRIORITAT = ?, ESTAT = ? WHERE ID_INCIDENCIA = ?');
    $stmt->execute([$prioritat, $estat, $id]);

    $missatge = ['tipus' => 'ok', 'text' => "Incidència #$id actualitzada correctament."];
}



$incidencies = $pdo->query("SELECT  
                                ID_INCIDENCIA,
                                DATA_CREACIO,
                                DATA_INICI,
                                DATA_FI,
                                DESCRIPCIO,
                                PRIORITAT,
                                ESTAT
                            FROM INCIDENCIA
                            ORDER BY DATA_CREACIO DESC")->fetchAll();

?>

<!DOCTYPE html>
<html lang="ca">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Pàgina del administrador</title>

 <link href ="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
 <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        background-color: #f0f2f5;
        font-family: sans-stream_notification_callback;
    }

    header{
      background-color: #f0f2f5;
      font-family: sans-serif;
      padding: 30px;

    }

    table{
      width: 100%; 
      border-collapse: collapse;
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);

    }

    thead th{
        background: white;
        color: red;
        padding: auto;
        font-size: 1;
        text-align: left;
    }

    tbody td{
      padding: 11px 14px;
      font-size: 0.87rem;
      color: #374151;
      border-bottom: 1px solid #e5e7eb;
      vertical-align: middle;
 

    }

    tbody tr:last-child td{
    border-bottom: none;
    }

    tbody tr:hover{
        background-color: #f9fafb;

    }

    td.id {
    font-weight: bold;
    color: #1f2937;
    }

    td.data {
    color: #374151;
    font-size: 0.6rem;

    }

    td.descripcio{
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

    .btn-save{
    background-color: #4f46e5;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 6px 14px;
    font-size: 0.8rem;
    cursor: pointer;
    }

    .btn-save:hover{
    background-color: #4f46e5cc;
    }

    .missatge{
    background: #d1fae5;
    border: 1px solid #6ee7b7;
    color: #065f46;
    padding: 10px 16px;
    border-radius: 8px;
    margin: 0 30px 16px 30px;
    font-size: 0.88rem;
    }

    .empty{
    text-align: center;
    padding: 40px;
    color: #9ca3af;
    }

    .badge{
    display: inline-block;
    font-size: 0.72rem;
    font-weight: bold;
    padding: 2px 8px;
    border-radius: 12px;
    margin-top: 4px;
    }

    .badge-ALTA{color:red}
    .badge-MITJANA{color:goldenrod}
    .badge-BAIXA{color:green}
    .badge-OBERTA{color:red}
    .badge-EN_PROCES{color:goldenrod}
    .badge-TANCADA{color:}


</style>

</head>

<body>

<header>
  <h1>Gestió d'Incidències</h1>
  <span>ADMINISTRADOR</span>
</header>

<?php if ($missatge): ?>
  <div class="missatge"><?= htmlspecialchars($missatge["text"]) ?></div>
<?php endif; ?>

  <table>
    <thead>
      <tr>
        <th>#ID</th>
        <th>Data creació</th>
        <th>Data inici</th>
        <th>Data fi</th>
        <th>Descripció</th>
        <th>Prioritat</th>
        <th>Estat</th>
        <th>Guardar</th>
      </tr>
    </thead>
    <tbody>
    
    <?php if (empty($incidencies)): ?>
      <tr><td colspan="8" class="empty">No hi ha incidències registrades.</td></tr>
    
    
      <?php else: ?>
     
        <?php foreach ($incidencies as $inc): ?>
      <tr>
        <!-- ID -->
        <td class="id">#<?= $inc['ID_INCIDENCIA'] ?></td>
 
        <!-- Dates -->
        <td class="data"><?= $inc['DATA_CREACIO'] ? htmlspecialchars($inc['DATA_CREACIO']) : '—' ?></td>
        <td class="data"><?= $inc['DATA_INICI']   ? htmlspecialchars($inc['DATA_INICI'])   : '—' ?></td>
        <td class="data"><?= $inc['DATA_FI']      ? htmlspecialchars($inc['DATA_FI'])      : '—' ?></td>
 
      
        <td class="descripcio"><?= nl2br(htmlspecialchars($inc['DESCRIPCIO'] ?? '')) ?></td>
 
        <!-- FORMULARI per guardar PRIORITAT + ESTAT -->
        <form method="POST"style="display:contents">
          <input type="hidden" name="id" value="<?= (int)$inc['ID_INCIDENCIA'] ?>">
 
            <td>
           
            <div class="form-grup">
              <label>Prioritat</label>
              <select name="prioritat" onchange="updateBadge(this,'prioritat')">
                <?php foreach (['ALTA','MITJANA','BAIXA'] as $p): ?>
                  <option value="<?= $p ?>" <?= $inc['PRIORITAT'] === $p ? 'selected' : '' ?>>
                    <?= $p ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="badge badge-<?= htmlspecialchars($inc['PRIORITAT'] ?? 'BAIXA') ?>">
                <?= htmlspecialchars($inc['PRIORITAT'] ?? '—') ?>
              </span>
            </div>
          </td>
 
         
          <td>
            <div class="form-grup">
              <label>Estat</label>
              <select name="estat">
                <?php foreach (['OBERTA','EN_PROCES','TANCADA'] as $e): ?>
                  <option value="<?= $e ?>" <?= $inc['ESTAT'] === $e ? 'selected' : '' ?>>
                    <?= str_replace('_', ' ', $e) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="badge badge-<?= htmlspecialchars($inc['ESTAT'] ?? 'OBERTA') ?>">
                <?= str_replace('_', ' ', htmlspecialchars($inc['ESTAT'] ?? '—')) ?>
              </span>
            </div>
          </td>
 
          
          <td class="accions">
            <button type="submit" class="btn-save">▶ Guardar</button>
          </td>
 
        </form>
      </tr>
      <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
  </table>

</body>
</html>