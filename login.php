<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso al Sistema</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card login-card p-4">
                <div class="text-center mb-4">
                    <i class="bi bi-shield-lock-fill l" style="font-size: 3rem;"></i>
                    <h4 class="fw-bold">Panel de Control</h4>
                    <p class="text-muted small">Inicia sesión para gestionar solicitudes</p>
                </div>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger py-2 small">Usuario o clave incorrectos</div>
                <?php endif; ?>

                <form action="src/validar_login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nombre de Usuario</label>
                        <input type="text" name="usuario" class="form-control" placeholder="Ej: admin01" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Contraseña</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login w-100 mb-3">Entrar</button>
                    <div class="text-center"><a href="index.php" class="text-muted small">Volver</a></div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>