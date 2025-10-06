<?php
$conexion = new mysqli("localhost", "root", "", "horario_profesores");

$nombre_materia = $_POST["nombre_materia"];
$consulta = $conexion->prepare("INSERT INTO materias (nombre) VALUES (?)");
$consulta->bind_param("s", $nombre_materia);
$consulta->execute();

header("Location: index.php");
?>
