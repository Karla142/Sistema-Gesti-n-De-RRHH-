<?php
require('fpdf181/fpdf.php');

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Horario del Docente'), 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-10);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'C');
    }
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_kam";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_GET['id_personal'])) {
    $id_personal = intval($_GET['id_personal']);
    $tabla = '';

    $tablas = ["horarios", "horarios_primaria", "horarios_general"];
    foreach ($tablas as $t) {
        $check_sql = "SELECT nivel_academico FROM $t WHERE id_personal = $id_personal LIMIT 1";
        $check_result = $conn->query($check_sql);
        if ($check_result && $check_result->num_rows > 0) {
            $tabla = $t;
            $nivel_academico = $check_result->fetch_assoc()['nivel_academico'];
            break;
        }
    }

    if ($tabla) {
        $sql = "SELECT docente, cedula_personal, nivel_academico, cargo_personal, hora, dia, materia 
                FROM $tabla 
                WHERE id_personal = $id_personal";

        $result = $conn->query($sql);

        if (!$result) {
            die("Error en la consulta: " . $conn->error);
        }

        if ($result->num_rows > 0) {
            $pdf = new PDF();
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 12);

            $row = $result->fetch_assoc();
            $pdf->Cell(50, 10, utf8_decode("Docente:"), 1);
            $pdf->Cell(0, 10, utf8_decode($row['docente']), 1, 1);
            $pdf->Cell(50, 10, utf8_decode("Cédula:"), 1);
            $pdf->Cell(0, 10, utf8_decode($row['cedula_personal']), 1, 1);
            $pdf->Cell(50, 10, utf8_decode("Nivel Académico:"), 1);
            $pdf->Cell(0, 10, utf8_decode($row['nivel_academico']), 1, 1);
            $pdf->Cell(50, 10, utf8_decode("Cargo:"), 1);
            $pdf->Cell(0, 10, utf8_decode($row['cargo_personal']), 1, 1);
            $pdf->Ln(10);

            $pdf->Cell(30, 10, utf8_decode("Hora"), 1, 0, 'C');
            $pdf->Cell(30, 10, utf8_decode("Día"), 1, 0, 'C');
            $pdf->Cell(100, 10, utf8_decode("Materia"), 1, 1, 'C');

            do {
                $pdf->Cell(30, 10, utf8_decode($row['hora']), 1, 0, 'C');
                $pdf->Cell(30, 10, utf8_decode($row['dia']), 1, 0, 'C');
                $pdf->Cell(100, 10, utf8_decode($row['materia']), 1, 1, 'C');
            } while ($row = $result->fetch_assoc());

            // Configuración para la descarga automática del archivo PDF
            $file_name = 'horario_' . strtolower(str_replace(" ", "_", $nivel_academico)) . '_' . $id_personal . '.pdf';
            $pdf->Output('D', $file_name);
            exit;
        } else {
            echo "No se encontraron horarios.";
        }
    } else {
        echo "No se encontraron registros en ninguna tabla.";
    }
}

$conn->close();
?>
