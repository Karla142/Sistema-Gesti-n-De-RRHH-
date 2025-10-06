<?php
$conexion = mysqli_connect("localhost", "root", "", "sistema_horarios");
if (!$conexion) {
  die("Error de conexión: " . mysqli_connect_error());
}
?>
