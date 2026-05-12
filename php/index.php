<?php
require_once __DIR__ . '/logger.php';
?>
<!-- La sidebar està treta d'un codi al GitHub, combinada amb bootstrap -->
<!DOCTYPE html>
<html lang="ca">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Gestió d'Incidències</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
   <link rel="icon" href="./Imatges/favicon.jpg" type="image/jpeg">
   <style>
      body {
         font-family: 'Montserrat', sans-serif;
      }

      #sidebar {
         width: 250px;
         height: 100vh;
         position: fixed;
         left: 0;
         top: 0;
         transform: translateX(-100%);
         transition: transform 0.3s ease;
         z-index: 1000;
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

      .main-content {
         width: 100%;
         min-height: 100vh;
         background-image: url('Imatges/fons.png');
         background-size: cover;
         background-position: center;
      }

      .btn-hover:hover {
         transform: translateY(-4px);
         box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
         opacity: 1 !important;
      }

      .btn-gris {
         background-color: #475569;
         opacity: 0.9;
      }

      .btn-gris:hover {
         background-color: #334155;
         color: white;
      }

      .btn-taronja {
         background-color: #ea580c;
         opacity: 0.9;
      }

      .btn-taronja:hover {
         background-color: #c2410c;
         color: white;
      }

      .bg-custom-dark {
         background-color: #1e3a5f;
      }
   </style>
</head>

<body class="min-vh-100 bg-secondary bg-opacity-10">

   <div class="d-flex">

      <!-- Sidebar -->
      <div id="sidebar" class="bg-white bg-opacity-75 shadow overflow-auto">
         <div class="d-flex justify-content-center align-items-center p-4 pb-5 border-bottom">
            <img src="./Imatges/logo.png" alt="Logo" style="width: 100px;">
         </div>

         <div id="sidebar-menu">

            <!-- Usuari -->
            <a href="#usuari-items" data-bs-toggle="collapse" aria-expanded="false"
               class="sidebar-item d-block px-3 py-3 text-decoration-none text-dark border-bottom mt-2">
               <i class="bi bi-person me-2"></i>Usuari
            </a>
            <div id="usuari-items" class="collapse border-top" data-bs-parent="#sidebar-menu">
               <a href="./Usuari/usuari.php" class="sidebar-item d-block px-5 py-2 text-decoration-none text-dark border-bottom small">
                  <i class="bi bi-door-open me-2"></i>Entrar a Usuari
               </a>
               <a href="./Usuari/consultar_incidencia_usuari.php" class="sidebar-item d-block px-5 py-2 text-decoration-none text-dark border-bottom small">
                  <i class="bi bi-search me-2"></i>Consultar Incidències
               </a>
               <a href="./Usuari/formulari.php" class="sidebar-item d-block px-5 py-2 text-decoration-none text-dark border-bottom small">
                  <i class="bi bi-file-text me-2"></i>Formulari
               </a>
            </div>

            <!-- Tècnic -->
            <a href="#tecnic-items" data-bs-toggle="collapse" aria-expanded="false"
               class="sidebar-item d-block px-3 py-3 text-decoration-none text-dark border-bottom">
               <i class="bi bi-tools me-2"></i>Tècnic
            </a>
            <div id="tecnic-items" class="collapse border-top" data-bs-parent="#sidebar-menu">
               <a href="./Tecnic/tecnic.php" class="sidebar-item d-block px-5 py-2 text-decoration-none text-dark border-bottom small">
                  <i class="bi bi-door-open me-2"></i>Entrar a Tècnic
               </a>
               <a href="./Tecnic/llistar_joan.php" class="sidebar-item d-block px-5 py-2 text-decoration-none text-dark border-bottom small">
                  <i class="bi bi-list me-2"></i>Llistar Joan
               </a>
               <a href="./Tecnic/llistar_maria.php" class="sidebar-item d-block px-5 py-2 text-decoration-none text-dark border-bottom small">
                  <i class="bi bi-list me-2"></i>Llistar Maria
               </a>
               <a href="./Tecnic/llistar_pere.php" class="sidebar-item d-block px-5 py-2 text-decoration-none text-dark border-bottom small">
                  <i class="bi bi-list me-2"></i>Llistar Pere
               </a>

            </div>

            <!-- Administrador -->
            <a href="#admin-items" data-bs-toggle="collapse" aria-expanded="false"
               class="sidebar-item d-block px-3 py-3 text-decoration-none text-dark border-bottom">
               <i class="bi bi-shield-lock me-2"></i>Administrador
            </a>
            <div id="admin-items" class="collapse border-top" data-bs-parent="#sidebar-menu">
               <a href="./Administrador/administrador.php" class="sidebar-item d-block px-5 py-2 text-decoration-none text-dark border-bottom small">
                  <i class="bi bi-door-open me-2"></i>Entrar a Admin
               </a>

               <a href="./Administrador/estadistiques.php" class="sidebar-item d-block px-5 py-2 text-decoration-none text-dark border-bottom small">
                  <i class="bi bi-bar-chart me-2"></i>Estadístiques
               </a>
               <a href="./Administrador/llistar.php" class="sidebar-item d-block px-5 py-2 text-decoration-none text-dark border-bottom small">
                  <i class="bi bi-list me-2"></i>Llistar
               </a>
            </div>

         </div>
      </div>

      <!-- Main Content -->
      <div class="main-content d-flex flex-column">

         <!-- Header -->

         <!-- Header -->
         <header class="w-100 text-center py-4 shadow-sm mb-5 bg-custom-dark position-relative">
            <img src="../Imatges/logo.png" alt="Logo" class="position-absolute top-0 start-0 mt-3 ms-3 d-none d-md-block" style="width: 120px;">
            <h1 class="fs-3 fw-bold mb-1 text-white">GESTIÓ D'INCIDÈNCIES</h1>
            <p class="text-white-50 mb-0">Gestio de incidències Institut Pedralbes</p>
            <link rel="icon" href="../Imatges/favicon.jpg" type="image/jpeg">

         </header>


         <!-- Botons -->
         <div class="flex-grow-1 d-flex align-items-start pt-5">
            <div class="container" style="max-width: 900px;">
               <div class="row g-4">

                  <div class="col-6">
                     <a href="Usuari/usuari.php" class="btn btn-primary btn-hover text-white fw-bold fs-5 text-uppercase w-100 py-5 shadow-sm">
                        USUARI
                     </a>
                  </div>

                  <div class="col-6">
                     <a href="Tecnic/tecnic.php" class="btn btn-gris btn-hover text-white fw-bold fs-5 text-uppercase w-100 py-5 shadow-sm">
                        TÈCNIC
                     </a>
                  </div>

                  <div class="col-12 d-flex justify-content-center mt-2">
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

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
   <script>
      function toggleSidebar() {
         document.getElementById('sidebar').classList.toggle('open');
      }
      document.addEventListener('click', function(e) {
         const sidebar = document.getElementById('sidebar');
         const toggle = document.getElementById('sidebar-toggle');
         if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
            sidebar.classList.remove('open');
         }
      });
   </script>
</body>

</html>