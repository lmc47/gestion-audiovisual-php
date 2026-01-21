<?php
// ================= CONEXIÓN =================
global $conexion;
require_once 'config/conexion/conexion-db.php';

// ================= VALIDAR DATOS =================
if (
    !isset($_GET['id']) ||
    !isset($_GET['estado']) ||
    !is_numeric($_GET['id'])
) {
    header("Location: ../gestor.php"); 
    exit;
}

$id = intval($_GET['id']);
$estado = $_GET['estado'];

// Estados permitidos 
$estadosPermitidos = ['Aceptado', 'Rechazado'];

if (!in_array($estado, $estadosPermitidos)) {
    header("Location: ../gestor.php");
    exit;
}

// ================= VERIFICAR SI YA EXISTE ESTADO =================
$check = mysqli_query(
    $conexion,
    "SELECT idSolicitud FROM estado WHERE idSolicitud = $id"
);

if (mysqli_num_rows($check) > 0) {
    // UPDATE
    $sql = "
        UPDATE estado
        SET estado = '$estado'
        WHERE idSolicitud = $id
    ";
} else {
    // INSERT
    $sql = "
        INSERT INTO estado (idSolicitud, estado)
        VALUES ($id, '$estado')
    ";
}

// ================= EJECUTAR =================
if (mysqli_query($conexion, $sql)) {

    $msg = ($estado === 'Aceptado') ? 'aceptado' : 'rechazado';

    header("Location: ../detalle.php?id=$id&msg=$msg");
    exit;

} else {
    echo "Error al actualizar estado";
}
