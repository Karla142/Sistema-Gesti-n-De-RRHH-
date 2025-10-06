<?php
include 'conexio.php';

if (isset($_GET['cedula'])) {
  $cedula = $_GET['cedula'];

  $stmt = $conn->prepare("SELECT nombre, apellido, cedula, cargo FROM personal WHERE cedula = ?");
  $stmt->bind_param("s", $cedula);
  $stmt->execute();
  $resultado = $stmt->get_result();

  if ($persona = $resultado->fetch_assoc()) {
    echo json_encode($persona);
  } else {
    http_response_code(404);
    echo json_encode(["error" => "Persona no encontrada"]);
  }
} else {
  http_response_code(400);
  echo json_encode(["error" => "Falta parámetro 'cedula'"]);
}
?>
