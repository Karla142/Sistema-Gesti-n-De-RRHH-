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
    $horaSalida = date("H:i");
    $fechaHoy = date("d-m-Y");

    $conn = new mysqli("localhost", "root", "", "base_kam");
    if ($conn->connect_error) {
        echo json_encode(["success" => false, "error" => "Error de conexión a la base de datos"]);
        exit;
    }

    // Verificar que la entrada ya haya sido registrada antes de permitir salida
    $query = "SELECT hora_entrada, hora_salida FROM asistencia WHERE cedula_personal = ? AND fecha_asistencia = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $_GET['cedula'], $fechaHoy);
    $stmt->execute();
    $result = $stmt->get_result();
    $registro = $result->fetch_assoc();

    if (!$registro || empty($registro["hora_entrada"])) {
        echo json_encode(["success" => false, "error" => "Debe registrar la entrada antes de la salida"]);
    } elseif (!empty($registro["hora_salida"])) {
        echo json_encode(["success" => false, "error" => "Salida ya registrada para hoy"]);
    } else {
        // Registrar salida
        $queryUpdate = "UPDATE asistencia SET hora_salida = ?, estado_asistencia = 'confirmada' WHERE cedula_personal = ? AND fecha_asistencia = ?";
        $stmtUpdate = $conn->prepare($queryUpdate);
        $stmtUpdate->bind_param("sss", $horaSalida, $_GET['cedula'], $fechaHoy);
        $stmtUpdate->execute();

        echo json_encode(["success" => true, "message" => "Salida registrada con éxito"]);
    }

    $stmt->close();
    $stmtUpdate->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "error" => "Huella no válida"]);
}
?>
