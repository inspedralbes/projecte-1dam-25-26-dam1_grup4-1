<?php
require_once __DIR__ . '/../logger.php';
require_once __DIR__ . '/../connexio.php';
$pdo = new PDO("mysql:host=$host;dbname=$base_de_datos;charset=utf8mb4", $usuario, $contrasenia);

$departaments = $pdo->query("SELECT ID_DEPARTAMENT,NOM FROM DEPARTAMENT ORDER BY NOM")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ca">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Qüestionari</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      background-image: url('../Imatges/fons.jpg');
      background-size: cover;
      background-position: center;
    }

    textarea {
      resize: none;
    }

    .bg-custom-dark {
      background-color: #1e3a5f;
    }
  </style>
</head>

<body class="min-vh-100 d-flex flex-column bg-secondary bg-opacity-10">

  <!-- Header -->
  <header class="w-100 text-center py-4 shadow-sm mb-5 bg-custom-dark position-relative">
    <img src="../Imatges/logo.png" alt="Logo" class="position-absolute top-0 start-0 mt-3 ms-3 d-none d-md-block" style="width: 120px;">
    <h1 class="fs-3 fw-bold mb-1 text-white">CREAR NOVA INCIDÈNCIA</h1>
    <p class="text-white-50 mb-0">Omplena el formulari per registrar una nova incidència</p>
    <link rel="icon" href="../Imatges/favicon.jpg" type="image/jpeg">

  </header>



  <?php if (isset($_GET['ok'])): ?>
    <div class="position-fixed bottom-0 start-50 translate-middle-x mb-5 bg-success text-white px-4 py-3 rounded fw-bold shadow">
      Incidència registrada correctament!
    </div>
  <?php endif; ?>



  <div class="container" style="max-width: 700px;">
    <form action="registrar.php" method="POST">
      <p class="text-muted mb-4">Completa el formulari per registrar una nova incidència.</p>
      <!-- Escollir Departament -->
      <fieldset class="p-3 mb-4 border border-secondary" style="background: rgba(158, 220, 255, 0.7)">
        <legend class="fw-bold px-2 w-auto">Departament</legend>
        <select id="departament" name="departament" class="form-select" required>
          <option value="">-- Tria un departament --</option>
          <?php foreach ($departaments as $dep): ?>
            <option value="<?= htmlspecialchars($dep['ID_DEPARTAMENT']) ?>">
              <?= htmlspecialchars($dep['NOM']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </fieldset>

      <!-- Posar Descripció -->
      <fieldset class="p-3 mb-4 border border-secondary" style="background: rgba(120, 220, 233, 0.7)">
        <legend class="fw-bold px-2 w-auto">Descripció de la incidència</legend>
        <label for="descripcio" class="form-label">Observacions</label>
        <textarea id="descripcio" name="descripcio" rows="6" class="form-control"
          placeholder="Pots escriure aquí la teva observació." required></textarea>
      </fieldset>

      <button type="submit" class="btn btn-success px-4 py-2 fw-bold">Registrar incidència</button>

    </form>
  </div>
  <footer class="bg-white bg-opacity-75 border-top mt-auto py-3">
    <p class="text-center text-muted mb-1">&copy; <?php echo date('Y'); ?> INS PEDRALBES</p>
    <p class="text-center text-muted mb-0 small">Jawad Mohdith and Sergi Martinez</p>
  </footer>
  <div class="fixed-bottom p-4">
    <a href="usuari.php" class="btn btn-secondary px-4 shadow-sm">← Tornar</a>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>