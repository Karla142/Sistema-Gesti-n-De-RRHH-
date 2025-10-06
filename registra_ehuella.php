<?php
header('Content-Type: application/json');

if (!isset($_GET['cedula'])) {
    echo json_encode(["success" => false, "error" => "Cédula no proporcionada"]);
    exit;
}

$cedula = escapeshellarg($_GET['cedula']);
$command = "java -jar Huella.jar $cedula";
$output = shell_exec($command);

if (!$output) {
    echo json_encode(["success" => false, "error" => "Error al ejecutar la validación de huella"]);
    exit;
}

if (strpos($output, "validado") !== false) {
    $horaEntrada = date("H:i");
    $fechaHoy = date("d-m-Y");

    $conn = new mysqli("localhost", "root", "", "base_kam");
    if ($conn->connect_error) {
        echo json_encode(["success" => false, "error" => "Error de conexión a la base de datos"]);
        exit;
    }

    // Verificar si ya existe un registro de asistencia para hoy
    $query = "SELECT entrada FROM asistencia WHERE cedula_personal = ? AND fecha_asistencia = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $_GET['cedula'], $fechaHoy);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["success" => false, "error" => "Entrada ya registrada para hoy"]);
    } else {
        // Insertar entrada
        $queryInsert = "INSERT INTO asistencia (cedula_personal, fecha_asistencia, hora_entrada, tipo_asistencia, estado_asistencia) VALUES (?, ?, ?, 'huella', 'confirmada')";
        $stmtInsert = $conn->prepare($queryInsert);
        $stmtInsert->bind_param("sss", $_GET['cedula'], $fechaHoy, $horaEntrada);
        $stmtInsert->execute();

        echo json_encode(["success" => true, "message" => "Entrada registrada con éxito"]);
    }

    $stmt->close();
    $stmtInsert->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "error" => "Huella no válida"]);
}
?>
