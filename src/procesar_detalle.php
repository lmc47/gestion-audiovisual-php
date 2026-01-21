<?php
// ================= CONEXION A LA DB =================
// Asegúrate de que la ruta sea correcta según la ubicación de este archivo
require_once 'config/conexion/conexion-db.php';

// ================= VALIDANDO ID =================
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: gestor.php");
    exit;
}

$id = intval($_GET['id']);

// ================= LOS DATOS DE UNA SOLICITUD =================
$sqlSolicitud = "
SELECT 
    s.idSolicitud,
    s.nombre_solicitante,
    s.email,
    s.telefono,
    s.lugar,
    s.entrega,
    s.servicio,
    s.descripcion,
    s.fecha_registro,
    e.estado,
    e.link_recurso,
    e.comentario
FROM solicitudes s
LEFT JOIN estado e ON s.idSolicitud = e.idSolicitud
WHERE s.idSolicitud = ?
LIMIT 1
";

// Sentencia preparada para seguridad
$stmt = mysqli_prepare($conexion, $sqlSolicitud);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$resSolicitud = mysqli_stmt_get_result($stmt);

if (!$resSolicitud || mysqli_num_rows($resSolicitud) == 0) {
    echo "Solicitud no encontrada";
    exit;
}

$data = mysqli_fetch_assoc($resSolicitud);

// ================= FECHAS =================
$sqlFechas = "
SELECT fecha, hora_inicio, hora_fin
FROM fechas_reserva
WHERE idSolicitud = ?
ORDER BY fecha ASC
";

// Sentencia preparada para las fechas
$stmtF = mysqli_prepare($conexion, $sqlFechas);
mysqli_stmt_bind_param($stmtF, "i", $id);
mysqli_stmt_execute($stmtF);
$resFechas = mysqli_stmt_get_result($stmtF);

