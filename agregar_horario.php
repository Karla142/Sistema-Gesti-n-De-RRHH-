<?php
$conexion = new mysqli("localhost", "root", "", "horario_profesores");

$nombre_profesor = $_POST["nombre_profesor"];
$tipo = $_POST["tipo"];
$materia_id = $_POST["materia_id"];
$dia = $_POST["dia"];
$hora_inicio = $_POST["hora_inicio"];
$hora_fin = $_POST["hora_fin"];

$consulta = $conexion->prepare("INSERT INTO horarios (profesor_id, tipo, materia_id, dia, hora_inicio, hora_fin) VALUES ((SELECT id FROM profesores WHERE nombre=?), ?, ?, ?, ?, ?)");
$consulta->bind_param("ssssss", $nombre_profesor, $tipo, $materia_id, $dia, $hora_inicio, $hora_fin);
$consulta->execute();

header("Location: index.php");
?>
