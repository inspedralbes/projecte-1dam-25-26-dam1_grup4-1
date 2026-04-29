<!DOCTYPE html>
<html lang="ca">


<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>USUARIS</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
   <style>
      body {
         font-family: 'Montserrat', sans-serif;
         background-image: linear-gradient(rgba(248, 250, 252, 0.8), rgba(248, 250, 252, 0.8)), url("fonsusuari.png");
         background-size: cover;
         background-position: center;
      }


      .btn-gris {
         background-color: #475569;
      }


      .btn-square {
         border-radius: 0;
      }


      .btn-hover:hover {
         transform: translateY(-4px);
         box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
      }


      .logo {
         position: absolute;
         top: 20px;
         left: 20px;
         width: 150px;
         height: auto;
      }


      .btn-orn {
         background-color: #ea580c;
      }


      .btn-orn:hover {
         background-color: #c2410c;
         color: white;
      }
   </style>
</head>


<body class="min-vh-100">
   <img src="logo.png" alt="Logo" class="logo">
   <?php
   $mysqli = include_once "connexio.php";
   $stats = $mysqli->query("
   SELECT ESTAT, COUNT(*) AS TOTAL
   FROM INCIDENCIA
   GROUP BY ESTAT
")->fetch_all(MYSQLI_ASSOC);
   $comptadors = ["OBERTA" => 0, "EN_PROCES" => 0, "TANCADA" => 0];
   foreach ($stats as $stat) {
      $comptadors[$stat['ESTAT']] = $stat['TOTAL'];
   }
   ?>


   <!-- Header -->
   <div class="w-100 text-center py-4 shadow-sm mb-5" style="background-color: #1e3a5f;">
      <h1 class="fs-3 fw-bold mb-1" style="color: white;">GESTIÓ D'INCIDÈNCIES</h1>
      <h1 class="fs-3 fw-bold mb-0" style="color: white;">USUARIS</h1>
   </div>


   <!-- Botons -->
   <div class="container pb-5" style="max-width: 900px;">
      <div class="row g-4 px-2">


         <div class="col-6">
            <a href="formulari.php" class="btn btn-primary btn-square btn-hover d-block text-white text-decoration-none py-5 px-4 text-center w-100">
               <span class="d-block fs-4 mb-2">+</span>
               <span class="d-block fw-bold fs-6">CREAR INCIDÈNCIA</span>
               <span class="d-block mt-2 fw-normal" style="font-size: 0.75rem; opacity: 0.8;">Reporta un nou problema</span>
            </a>
         </div>


         <div class="col-6">
            <a href="consultar_incidencia_usuari.php" class="btn btn-orn btn-square btn-hover d-block text-white text-decoration-none py-5 px-4 text-center w-100">
               <span class="d-block fs-4 mb-2">?</span>
               <span class="d-block fw-bold fs-6">CONSULTAR INCIDÈNCIA</span>
               <span class="d-block mt-2 fw-normal" style="font-size: 0.75rem; opacity: 0.8;">Revisa les teves incidències</span>
            </a>
         </div>

      </div>
   </div>
   <div class="fixed-bottom p-4">
      <a href="index.php" class="btn btn-outline-secondary px-4 shadow-sm">← Tornar</a>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>