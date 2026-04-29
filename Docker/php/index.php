<!DOCTYPE html>
<html lang="ca">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Landing Page</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
   <style>
      /* Solo lo que Bootstrap no puede hacer */
      body {
         font-family: 'Montserrat', sans-serif;
         background-image: linear-gradient(rgba(248, 250, 252, 0.8), rgba(248, 250, 252, 0.8)), url("fonslandingpage.png");
         background-size: cover;
         background-position: center;
      }

      .btn-hover:hover {
         transform: translateY(-4px);
         box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      }

      .btn-gris {
         background-color: #475569;
         opacity: 0.9;
      }

      .btn-taronja {
         background-color: #ea580c;
         opacity: 0.9;
      }

      .btn-gris:hover,
      .btn-taronja:hover {
         opacity: 1;
         color: white;
      }

      .btn-gris:hover {
         background-color: #334155;
      }

      .btn-taronja:hover {
         background-color: #c2410c;
      }
   </style>
</head>

<body class="min-vh-100">

   <main>

      <!-- Header -->
      <div class="w-100 text-center py-4 shadow-sm mb-5 position-relative" style="background-color: rgba(144, 178, 216, 0.8);">
         <img src="logo.png" alt="Logo" class="position-absolute top-0 start-0 mt-3 ms-3" style="width: 150px;">
         <h1 class="fs-3 fw-bold mb-1">GESTIÓ D'INCIDÈNCIES</h1>
         <h1 class="fs-3 fw-bold mb-0">INS PEDRALBES</h1>
      </div>

      <!-- Botons -->
      <div class="container" style="max-width: 900px;">
         <div class="row g-4">

            <div class="col-6">
               <a href="usuari.php" class="btn btn-primary btn-hover text-white text-decoration-none fw-bold fs-5 text-uppercase w-100 py-5 shadow-sm">
                  USUARI
               </a>
            </div>

            <div class="col-6">
               <a href="tecnic.php" class="btn btn-gris btn-hover text-white text-decoration-none fw-bold fs-5 text-uppercase w-100 py-5 shadow-sm">
                  TÈCNIC
               </a>
            </div>

            <div class="col-12 d-flex justify-content-center mt-2">
               <a href="llistar.php" class="btn btn-taronja btn-hover text-white text-decoration-none fw-bold fs-5 text-uppercase py-5 shadow-sm" style="width: 60%;">
                  ADMINISTRADOR
               </a>
            </div>

         </div>
      </div>

   </main>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php include 'footer.php'; ?>