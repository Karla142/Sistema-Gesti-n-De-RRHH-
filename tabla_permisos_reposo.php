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
// Conectar a tu base de datos
$conn = new mysqli("localhost", "root", "", "base_kam");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el número total de registros
$total_result = $conn->query("SELECT FROM persona");


// Ejecutar tu consulta SQL con límite
$sql = "SELECT * FROM persona ";
$result = $conn->query($sql);

if ($result === false) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>KAM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</head>
<body>



<style>

.lol {
    color: #2378b6;
    font-weight: bold; /* Cambia el grosor */
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
            margin-top:-40px;
            right: 20px;
            display: flex;
            gap: 20px; /* Espacio entre los logos */
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
            top: 10px;
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
            font-size
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

        .clos {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .clos:hover,
        .clos:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

    </style>
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
left:80%;
margin-top: 2.8%;
}


.search-container input[type="text"]{

display:flex;
padding:10px 19px;
border:2px solid rgb(35,120,182);
font-size:12px;
border-radius:25px;
outline:2px;
}

.search-icon{

 position:absolute;
 top:50%;
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

  
 
</style>

<div class="logo-container">
    <a href="principal.php">
        <img src="inicio.png" width="40" height="30" alt="perfil">
        </a>
    <div class="fixed-message">Principal / Permisos</div>
   
</div>

    <style>
       h1 {
        text-align: center;
        color: #2378b2;
        font-weight: bolder;
        font-size:32px;
    }

    .letra {
        margin-top: -1%;
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
        <span class="clos" id="closeProfil">&times;</span>
<div class="lol">
            <h2>Perfil de Usuario</h2>
           
    
            <p><strong>Nombre de Usuario:</strong> <?php echo htmlspecialchars($usuario); ?></p>
            <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($correo); ?></p>
   
            </div>
        </div>
    </div>
</div>
    <div class="letra">
       <h1>Permisos de Reposos</h1></div>
<style>
        table {
            width: 99%;
            border-collapse: collapse;
            margin-top: 26px;
        }
        th, td {
            padding: 2px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        td{

font-size: 15px;
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
             display: flex;
    justify-content: space-between;
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #2378b6;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            margin-left: 80%;
        }
        button:hover {
            background-color: #2378b2;
        }
        .hover-text {
            position: absolute;
            visibility: hidden;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            text-align: center;
            border-radius: 5px;
            padding: 5px;
            font-size: 12px;
            z-index: 1;
            white-space: nowrap;
        }
        .hover-container:hover .hover-text {
            visibility: visible;
        }
        .icon-container {
            position: relative;
            display: inline-block;
        }
    </style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    .icon-container {
        display: inline-block;
        margin-right: 15px; /* Separación entre los iconos */
        position: relative;
    }
    
    .hover-text {
        visibility: hidden;
        width: 120px;
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;
        position: absolute;
        z-index: 1;
        bottom: 125%; /* Cambiar para ajustar la posición */
        left: 50%;
        margin-left: -60px;
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .icon-container:hover .hover-text {
        visibility: visible;
        opacity: 1;
    }
</style>


<body>
    <div class align="center">
    <table id="miTabla" id="dataTable">
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Cédula</th>
            <th>Cargo</th>
            <th>Acciones</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["nombre_personal"] . "</td>
                        <td>" . $row["apellido_personal"] . "</td>
                        <td>" . $row["cedula_personal"] . "</td>
                        <td>" . $row["cargo_personal"] . "</td>
                        <td>

                        <div class='icon-container hover-container'>
                        <a href='#' class='preview-link' data-id='" . $row['id_personal'] . "' onclick='openModal(" . $row['id_personal'] . ")'>
                            <i class='fas fa-eye' style='font-size: 22px;'></i>
                            <span class='hover-text'>Vista Previa</span>
                        </a>
                    </div>
                            <div class='icon-container hover-container'>
                                <a href='generar_pdf.php?id=" . $row['id_personal'] . "' class='download-link' data-id='" . $row['id_personal'] . "'>
                                    <img src='descargar.png' alt='Descargar' width='25' height='22'>
                                    <span class='hover-text'>Descargar</span>
                                </a>
                            </div>
                           
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No se encontraron registros</td></tr>";
        }

        // Liberar el resultado y cerrar la conexión
        if ($result instanceof mysqli_result) {
            $result->close();
        }
        $conn->close();
        ?>
    </table>
    </div>




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

<!-- Modal de Edición -->
<!-- Modal de Edición -->
<div class="modal fade" id="editModal" tabindex="1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 align="center"class="modal-title" id="editModalLabel"> Permiso de Reposo</h5>
            
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <div class="mb-3">
                        <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
                        <input type="date" class="form-control" id="fechaInicio" required>
                    </div>
                    <div class="mb-3">
                        <label for="fechaFin" class="form-label">Fecha de Fin</label>
                        <input type="date" class="form-control" id="fechaFin" required>
                    </div>
                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo</label>
                        <input type="text" class="form-control capitalize" id="motivo" required>
                    </div>
                    <div class="mb-3">
                        <label for="condicionPermiso" class="form-label">Condición de Permiso</label>
                        <input type="text" class="form-control capitalize" id="condicionPermiso" required>
                    </div>
                    <div class="mb-3">
  <label for="nombreAutoridad" class="form-label">Nombre de autoridad</label>
  <input type="text" class="form-control" id="nombreAutoridad" list="autores" required>
  <datalist id="autores">
    <option value="Carmen Delgado">
    <option value="Naydelis Biel">
  </datalist>
</div>
 
                    <div class="mb-3">
                        <label for="cedulaAutoriza" class="form-label">Cédula que Autoriza</label>
                        <input type="text" class="form-control" id="cedulaAutoriza" required>
                    </div>
                    <input type="hidden" id="personaId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveChanges">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-primary {
        background-color: #2378b6;
        border-color: #2378b6;
    }

    .btn-primary:hover {
        background-color: #2378b6;
        border-color: #2378b6;  
        
    }

    .capitalize {
        text-transform: capitalize;
    }

    .toast-container {
        position: fixed;
        top: 7px;
        right: 20px;
        z-index: 10000;
    }

    .toast {
        background-color: #343a40;
        color: #fff;
        border-radius: 5px;
        padding: 10px 20px;
        margin-bottom: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
         border: 0px solid #fff;
        box-shadow: rgba(2,2,5,5) 0px 1px 4px 0px;
        animation: zoomIn 0.5s;
    }
   @keyframes zoomIn {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
        }
    }

    .toast h5 {
        text-align: center;
      margin: 5em 0em 5em 0em;
        color: #2378b6;
    }

</style>

<div class="toast-container" id="toastContainer"></div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let editModal = new bootstrap.Modal(document.getElementById('editModal'), {});
        let saveChangesButton = document.getElementById('saveChanges');
        let personaIdField = document.getElementById('personaId');
        let fechaInicioField = document.getElementById('fechaInicio');
        let fechaFinField = document.getElementById('fechaFin');
        let motivoField = document.getElementById('motivo');
        let condicionPermisoField = document.getElementById('condicionPermiso');
        let nombreAutoridadField = document.getElementById('nombreAutoridad');
        let cedulaAutorizaField = document.getElementById('cedulaAutoriza');

        document.querySelectorAll('.download-link').forEach(function (link) {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                let personaId = this.getAttribute('data-id');
                personaIdField.value = personaId;
                editModal.show();
            });
        });

        saveChangesButton.addEventListener('click', function () {
            let personaId = personaIdField.value;
            let fechaInicio = fechaInicioField.value;
            let fechaFin = fechaFinField.value;
            let motivo = motivoField.value;
            let condicionPermiso = condicionPermisoField.value;
            let nombreAutoridad = nombreAutoridadField.value;
            let cedulaAutoriza = cedulaAutorizaField.value;

            if (!fechaInicio || !fechaFin || !motivo || !condicionPermiso || !nombreAutoridad || !cedulaAutoriza) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor, complete todos los campos.'
                });
                return;
            }

            if (!validateStartAndEndDates(fechaInicio, fechaFin)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La fecha de inicio debe ser el día actual o una fecha posterior y la fecha de fin debe ser posterior a la fecha de inicio.'
                });
                return;
            }

            window.location.href = `generar_pdc.php?id=${personaId}&fechaInicio=${fechaInicio}&fechaFin=${fechaFin}&motivo=${motivo}&condicionPermiso=${condicionPermiso}&nombreAutoridad=${nombreAutoridad}&cedulaAutoriza=${cedulaAutoriza}`;
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Descarga exitosa'
            }).then(() => {
                editModal.hide();
            });
        });
    });

    function validateStartAndEndDates(startDate, endDate) {
        const today = new Date().setHours(0, 0, 0, 0);
        const start = new Date(startDate).setHours(0, 0, 0, 0);
        const end = new Date(endDate).setHours(0, 0, 0, 0);

        if (start < today) {
            return false;
        }

        return start <= end;
    }
</script>



    <!-- Modal -->
    <div id="modalPreview" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="modalBody"></div>
        </div>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modalPreview');
    const closeModal = document.getElementsByClassName('close')[0];
    const previewLinks = document.getElementsByClassName('preview-link');

    Array.from(previewLinks).forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            const id = link.getAttribute('data-id');
            fetch(`vista_previa.php?id=${id}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('modalBody').innerHTML = data;
                    modal.style.display = 'block';
                });
        });
    });

    closeModal.onclick = () => {
        modal.style.display = 'none';
    }

    window.onclick = (event) => {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Modal para el perfil de usuario
    const userProfileButton = document.getElementById('userProfileButton');
    const userProfileModal = document.getElementById('userProfileModal');
    const closeProfile = document.getElementById('closeProfile');
    userProfileButton.onclick = function() {
        userProfileModal.style.display = "block";
    }
    closeProfil.onclick = function() {
        userProfileModal.style.display = "none";
    }

   
    window.onclick = function(event) {
        if (event.target == userProfileModal) {
            userProfileModal.style.display = "none";
        }
     
    }
</script>

</body>
</html>
