<?php
require_once '../config/conexion/conexion-db.php';

$user = "admin"; // usuario para el admin
$email = "admin@correo.com"; // email para el admin
$pass = "12345"; // contraseña para el admin    

$pass_encriptada = password_hash($pass, PASSWORD_DEFAULT);

$sql = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "sss", $user, $email, $pass_encriptada);

if(mysqli_stmt_execute($stmt)) {
    echo "Admin usuario creado";
}
?>