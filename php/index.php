<?php
require_once __DIR__ . '/logger.php';
?>
<!DOCTYPE html>
<html lang="ca">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Gestió d'Incidències - INS Pedralbes</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
   <link rel="icon" href="./Imatges/favicon.jpg" type="image/jpeg">
   <style>
      body {
         font-family: 'Montserrat', sans-serif;
      }

      /* Sidebar Estils */
      #sidebar {
         width: 250px;
         height: 100vh;
         position: fixed;
         left: 0;
         top: 0;
         transform: translateX(-100%);
         transition: transform 0.3s ease;
         z-index: 1050;
         /* Per sobre del header */
      }

      #sidebar.open {
         transform: translateX(0);
      }

      .sidebar-item {
         transition: background-color 0.3s;
      }

      .sidebar-item[data-bs-toggle="collapse"]::after {
         content: '\f282';
         font-family: 'bootstrap-icons';
         float: right;
         transition: transform 0.3s;
      }

      .sidebar-item[data-bs-toggle="collapse"][aria-expanded="true"]::after {
         transform: rotate(180deg);
      }

      /* Contingut Principal */
      .main-content {
         width: 100%;
         min-height: 100vh;
         background-image: url('Imatges/fons.jpg');
         background-size: cover;
         background-position: center;
         transition: margin-left 0.3s ease;
      }

      .bg-custom-dark {
         background-color: #1e3a5f;
      }

      /* Botons i Hovers */
      .btn-hover:hover {
         transform: translateY(-4px);
         box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
         opacity: 1 !important;
      }

      .btn-gris {
         background-color: #475569;
         opacity: 0.9;
         color: white;
      }

      .btn-gris:hover {
         background-color: #334155;
         color: white;
      }

      .btn-taronja {
         background-color: #ea580c;
         opacity: 0.9;
         color: white;
      }

      .btn-taronja:hover {
         background-color: #c2410c;
         color: white;
      }
   </style>
</head>

<body class="min-vh-100">

   <div class="d-flex">



      <div class="main-content d-flex flex-column">

         <!-- Header -->
         <header class="w-100 text-center py-4 shadow-sm mb-5 bg-custom-dark position-relative">
            <img src="../php/Imatges/logo.png" alt="Logo" class="position-absolute top-0 start-0 mt-3 ms-3 d-none d-md-block" style="width: 120px;">

            <h1 class="fs-3 fw-bold mb-1 text-white">GESTIÓ D'INCIDÈNCIES</h1>
            <p class="text-white-50 mb-0">Institut Pedralbes</p>
         </header>

         <!-- Botons Centrals -->
         <div class="flex-grow-1 d-flex align-items-start pt-2">
            <div class="container" style="max-width: 900px;">
               <div class="row g-4">
                  <div class="col-md-6">
                     <a href="Usuari/usuari.php" class="btn btn-primary btn-hover text-white fw-bold fs-5 text-uppercase w-100 py-5 shadow-sm">
                        USUARI
                     </a>
                  </div>
                  <div class="col-md-6">
                     <a href="Tecnic/tecnic.php" class="btn btn-gris btn-hover text-white fw-bold fs-5 text-uppercase w-100 py-5 shadow-sm">
                        TÈCNIC
                     </a>
                  </div>
                  <div class="col-12 d-flex justify-content-center mt-4">
                     <a href="Administrador/administrador.php" class="btn btn-taronja btn-hover text-white fw-bold fs-5 text-uppercase py-5 shadow-sm" style="width: 60%;">
                        ADMINISTRADOR
                     </a>
                  </div>
               </div>
            </div>
         </div>

         <!-- Footer -->
         <footer class="bg-white bg-opacity-75 border-top mt-auto py-3">
            <p class="text-center text-muted mb-1">&copy; <?php echo date('Y'); ?> INS PEDRALBES</p>
            <p class="text-center text-muted mb-0 small">Jawad Mohdith and Sergi Martinez</p>
         </footer>

      </div>
   </div>

   <!-- Scripts -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>