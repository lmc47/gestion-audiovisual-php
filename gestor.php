<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    // Si no ha iniciado sesión, lo mandamos al login
    header("Location: login.php");
    exit;
}
require_once 'src/procesar_gestor.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Solicitudes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- estilos-->
    <link rel="stylesheet" href="assets/css/gestor.css">

</head>

<body>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
                <div>
                    <h5 class="mb-0">Hola, <span class="text-primary fw-bold"><?= htmlspecialchars($_SESSION['admin_username']) ?></span></h5>
                    <small class="text-muted">Panel de control administrativo</small>
                </div>
                <a href="src/logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                    <i class="bi bi-power"></i> Salir del Sistema
                </a>
            </div>
            <div class="main-card">
                <div class="card-header-custom">
                    <i class="bi bi-table fs-2 text-primary"></i>
                    <h3 class="mt-2">Gestión de Solicitudes</h3>
                </div>
                <div class="card-body p-4">

                    <!-- buscador -->
                    <form method="get" class="mb-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                            <input type="text" name="buscar" class="form-control bg-light"
                                   placeholder="Buscar por ID, solicitante o servicio"
                                   value="<?= htmlspecialchars($buscar); ?>">
                        </div>
                    </form>

                    <!-- TABLA -->
                    <div class="table-responsive table-rounded">
                        <table class="table table-custom mb-0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Solicitante</th>
                                <th>Servicio</th>
                                <th>Fecha</th>
                                <th>Registro</th>
                                <th>Estado</th>
                                <th class="text-center">Detalle</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>

                                    <?php
                                    // color segun estado
                                    $estado = $row['estado'] ?? 'Pendiente';
                                    $badgeClass = match ($estado) {
                                        'Aceptado'    => 'bg-info bg-opacity-10 text-info border border-info-subtle',
                                        'En Proceso'  => 'bg-primary bg-opacity-10 text-primary border border-primary-subtle',
                                        'Completado'  => 'bg-success bg-opacity-10 text-success border border-success-subtle',
                                        'Rechazado'   => 'bg-danger bg-opacity-10 text-danger border border-danger-subtle',
                                        default       => 'bg-warning bg-opacity-10 text-warning border border-warning-subtle',
                                    };
                                    ?>

                                    <tr>
                                        <td class="fw-bold text-primary">#<?= $row['idSolicitud']; ?></td>
                                        <td><?= $row['nombre_solicitante']; ?></td>
                                        <td><?= $row['servicio']; ?></td>
                                        <td><?= $row['fecha']; ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($row['fecha_registro'])); ?></td>
                                        <td>
                                            <span class="badge <?= $badgeClass ?>">
                                                <?= $estado ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="detalle.php?id=<?= $row['idSolicitud']; ?>"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        No se encontraron registros
                                    </td>
                                </tr>
                            <?php endif; ?>

                            </tbody>
                        </table>
                    </div>

                    <!--varias paginas -->
                    <nav class="mt-4">
                        <ul class="pagination justify-content-end pagination-sm">
                            <li class="page-item <?= ($pagina<=1)?'disabled':''; ?>">
                                <a class="page-link" href="?pagina=<?= $pagina-1; ?>&buscar=<?= urlencode($buscar); ?>">
                                    Anterior
                                </a>
                            </li>

                            <?php for($i=1;$i<=$total_paginas;$i++): ?>
                                <li class="page-item <?= ($i==$pagina)?'active':''; ?>">
                                    <a class="page-link" href="?pagina=<?= $i; ?>&buscar=<?= urlencode($buscar); ?>">
                                        <?= $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?= ($pagina>=$total_paginas)?'disabled':''; ?>">
                                <a class="page-link" href="?pagina=<?= $pagina+1; ?>&buscar=<?= urlencode($buscar); ?>">
                                    Siguiente
                                </a>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
