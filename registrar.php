<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $nivel_usuario = $_POST['nivel_usuario'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    $response = array();

    $conn = new mysqli("localhost", "root", "", "base_kam");

    if ($conn->connect_error) {
        $response['status'] = 'error';
        $response['message'] = 'Conexión fallida: ' . $conn->connect_error;
    } else {
        // Verificar si el usuario ya existe
        $stmt = $conn->prepare("SELECT usuario FROM usuarios WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $response['status'] = 'error';
            $response['message'] = 'Usuario ya existe, intente con otro usuario.';
        } else {
            if ($contrasena != $confirmar_contrasena) {
                $response['status'] = 'error';
                $response['message'] = 'Las contraseñas no coinciden.';
            } else {
                $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO usuarios (usuario, nivel_usuario, correo, contrasena) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $usuario, $nivel_usuario, $correo, $hashed_password);
                if ($stmt->execute()) {
                    $response['status'] = 'success';
                    $response['message'] = 'Registro exitoso';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Error: ' . $stmt->error;
                }
                $stmt->close();
            }
        }

        $conn->close();
    }

    echo json_encode($response);
    exit;
}
?>
