<?php
// Configuración de conexión
try {
    $pdo = new PDO("mysql:host=localhost;dbname=sistema_horarios;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error de conexión: " . $e->getMessage()]);
    exit;
}

// Consulta de personal filtrado
try {
    $stmt = $pdo->prepare("SELECT nombre, apellido, cedula, cargo FROM personal WHERE cargo IN ('Aux.Inicial', 'maestra','Auxiliar inicial','Auxiliar') ORDER BY apellido ASC");
    $stmt->execute();
    $datos = $stmt->fetchAll();

    header('Content-Type: application/json');

    if (count($datos) > 0) {
        echo json_encode($datos);
    } else {
        echo json_encode([]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error al consultar datos: " . $e->getMessage()]);
}
?>
