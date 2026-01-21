<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit; }
require_once 'src/procesar_detalle.php';

$id = $data['idSolicitud'];
$estado = $data['estado'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle Solicitud #<?= $id ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/detalle.css">
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card detail-card border-0 shadow-sm">

                <div class="card-header bg-white text-center py-4 border-0">
                    <i class="bi bi-file-earmark-text fs-1 text-primary"></i>
                    <h4 class="mt-2 mb-1">Detalle de Solicitud #<?= $id ?></h4>
                    <?php
                    $badge = match($estado){
                        'Aceptado' => 'bg-info', 'En Proceso' => 'bg-primary',
                        'Completado' => 'bg-success', 'Rechazado' => 'bg-danger', default => 'bg-warning'
                    };
                    ?>
                    <span class="badge <?= $badge ?> rounded-pill px-3 py-2 text-white"><?= strtoupper($estado) ?></span>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="label text-muted fw-bold small d-block mb-1">SOLICITANTE</label>
                            <div class="fw-semibold"><?= htmlspecialchars($data['nombre_solicitante']) ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="label text-muted fw-bold small d-block mb-1">SERVICIO REQUERIDO</label>
                            <div class="badge bg-light text-primary border border-primary-subtle"><?= htmlspecialchars($data['servicio']) ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="label text-muted fw-bold small d-block mb-1">EMAIL</label>
                            <div><?= htmlspecialchars($data['email']) ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="label text-muted fw-bold small d-block mb-1">TELÉFONO</label>
                            <div><?= htmlspecialchars($data['telefono']) ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="label text-muted fw-bold small d-block mb-1">LUGAR DEL EVENTO</label>
                            <div><?= htmlspecialchars($data['lugar']) ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="label text-muted fw-bold small d-block mb-1">MODO DE ENTREGA SOLICITADO</label>
                            <div><?= htmlspecialchars($data['entrega']) ?></div>
                        </div>

                        <?php if(!empty($data['link_recurso']) || !empty($data['comentario'])): ?>
                            <div class="col-12">
                                <div class="p-3 bg-light rounded border-start border-4 border-success shadow-sm">
                                    <h6 class="fw-bold text-success mb-2"><i class="bi bi-box-seam"></i> Resultado de la Gestión</h6>
                                    <?php if($data['link_recurso']): ?>
                                        <p class="mb-1 small"><strong>Link de Recursos:</strong> <a href="<?= $data['link_recurso'] ?>" target="_blank" class="text-break"><?= $data['link_recurso'] ?></a></p>
                                    <?php endif; ?>
                                    <?php if($data['comentario']): ?>
                                        <p class="mb-0 small"><strong>Nota de Entrega:</strong> <?= nl2br(htmlspecialchars($data['comentario'])) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="col-12">
                            <label class="label text-muted fw-bold small mb-2 d-block">CRONOGRAMA DE FECHAS</label>
                            <div class="table-responsive">
                                <table class="table table-sm border table-hover">
                                    <thead class="table-light">
                                    <tr><th>Fecha</th><th>Inicio</th><th>Fin</th></tr>
                                    </thead>
                                    <tbody>
                                    <?php while($f = mysqli_fetch_assoc($resFechas)): ?>
                                        <tr>
                                            <td><?= date('d/m/Y', strtotime($f['fecha'])) ?></td>
                                            <td><?= substr($f['hora_inicio'], 0, 5) ?></td>
                                            <td><?= substr($f['hora_fin'], 0, 5) ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="label text-muted fw-bold small d-block mb-2">OBSERVACIONES DEL SOLICITANTE</label>
                            <div class="p-3 bg-light rounded border small">
                                <?= nl2br(htmlspecialchars($data['descripcion'] ?? 'Sin observaciones adicionales')) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-0 d-flex justify-content-between p-4">
                    <a href="gestor.php" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>

                    <div class="d-flex gap-2">
                        <?php if($estado === 'Pendiente'): ?>
                            <a href="src/procesar_notificacion.php?id=<?= $id ?>&estado=Aceptado" class="btn btn-success rounded-pill px-4" onclick="return confirm('¿Aceptar esta solicitud?')">
                                <i class="bi bi-check-lg"></i> Aceptar
                            </a>
                            <a href="src/procesar_notificacion.php?id=<?= $id ?>&estado=Rechazado" class="btn btn-danger rounded-pill px-4" onclick="return confirm('¿Rechazar esta solicitud?')">
                                <i class="bi bi-x-lg"></i> Rechazar
                            </a>

                        <?php elseif($estado === 'Aceptado'): ?>
                            <a href="src/procesar_notificacion.php?id=<?= $id ?>&estado=En+Proceso" class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-camera-reels"></i> Iniciar Evento
                            </a>

                        <?php elseif($estado === 'En Proceso'): ?>
                            <button type="button" class="btn btn-dark rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalCierre">
                                <i class="bi bi-cloud-check"></i> Finalizar Entrega
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCierre" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="src/procesar_notificacion.php" method="GET" class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Confirmar Entrega de Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="hidden" name="estado" value="Completado">

                <div class="mb-3">
                    <label class="form-label small fw-bold">Link de Recursos (Opcional)</label>
                    <input type="url" name="link" class="form-control" placeholder="https://drive.google.com/...">
                    <div class="form-text small">Ejem: Drive, OneDrive o YouTube (Déjalo vacío si es entrega física).</div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Comentario / Detalle Final</label>
                    <textarea name="comentario" class="form-control" rows="3" placeholder="Ej: Transmisión cerrada / USB entregado en oficina / Se enviaron 20 fotos."></textarea>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success rounded-pill px-4">Guardar y Notificar</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>