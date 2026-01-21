<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Gestión Audiovisual</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card welcome-card">
                <div class="row g-0">
                    <div class="col-md-6 border-end">
                        <a href="formulario.php" class="option-box">
                            <div class="icon-circle">
                                <i class="bi bi-file-earmark-plus"></i>
                            </div>
                            <h4 class="fw-bold text-dark">Solicitante</h4>
                            <p class="text-muted">Soy alumno o docente y deseo solicitar apoyo audiovisual para un evento.</p>
                            <span class="btn btn-primary rounded-pill px-4">Nueva Solicitud</span>
                        </a>
                    </div>

                    <div class="col-md-6">
                        <a href="login.php" class="option-box admin-box">
                            <div class="icon-circle">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <h4 class="fw-bold text-dark">Administrador</h4>
                            <p class="text-muted">Acceso restringido para personal técnico y gestión de solicitudes.</p>
                            <span class="btn btn-outline-secondary rounded-pill px-4">Iniciar Sesión</span>
                        </a>
                    </div>
                </div>
            </div>
            <p class="text-center mt-4 text-muted small">Sistema de Gestión de Solicitudes Audiovisual </p>
        </div>
    </div>
</div>
</body>
</html>