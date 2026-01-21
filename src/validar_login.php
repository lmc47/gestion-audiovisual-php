<?php
session_start();
require_once '../config/conexion/conexion-db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_input = $_POST['usuario'];
    $pass_input = $_POST['password'];

    // Buscamos por la columna username
    $sql = "SELECT idAdmin, username, password FROM user WHERE username = ? LIMIT 1";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $user_input);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $usuario = mysqli_fetch_assoc($resultado);

    // Verificamos si existe el usuario y la contraseña
    if ($usuario && password_verify($pass_input, $usuario['password'])) {
        $_SESSION['admin_id'] = $usuario['idAdmin'];
        $_SESSION['admin_username'] = $usuario['username'];

        header("Location: ../gestor.php");
        exit;
    } else {
        header("Location: ../login.php?error=1");
        exit;
    }
}