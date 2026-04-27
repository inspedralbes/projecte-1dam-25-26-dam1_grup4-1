<?php

//Validació de que arriben les dades necessàries
if (empty($_POST["departament"]) || empty($_POST["obs"])) {
    exit("Falten dades al fomulari");
}
//Connectar la BD 

$mysqli = include_once "connexio.php";


$descripcion = $_POST["obs"];
$departament = $_POST["departament"];

//Cercar el departament a la BD per obtenir el seu id

$stmt_dept = $mysqli->prepare("SELECT id_departament FROM departament WHERE nom = ?");
$stmt_dept->bind_param("s", $departament);
$stmt_dept->execute();
$result_dept = $stmt_dept->get_result();
$row_dept = $result_dept->fetch_assoc();


// si el departament no existeix en la bd:
if (!$row_dept) {
    exit("Departament no trobat");
}
$id_departament = $row_dept["id_departament"];

//Registrar la nova incidència a la BD
$sentencia = $mysqli->prepare("INSERT INTO incidencies (Descripció, prioritat, estat, id_departament) VALUES (?, 'mitjana', 'oberta', ?)"); 



$sentencia->bind_param("si", $descripcion, $id_departament);
$sentencia->execute();

// Redirigir a la pàgina de llistar les incidències
header("Location: consultar_incidencies.php");
exit;