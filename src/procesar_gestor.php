<?php
global $conexion;
require_once 'config/conexion/conexion-db.php';

$por_pagina = 20;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina < 1) $pagina = 1;
$inicio = ($pagina - 1) * $por_pagina;

$buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';
$term = "%$buscar%";


$where = "";
if (!empty($buscar)) {
    $where = "WHERE s.idSolicitud LIKE ? OR s.nombre_solicitante LIKE ? OR s.servicio LIKE ?";
}

$count_sql = "SELECT COUNT(DISTINCT s.idSolicitud) AS total FROM solicitudes s $where";
$stmtC = mysqli_prepare($conexion, $count_sql);

if (!empty($buscar)) {
    mysqli_stmt_bind_param($stmtC, "sss", $term, $term, $term);
}

mysqli_stmt_execute($stmtC);
$total_filas = mysqli_stmt_get_result($stmtC)->fetch_assoc()['total'];
$total_paginas = ceil($total_filas / $por_pagina);


$sql = "SELECT 
            s.idSolicitud, s.nombre_solicitante, s.servicio,
            f.fecha, s.fecha_registro, e.estado
        FROM solicitudes s
        LEFT JOIN fechas_reserva f ON s.idSolicitud = f.idSolicitud
        LEFT JOIN estado e ON s.idSolicitud = e.idSolicitud
        $where
        GROUP BY s.idSolicitud
        ORDER BY s.idSolicitud DESC
        LIMIT ?, ?";

$stmt = mysqli_prepare($conexion, $sql);

if (!empty($buscar)) {

    mysqli_stmt_bind_param($stmt, "sssii", $term, $term, $term, $inicio, $por_pagina);
} else {

    mysqli_stmt_bind_param($stmt, "ii", $inicio, $por_pagina);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>