
<?php
session_start();
include 'conex.php'; // Archivo de conexión a la base de datos

// Configurar la zona horaria correcta
date_default_timezone_set('America/Caracas');

// Verificar conexión a la base de datos
if (!$conexion) {
    error_log("Error: La conexión a la base de datos no se ha establecido correctamente.");
    die("Error: No se pudo establecer conexión con la base de datos.");
}

// Establecer el conjunto de caracteres para evitar problemas con acentos
$conexion->set_charset("utf8mb4");
$conexion->query("SET NAMES 'utf8mb4'");

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
                text: 'Debe iniciar sesión para acceder al sistema',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                window.location.href = 'Login.php';
            });
        </script>
    </body>
    </html>";
    exit;
}

// Obtén los datos del usuario desde la sesión
$usuario = $_SESSION['usuario'];
$correo = $_SESSION['correo'];

// Recuperar datos de bitácora según la fecha actual
$fecha_actual = date("Y-m-d");

// Consulta preparada con formato de hora en 12 horas
$query = "SELECT id, usuario_id, nombre_usuario, correo, accion, 
          DATE_FORMAT(fecha_hora, '%d-%m-%Y %h:%i %p') AS fecha_hora 
          FROM bitacora WHERE DATE(fecha_hora) = ? ORDER BY fecha_hora DESC";

$stmt = $conexion->prepare($query);

if (!$stmt) {
    error_log("Error al preparar la consulta: " . $conexion->error);
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error en la consulta',
                text: 'Ocurrió un problema al recuperar la bitácora.',
                confirmButtonText: 'Aceptar'
            });
          </script>";
    exit;
}

$stmt->bind_param("s", $fecha_actual);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>KAM</title>




<style>
 
body{

background:url(FONDO3.jpg) no-repeat;
  background-size: 110%;
  margin:auto;
background-attachment: fixed;
background-repeat: no-repeat;
background-position: top center;
font-family: sans-serif;


}
    
    table {
        width:99%;
        border-collapse: collapse;
        margin-top: 55px;
    }
    table, th, td {
        border: 1px solid #ddd;
        text-align: center;
    }
    th{
               background-color: #2378b6;
            color: white;
            padding: 8px 16px;
            margin: 1px 0;
            border: none;
            cursor: pointer;
            font-size: 15px;
        
    }
    th, td {  padding: 4px;
            text-align: center;
            border-bottom: 1px solid #ddd; }
    .hidden { display: none; }
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        top:80px;
        left:45px;
        height: 26px;
    } td{
font-size:14px;
padding: 4px;
}
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #2378d8;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 34px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 15px;
        width: 18px;
        left: 5px;
        bottom: 6px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked + .slider {
        background-color: #0b05ff;
    }
    input:checked + .slider:before {
        transform: translateX(20px);
    }
      .logo-container {
            position: absolute;
            top: 20px;
            left: 8px;
            display: flex;
            align-items: center;
        }
        .hover-message {
            display: none;
            font-size: 12px;
            background-color: rgba(51, 51, 51, 0.9);
            color: white;
            padding: 5px;
            border-radius: 5px;
            position: absolute;
            left: 50px;
            top: 50%;
            transform: translateY(-50%);
        }
        .logo-container {
            position: relative;
        }
        h1 {
            text-align: center;
            color: #2378b2;
            margin-top:-1%;
        }
        .letra {
            margin-top: -4%;
        }
        body {
            background: url(FONDO3.jpg) no-repeat;
            background-size: 110%;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: top center;
            font-family: sans-serif;
        }
        .search-container {
            display: flex;
            position: relative;
            justify-content: left;
            align-items: left;
          
            overflow: hidden;
            left: 76%;
            margin-top: 30px;
        }
        .search-container input[type="text"] {
            display: flex;
            padding: 12px 20px;
            border: 2px solid rgb(35, 120, 182);
            outline: 2px;
            border-radius: 25px;
        }
        .search-icon {
            position: absolute;
            top: 60%;
            left: 80%;
            transform: translateY(-50%);
            pointer-events: none;
        }
        .left {
            display: flex;
            position: relative;
            justify-content: left;
            top: -10%;
        }
        .boot {
            width: 5px;
            height: 5px;
        }
        #pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .page-number {
            display: inline-block;
            padding: 5px 10px;
            margin: 0 5px;
            border: 1px solid #ccc;
            cursor: pointer;
        }
        .page-number.active {
            background-color: #2378b6;
            color: white;
        } 
       
    button {
      background-color: #2378b6;
      color: white;
      padding: 10px 10px;
      border-radius: 5px;
      border:none;
      font-size: 12px;
      cursor: pointer;
      transition: background-color 0.3s;
   
    }

    button:hover {
      background-color: #41a7f5;
    }

  
</style>
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
  // Función para buscar en la tabla
  document.getElementById('searchInput').addEventListener('keyup', function() {
  const filter = document.getElementById('searchInput').value.toUpperCase();
  const table = document.getElementById('dataTable');
  const tr = table.getElementsByTagName('tr');
  
  for (let i = 1; i < tr.length; i++) {
    const td = tr[i].getElementsByTagName('td');
    tr[i].style.display = 'none'; // Ocultar fila por defecto
    for (let j = 0; j <script td.length; j++) {
      if (td[j] && td[j].innerHTML.toUpperCase().includes(filter)) {
        tr[i].style.display = ''; // Mostrar fila si coincide
        break;
      }
    }
  }
});
    </script>


<style>
    
    .logo-container {
        position: absolute;
        top: 70px;
        left: 15px;
        display: flex;
        align-items: center;
    }

    .fixed-message {
        font-size: 12px;
        background-color: rgba(51, 51, 51, 0.9);
        color: white;
        padding: 5px;
        border-radius: 5px;
        margin-left: 12px; /* Ajusta este valor según sea necesario */
        display: inline-block; /* Asegura que se alinee adecuadamente */
    }

        h1 {
            text-align: center;
            color: #2378b2;
        }
        .letra {
            margin-top: 5%;
        }
    </style>

<div class="logo-container">
    <a href="principal.php">
        <img src="inicio.png" width="40" height="30" alt="perfil">  </a>
        <div class="fixed-message">Principal / Mantenibilidad</div>
  
</div>
<body>
<div class="left">
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Buscar en la tabla...">
            <div class="search-icon">
                <img src="lupa.png" width="25" height="15" alt="#">
            </div>
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
        <div align="left"><div class="p">
            <h2>Perfil de Usuario</h2>
            <p><strong>Nombre de Usuario:</strong> <?php echo htmlspecialchars($usuario); ?></p>
            <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($correo); ?></p>
   
            </div>
        </div>
    </div>
</div>
 
<style>

    h2{

        color:#2378b2;
        margin-top:-3%;
    }
    .right{
      margin-left:89%;
      margin-top:55px;
    }
    .titulo {
    margin-top: 6%; /* Ajusta el valor según lo que necesites */
}

</style>


<body>
  <h1>Registro de Bitacora</h1>


<div class align="center">
    <table id="dataTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Usuario</th>
                <th>Nombre Usuario</th>
                <th>Correo</th>
                <th>Acción</th>
                <th>Fecha y Hora</th>
            </tr>
        </thead>
        <tbody></div>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['usuario_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nombre_usuario']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['correo']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['accion']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['fecha_hora']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay registros en la bitácora para la fecha actual.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
$stmt->close();
$conexion->close();
?>



    <style>
    
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
              margin-top:-40px;
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
          .p{
    color:#2378b6;
}
          .modalt {
              display: none;
              position: fixed;
              z-index: 1;
              left: 0;
              top: 1px;
              width: 100%;
              height: 110%;
              overflow: auto;
              
              padding-top: 20px;
          }
  
          .modalt-contente {
    background-color: #fff;
    opacity: 90%;
    margin: 3% auto;
    padding: 28px;
    width: 80%;
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
<div id="pagination">
    <div class="page-navigation">
        <button id="prevButton">Anterior</button>
        <button id="nextButton">Siguiente</button>
    </div>
    <div class="page-numbers" id="pageNumbers">
    <div class="page-number active" onclick="showPage(1)">1</div></div>
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
  var currentPage = 1;
  var rowsPerPage = 12;

  function showPage(page) {
      var table = document.getElementById("miTabla");
      var rows = table.getElementsByTagName("tr");
      var start = (page - 1) * rowsPerPage + 1;
      var end = start + rowsPerPage;

      for (var i = 1; i < rows.length; i++) {
          if (i >= start && i < end) {
              rows[i].style.display = "";
          } else {
              rows[i].style.display = "none";
          }
      }
      updatePageNumbers();
  }

  function nextPage() {
      var table = document.getElementById("miTabla");
      var rows = table.getElementsByTagName("tr");
      if (currentPage * rowsPerPage < rows.length - 1) {
          currentPage++;
          showPage(currentPage);
      }
  }

  function prevPage() {
      if (currentPage > 1) {
          currentPage--;
          showPage(currentPage);
      }
  }

  function updatePageNumbers() {
      var pageNumbers = document.getElementById("pageNumbers");
      pageNumbers.innerHTML = "";
      var table = document.getElementById("miTabla");
      var rows = table.getElementsByTagName("tr");
      var totalPages = Math.ceil((rows.length - 1) / rowsPerPage);

      for (var i = 1; i <= totalPages; i++) {
          var pageNumber = document.createElement("div");
          pageNumber.className = "page-number" + (i === currentPage ? " active" : "");
          pageNumber.innerText = i;
          pageNumber.setAttribute("onclick", "showPage(" + i + ")");
          pageNumbers.appendChild(pageNumber);
      }
  }

  // Mostrar la primera página
  showPage(currentPage);
</script>
</body></html>
