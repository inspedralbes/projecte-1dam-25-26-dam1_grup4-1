<?php
$host = "db";
$dbname = "projecte_gip3";
$username = "usuari";
$password = "1234";

   $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $departaments = $pdo->query("SELECT ID_DEPARTAMENT,NOM FROM DEPARTAMENT ORDER BY NOM")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ca">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Questionari</title>


 <style>
   body {
     font-family: Arial, sans-serif;
     margin: 20px;
     background-color: #f4f4f4;
   }


   fieldset {
     margin-bottom: 20px;
     padding: 10px;
   }


   legend {
     font-weight: bold;
     padding: 0 10px;
   }


   label {
     display: block;
     margin-top: 10px;
   }


   input[type="text"],
   textarea {
     width: 100%;
     padding: 8px;
     box-sizing: border-box;
   }


   input[type="submit"] {
     background-color: #4CAF50;
     color: white;
     padding: 10px 20px;
     border: none;
     cursor: pointer;
   }


   input[type="submit"]:hover {
     background-color: #45a049;
   }

   .missatge-ok {
      position: fixed;
      bottom: 400px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #4CAF50;
      color: white;
      padding: 15px 25px;
      border-radius: 8px;
      font-weight: bold;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      animation: fadeIn 0.5s ease;
}
 </style>
</head>
<body>
  <h2 style="text-align: center;">FORMULARI</h2>
 <h2 style="text-align: center;">CREAR INCIDÈNCIA</h2>

<?php if (isset($_GET['ok'])): ?>     
    <div class="missatge-ok"> Incidència registrada correctament!</div>   
  <?php endif; ?>

 <form action="registrar.php" method="POST">


   <fieldset style="background-color: #f1ed19; border: 1px solid #555555;">
     <legend>Departament</legend>
        <select id = "departament" name="departament" required> Selecciona el departament 
        <option value="">-- Tria un departament --</option>
        <?php foreach ($departaments as $dep): ?>
          <option value="<?= htmlspecialchars($dep['ID_DEPARTAMENT']) ?>">
            <?= htmlspecialchars($dep['NOM']) ?>
          </option>
        <?php endforeach; ?>
      </select>
   </fieldset>

     <br>
   <br>
   <fieldset style="background-color: #ffe7e7; border: 1px solid #555;">
      <legend>Descripció de la incidència</legend>
      <label for="observacions">Observacions</label><br>
      <textarea id="descripcio" name="descripcio" rows="6" style="resize: none;"
        placeholder="Pots escriure aquí la teva observació." required></textarea>
    </fieldset>

    <button type="submit">Registrar incidència</button>

  

  </form>
</body>
</html>
