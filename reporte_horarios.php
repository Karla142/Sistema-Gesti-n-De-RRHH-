<?php
ob_start(); // Evita salida antes del PDF

require('fpdf181/fpdf.php');

// Conexión a sistema_horarios
$conn = new mysqli("localhost", "root", "", "sistema_horarios");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

class PDF extends FPDF
{
    function Header()
    {
        if (file_exists('mio.jpeg')) {
            $this->Image('mio.jpeg', 10, 5, 30);
        }
        if (file_exists('Edupalcubo.png')) {
            $this->Image('Edupalcubo.png', 170, 10, 30);
        }

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('República Bolivariana de Venezuela'), 0, 1, 'C');
        $this->Cell(0, 10, utf8_decode('Ministerio del Poder Popular para la Educación'), 0, 1, 'C');
        $this->Cell(0, 10, utf8_decode('U.E.P Colegio Edupal'), 0, 1, 'C');
        $this->Cell(0, 10, utf8_decode('La Victoria - Estado Aragua'), 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, utf8_decode('Reporte General de Horarios por Docente'), 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'C');
    }

    function AddHorarioHeader($data)
    {
        $this->SetFont('Arial', 'B', 9); // Fuente más pequeña
        $this->SetFillColor(220, 220, 220);

        $texto1 = "Docente: {$data['nombre']} {$data['apellido']} | Cédula: {$data['cedula']}";
        $texto2 = "Materia: {$data['materia']} | Tipo: {$data['tipo']} | Total horas: {$data['total_horas']}";

        $this->MultiCell(0, 7, utf8_decode($texto1), 0, 'L', true);
        $this->MultiCell(0, 7, utf8_decode($texto2), 0, 'L', true);
        $this->Ln(2);
    }

    function AddBloqueHeader($tipo)
    {
        $tabla_ancho = 200;
        $this->SetX(($this->w - $tabla_ancho) / 2);

        $this->SetFont('Arial', 'B', 11);
        $this->SetFillColor(35, 120, 182);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(60, 12, utf8_decode('Día'), 1, 0, 'C', true);
        $this->Cell(40, 12, utf8_decode(($tipo === 'parcial') ? 'Hora' : 'Bloque'), 1, 0, 'C', true);
        $this->Cell(50, 12, utf8_decode('Nivel'), 1, 0, 'C', true);
        $this->Cell(50, 12, utf8_decode('Sección'), 1, 1, 'C', true);
        $this->SetTextColor(0, 0, 0);
    }

    function AddBloqueRow($bloque, $tipo)
    {
        $tabla_ancho = 200;
        $this->SetX(($this->w - $tabla_ancho) / 2);

        $this->SetFont('Arial', '', 10);
        $dia = isset($bloque['dia']) ? $bloque['dia'] : '-';
        $hora = ($tipo === 'parcial') ? ($bloque['hora'] ?? '-') : ($bloque['bloque_hora'] ?? '-');
        $nivel = $bloque['nivel'] ?? '-';
        $seccion = $bloque['seccion'] ?? '-';

        $this->Cell(60, 12, utf8_decode($dia), 1, 0, 'C');
        $this->Cell(40, 12, utf8_decode($hora), 1, 0, 'C');
        $this->Cell(50, 12, utf8_decode($nivel), 1, 0, 'C');
        $this->Cell(50, 12, utf8_decode($seccion), 1, 1, 'C');
    }
}

// Consulta principal de horarios
$sql = "
SELECT h.id, h.cedula, h.tipo, h.total_horas, m.nombre AS materia, p.nombre, p.apellido
FROM horarios h
JOIN materias m ON h.materia_id = m.id
JOIN personal p ON h.cedula = p.cedula
ORDER BY p.apellido, p.nombre
";
$result = $conn->query($sql);

$pdf = new PDF();
$pdf->AddPage('P');
$pdf->SetLeftMargin(15);

while ($row = $result->fetch_assoc()) {
    $pdf->AddHorarioHeader($row);
    $pdf->AddBloqueHeader($row['tipo']);

    if ($row['tipo'] === 'parcial') {
        $bloques = $conn->query("SELECT * FROM bloques_parcial WHERE horario_id = {$row['id']}");
        while ($b = $bloques->fetch_assoc()) {
            $pdf->AddBloqueRow($b, 'parcial');
        }
    } else {
        $bloques = $conn->query("SELECT * FROM bloques_completo WHERE horario_id = {$row['id']}");
        while ($b = $bloques->fetch_assoc()) {
            $pdf->AddBloqueRow($b, 'tiempo_completo');
        }
    }

    $pdf->Ln(5);
}

$pdf->Output("D", utf8_decode("reporte_general_horarios.pdf"));
ob_end_flush(); // Finaliza el buffer
?>
