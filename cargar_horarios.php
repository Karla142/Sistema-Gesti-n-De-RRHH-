<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "base_kam");

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se recibió el nombre del docente
if (isset($_POST['docente'])) {
    $docente = $conn->real_escape_string($_POST['docente']);

    // Consulta SQL para obtener los horarios del docente
    $sql = "SELECT dia, hora, materia 
            FROM horarios 
            WHERE docente = '$docente'";

    $result = $conn->query($sql);

    // Crear un array para almacenar los resultados
    $horarios = array();

    if ($result->num_rows > 0) {
        // Almacenar los datos en el array
        while ($row = $result->fetch_assoc()) {
            $horarios[] = $row;
        }
    }

    // Devolver los resultados en formato JSON
    echo json_encode($horarios);
} else {
    echo json_encode(array("error" => "No se recibió el nombre del docente."));
}

// Cerrar la conexión
$conn->close();
?>
