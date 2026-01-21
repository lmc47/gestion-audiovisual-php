<?php
$host = 'localhost';
$user = 'root';
$pass = 'Prueba123';
$db   = 'audiovisualesfii';

$conexion = mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Configurar el conjunto de caracteres a utf8mb4
$conexion->set_charset("utf8mb4");
