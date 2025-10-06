<?php
require('fpdf181/fpdf.php');

// Conectar a tu base de datos
$conn = new mysqli("localhost", "root", "", "base_kam");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del personal y las fechas de permiso vacacional
$id_personal = $_GET['id'];
$fecha_inicio = $_GET['fechaInicio'];
$fecha_fin = $_GET['fechaFin'];
$motivo = $_GET['motivo'];
$cedula_autoriza = $_GET['cedulaAutoriza'];
$condicion_permiso = $_GET['condicionPermiso'];

$sql = "SELECT * FROM persona WHERE id_personal = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_personal);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre_personal = $row['nombre_personal'];
    $apellido_personal = $row['apellido_personal'];
    $cedula_personal = $row['cedula_personal'];
    $cargo_personal = $row['cargo_personal'];
} else {
    die("No se encontró el registro.");
}

$stmt->close();
$conn->close();

// Crear el PDF
class PDF extends FPDF
{
    function Header()
    {
        $this->Image('mio.jpeg', 10, 0, 40, 45);
        $this->Image('Edupalcubo.png', 155, 12, 35, 20);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Republica Bolivariana de Venezuela', 0, 1, 'C');
        $this->Cell(0, 10, 'Ministerio del Poder Popular para la Educacion', 0, 1, 'C');
        $this->Cell(0, 10, 'U.E.P Colegio Edupal', 0, 1, 'C');
        $this->Cell(0, 10, 'La Victoria-Estado Aragua', 0, 1, 'C');
        $this->Ln(20);
        $this->Cell(0, 10, 'Permiso de Reposo', 0, 1, 'C');
        $this->Ln(15);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

$texto = "Por medio de la presente Yo $nombre_personal $apellido_personal, C.I. $cedula_personal, quien trabaja en esta institucion como: $cargo_personal, deseo pedir permiso para ausentarme de la institucion en los dias $fecha_inicio por motivo de: $motivo. Condicion de permiso: $condicion_permiso. Por: $fecha_fin. C.I: $cedula_autoriza.";
$pdf->MultiCell(0, 10, $texto);

// Insert a blank space of 20 lines
$pdf->Ln(30);

// Add "Sello" text at the bottom left
$pdf->Cell(20, 10, "Sello", 0, 0, 'L');

// Guardar el PDF en una variable
$pdf_content = $pdf->Output('', 'S');

// Codificar el contenido del PDF en base64
$pdf_base64 = base64_encode($pdf_content);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Previa del PDF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .modal-content {
            transform: scale(0.8);
            transition: transform 0.5s;
        }
        .modal.show .modal-content {
            transform: scale(1);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pdfModal">Vista Previa</button>

        <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pdfModalLabel">Vista Previa del PDF</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <iframe src="data:application/pdf;base64,<?php echo $pdf_base64; ?>" width="100%" height="500px"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
