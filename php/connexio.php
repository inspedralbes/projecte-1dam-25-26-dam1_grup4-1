<?php
$host = "localhost";
$usuario = "a25jawmohbou_Projecte_gip3";
$contrasenia = "Jawad123-.";
$base_de_datos = "a25jawmohbou_g4_projectegip3";


$mysqli = new mysqli($host, $usuario, $contrasenia, $base_de_datos);
if ($mysqli->connect_errno) {
    echo "Error mysqli: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}


$pdo = new PDO("mysql:host=$host;dbname=$base_de_datos;charset=utf8mb4", $usuario, $contrasenia);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

return $mysqli;