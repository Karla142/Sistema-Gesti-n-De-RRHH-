<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$database = "base_kam";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Conexión fallida: ' . $conn->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);

// Validación básica
if (!isset($data['docente']) || !is_array($data['cambios']) || empty($data['cambios'])) {
    die(json_encode(['error' => 'Datos inválidos.']));
}

$docente = $data['docente'];
$cambios = $data['cambios'];
$actualizados = 0;

foreach ($cambios as $cambio) {
    $sql = "UPDATE horarios SET hora = ?, dia = ?, materia = ? WHERE docente = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die(json_encode(['error' => 'Error al preparar la consulta.']));
    }

    $stmt->bind_param('ssss', $cambio['hora'], $cambio['dia'], $cambio['materia'], $docente);
    if ($stmt->execute()) {
        $actualizados++;
    } else {
        die(json_encode(['error' => 'Error al ejecutar la consulta: ' . $stmt->error]));
    }

    $stmt->close();
}

$conn->close();

echo json_encode(['success' => true, 'actualizados' => $actualizados]);
?>
