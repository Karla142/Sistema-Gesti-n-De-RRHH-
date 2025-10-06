<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_kam";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener parámetros de la URL
$cedula = $_GET['cedula'];
$fecha_actual = date('Y-m-d'); // Fecha actual en formato YYYY-MM-DD

// Insertar un nuevo registro de asistencia
$sql = "INSERT INTO asistencia (cedula_personal, fecha_asistencia) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $cedula, $fecha_actual);

$response = ['success' => false];

if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['error'] = $stmt->error;
}

echo json_encode($response);

// Cerrar conexión
$stmt->close();
$conn->close();
?>
