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
    exit;
}

// Obtén los datos del usuario desde la sesión
$usuario = $_SESSION['usuario'];
$correo = $_SESSION['correo'];
$nivel_usuario = $_SESSION['nivel_usuario'] ?? 'Invitado'; // Nivel de usuario desde la sesión

// Incluir los archivos necesarios
include_once 'conexion.php'; // Archivo de conexión a la base de datos
include_once 'permisos.php'; // Archivo con las funciones de permisos

// Obtener el nombre del archivo actual
$modulo = basename(__FILE__); // Ejemplo: PERSONAL.php

// Verificar permisos del usuario para este módulo
if (!verificar_acceso($nivel_usuario, $modulo, $db)) {
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Acceso Denegado',
                text: 'No tienes permiso para acceder al módulo asistencia',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                window.location.href = 'principal.php'; // Redirige al usuario a la página principal
            });
        </script>
    </body>
    </html>";
    exit;
}

?>
<?php

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "base_kam");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener datos combinados de la tabla persona y asistencia filtrados por la fecha actual
$sql = "SELECT 
            p.nombre_personal, 
            p.apellido_personal, 
            p.cedula_personal, 
            IF(a.fecha_asistencia = CURDATE(), a.fecha_asistencia, 'No registrado') AS fecha_asistencia,
            IF(a.fecha_asistencia = CURDATE(), DATE_FORMAT(a.hora_entrada, '%h:%i %p'), 'No registrado') AS hora_entrada_12h,
            IF(a.fecha_asistencia = CURDATE() AND a.hora_salida IS NOT NULL, DATE_FORMAT(a.hora_salida, '%h:%i %p'), 'No registrado') AS hora_salida_12h
        FROM persona p
        LEFT JOIN asistencia a 
        ON p.cedula_personal = a.cedula_personal 
        AND a.fecha_asistencia = CURDATE()";

$result = $conn->query($sql);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

?>




<!DOCTYPE html>
<html lang="es">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <title>KAM</title>


 
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
            margin-top:30px;
            right: 20px;
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
            justify-content:left;
            align-items:left;
            display: none;
            
            position: fixed;
            z-index: 1;
            left: 0;
            top: 10px;
            width: 100%;
            height: 100%;
            overflow: auto;
            
            padding-top: 20px;
        }

        .modalt-contente {
            justify-content:left;
            align-items:left;
            background-color: #fff;
            opacity: 90%;
            margin: 3% auto;
            padding: 20px;
            
            width: 70%;
            max-width: 600px;
             border-radius: 15px;
              border: 1px solid #2378b6;
    box-shadow: rgba(5,2,5,5.14902) 0px 2px 6px 0px;
            animation: zoom 0.3s;
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
.p{
    text-align: left;
    color:#2378b6;
    justify-content:left;
            align-items:left;
}
.h2{

text-align: left;
color: #2378b2;  
}
    </style>



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
        
            <h2>Perfil de Usuario</h2>
            <div class="p">
            <p><strong>Nombre de Usuario:</strong> <?php echo htmlspecialchars($usuario); ?></p>
            <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($correo); ?></p>
   
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Modal para el perfil de usuario
    const userProfileButton = document.getElementById('userProfileButton');
    const userProfileModal = document.getElementById('userProfileModal');
    const closeProfile = document.getElementById('closeProfile');
    userProfileButton.onclick = function() {
        userProfileModal.style.display = "block";
    }
    closeProfile.onclick = function() {
        userProfileModal.style.display = "none";
    }

   
    window.onclick = function(event) {
        if (event.target == userProfileModal) {
            userProfileModal.style.display = "none";
        }
     
    }
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
        margin-left: 12px; /* Ajusta este valor según sea necesario */
        display: inline-block; /* Asegura que se alinee adecuadamente */
    }




        h1 {
            text-align: center;
            color: #2378b2;
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
            left: 79%;
            top:-49px;
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
            top: -14%;
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
        }   table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 80px;
        }
        th, td {
            padding: 4px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        td{
            font-size: 14px;
            padding: 4px;
        }
        th {
            background-color: #2378b6;
            color: white;
            padding: 8px 16px;
            margin: 1px 0;
            border: none;
            cursor: pointer;
            font-size: 15px;
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
    <div class="logo-container">
        <a href="principal.php">
            <img src="inicio.png" width="40" height="30" alt="perfil">  </a>
            <div class="fixed-message">Principal / Asistencia</div>
      
    </div>
    <br><br><br>
    <script>
        document.querySelector('.logo-container').addEventListener('mouseover', function() {
            document.querySelector('.hover-message').style.display = 'block';
        });
        document.querySelector('.logo-container').addEventListener('mouseout', function() {
            document.querySelector('.hover-message').style.display = 'none';
        });
    </script>
    <div class="left">
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Buscar en la tabla...">
            <div class="search-icon">
                <img src="lupa.png" width="25" height="15" alt="#">
            </div>
        </div>
    </div>
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
    <div class="letra">
        <h1>Gestión De Asistencia </h1>
    </div>

    <body>
    <style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #f0f8ff; /* Azul claro */
        margin: 10% auto;
        padding: 20px;
        border-radius: 10px;
        border: 1px solid #ccc;
        width: 50%;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        font-family: Arial, sans-serif;
    }

    .modal-header {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        text-align: center;
        margin-bottom: 10px;
    }

    h2 {
        color: #2378b6; /* Azul brillante */
        text-align: center;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: red;
        text-decoration: none;
    }

    .modal-content p {
        margin: 10px 0;
        font-size: 14px;
        line-height: 1.6;
        color: #555;
    }

    .input-search {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .table-modal {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .table-modal th, .table-modal td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
        font-size: 14px;
    }

    .table-modal th {
        background-color: #2378b6; /* Azul brillante */
        color: white;
    }

    .table-modal tbody tr:hover {
        background-color: #e3f2fd; /* Azul claro al pasar el cursor */
    }
</style>

</head>
<body>
    <table id="miTabla">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cédula</th>
                <th>Fecha</th>
                <th>Hora de Entrada</th>
                <th>Hora de Salida</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <tr data-cedula="<?php echo htmlspecialchars($row['cedula_personal']); ?>">
                        <td class="nombre"><?php echo htmlspecialchars($row['nombre_personal']); ?></td>
                        <td class="apellido"><?php echo htmlspecialchars($row['apellido_personal']); ?></td>
                        <td class="cedula"><?php echo htmlspecialchars($row['cedula_personal']); ?></td>
                        <td><?php echo $row['fecha_asistencia'] !== "No registrado" ? htmlspecialchars($row['fecha_asistencia']) : "No registrado"; ?></td>
                        <td class="entrada"><?php echo $row['hora_entrada_12h'] !== "No registrado" ? htmlspecialchars($row['hora_entrada_12h']) : "No registrado"; ?></td>
                        <td class="salida"><?php echo $row['hora_salida_12h'] !== "No registrado" ? htmlspecialchars($row['hora_salida_12h']) : "No registrado"; ?></td>
                        <td>
                            <div class="icono-con-texto">
                                <i class="fas fa-eye" onclick="vistaPrevia('<?php echo htmlspecialchars($row['cedula_personal']); ?>', '<?php echo date('Y-m-d'); ?>')" style="color: blue;"></i>
                                <span class="texto-hover">Vista previa</span>
                            </div>
                            <div class="icono-con-texto">
                                <i class="fas fa-edit" onclick="otrosRegistros('<?php echo htmlspecialchars($row['cedula_personal']); ?>')" style="color: blue;"></i>
                                <span class="texto-hover">Otros registros</span>
                            </div>
                        </td>
                    </tr>
                <?php }
            } else {
                echo "<tr><td colspan='7'>No se encontraron resultados.</td></tr>";
            }
            ?>
        </tbody>
    </table>
   <!-- Modal de Vista Previa -->
   <div id="vistaPreviaModal" class="modal">
    <div class="modal-content">
        <span onclick="cerrarModal('vistaPreviaModal')" class="close">&times;</span>
        <h2>Vista Previa</h2>
        <div id="vistaPreviaModalContent"></div>
    </div>
</div>

<script>
    // Función para cerrar modales
    function cerrarModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }

    // Función para mostrar datos en Vista Previa
    function vistaPrevia(cedula) {
        const filaSeleccionada = document.querySelector(`tr[data-cedula="${cedula}"]`);
        if (filaSeleccionada) {
            const datos = {
                nombre: filaSeleccionada.querySelector(".nombre").innerText,
                apellido: filaSeleccionada.querySelector(".apellido").innerText,
                cedula: filaSeleccionada.querySelector(".cedula").innerText,
                fecha: filaSeleccionada.querySelector("td:nth-child(4)").innerText,
                entrada: filaSeleccionada.querySelector(".entrada").innerText,
                salida: filaSeleccionada.querySelector(".salida").innerText
            };

            // Generar contenido para el modal
            document.getElementById("vistaPreviaModalContent").innerHTML = `
                <p><strong>Nombre:</strong> ${datos.nombre}</p>
                <p><strong>Apellido:</strong> ${datos.apellido}</p>
                <p><strong>Cédula:</strong> ${datos.cedula}</p>
                <p><strong>Fecha:</strong> ${datos.fecha}</p>
                <p><strong>Hora de Entrada:</strong> ${datos.entrada}</p>
                <p><strong>Hora de Salida:</strong> ${datos.salida}</p>
            `;
            // Mostrar el modal
            document.getElementById("vistaPreviaModal").style.display = "block";
        }
    }
</script>
<div id="otrosRegistrosModal" class="modal">
    <div class="modal-content">
        <span onclick="cerrarModal('otrosRegistrosModal')" class="close">&times;</span>
        <h2>Registros Generales</h2>
        <!-- Barra de búsqueda -->
        <input type="text" id="buscarFecha" class="input-search" placeholder="Buscar por fecha" oninput="filtrarRegistros()">
        <div id="otrosRegistrosModalContent"></div>
    </div>
</div>

<script>
    // Función para convertir formato 24 horas a 12 horas con AM/PM
    function convertirFormatoHora(hora) {
        const [horas, minutos] = hora.split(':');
        let horas12 = horas % 12 || 12; // Convierte a formato 12 horas
        const amPm = horas < 12 ? 'AM' : 'PM';
        return `${horas12}:${minutos} ${amPm}`;
    }

    let registrosOriginales = []; // Variable para almacenar los datos originales

    // Función para mostrar registros históricos
    function otrosRegistros(cedula) {
        fetch('otros_registros.php?cedula=' + encodeURIComponent(cedula))
            .then(response => response.json())
            .then(data => {
                registrosOriginales = data; // Guardar los datos originales
                if (data.length > 0) {
                    actualizarTabla(data);
                } else {
                    document.getElementById("otrosRegistrosModalContent").innerHTML = "<p>No se encontraron registros.</p>";
                }
                document.getElementById("otrosRegistrosModal").style.display = "block";
            })
            .catch(error => {
                console.error('Error al obtener los registros:', error);
                document.getElementById("otrosRegistrosModalContent").innerHTML = "<p>Error al cargar los registros.</p>";
                document.getElementById("otrosRegistrosModal").style.display = "block";
            });
    }

    // Función para actualizar la tabla con los registros proporcionados
    function actualizarTabla(registros) {
        const tablaRegistros = registros.map(registro => `
            <tr>
                <td>${registro.fecha_asistencia}</td>
                <td>${convertirFormatoHora(registro.hora_entrada)}</td>
                <td>${convertirFormatoHora(registro.hora_salida)}</td>
            </tr>
        `).join("");

        document.getElementById("otrosRegistrosModalContent").innerHTML = `
            <table class="table-modal">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora de Entrada</th>
                        <th>Hora de Salida</th>
                    </tr>
                </thead>
                <tbody id="tablaRegistros">
                    ${tablaRegistros}
                </tbody>
            </table>
        `;
    }

    // Función para filtrar los registros según la búsqueda
    function filtrarRegistros() {
        const criterioBusqueda = document.getElementById("buscarFecha").value.toLowerCase();
        const registrosFiltrados = registrosOriginales.filter(registro => 
            registro.fecha_asistencia.toLowerCase().includes(criterioBusqueda)
        );
        actualizarTabla(registrosFiltrados); // Actualiza la tabla con los registros filtrados
    }
</script>

<style>
.icono-con-texto {
    position: relative;
    display: inline-block;
    margin-right: 20px; /* Agrega espacio a la derecha de cada icono */
}

.texto-hover {
    position: absolute;
    background-color: rgba(0, 0, 0, 0.8);
    padding: 5px 10px;
    border-radius: 3px;
    opacity: 0;
    transition: opacity 0.3s ease;
    white-space: nowrap;
    z-index: 12;
    right: 58px;
    top: 0px;
    font-size: 12px;
    color: white;
}

.icono-con-texto:hover .texto-hover {
    opacity: 1;
}
</style>

</body>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
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

</style>
<div class="pagination">
  <div class="pagination-buttons">
    <button onclick="prevPage()">Anterior</button>
    <button onclick="nextPage()">Siguiente</button>
  </div>
  <div class="page-numbers" id="pageNumbers"></div>
</div>


<script>
  var currentPage = 1;
  var rowsPerPage = 15;

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

</body>
</html>
