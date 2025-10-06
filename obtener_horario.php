<?php
include 'conexio.php';
header('Content-Type: application/json');

$cedula = $_GET['cedula'] ?? '';
if (!$cedula) {
  echo json_encode(["error" => "Cédula no proporcionada"]);
  exit;
}

// Obtener datos del personal
$stmt = $pdo->prepare("SELECT nombre, apellido, cargo FROM personal WHERE cedula = ?");
$stmt->execute([$cedula]);
$persona = $stmt->fetch();

if (!$persona) {
  echo json_encode(["error" => "Personal no encontrado"]);
  exit;
}

// Obtener horario
$stmtHorario = $pdo->prepare("SELECT id, materia_id, tipo, total_horas FROM horarios WHERE cedula = ?");
$stmtHorario->execute([$cedula]);
$horario = $stmtHorario->fetch();

if (!$horario) {
  echo json_encode(["error" => "No hay horario registrado"]);
  exit;
}

$id_horario = $horario['id'];
$tipo = $horario['tipo'];
$total_horas = $horario['total_horas'];
$materia_id = $horario['materia_id'];

// Obtener nombre de la materia
$stmtMateria = $pdo->prepare("SELECT nombre FROM materias WHERE id = ?");
$stmtMateria->execute([$materia_id]);
$materia = $stmtMateria->fetchColumn() ?: 'Materia no registrada';

// Obtener bloques según tipo
if ($tipo === 'parcial') {
  $stmtBloques = $pdo->prepare("SELECT dia, hora, nivel, seccion FROM bloques_parcial WHERE horario_id = ?");
} else {
  $stmtBloques = $pdo->prepare("SELECT dia, bloque_hora AS hora, nivel, seccion FROM bloques_completo WHERE horario_id = ?");
}
$stmtBloques->execute([$id_horario]);
$bloques = $stmtBloques->fetchAll();

// Respuesta JSON
echo json_encode([
  "nombre" => $persona['nombre'],
  "apellido" => $persona['apellido'],
  "cargo" => $persona['cargo'],
  "cedula" => $cedula,
  "materia" => $materia,
  "tipo" => $tipo,
  "total_horas" => $total_horas,
  "horario" => $bloques
]);
?>
