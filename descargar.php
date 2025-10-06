<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "base_kam");
if ($conn->connect_error) {
    die(json_encode(['exito' => false, 'mensaje' => 'Error en la conexión']));
}

$tipo = $_GET['tipo'];
$cedula = $_GET['cedula'];
$fecha_actual = date('Y-m-d');

if ($tipo == 'diario') {
    $sql = "SELECT * FROM asistencia WHERE cedula_personal = '$cedula' AND fecha_asistencia = '$fecha_actual'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Generar el archivo PDF aquí
        $url_pdf = "diario_$cedula.pdf"; // Ruta simulada
        echo json_encode(['exito' => true, 'mensaje' => 'Descarga exitosa', 'url_descarga' => $url_pdf]);
    } else {
        echo json_encode(['exito' => false, 'mensaje' => 'Este usuario no ha registrado su asistencia diaria']);
    }
} elseif ($tipo == 'general') {
    $sql = "SELECT * FROM asistencia WHERE cedula_personal = '$cedula'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Generar el archivo PDF aquí
        $url_pdf = "general_$cedula.pdf"; // Ruta simulada
        echo json_encode(['exito' => true, 'mensaje' => 'Descarga exitosa', 'url_descarga' => $url_pdf]);
    } else {
        echo json_encode(['exito' => false, 'mensaje' => 'Este usuario no guarda registro de asistencia']);
    }
} else {
    echo json_encode(['exito' => false, 'mensaje' => 'Tipo de reporte no válido']);
}

$conn->close();
?>
