<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Solicitud Audiovisuales FII</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- estilos -->
    <link rel="stylesheet" href="assets/css/formulario.css">
</head>

<body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-8">

                <div class="main-card">

                    <div class="card-header-custom">
                        <div
                            class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle p-3 mb-3">
                            <i class="bi bi-camera-reels-fill fs-3"></i>
                        </div>
                        <h3 class="mb-1">Solicitud Audiovisuales</h3>
                        <p class="text-muted small">FACULTAD DE INGENERIA INDUSTRIAL - FII</p>
                    </div>

                    <div class="card-body p-4 p-md-5">

                        <!-- ########## logica para la notificacion ########## -->
                        <?php if (isset($_GET['msg'])): ?>

                            <?php if ($_GET['msg'] === 'enviado'): ?>
                                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4"
                                    role="alert" style="border-radius: 12px; background-color: #d1e7dd; color: #0f5132;">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                                        <div>
                                            <strong class="d-block">¡Solicitud Enviada!</strong>
                                            Su registro se completó con éxito y se envió un correo de confirmación.
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                            <?php elseif ($_GET['msg'] === 'error_correo'): ?>
                                <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm mb-4"
                                    role="alert" style="border-radius: 12px; background-color: #fff3cd; color: #664d03;">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                                        <div>
                                            <strong class="d-block">Registro parcial</strong>
                                            Tu solicitud se guardó en el sistema, pero <strong>no se pudo enviar el
                                                correo</strong> de confirmación. Por favor, contacta con soporte.
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                            <?php elseif ($_GET['msg'] === 'error_sistema'): ?>
                                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert"
                                    style="border-radius: 12px; background-color: #f8d7da; color: #842029;">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-x-octagon-fill fs-4 me-3"></i>
                                        <div>
                                            <strong class="d-block">Error de Sistema</strong>
                                            No se pudo procesar tu solicitud debido a un error interno. Inténtalo de nuevo más
                                            tarde.
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                        <?php endif; ?>
                        <!-- ########### logica para la notificacion ########## -->
                        <form action="src/procesar_formulario.php" method="POST">

                            <div class="mb-5">
                                <div class="section-title">
                                    <i class="bi bi-person-circle me-2"></i> Información del Solicitante
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="nombre" name="nombre"
                                                placeholder="Nombre" required>
                                            <label for="nombre">Nombre y Apellido</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Email" required>
                                            <label for="email">Email Institucional</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="tel" class="form-control" id="telefono" name="telefono"
                                                placeholder="Teléfono" maxlength="9" required>
                                            <label for="telefono">Teléfono / Celular</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select class="form-select" id="lugar" name="lugar"
                                                aria-label="Lugar del evento" required>
                                                <option selected disabled value="">Seleccione...</option>
                                                <option value="Auditorio">Auditorio FII</option>
                                                <option value="Auditorio">Auditorio FII</option>
                                                <option value="Auditorio">Auditorio FII</option>
                                            </select>
                                            <label for="lugar">Lugar del Evento</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select class="form-select" id="entrega" name="entrega"
                                                aria-label="Modo de entrega" required>
                                                <option selected disabled value="">Seleccione...</option>
                                                <option value="Drive">Google Drive</option>
                                                <option value="USB">USB</option>
                                                <option value="CD">CD / DVD</option>
                                            </select>
                                            <label for="entrega">Modo de Entrega</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-5">
                                <div class="section-title">
                                    <i class="bi bi-calendar-week me-2"></i> Programación
                                </div>

                                <div class="table-responsive table-rounded mb-3">
                                    <table class="table table-custom mb-0">
                                        <thead>
                                            <tr>
                                                <th width="35%">Fecha</th>
                                                <th width="25%">Inicio</th>
                                                <th width="25%">Fin</th>
                                                <th width="15%" class="text-center"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="cuerpo-tabla">
                                            <tr>
                                                <td><input type="date"
                                                        class="form-control form-control-sm border-0 bg-light"
                                                        name="fechas[]" required></td>
                                                <td><input type="time"
                                                        class="form-control form-control-sm border-0 bg-light"
                                                        name="h_inicio[]" required></td>
                                                <td><input type="time"
                                                        class="form-control form-control-sm border-0 bg-light"
                                                        name="h_fin[]" required></td>
                                                <td class="text-center text-muted"><i
                                                        class="bi bi-lock-fill opacity-25"></i></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-light text-primary btn-sm fw-medium"
                                    onclick="agregarFila()">
                                    <i class="bi bi-plus-lg me-1"></i> Agregar otra fecha
                                </button>
                            </div>

                            <div class="mb-5">
                                <div class="section-title">
                                    <i class="bi bi-grid-fill me-2"></i> Servicios Requeridos
                                </div>

                                <div class="row g-3">
                                    <div class="col-4">
                                        <label class="w-100 h-100">
                                            <input type="checkbox" name="servicio[]" value="Fotografia"
                                                class="service-option">
                                            <div class="service-card">
                                                <i class="bi bi-camera"></i>
                                                <span class="d-block small">Fotografía</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <label class="w-100 h-100">
                                            <input type="checkbox" name="servicio[]" value="Grabación"
                                                class="service-option">
                                            <div class="service-card">
                                                <i class="bi bi-film"></i>
                                                <span class="d-block small">Video</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <label class="w-100 h-100">
                                            <input type="checkbox" name="servicio[]" value="Transmision"
                                                class="service-option">
                                            <div class="service-card">
                                                <i class="bi bi-broadcast"></i>
                                                <span class="d-block small">Transmision</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-5">
                                <div class="form-floating">
                                    <textarea class="form-control" name="descripcion" id="observaciones"
                                        style="height: 120px" placeholder="Detalles"></textarea>
                                    <label for="observaciones">Observaciones adicionales...</label>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-cta btn-lg shadow-sm">
                                    ENVIAR SOLICITUD <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- javascript -->
    <script src="assets/js/formulario.js"></script>
    <script>
        // Limpia los parámetros de la URL sin recargar la página
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.pathname);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>