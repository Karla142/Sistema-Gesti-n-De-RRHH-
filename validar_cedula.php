<?php
// Configuración de la base de datos (ajusta estos valores)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_kam"; // Nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir la cédula desde JavaScript
$cedula = $_GET['cedula'];

// Consultar la base de datos (ajusta el nombre de la tabla)
$sql = "SELECT cedula_personal FROM persona WHERE cedula_personal = '$cedula'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "existe"; // La cédula ya existe
} else {
    // Mostrar mensaje con SweetAlert2
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Cédula no encontrada',
                text: 'La cédula no existe en el sistema.'
            });
          </script>";
}

$conn->close();
?>
