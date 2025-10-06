<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre_personal = $_POST['nombre_personal'];
    $apellido_personal = $_POST['apellido_personal'];
    $cedula_personal = $_POST['cedula_personal'];
    $correo_personal = $_POST['correo_personal'];
    $nacimiento_personal = $_POST['nacimiento_personal'];
    $ingreso_personal = $_POST['ingreso_personal'];
    $cargo_personal = $_POST['cargo_personal'];

    $conn = new mysqli("localhost", "root", "", "base_kam");

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Preparar y ejecutar la consulta de actualización
    $stmt = $conn->prepare("UPDATE persona SET nombre_personal = ?, apellido_personal =  ?, correo_personal = ?, nacimiento_personal = ?, ingreso_personal = ?, cargo_personal = ? WHERE cedula_personal = ?");
    if (!$stmt) {
        die("Error al preparar la sentencia: " . $conn->error);
    }

    $stmt->bind_param("ssssssss", $nombre_personal, $apellido_personal, $titulo_personal, $correo_personal, $nacimiento_personal, $ingreso_personal, $cargo_personal, $cedula_personal);

    if ($stmt->execute()) {
        $response = ["success" => true];
    } else {
        $response = ["success" => false, "error" => $stmt->error];
    }

    $stmt->close();
    echo json_encode($response);
}

$conn->close();
?>
