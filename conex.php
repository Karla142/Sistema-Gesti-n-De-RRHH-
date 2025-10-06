<?php
$servidor = "localhost";  // Cambia esto según tu configuración
$usuario = "root";        // Usuario de la base de datos
$clave = "";              // Contraseña de la base de datos
$base_de_datos = "base_kam"; // Nombre de la base de datos

// Crear conexión
$conexion = new mysqli($servidor, $usuario, $clave, $base_de_datos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Establecer el conjunto de caracteres para evitar problemas con acentos y caracteres especiales
$conexion->set_charset("utf8");

// Para usar la conexión en otros archivos, simplemente usa:
//
// include 'conex.php';
// $conexion->query("SELECT * FROM tabla");  // Ejemplo de uso

?>
