<?php
include 'conexio.php';

$cedula = $_POST['cedula'] ?? '';
if (!$cedula) {
  echo "❌ Cédula no proporcionada.";
  exit;
}

// Buscar todos los horarios asociados a la cédula
$queryHorarios = "SELECT id FROM horarios WHERE cedula = '$cedula'";
$resultHorarios = mysqli_query($conexion, $queryHorarios);

if (!$resultHorarios) {
  echo "❌ Error en la consulta de horarios: " . mysqli_error($conexion);
  exit;
}

if (mysqli_num_rows($resultHorarios) === 0) {
  echo "⚠️ No se encontraron horarios para la cédula: $cedula";
  // Aún así intentamos eliminar el personal
  $deletePersonal = mysqli_query($conexion, "DELETE FROM personal WHERE cedula = '$cedula'");
  if ($deletePersonal) {
    echo "✅ Registro del personal eliminado.";
  } else {
    echo "❌ Error al eliminar el personal: " . mysqli_error($conexion);
  }
  exit;
}

// Eliminar bloques asociados a cada horario
while ($horario = mysqli_fetch_assoc($resultHorarios)) {
  $idHorario = $horario['id'];

  // Eliminar bloques parciales
  $deleteParcial = mysqli_query($conexion, "DELETE FROM bloques_parcial WHERE horario_id = '$idHorario'");
  if (!$deleteParcial) {
    echo "❌ Error al eliminar bloques parciales: " . mysqli_error($conexion);
    exit;
  }

  // Eliminar bloques completos
  $deleteCompleto = mysqli_query($conexion, "DELETE FROM bloques_completo WHERE horario_id = '$idHorario'");
  if (!$deleteCompleto) {
    echo "❌ Error al eliminar bloques completos: " . mysqli_error($conexion);
    exit;
  }
}

// Eliminar horarios
$deleteHorarios = mysqli_query($conexion, "DELETE FROM horarios WHERE cedula = '$cedula'");
if (!$deleteHorarios) {
  echo "❌ Error al eliminar horarios: " . mysqli_error($conexion);
  exit;
}

// Eliminar registro del personal
$deletePersonal = mysqli_query($conexion, "DELETE FROM personal WHERE cedula = '$cedula'");
if (!$deletePersonal) {
  echo "❌ Error al eliminar el personal: " . mysqli_error($conexion);
  exit;
}

echo "✅ Horarios, bloques y registro del personal eliminados correctamente.";
?>
