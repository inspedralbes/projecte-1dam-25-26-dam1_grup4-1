<!DOCTYPE html>
<html lang="ca">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Gestió d'Incidències</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
   <style>
      body {
         font-family: 'Montserrat', sans-serif;

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

<body class="min-vh-100 d-flex flex-column bg-secondary bg-opacity-10">

   <main class="flex-grow-1">

      <!-- Header -->
      <div class="w-100 text-center py-4 shadow-sm mb-5 position-relative" style="background-color: #1e3a5f;">
         <img src="logo.png" alt="Logo" class="position-absolute top-0 start-0 mt-3 ms-3" style="width: 150px;">
         <h1 class="fs-3 fw-bold mb-1 " style="color: white;">GESTIÓ D'INCIDÈNCIES</h1>
         <h1 class="fs-3 fw-bold mb-0" style="color: white;">INS PEDRALBES</h1>
         <link rel="icon" href="favicon.jpg" type="image/png">
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

   <div class="container">
      <footer class="py-3 my-4">
         <ul class="nav justify-content-center border-bottom pb-3 mb-3">&copy; <?php echo date('Y'); ?>
            INS PEDRALBES
         </ul>
         <p class="text-center text-body-secondary"> Jawad Mohdith and Sergi Martinez</p>
      </footer>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>