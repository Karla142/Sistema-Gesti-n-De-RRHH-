<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$conn = new mysqli("localhost", "root", "", "base_kam");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST['accion'];
    $correo = filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL);
    $nueva_contrasena = $_POST['nueva_contrasena'] ?? null;
    $token = $_POST['token'] ?? null;

    if (!$correo) {
        echo json_encode(['status' => 'error', 'message' => 'Por favor, ingresa un correo válido.']);
        exit;
    }

    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos.']);
        exit;
    }

    // Funcionalidad para enviar el token
    if ($accion === 'enviar_token') {
        $stmt = $conn->prepare("SELECT usuario FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($usuario);
            $stmt->fetch();

            $token = mt_rand(100000, 999999);
            $expiracion = date("Y-m-d H:i:s", strtotime("+1 minute"));

            $stmt2 = $conn->prepare("UPDATE usuarios SET token_recuperacion = ?, expiracion_token = ? WHERE correo = ?");
            $stmt2->bind_param("sss", $token, $expiracion, $correo);
            $stmt2->execute();

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'Karlaad142@gmail.com';
                $mail->Password = 'skde jnuc lkwu aosu'; // Cambia por tu contraseña segura
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('Karlaad142@gmail.com', 'KAM');
                $mail->addAddress($correo, $usuario);
                $mail->isHTML(true);
                $mail->Subject = 'Recupera tu Contraseña';
                $mail->Body = "Hola $usuario,<br>
                    Usa el siguiente código para confirmar el cambio de contraseña: <b>$token</b><br>
                    Este código expira en 1 minuto.";

                $mail->send();

                echo json_encode(['status' => 'success', 'message' => 'El código de recuperación ha sido enviado.']);
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'Error al enviar el correo.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'El correo no está registrado.']);
        }
    }

    // Funcionalidad para actualizar la contraseña
    if ($accion === 'actualizar_contrasena') {
        $stmt = $conn->prepare("SELECT expiracion_token FROM usuarios WHERE correo = ? AND token_recuperacion = ?");
        $stmt->bind_param("ss", $correo, $token);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($expiracion_token);
            $stmt->fetch();

            if (strtotime($expiracion_token) > time()) {
                $hashed_password = password_hash($nueva_contrasena, PASSWORD_BCRYPT);

                $stmt2 = $conn->prepare("UPDATE usuarios SET contrasena = ?, token_recuperacion = NULL, expiracion_token = NULL WHERE correo = ?");
                $stmt2->bind_param("ss", $hashed_password, $correo);
                $stmt2->execute();

                echo json_encode(['status' => 'success', 'message' => 'Contraseña actualizada correctamente.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'El token ha expirado.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'El token es inválido o no coincide.']);
        }
    }
}
?>
