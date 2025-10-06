<?php
require('fpdf181/fpdf.php');

// Conexión a sistema_horarios
$pdo = new PDO("mysql:host=localhost;dbname=sistema_horarios;charset=utf8mb4", "root", "", [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

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
    $this->Cell(0, 10, utf8_decode('Reporte Individual de Horarios por Docente'), 0, 1, 'C');
    $this->Ln(5);
  }

  function Footer()
  {
    $this->SetY(-15);
    $this->SetFont('Arial', 'I', 10);
    $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'C');
  }

  function DocenteHeader($docente, $cedula)
  {
    $this->SetFont('Arial', '', 12);
    $this->Cell(0, 8, utf8_decode("Nombre: {$docente['nombre']} {$docente['apellido']}"), 0, 1);
    $this->Cell(0, 8, utf8_decode("Cédula: {$cedula}"), 0, 1);
    $this->Cell(0, 8, utf8_decode("Cargo: {$docente['cargo']}"), 0, 1);
    $this->Ln(3);
  }

  function HorarioHeader($horario)
  {
    $this->SetFont('Arial', 'B', 12);
    $texto = "Materia: {$horario['materia']} | Tipo: {$horario['tipo']} | Total Horas: {$horario['total_horas']}";
    $this->Cell(0, 10, utf8_decode($texto), 0, 1, 'C');
    $this->Ln(3);

    $tabla_ancho = 180;
    $this->SetX(($this->w - $tabla_ancho) / 2);

    $this->SetFont('Arial', 'B', 11);
    $this->SetFillColor(35, 120, 182);
    $this->SetTextColor(255, 255, 255);
    $this->Cell(50, 12, utf8_decode('Día'), 1, 0, 'C', true);
    $this->Cell(50, 12, utf8_decode(($horario['tipo'] === 'parcial') ? 'Hora' : 'Bloque'), 1, 0, 'C', true);
    $this->Cell(40, 12, utf8_decode('Nivel'), 1, 0, 'C', true);
    $this->Cell(40, 12, utf8_decode('Sección'), 1, 1, 'C', true);
    $this->SetTextColor(0, 0, 0);
  }

  function BloqueRow($bloque, $tipo)
  {
    $this->SetFont('Arial', '', 11);
    $dia = $bloque['dia'] ?? '-';
    $hora = ($tipo === 'parcial') ? ($bloque['hora'] ?? '-') : ($bloque['bloque_hora'] ?? '-');
    $nivel = $bloque['nivel'] ?? '-';
    $seccion = $bloque['seccion'] ?? '-';

    $tabla_ancho = 180;
    $this->SetX(($this->w - $tabla_ancho) / 2);

    $this->Cell(50, 12, utf8_decode($dia), 1, 0, 'C');
    $this->Cell(50, 12, utf8_decode($hora), 1, 0, 'C');
    $this->Cell(40, 12, utf8_decode($nivel), 1, 0, 'C');
    $this->Cell(40, 12, utf8_decode($seccion), 1, 1, 'C');
  }
}

// Obtener la cédula desde la URL
$cedula = $_GET['cedula'] ?? null;
if (!$cedula) {
  die("No se especificó la cédula.");
}

// Obtener datos del personal
$stmt = $pdo->prepare("SELECT nombre, apellido, cargo FROM personal WHERE cedula = ?");
$stmt->execute([$cedula]);
$docente = $stmt->fetch();

if (!$docente) {
  die("Docente no encontrado.");
}

// Obtener horarios del docente
$stmt = $pdo->prepare("
  SELECT h.id, h.tipo, h.total_horas, m.nombre AS materia
  FROM horarios h
  JOIN materias m ON h.materia_id = m.id
  WHERE h.cedula = ?
");
$stmt->execute([$cedula]);
$horarios = $stmt->fetchAll();

if (!$horarios) {
  die("No se encontraron horarios para esta cédula.");
}

$pdf = new PDF();
$pdf->AddPage('P');
$pdf->SetLeftMargin(15);
$pdf->DocenteHeader($docente, $cedula);

foreach ($horarios as $horario) {
  $pdf->HorarioHeader($horario);

  if ($horario['tipo'] === 'parcial') {
    $stmt = $pdo->prepare("SELECT * FROM bloques_parcial WHERE horario_id = ?");
    $stmt->execute([$horario['id']]);
    $bloques = $stmt->fetchAll();

    foreach ($bloques as $b) {
      $pdf->BloqueRow($b, 'parcial');
    }

  } elseif ($horario['tipo'] === 'tiempo_completo') {
    $stmt = $pdo->prepare("SELECT * FROM bloques_completo WHERE horario_id = ?");
    $stmt->execute([$horario['id']]);
    $bloques = $stmt->fetchAll();

    foreach ($bloques as $b) {
      $pdf->BloqueRow($b, 'tiempo_completo');
    }
  }

  $pdf->Ln(5);
}

$pdf->Output('I', 'horario_'.$cedula.'.pdf');
?>
