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
         background-image: url('Imatges/fons.png');
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

<body class="min-vh-100 d-flex flex-column bg-secondary bg-opacity-10">

   <main class="flex-grow-1">

      <!-- Header -->
      <div class="w-100 text-center py-4 shadow-sm mb-5 position-relative" style="background-color: #1e3a5f;"> <img src="Imatges/logo.png" alt="Logo" class="position-absolute top-0 start-0 mt-3 ms-3" style="width: 150px;">
         <div class="position-absolute top-50 translate-middle-y d-flex gap-4" style="right: 10%;">
            <div class="dropdown">
               <a class="btn btn-link dropdown-toggle text-white text-decoration-none fw-bold p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Usuari</a>
               <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="Usuari/usuari.php">Pàgina Usuari</a></li>
                  <li><a class="dropdown-item" href="Usuari/consultar_incidencia_usuari.php">Consultar Incidències</a></li>
                  <li><a class="dropdown-item" href="Usuari/formulari.php">Formulari</a></li>
               </ul>
            </div>
            <div class="dropdown">
               <a class="btn btn-link dropdown-toggle text-white text-decoration-none fw-bold p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Tècnic</a>
               <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="Tecnic/tecnic.php">Pàgina Tècnic</a></li>
                  <li><a class="dropdown-item" href="Tecnic/llistar_joan.php">Llistar Joan</a></li>
                  <li><a class="dropdown-item" href="Tecnic/llistar_maria.php">Llistar Maria</a></li>
                  <li><a class="dropdown-item" href="Tecnic/llistar_pere.php">Llistar Pere</a></li>
               </ul>
            </div>
            <div class="dropdown">
               <a class="btn btn-link dropdown-toggle text-white text-decoration-none fw-bold p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Admin</a>
               <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="Administrador/administrador.php">Pàgina Admin</a></li>
                  <li><a class="dropdown-item" href="Administrador/gestionar.php">Gestionar</a></li>
                  <li><a class="dropdown-item" href="Administrador/estadistiques.php">Estadístiques</a></li>
                  <li><a class="dropdown-item" href="Administrador/llistar.php">Llistar</a></li>
               </ul>
            </div>
         </div>
         <h1 class="fs-3 fw-bold mb-1 " style="color: white;">GESTIÓ D'INCIDÈNCIES</h1>
         <h1 class="fs-3 fw-bold mb-0" style="color: white;">INS PEDRALBES</h1>
         <link rel="icon" href="Imatges/favicon.jpg" type="image/png">
      </div>


      <!-- Botons -->
      <div class="container" style="max-width: 900px;">
         <div class="row g-4">

            <div class="col-6">
               <a href="Usuari/usuari.php" class="btn btn-primary btn-hover text-white text-decoration-none fw-bold fs-5 text-uppercase w-100 py-5 shadow-sm">
                  USUARI
               </a>
            </div>

            <div class="col-6">
               <a href="Tecnic/tecnic.php" class="btn btn-gris btn-hover text-white text-decoration-none fw-bold fs-5 text-uppercase w-100 py-5 shadow-sm">
                  TÈCNIC
               </a>
            </div>

            <div class="col-12 d-flex justify-content-center mt-2">
               <a href="Administrador/administrador.php" class="btn btn-taronja btn-hover text-white text-decoration-none fw-bold fs-5 text-uppercase py-5 shadow-sm" style="width: 60%;">
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