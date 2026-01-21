<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../config/PHPMailer/Exception.php';
require '../config/PHPMailer/PHPMailer.php';
require '../config/PHPMailer/SMTP.php';

// Conexión
$mysqli = new mysqli('localhost', 'root', 'Prueba123', 'audiovisualesfii');
$mysqli->set_charset("utf8mb4");

// Captura de datos (GET)
$id = $_GET['id'] ?? null;
$nuevo_estado = $_GET['estado'] ?? null;
$link = $_GET['link'] ?? null; // Nuevo
$comentario = $_GET['comentario'] ?? null; // Nuevo

if ($id && $nuevo_estado) {
    // Obtener datos del solicitante
    $stmt = $mysqli->prepare("SELECT nombre_solicitante, email, servicio FROM solicitudes WHERE idSolicitud = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $datos = $stmt->get_result()->fetch_assoc();

    if ($datos) {
        //Actualizar estado, link y comentario
        $update = $mysqli->prepare("UPDATE estado SET estado = ?, link_recurso = ?, comentario = ?, fecha_actualizacion = NOW() WHERE idSolicitud = ?");
        $update->bind_param("sssi", $nuevo_estado, $link, $comentario, $id);

        if ($update->execute()) {
            // Enviar correo de notificación
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = ''; //correo
                $mail->Password = '';//clave de aplicacion
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;
                $mail->CharSet = 'UTF-8';

                $mail->setFrom(''/**correo */, 'Audiovisuales FII');
                $mail->addAddress($datos['email']);

                // config colores y estados
                $color = match($nuevo_estado) {
                    'Aceptado' => '#0dcaf0',
                    'En Proceso' => '#0d6efd',
                    'Completado' => '#198754',
                    'Rechazado' => '#dc3545',
                    default => '#ffc107'
                };

                // si hay link
                $bloqueEntrega = "";
                if ($nuevo_estado == 'Completado' && $link) {
                    $bloqueEntrega = "
                        <div style='background: #f8f9fa; border: 1px dashed #198754; padding: 15px; margin: 20px 0; text-align: center;'>
                            <p style='margin-bottom: 10px;'><strong>¡Tu material está listo!</strong></p>
                            <a href='$link' style='background: #198754; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;'>Descargar Recursos aquí</a>
                        </div>";
                }

                // sin hay comentarios
                $bloqueComentario = ($comentario) ? "<p><strong>Nota del administrador:</strong><br><em>$comentario</em></p>" : "";

                $mail->isHTML(true);
                $mail->Subject = "Actualización de su Solicitud #$id - $nuevo_estado";
                $mail->Body = "
                    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #eee; padding: 30px; border-radius: 10px;'>
                        <div style='text-align: center; margin-bottom: 20px;'>
                            <h2 style='color: $color; margin: 0;'>Estado: $nuevo_estado</h2>
                        </div>
                        <p>Hola <strong>{$datos['nombre_solicitante']}</strong>,</p>
                        <p>Te notificamos que el estado de tu solicitud para <strong>{$datos['servicio']}</strong> ha cambiado.</p>
                        
                        $bloqueEntrega
                        $bloqueComentario

                        <p>Si tienes alguna duda, puedes contactarnos respondiendo a este correo.</p>
                        <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                        <p style='font-size: 11px; color: #888; text-align: center;'>Sistema de Gestión Audiovisual - FII</p>
                    </div>";

                $mail->send();
                header("Location: ../detalle.php?id=$id&msg=" . urlencode($nuevo_estado));
            } catch (Exception $e) {
                // Si falla el correo, igual avisamos que la DB se actualizó
                header("Location: ../detalle.php?id=$id&msg=error_email");
            }
        }
    }
}