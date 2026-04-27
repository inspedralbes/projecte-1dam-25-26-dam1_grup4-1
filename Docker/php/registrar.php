<?php
// Configuració de la connexió (coincideix amb docker-compose.yaml)
$host     = "db";                  // nom del servei Docker
$dbname   = "projecte_gip3";
$username = "usuari";
$password = "1234";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de connexió: " . $e->getMessage());
}

// Recollir dades del formulari
$departament_nom = trim($_POST['departament'] ?? '');
$descripcio      = trim($_POST['obs'] ?? '');
$prioritat       = trim($_POST['prioritat'] ?? 'MITJANA');

// Validació
if (empty($departament_nom) || empty($descripcio)) {
    die("Error: Tots els camps són obligatoris.");
}

// Buscar l'ID del departament pel nom
$stmt = $pdo->prepare("SELECT ID_DEPARTAMENT FROM DEPARTAMENT WHERE NOM = :nom");
$stmt->execute([':nom' => $departament_nom]);
$departament = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$departament) {
    die("Error: Departament no trobat.");
}

// Inserir la incidència
$sql = "INSERT INTO INCIDENCIA (DESCRIPCIO, PRIORITAT, ESTAT, ID_DEPARTAMENT)
        VALUES (:descripcio, :prioritat, 'OBERTA', :id_departament)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':descripcio'      => $descripcio,
    ':prioritat'       => $prioritat,
    ':id_departament'  => $departament['ID_DEPARTAMENT']
]);

header("Location: formulari.php?ok=1");
exit;
?>