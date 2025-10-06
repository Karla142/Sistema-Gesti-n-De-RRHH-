<?php
include 'conexio.php';

if (isset($_POST['cedula']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['cargo'])) {
  $cedula = $_POST['cedula'];
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $cargo = $_POST['cargo'];

  $stmt = $conn->prepare("UPDATE personal SET nombre = ?, apellido = ?, cargo = ? WHERE cedula = ?");
  $stmt->bind_param("ssss", $nombre, $apellido, $cargo, $cedula);

  if ($stmt->execute()) {
    echo "Datos actualizados correctamente.";
  } else {
    http_response_code(500);
    echo "Error al actualizar.";
  }
} else {
  http_response_code(400);
  echo "Faltan datos del formulario.";
}
?>
