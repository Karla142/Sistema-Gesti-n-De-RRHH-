<?php
header('Content-Type: application/json');

// Conectar a la base de datos
$host = 'localhost';
$dbname = 'base_kam';
$username = 'root';
$password = '';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Recibir los datos del frontend
$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $docente = $input['docente'];
    $nivel_academico = $input['nivel_academico'];
    $cargo_personal = $input['cargo_personal'];
    $horarios = $input['horarios'];

    try {
        // Insertar cada fila de horario en la base de datos
        foreach ($horarios as $horario) {
            $stmt = $conn->prepare("INSERT INTO horarios (docente, nivel_academico, cargo_personal, hora, dia, materia) 
                                    VALUES (:docente, :nivel_academico, :cargo_personal, :hora, :dia, :materia)");
            $stmt->execute([
                ':docente' => $docente,
                ':nivel_academico' => $nivel_academico,
                ':cargo_personal' => $cargo_personal,
                ':hora' => $horario['hora'],
                ':dia' => $horario['dia'],
                ':materia' => $horario['materia']
            ]);
        }

        echo json_encode(['message' => 'Horarios guardados exitosamente']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
