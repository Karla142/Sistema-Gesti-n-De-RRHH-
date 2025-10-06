<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario']) || !isset($_SESSION['correo'])) {
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Acceso denegado',
                text: 'No puede acceder al sistema sin haber iniciado sesión',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                window.location.href = 'Login.php';
            });
        </script>
    </body>
    </html>";
    exit; // Detiene la ejecución del resto del código PHP.
}

// Obtén los datos del usuario desde la sesión
$usuario = $_SESSION['usuario'];
$correo = $_SESSION['correo'];
?>
<?php
require('fpdf181/fpdf.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_kam";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Actualiza los nombres de las columnas según tu tabla 'persona'
$sql = "SELECT nombre_personal, apellido_personal, cedula_personal, titulo_personal, correo_personal, nacimiento_personal, ingreso_personal, cargo_personal FROM persona";
$result = $conn->query($sql);

// Verificar si la consulta se ejecutó correctamente
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

class PDF extends FPDF
{
    function Header()
    {
        $x_logo = 40;
        $y_logo = 0;
        $ancho_logo = 40;
        $alto_logo = 45;

        if (file_exists('mio.jpeg')) {
            $this->Image('mio.jpeg', $x_logo, $y_logo, $ancho_logo, $alto_logo);
        } else {
            echo "No se encontró el archivo de la imagen.";
            exit;
        }

        $x_logo = 215;
        $y_logo = 12;
        $ancho_logo = 35;
        $alto_logo = 20;

        if (file_exists('Edupalcubo.png')) {
            $this->Image('Edupalcubo.png', $x_logo, $y_logo, $ancho_logo, $alto_logo);
        } else {
            echo "No se encontró el archivo de la imagen.";
            exit;
        }

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('República Bolivariana de Venezuela'), 0, 1, 'C');
        $this->Cell(0, 10, utf8_decode('Ministerio del Poder Popular para la Educación'), 0, 1, 'C');
        $this->Cell(0, 10, utf8_decode('U.E.P Colegio Edupal'), 0, 1, 'C');
        $this->Cell(0, 10, utf8_decode('La Victoria - Estado Aragua'), 0, 1, 'C');
        $this->Ln(05);
        $this->Cell(0, 10, utf8_decode('Reporte General de Personal'), 0, 1, 'C');
        $this->Ln(05);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'C');
    }

    function AddTableHeader()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(35, 120, 182);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(30, 10, 'Nombre', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Apellido', 1, 0, 'C', true);
        $this->Cell(30, 10,  utf8_decode('Cédula'), 1, 0, 'C', true);
        $this->Cell(50, 10, 'Correo', 1, 0, 'C', true);
        $this->Cell(45, 10, 'Fecha de Nacimiento', 1, 0, 'C', true);
        $this->Cell(45, 10, 'Fecha de Ingreso', 1, 0, 'C', true);
        $this->Cell(50, 10, 'Cargo', 1, 1, 'C', true);
    }

    function AddTableRow($persona)
    {
        $this->SetFont('Arial', '', 12);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(30, 10, utf8_decode($persona['nombre_personal']), 1, 0, 'C');
        $this->Cell(30, 10, utf8_decode($persona['apellido_personal']), 1, 0, 'C');
        $this->Cell(30, 10, utf8_decode($persona['cedula_personal']), 1, 0, 'C');
        $this->Cell(50, 10, utf8_decode($persona['correo_personal']), 1, 0, 'C');
        $this->Cell(45, 10, utf8_decode($persona['nacimiento_personal']), 1, 0, 'C');
        $this->Cell(45, 10, utf8_decode($persona['ingreso_personal']), 1, 0, 'C');
        $this->Cell(50, 10, utf8_decode($persona['cargo_personal']), 1, 1, 'C');
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT nombre_personal, apellido_personal, cedula_personal, titulo_personal, correo_personal, nacimiento_personal, ingreso_personal, cargo_personal FROM persona WHERE id = $id";
    $result = $conn->query($sql);
    $persona = $result->fetch_assoc();

    $pdf = new PDF();
    $pdf->AddPage('L'); // Cambia la orientación a horizontal
    $pdf->SetLeftMargin(20); // Centrar la tabla
    $pdf->AddTableHeader();
    $pdf->AddTableRow($persona);

    $pdf->Output("D", utf8_decode("{$persona['nombre_personal']}.pdf"));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['all'])) {
    $sql = "SELECT nombre_personal, apellido_personal, cedula_personal, titulo_personal, correo_personal, nacimiento_personal, ingreso_personal, cargo_personal FROM persona";
    $result = $conn->query($sql);

    $pdf = new PDF();
    $pdf->AddPage('L'); // Cambia la orientación a horizontal
    $pdf->SetLeftMargin(10); // Centrar la tabla
    $pdf->AddTableHeader();
    while ($persona = $result->fetch_assoc()) {
        $pdf->AddTableRow($persona);
    }

    $pdf->Output("D", utf8_decode("todos_los_datos.pdf"));
    exit;
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>KAM</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>
<body>
    <style>
        body {
            background: url(FONDO3.jpg) no-repeat;
            background-size: 110%;
            margin: auto;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: top center;
            font-family: sans-serif;
        }

     
/*estilo de barra de busqueda*/
.search-container{

display:flex;
position: relative;
justify-content: left;
align-items: left;
border:1 px solid #2378b6;
border-radius:10px;
overflow:hidden;
left:77%;
margin-top: 3%;
}


.search-container input[type="text"]{

display:flex;
padding:12px 20px;
border:2px solid rgb(35,120,182);
outline:2px;
border-radius:25px;
}

.search-icon{

 position:absolute;
 top:60%;
 left:80%;
 transform:translateY(-50%);
 pointer-events: none; 


}

/*posicion logos*/

.left{
display: flex;
position: relative;
justify-content: left;
top: -10%;

}

 .boot{
width: 5px;
height: 5px;
          }
 
</style>



     <div class ="left">
    <div class="search-container">
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Buscar en la tabla...">
    <div class="search-icon">

    <img src="lupa.png" width="25" height="15"alt="#">

    </div></div></div>
<script>

        document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = document.getElementById('searchInput').value.toUpperCase();
    const table = document.getElementById('miTabla');
    const tr = table.getElementsByTagName('tr');
    
    for (let i = 1; i < tr.length; i++) {
        tr[i].style.display = 'none';
        const td = tr[i].getElementsByTagName('td');
        
        for (let j = 0; j < td.length; j++) {
            if (td[j]) {
                if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = '';
                    break;
                }
            }
        }
    }
});
</script>
   
    <script>
        document.querySelectorAll('.logo-container').forEach(container => {
            const logo = container.querySelector('.logo');
            const hoverMessage = container.querySelector('.hover-message');

            logo.addEventListener('mouseenter', () => {
                hoverMessage.style.display = 'block';
            });

            logo.addEventListener('mouseleave', () => {
                hoverMessage.style.display = 'none';
            });
        });
    </script>

<style>
    .logo-container {
        position: absolute;
        top: 40px;
        left: 8px;
        display: flex;
        align-items: center;
    }

    .fixed-message {
        font-size: 12px;
        background-color: rgba(51, 51, 51, 0.9);
        color: white;
        padding: 5px;
        border-radius: 5px;
        margin-left: 15px; /* Ajusta este valor según sea necesario */
        display: inline-block; /* Asegura que se alinee adecuadamente */
    }

    h1 {
        text-align: center;
        color: #2378b2;
    }

    .letra {
        margin-top: -4%;
    }
</style>

<div class="logo-container">
    <a href="principal.php">
        <img src="inicio.png" width="40" height="30" alt="perfil">
    </a>
    <div class="fixed-message">Principal / Reportes</div>
</div>

     
    </div>

    
<div class="container">
    <div class="logos">
        <div class="hover-container3">
            <a href="#" id="userProfileButton">
                <img src="usuario.png" alt="Perfil">
                <div class="hover-message3">Perfil</div>
            </a>
        </div>
    </div>
</div>
<br>
<div id="userProfileModal" class="modal">
    <div class="modalt-contente">
        <span class="close" id="closeProfile">&times;</span>
        <div align="left">
        <div class="p">
            <h2>Perfil de Usuario</h2>
            <p><strong>Nombre de Usuario:</strong> <?php echo htmlspecialchars($usuario); ?></p>
            <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($correo); ?></p>
   
            </div>
        </div>
    </div>
</div>
    <div class="letra">
<h1>Gestión De Reportes Horarios</h1>
</div>
    <style>
          table {
            justify-content: center;
            text-align: center;
            width: 99%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        th, td {
            padding: 4px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        td{
            font-size: 15px;
            padding: 4px;
        }
        th {
            background-color: #2378b6;
            color: white;
            padding: 8px 16px;
            margin: 1px 0;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
    button {
      background-color: #2378b6;
      color: white;
      padding: 8px 10px;
      border-radius: 5px;
      border:none;
      font-size: 12px;
      cursor: pointer;
      transition: background-color 0.3s;
      right: 800%;
    }

    button:hover {
      background-color: #41a7f5;
    }

    .right{
margin-left: 70%;

    }
    </style>
</head>
<body>
<br>
<div class align="center">
<table id="miTabla" id="dataTable">
    <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Cédula</th>
        <th>Correo</th>
        <th>Fecha de Nacimiento</th>
        <th>Fecha de Ingreso</th>
        <th>Cargo</th>
    </tr>
    </div>
    <?php
    // Mostrar los datos en la tabla
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["nombre_personal"] . "</td>
                    <td>" . $row["apellido_personal"] . "</td>
                    <td>" . $row["cedula_personal"] . "</td>
                    <td>" . $row["correo_personal"] . "</td>
                    <td>" . $row["nacimiento_personal"] . "</td>
                    <td>" . $row["ingreso_personal"] . "</td>
                    <td>" . $row["cargo_personal"] . "</td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No hay registros</td></tr>";
    }
    $conn->close();
    ?>
</table>
<br>
<div id="pagination">
    <div class="page-navigation">
        <button id="prevButton">Anterior</button>
        <button id="nextButton">Siguiente</button>
    </div>
    <div class="page-numbers" id="pageNumbers"></div>
</div>

<style>
#pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1000px;
    margin-top: 10px;
}

.page-navigation {
    display: flex;
    gap: 10px;
}

.page-numbers {
    display: flex;
    gap: 5px;
}

.page-navigation button {
    padding: 8px 10px;
    cursor: pointer;
}
 .pagination {
    display: flex;
    justify-content:center;
    align-items: center;
    margin-top: 10px;
   

  }

  .pagination-buttons {
    display: flex;
    gap: 5px;
     margin-right: 75%;
  }

  button {
    margin: 0;
    padding: 10px 10px;
    background-color: #2378b6;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 12px;
  }

  button:hover {
    background-color: #41a7f5;
  }

  .page-numbers {
    display: flex;
    gap: 5px;
  }

  .page-number {
    padding: 5px 10px;
    border: 1px solid #ddd;
    border-radius: 3px;
    cursor: pointer;
  }

  .page-number.active {
    background-color: #2378b6;
    color: white;
    border-color: #2378b6;
  }
.page-numbers button {
    padding: 8px 10px;
    cursor: pointer;
}

.page-numbers button.active {
    font-weight: bold;
    background-color: #2378b6;
    color: white;
    border: none;
}
</style>


<script>
const rowsPerPage = 7;
let currentPage = 1;
const table = document.getElementById('miTabla');
const rows = table.querySelectorAll('tbody tr');
const totalRows = rows.length;
const totalPages = Math.ceil(totalRows / rowsPerPage);
const pageNumbers = document.getElementById('pageNumbers');

function displayRows() {
    rows.forEach((row, index) => {
        row.style.display = (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) ? '' : 'none';
    });
}

function updatePageNumbers() {
    pageNumbers.innerHTML = '';
    for (let i = 1; i <= totalPages; i++) {
        const button = document.createElement('button');
        button.textContent = i;
        button.classList.toggle('active', i === currentPage);
        button.addEventListener('click', () => {
            currentPage = i;
            displayRows();
            updatePageNumbers();
        });
        pageNumbers.appendChild(button);
    }
}

function showPrevious() {
    if (currentPage > 1) {
        currentPage--;
        displayRows();
        updatePageNumbers();
    }
}

function showNext() {
    if (currentPage < totalPages) {
        currentPage++;
        displayRows();
        updatePageNumbers();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    displayRows();
    updatePageNumbers();
});

document.getElementById("prevButton").addEventListener("click", showPrevious);
document.getElementById("nextButton").addEventListener("click", showNext);
</script>

<br>
<dic class ="right">
<button onclick="window.location.href='reporte_horarios.php'">Descargar PDF</button>
<button onclick="window.location.href='tabla_horarios.php'">PDF individual</button></div>

<style>
        .p{
    color:#2378b6;
}
    .hover-message3 {
              display: none;
              background-color: rgba(51, 51, 51, 0.6); /* Fondo #333 con opacidad de 60% */
              color: white; /* Letras blancas */
              font-size: 15px;
              border-radius: 5px;
              padding: 4px;
              position: absolute;
              top: 50px; /* Ajustar según sea necesario */
              left: 40%;
              transform: translateX(-50%);
              z-index: 1;
              opacity: 0.9;
          }
  
          
          .hover-container3:hover .hover-message3 {
              display: block;
          }
  
          .container {
              margin: 0em 0em 0em 0em;
          }
  
              .logos {
              position: absolute;
              margin-top:-39px;
              left: 95%;
              display: flex;
              gap: 20px; /* Espacio entre los logos */
          }
  .hover-container {
              position: relative;
              cursor: pointer;
              z-index: 1;
          }
          .hover-container img {
              width: 40px;
              height: 40px;
              transition: transform 0.3s ease;
          }
          .hover-container:hover img {
              transform: scale(1.2);
              z-index: 2;
          }
        .hover-container3 {
              position: relative;
              display: inline-block;
          }
          
  
  
  
  
   .menu-container {
        display: none;
        position: absolute;
        top: 80px;
        background-color: white;
        border: 1px solid #ccc;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        z-index: 1;
        padding: 10px;
      }
  
      .menu-option {
        padding: 20px;
        cursor: pointer;
      }
  
      .menu-option:hover {
        background-color: #f0f0f0;
      }
  
  
  
          .logos a {
              display: inline-block;
          }
  
          .logos img {
              width: 40px;
              height: 40px;
          }
  
          .modalt {
              display: none;
              position: fixed;
              z-index: 1;
              left: 0;
              top: 1px;
              width: 100%;
              height: 100%;
              overflow: auto;
              
              padding-top: 20px;
          }
  
          .modalt-contente {
    background-color: #fff;
    opacity: 90%;
    margin: 3% auto;
    padding: 20px;
    width: 70%;
    max-width: 600px;
    border-radius: 15px;
    border: 1px solid #2378b6;
    box-shadow: rgba(5, 2, 5, 0.5) 0px 2px 6px 0px;
    animation: zoom 0.3s;
    z-index: 10000; /* Más alto que otros elementos */
    position: relative; /* Necesario para aplicar el z-index dentro del modal */
}

  
          @keyframes zoom {
              from {transform: scale(0)} 
              to {transform: scale(1)}
          }
  
          .close {
              color: #aaa;
              float: right;
              font-size: 28px;
              font-weight: bold;
          }
  
          .close:hover,
          .close:focus {
              color: black;
              text-decoration: none;
              cursor: pointer;
          }
          #userProfileModal {
    display: none; /* Ocultar el modal por defecto */
    position: fixed; /* Para posicionarlo sobre todo */
    z-index: 9999; /* Asegúrate de que tenga el z-index más alto */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5); /* Fondo semitransparente */
}

      </style>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Modal para el perfil de usuario
    const userProfileButton = document.getElementById('userProfileButton');
    const userProfileModal = document.getElementById('userProfileModal');
    const closeProfile = document.getElementById('closeProfile');

    // Mostrar modal solo cuando se hace clic en el botón (logo)
    userProfileButton.onclick = function() {
        userProfileModal.style.display = "block";
    };

    // Cerrar modal cuando se hace clic en el botón de cerrar
    closeProfile.onclick = function() {
        userProfileModal.style.display = "none";
    };

    // Cerrar modal si se hace clic fuera de él
    window.onclick = function(event) {
        if (event.target === userProfileModal) {
            userProfileModal.style.display = "none";
        }
    };
</script>
         
</body>
</html>
