<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_kam";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del POST
$id_personal = $_POST['id_personal'];
$estatus = $_POST['estatus'];

// Actualizar estatus en la base de datos
$sql = "UPDATE persona SET estatus = '$estatus' WHERE id_personal = $id_personal";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error: " . $conn->error;
}

$conn->close();
?>
