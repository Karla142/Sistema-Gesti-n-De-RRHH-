<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'Karlaad142@gmail.com';
    $mail->Password = 'skde jnuc lkwu aosu';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Configuración del correo
    $mail->setFrom('Karlaad142@gmamil.com', 'Karla');
    $mail->addAddress('kr6101104@gmail.com', 'Destinatario');
    $mail->isHTML(true);
    $mail->Subject = 'Prueba de envío con PHPMailer';
    $mail->Body = 'Este es un mensaje de prueba enviado desde PHPMailer.';
    $mail->AltBody = 'Este es un mensaje de prueba en texto plano.';

    $mail->send();
    echo 'El correo ha sido enviado exitosamente.';
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
?>