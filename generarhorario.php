<?php
require_once('tcpdf/tcpdf.php');

$conn_base_ka = new mysqli('localhost', 'root', '', 'base_ka');

if ($conn_base_ka->connect_error) {
    die("Error de conexión: " . $conn_base_ka->connect_error);
}

// Obtener datos de horarios
$sql_horarios = "SELECT p.cedula_personal, p.nombre_personal, p.apellido_personal, m.nombre AS materia, h.dia_semana, h.hora_inicio, h.hora_fin
                 FROM base_ka.horario h
                 JOIN base_kam.persona p ON h.id_personal = p.id_personal
                 JOIN base_ka.materia m ON h.id_materia = m.id_materia";
$result = $conn_base_ka->query($sql_horarios);

// Crear PDF
$pdf = new TCPDF();
$pdf->SetCreator('Sistema de Horarios');
$pdf->SetTitle('Horarios Registrados');
$pdf->SetHeaderData('', 0, 'Horarios Registrados', '');
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->AddPage();

// Estilos
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(0, 10, 'Lista de Horarios', 0, 1, 'C');
$pdf->Ln(5);

// Crear tabla
$html = '<table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Profesor</th>
                    <th>Materia</th>
                    <th>Día</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                </tr>
            </thead>
            <tbody>';
while ($row = $result->fetch_assoc()) {
    $html .= "<tr>
                <td>{$row['cedula_personal']}</td>
                <td>{$row['nombre_personal']} {$row['apellido_personal']}</td>
                <td>{$row['materia']}</td>
                <td>{$row['dia_semana']}</td>
                <td>{$row['hora_inicio']}</td>
                <td>{$row['hora_fin']}</td>
              </tr>";
}
$html .= '</tbody></table>';

$pdf->writeHTML($html, true, false, false, false, '');
$pdf->Output('horarios.pdf', 'D'); // Descarga directa

$conn_base_ka->close();
?>
