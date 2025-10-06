<?php
// Configuración de la conexión a la base de datos
$host = "localhost";
$dbname = "base_kam";
$username = "root";
$password = "";

// Configurar cabeceras de respuesta como JSON
header('Content-Type: application/json');

try {
    // Crear conexión usando PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error de conexión a la base de datos']);
    exit();
}

// Manejar las solicitudes HTTP
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener todos los usuarios o un usuario específico
    try {
        if (isset($_GET['id'])) {
            // Obtener un usuario por ID
            $id = intval($_GET['id']);
            $sql = "SELECT id, usuario, correo FROM usuarios WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                echo json_encode($usuario);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Usuario no encontrado']);
            }
        } else {
            // Obtener todos los usuarios
            $sql = "SELECT id, usuario, correo FROM usuarios";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($usuarios);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al obtener usuarios: ' . $e->getMessage()]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Actualizar un usuario existente
    $putData = json_decode(file_get_contents("php://input"), true); // Leer JSON

    if (isset($putData['usuario'], $putData['correo']) && isset($_GET['id'])) {
        try {
            $id = intval($_GET['id']);
            $sql = "UPDATE usuarios SET usuario = :usuario, correo = :correo WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':usuario', $putData['usuario'], PDO::PARAM_STR);
            $stmt->bindParam(':correo', $putData['correo'], PDO::PARAM_STR);

            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode(['mensaje' => 'Usuario actualizado correctamente']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'No se pudo actualizar el usuario']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al actualizar el usuario: ' . $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Datos incompletos para actualizar']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Eliminar un usuario por ID
    $deleteData = json_decode(file_get_contents("php://input"), true); // Leer JSON

    if (isset($deleteData['id'])) {
        try {
            $id = intval($deleteData['id']);
            $sql = "DELETE FROM usuarios WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode(['mensaje' => 'Usuario eliminado correctamente']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'No se pudo eliminar el usuario']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al eliminar el usuario: ' . $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'ID no proporcionado para eliminar']);
    }
} else {
    // Manejar métodos no permitidos
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}

// Finalizar conexión (aunque PDO se encarga automáticamente al finalizar el script)
$conn = null;
?>
