<?php
include 'conexio.php';

$cedula = $_POST['cedula'] ?? '';
$horario_id = $_POST['horario_id'] ?? '';
$tipo = $_POST['tipo'] ?? '';
$total_horas = $_POST['total_horas'] ?? '';
$bloques = $_POST['bloques'] ?? [];

if (!$cedula || !$horario_id || !$tipo || !$total_horas) {
  header("Location: PREESCOLAR1.php?status=error");
  exit;
}

$tablaBloques = ($tipo === 'parcial') ? 'bloques_parcial' : 'bloques_completo';
$campoHora = ($tipo === 'parcial') ? 'hora' : 'bloque_hora';

// Actualizar horario
$updateHorario = "UPDATE horarios SET tipo='$tipo', total_horas='$total_horas' WHERE ir=$horario_id";
if (mysqli_query($conexion, $updateHorario)) {
  // Eliminar bloques anteriores
  mysqli_query($conexion, "DELETE FROM $tablaBloques WHERE horario_id=$horario_id");

  // Insertar nuevos bloques
  foreach ($bloques as $dia => $horas) {
    foreach ($horas as $hora => $valor) {
      if (trim($valor) !== '') {
        $partes = explode('-', $valor);
        $nivel = trim($partes[0] ?? '');
        $seccion = trim($partes[1] ?? '');
        $insert = "INSERT INTO $tablaBloques (horario_id, dia, $campoHora, nivel, sección) 
                   VALUES ($horario_id, '$dia', '$hora', '$nivel', '$seccion')";
        mysqli_query($conexion, $insert);
      }
    }
  }
  header("Location: PREESCOLAR1.php?status=success");
} else {
  header("Location: PREESCOLAR1.php?status=error");
}
?>
