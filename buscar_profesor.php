<?php
$conexion = new mysqli("localhost", "root", "", "base_kam");

if ($conexion->connect_error) {
  http_response_code(500);
  echo json_encode(["error" => "Error de conexión"]);
  exit;
}
 $cedula = trim($_POST['cedula']);
    $stmt = $conn->prepare("SELECT nombre_personal, apellido_personal, cargo_personal FROM persona WHERE cedula_personal = ?");
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $stmt->store_result();

if ($profesor = $resultado->fetch_assoc()) {
  echo json_encode([
    "encontrado" => true,
    "nombre" => $profesor["nombre"],
    "apellido" => $profesor["apellido"],
    "cargo" => $profesor["cargo"]
  ]);
} else {
  echo json_encode(["encontrado" => false]);
}

$stmt->close();
$conexion->close();
?>
