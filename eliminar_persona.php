<?php
include 'conexio.php';

$cedula = $_GET['cedula'] ?? null;

if ($cedula) {
  $stmt = $conn->prepare("DELETE FROM personal WHERE cedula = ?");
  $stmt->bind_param("s", $cedula);

  if ($stmt->execute()) {
    echo "Registro eliminado correctamente.";
  } else {
    http_response_code(500);
    echo "Error al eliminar.";
  }
} else {
  http_response_code(400);
  echo "Falta el parámetro 'cedula'";
}
?>
