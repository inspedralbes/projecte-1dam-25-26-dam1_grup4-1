<?php
$host = "db";
$dbname = "projecte_gip3";
$username = "usuari";
$password = "1234";
//Validació de que arriben les dades necessàries
if (empty($_POST["departament"]) || empty($_POST["descripcio"])) {
    exit("Falten dades al fomulari");
}
//Connectar la BD 
$mysqli = include_once "connexio.php";


$descripcion = $_POST["descripcio"];
$departament = $_POST["departament"];


//Registrar la nova incidència a la BD
$sentencia = $mysqli->prepare("INSERT INTO INCIDENCIA (DESCRIPCIO, ID_DEPARTAMENT, DEPARTAMENT) VALUES (?, ?, ?)");
$sentencia->bind_param("ssi", $descripcion, $departament, $departament);
$sentencia->execute();

// Redirigir a la pàgina de llistar les incidències
header("Location: formulari.php?ok=1");
exit;
?>