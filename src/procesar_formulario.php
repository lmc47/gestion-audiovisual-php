<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../config/PHPMailer/Exception.php';
require '../config/PHPMailer/PHPMailer.php';
require '../config/PHPMailer/SMTP.php';

// quitar solo es un reporte
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    require_once '../config/conexion/conexion-db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $nombre = $_POST['nombre'] ?? '';
        $email = $_POST['email'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $lugar = $_POST['lugar'] ?? '';
        $entrega = $_POST['entrega'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $fechas = $_POST['fechas'] ?? [];
        $inicios = $_POST['h_inicio'] ?? [];
        $fines = $_POST['h_fin'] ?? [];

        $servicios_post = $_POST['servicio'] ?? [];
        $servicios_array = is_array($servicios_post) ? $servicios_post : [$servicios_post];
        $servicios_html = "";
        $servicios_texto = implode(', ', $servicios_array);

        foreach ($servicios_array as $serv) {
            $servicios_html .= "<li>" . htmlspecialchars($serv) . "</li>";
        }

        // --- LÓGICA DE BASE DE DATOS preparada ---

        // insertar
        $sql = "INSERT INTO solicitudes (nombre_solicitante, email, servicio, lugar, telefono, descripcion, entrega) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssssss", $nombre, $email, $servicios_texto, $lugar, $telefono, $descripcion, $entrega);
        $stmt->execute();

        $id_solicitud = $conexion->insert_id;
        $stmt->close();

        // insertando las fechas
        $sqlFecha = "INSERT INTO fechas_reserva (idSolicitud, fecha, hora_inicio, hora_fin) VALUES (?, ?, ?, ?)";
        $stmtFecha = $conexion->prepare($sqlFecha);

        $filas_fechas_html = "";
        for ($i = 0; $i < count($fechas); $i++) {
            if (!empty($fechas[$i])) {
                $stmtFecha->bind_param("isss", $id_solicitud, $fechas[$i], $inicios[$i], $fines[$i]);
                $stmtFecha->execute();

                // formato para las fechas
                $fecha_formateada = date('d/m/Y', strtotime($fechas[$i]));
                $filas_fechas_html .= "<li><strong>Fecha:</strong> $fecha_formateada | <strong>Horario:</strong> {$inicios[$i]} - {$fines[$i]}</li>";
            }
        }
        $stmtFecha->close();

        // --- logica para enviar los correos ---
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

            $contenidoCorreo = "
                <div style='font-family: sans-serif; padding: 20px; color: #333;'>
                    <h2 style='color: #007bff;'>Nueva Solicitud #$id_solicitud</h2>
                    <p>Hola <strong>$nombre</strong>, hemos recibido tu solicitud con los siguientes detalles:</p>
                    <hr>
                    <p><strong>Lugar:</strong> $lugar</p>
                    <p><strong>Servicios solicitados:</strong></p>
                    <ul>$servicios_html</ul>
                    <p><strong>Fechas reservadas:</strong></p>
                    <ul>$filas_fechas_html</ul>
                    <p><strong>Observaciones:</strong> " . nl2br(htmlspecialchars($descripcion)) . "</p>
                    <hr>
                    <p style='font-size: 0.9em; color: #666;'>Este es un mensaje automático, por favor no responda.</p>
                </div>
            ";

            $mail->setFrom(''/**correo */ , 'Audiovisuales FII');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = "Confirmación de Solicitud #$id_solicitud";
            $mail->Body = $contenidoCorreo;
            $mail->send();

            // Redirección con éxito
            header("Location: ../formulario.php?msg=enviado");
            exit;

        } catch (Exception $e) {
            //salta notificacion si hay un error
            header("Location: ../formulario.php?msg=error_sistema");
            exit;
        }
    }
} catch (Exception $e) {
    // salta notificacion si hay un error
    header("Location: ../formulario.php?msg=error_sistema");
    exit;
}
?>