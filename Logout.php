<?php
// Iniciar la sesión
session_start();
include 'conex.php'; // Archivo de conexión a la base de datos

// Comprobar si se recibió la confirmación para cerrar sesión
if (isset($_POST['confirm_logout']) && $_POST['confirm_logout'] === 'yes') {
    // Obtener los datos del usuario desde la sesión
    $usuario_id = $_SESSION['usuario_id']; // ID del usuario desde la sesión
    $usuario = $_SESSION['usuario']; // Nombre de usuario
    $correo = $_SESSION['correo']; // Correo del usuario
    $fecha_hora = date("Y-m-d H:i:s"); // Fecha y hora actual

    // Registrar el cierre de sesión en la bitácora
    $stmt = $conexion->prepare("INSERT INTO bitacora (usuario_id, nombre_usuario, correo, accion, fecha_hora) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        $accion = 'Cierre de sesión'; // Acción registrada
        $stmt->bind_param("issss", $usuario_id, $usuario, $correo, $accion, $fecha_hora);
        if (!$stmt->execute()) {
            echo "Error al registrar la acción en la bitácora: " . $stmt->error; // Manejo de errores
        }
        $stmt->close(); // Cerrar la consulta preparada
    } else {
        die("Error al preparar la consulta para registrar en bitácora: " . $conexion->error); // Manejo de errores
    }

    // Destruir las variables de sesión y la sesión
    session_unset();
    session_destroy();

    // Redirigir al archivo login.php
    header("Location: Login.php");
    exit; // Salida segura
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cerrar Sesión</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        // Mostrar mensaje de confirmación con SweetAlert2
        Swal.fire({
            title: '¿Está seguro de cerrar su sesión?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, cerrar sesión',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar formulario para confirmar cierre de sesión
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'logout.php';
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'confirm_logout';
                input.value = 'yes';
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            } else {
                // Cancelar acción y redirigir a principal.php
                window.location.href = 'principal.php';
            }
        });
    </script>
</body>
</html>
