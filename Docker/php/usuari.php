<!DOCTYPE html>
<html lang="ca">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>USUARIS</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
   <style>
      body {
         margin: 0;
         min-height: 100vh;
         font-family: 'Montserrat', sans-serif;
         background-image: linear-gradient(rgba(248, 250, 252, 0.8), rgba(248, 250, 252, 0.8)), url("fonsusuari.png");
         background-size: cover;
         background-position: center;
      }


      .header-container {
         background-color: rgba(144, 178, 216, 0.8);
         width: 100%;
         padding: 30px 0;
         text-align: center;
         box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
         margin-bottom: 80px;
         border-radius: 0;
         position: relative;
      }

      .header-container h1 {
         font-size: 1.8rem;
         margin: 4px 0;
         color: 1e3a5f;
      }




      /* Botons principals (Crear incidència, Consultar incidència) */

      .buttons-grid {
         display: grid;
         grid-template-columns: 1fr 1fr;
         gap: 20px;
         max-width: 900px;
         margin: 0 auto;
         padding: 0 20px 40px;
      }


      .button {
         font-family: 'Montserrat', sans-serif;
         font-weight: 700;
         color: white;
         border-radius: 0px;
         border: none;
         padding: 36px 20px;
         text-align: center;
         text-decoration: none;
         display: block;
         transition: transform 0.2s, box-shadow 0.2s;
      }

      .button:hover {
         transform: translateY(-4px);
         box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
         color: white;
      }

      .button-icon {
         font-size: 1.8rem;
         display: block;
         margin-bottom: 10px;
      }

      .button-title {
         font-size: 1.1rem;
         display: block;
      }

      .button-subtitle {
         font-size: 0.75rem;
         opacity: 0.8;
         display: block;
         margin-top: 6px;
         font-weight: 400;
      }

      .button1 {
         background-color: #2563eb;
      }

      .button2 {
         background-color: #475569;
      }

      .logo {
         position: absolute;
         top: 20px;
         left: 20px;
         width: 150px;
         height: auto;
      }
   </style>
</head>

<body>

   <?php
   $mysqli = include_once "connexio.php";


   $stats = $mysqli->query("
    SELECT ESTAT, COUNT(*) AS TOTAL 
    FROM INCIDENCIA 
    GROUP BY ESTAT
")->fetch_all(MYSQLI_ASSOC);

   //Convertim el resultat a un array  més senzill d'utilitzar
   $comptadors = ["OBERTA" => 0, "EN_PROCES" => 0, "TANCADA" => 0];
   foreach ($stats as $stat) {
      $comptadors[$stat['ESTAT']] = $stat['TOTAL'];
   }


   ?>

   <div class="header-container">
      <img src="logo.png" alt="Logo" class="logo">
      <h1>GESTIÓ D'INCIDÈNCIES</h1>
      <h1>USUARIS</h1>
   </div>

   <!-- Botons principals -->

   <div class="buttons-grid">
      <a href="formulari.php" class="button button1">
         <span class="button-icon">+</span>
         <span class="button-title">CREAR INCIDÈNCIA</span>
         <span class="button-subtitle">Reporta un nou problema</span>
      </a>

      <a href="consultar_incidencia_usuari.php" class="button button2">
         <span class="button-icon">?</span>
         <span class="button-title">CONSULTAR INCIDÈNCIA</span>
         <span class="button-subtitle">Revisa les teves incidències</span>
      </a>


   </div>


</body>

</html>