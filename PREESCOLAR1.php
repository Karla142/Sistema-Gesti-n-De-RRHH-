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
// Verificar cédula vía AJAX
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['ajax'])) {
    $conn = new mysqli("localhost", "root", "", "base_kam");
    $response = ["encontrado" => false];

    if ($conn->connect_error) {
        $response["mensaje"] = "Error de conexión.";
        echo json_encode($response);
        exit;
    }

    $cedula = trim($_POST['cedula']);
    $stmt = $conn->prepare("SELECT nombre_personal, apellido_personal, cargo_personal FROM persona WHERE cedula_personal = ?");
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($nombre, $apellido, $cargo);
        $stmt->fetch();
        $response = [
            "encontrado" => true,
            "nombre" => $nombre,
            "apellido" => $apellido,
            "cargo" => $cargo
        ];
    } else {
        $response["mensaje"] = "La cédula no está registrada.";
    }

    $stmt->close();
    $conn->close();
    echo json_encode($response);
    exit;
}
   
?>


<!DOCTYPE html>


<html lagn="es">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0"> 
<head>
    <!-- Incluir SweetAlert2 desde un CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <head>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-/1W6z9nm0W0YXXhVshgFLCchNH4lvvxN4XqI/1Wx1gJhbyd/WQfwvChpIlhC3iA8bpoVaUe6NB2JQAnWDx9kEg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  
  <!-- Iconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font--awesome/4.7.0/css/font-awesome.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
</head>

</head>
    <title>KAM</title>
<style>
  .hover-message3 {
    display: none;
    background-color: rgba(51, 51, 51, 0.6);
    color: white;
    font-size: 15px;
    border-radius: 5px;
    padding: 4px;
    position: absolute;
    top: 50px;
    left: 40%;
    transform: translateX(-50%);
    z-index: 1;
    opacity: 0.9;
  }

  .hover-container3:hover .hover-message3 {
    display: block;
  }

  .container {
    margin: 0;
  }

  .logos {
    position: absolute;
    margin-top: 30px;
    right: 20px;
    display: flex;
    gap: 20px;
  }

  .hover-container3 {
    position: relative;
    display: inline-block;
    cursor: pointer;
    z-index: 1;
  }

  .hover-container3 img {
    width: 40px;
    height: 40px;
    transition: transform 0.3s ease;
  }

  .hover-container3:hover img {
    transform: scale(1.2);
    z-index: 2;
  }

  .modalt {
    display: none;
    position: fixed;
    z-index: 10;
    left: 0;
    top: 10px;
    width: 100%;
    height: 100%;
    overflow: auto;
    padding-top: 20px;
  }

  .modalt-contente {
    background-color: #fff;
    opacity: 0.9;
    margin: 3% auto;
    padding: 20px;
    width: 70%;
    max-width: 600px;
    border-radius: 15px;
    border: 1px solid #2378b6;
    box-shadow: 0 2px 6px rgba(5, 2, 5, 0.15);
    animation: zoom 0.3s;
  }

  @keyframes zoom {
    from {
      transform: scale(0);
    }

    to {
      transform: scale(1);
    }
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

  .p,
  h2 {
    color: #2378b6;
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

<div id="userProfileModal" class="modalt">
  <div class="modalt-contente">
    <span class="close" id="closeProfile">&times;</span>
    <div align="left">
      <h2>Perfil de Usuario</h2>
      <div class="p">
        <p><strong>Nombre de Usuario:</strong> <?php echo htmlspecialchars($usuario); ?></p>
        <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($correo); ?></p>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const userProfileButton = document.getElementById('userProfileButton');
    const userProfileModal = document.getElementById('userProfileModal');
    const closeProfile = document.getElementById('closeProfile');

    userProfileButton.onclick = function (e) {
      e.preventDefault(); // Prevenir comportamiento por defecto del enlace
      userProfileModal.style.display = "block";
    };

    closeProfile.onclick = function () {
      userProfileModal.style.display = "none";
    };

    window.onclick = function (event) {
      if (event.target === userProfileModal) {
        userProfileModal.style.display = "none";
      }
    };
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
        font-weight: bold;
    }

    .letra {
        margin-top:-2%;
    }
</style>

<div class="logo-container">
    <a href="principal.php">
        <img src="inicio.png" width="40" height="30" alt="perfil">
        </a>
    <div class="fixed-message">Principal / Horarios</div>
   
</div>
<br><br>
    <script>
        
  document.querySelector('.logo-container').addEventListener('mouseover', function() {
    document.querySelector('.hover-message').style.display = 'block';
});
document.querySelector('.logo-container').addEventListener('mouseout', function() {
    document.querySelector('.hover-message').style.display = 'none';
});


    </script>
  <style>
    .zoom { animation: zoomIn 0.4s ease; }
    @keyframes zoomIn {
      from { transform: scale(0.7); opacity: 0; }
      to   { transform: scale(1); opacity: 1; }
    }
  </style>
</head>
<style>

/*estilo de fondo*/

body{

      background:url(FONDO3.jpg) no-repeat;
      background-size: 110%;
    
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
left:78%;
margin-top: -18px;
}


.search-container input[type="text"]{

display:flex;
padding:8px 12px;
border:2px solid rgb(35,120,182);
outline:2px;
border-radius:25px;
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
top: -14%;

}

 .boot{
width: 5px;
height: 5px;
          }
 
</style>
<div class="left">
  <div class="search-container">
    <input type="text" id="searchInput" placeholder="Buscar en la tabla...">
    <div class="search-icon">
      <img src="lupa.png" width="25" height="15" alt="#">
    </div>
  </div>
</div>
<script>
document.getElementById('searchInput').addEventListener('keyup', function () {
  const filter = this.value.toUpperCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
  const table = document.getElementById('tablaHorarios');
  const tr = table.getElementsByTagName('tr');

  for (let i = 1; i < tr.length; i++) {
    const tds = tr[i].getElementsByTagName('td');
    let mostrar = false;

    for (let j = 0; j < tds.length; j++) {
      const texto = tds[j].textContent.toUpperCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
      if (texto.includes(filter)) {
        mostrar = true;
        break;
      }
    }

    tr[i].style.display = mostrar ? '' : 'none';
  }
});
</script>
  <div class="letra">
<h1>Gestión De Horarios</h1>
</div>

    <div  data-bs-toggle="modal" data-bs-target="#modalHorario"><img src="añadir_horario.png" alt="añadir" width="170" height="120"></div>
<style>
  .contenedor-tabla {
    display: flex;
    justify-content: center;
    margin-top: 20px;
  }

   table {
            width: 99%;
            border-collapse: collapse;
            margin-top: 20px;
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

  .hidden {
    display: none;
  }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class align="center">
<div class="table"> 
  <table  id="tablaHorarios">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Cédula</th>
        <th>Cargo</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <!-- Aquí irán las filas generadas dinámicamente -->
    </tbody>
  </table>
</div></div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  cargarTablaPersonal();
  setInterval(cargarTablaPersonal, 15000);

  // Evento de edición de persona
  const formEditar = document.getElementById("formEditar");
  if (formEditar) {
    formEditar.addEventListener("submit", function (e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch("editar_persona.php", {
        method: "POST",
        body: formData
      })
      .then(res => res.text())
      .then(msg => {
        Swal.fire({
          title: 'Edición completada',
          text: msg,
          icon: msg.includes('correctamente') ? 'success' : 'error',
          confirmButtonText: 'Aceptar'
        });
        bootstrap.Modal.getInstance(document.getElementById('modalEditar')).hide();
        cargarTablaPersonal();
      })
      .catch(error => {
        console.error("Error al guardar:", error);
        Swal.fire({
          title: 'Error',
          text: 'No se pudo guardar la edición.',
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
      });
    });
  }
});

function cargarTablaPersonal() {
  fetch('obtener_personal.php')
    .then(res => res.json())
    .then(data => {
      const tbody = document.querySelector("#tablaHorarios tbody");
      tbody.innerHTML = "";

      data.forEach(persona => {
        const fila = document.createElement("tr");
        fila.innerHTML = `
          <td>${persona.nombre}</td>
          <td>${persona.apellido}</td>
          <td>${persona.cedula}</td>
          <td>${persona.cargo}</td>
          <td>
            <a href="#" title="Editar" onclick="mostrarModalEdicion('${persona.cedula}', '${persona.id_horario}')">
              <i class="fas fa-pencil-alt" style="color:#3787b2;"></i>
            </a>
            <a href="#" title="Vista previa" onclick="mostrarVistaPrevia('${persona.cedula}')">
              <i class="fas fa-eye" style="color:#3787b2;"></i>
            </a>
            <a href="#" title="Eliminar" onclick="eliminarHorario('${persona.cedula}', '${persona.id_horario}')">
              <i class="fas fa-trash-alt" style="color:#b23737;"></i>
            </a>
          </td>
        `;
        tbody.appendChild(fila);
      });
    })
    .catch(error => {
      console.error("Error al cargar datos:", error);
      Swal.fire({
        title: 'Error',
        text: 'No se pudo cargar la tabla de personal.',
        icon: 'error',
        confirmButtonText: 'Aceptar'
      });
    });
}

// ✏️ Redirige al formulario de edición con estilo
function mostrarModalEdicion(cedula, idHorario) {
  Swal.fire({
    title: 'Editar horario',
    text: '¿Deseas editar este horario?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Sí, editar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = `editar_horario.php?cedula=${encodeURIComponent(cedula)}&id=${encodeURIComponent(idHorario)}`;
    }
  });
}

// 👁 Vista previa con confirmación
function mostrarVistaPrevia(cedula) {
  Swal.fire({
    title: 'Vista previa',
    text: 'Se abrirá la vista del horario completo.',
    icon: 'info',
    confirmButtonText: 'Ver ahora'
  }).then(() => {
    window.location.href = `vista_horarios.php?cedula=${encodeURIComponent(cedula)}`;
  });
}

// 🗑 Elimina horario con validación y estilo
function eliminarHorario(cedula, idHorario) {
  Swal.fire({
    title: '¿Eliminar horario?',
    text: 'Esta acción eliminará el horario y sus bloques asociados.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('eliminar_horario.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `cedula=${encodeURIComponent(cedula)}&id_horario=${encodeURIComponent(idHorario)}`
      })
      .then(res => res.text())
      .then(data => {
        Swal.fire({
          title: 'Resultado',
          text: data,
          icon: data.includes('correctamente') ? 'success' : 'error',
          confirmButtonText: 'Aceptar'
        }).then(() => cargarTablaPersonal());
      })
      .catch(err => {
        Swal.fire({
          title: 'Error',
          text: 'No se pudo eliminar el horario.',
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
      });
    }
  });
}
</script>



<form method="POST" action="guardar_horario.php">
  <div class="modal fade" id="modalHorario" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content zoom">
        <div class="modal-header">
          <h5 class="modal-title">Asignar Horario</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">

          <!-- Entrada cédula -->
          <input type="text" id="cedulaInput" class="form-control mb-2" placeholder="Ingrese cédula" />
          <button class="btn btn-primary mb-2" type="button" onclick="verificarCedula()">Verificar</button>
          <div id="mensaje" class="mb-2"></div>

          <div id="formularioHorario" style="display:none;">

            <!-- Este input se llena tras verificar cédula -->
            <input type="hidden" name="cedula" id="cedulaOculta" />

            <!-- Materia -->
            <label>Materia:</label>
            <select id="selectMateria" name="materia" class="form-control mb-2" required>
              <option value="">-- Selecciona una materia --</option>
              <option value="Matemática">Formación personal y social</option>
              <option value="Lengua">Relación con el ambiente</option>
              <option value="Ciencias Sociales">Comunicación y representación</option>
              <option value="Manos a la siembra">Manos a la siembra</option>
             
              <option value="añadir">➕ Añadir nueva materia</option>
            </select>

            <div id="nuevoCampoMateria" style="display:none;">
              <label>Nombre de nueva materia:</label>
              <input type="text" name="nueva_materia" class="form-control mb-2" />
            </div>

            <!-- Tipo de horario -->
            <label>Tipo de Horario:</label>
            <select name="tipo_horario" class="form-control" required onchange="tipoHorarioChange(this)">
              <option value="">Selecciona tipo</option>
              <option value="parcial">Parcial</option>
              <option value="tiempo_completo">Tiempo Completo</option>
            </select>

            <!-- Contenedor de bloques -->
            <div id="bloquesContainer"></div>

            <!-- Botón de envío -->
            <button type="submit" class="btn btn-success mt-3">Guardar Horario</button>

          </div>
        </div>
      </div>
    </div>
  </div>
</form>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function verificarCedula() {
  const cedula = document.getElementById("cedulaInput").value.trim();
  const mensaje = document.getElementById("mensaje");

  if (!cedula) {
    mensaje.innerText = "Ingrese una cédula válida.";
    mensaje.className = "mb-2 text-danger";
    return;
  }

  fetch("", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `cedula=${encodeURIComponent(cedula)}&ajax=1`
  })
  .then(resp => resp.json())
  .then(data => {
    if (data.encontrado) {
      mensaje.innerHTML = `<strong>${data.nombre} ${data.apellido}</strong> - ${data.cargo}`;
      mensaje.className = "mb-2 text-success";
      document.getElementById("cedulaOculta").value = cedula;
      document.getElementById("formularioHorario").style.display = "block";

      // ❌ Ya no se cierra el modal automáticamente
    } else {
      mensaje.innerText = data.mensaje || "Cédula no encontrada.";
      mensaje.className = "mb-2 text-danger";
      document.getElementById("formularioHorario").style.display = "none";
    }
  })
  .catch(() => {
    mensaje.innerText = "Error al verificar la cédula.";
    mensaje.className = "mb-2 text-danger";
    document.getElementById("formularioHorario").style.display = "none";
  });
}


document.getElementById("selectMateria").addEventListener("change", function () {
  document.getElementById("nuevoCampoMateria").style.display = this.value === "añadir" ? "block" : "none";
});



function tipoHorarioChange(select) {
  const container = document.getElementById("bloquesContainer");
  container.innerHTML = "";

  if (select.value === "parcial") {
    const parcialNode = generarParcial(); // Devuelve un nodo real
    container.appendChild(parcialNode);
  } else {
    container.innerHTML = generarCompleto(); // Sigue como HTML string
  }
}

function generarParcial() {
  const dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
  const opciones = dias.map(d => `<option value="${d}">${d}</option>`).join("");

  const container = document.createElement("div");
  container.className = "mb-3";

  container.innerHTML = `
    <label>Total de Horas a Trabajar:</label>
    <input type="number" name="total_horas" class="form-control" required>
    <table class="table table-bordered mt-3">
      <thead><tr><th>Día</th><th>Hora</th><th>Nivel</th><th>Sección</th></tr></thead>
      <tbody id="tbodyParcial">${filaParcial(opciones)}</tbody>
    </table>
  `;

  const boton = document.createElement("button");
  boton.type = "button";
  boton.className = "btn btn-sm btn-outline-secondary mt-2";
  boton.textContent = "➕ Añadir fila";

  boton.addEventListener("click", () => {
    const tbody = container.querySelector("#tbodyParcial");
    tbody.insertAdjacentHTML("beforeend", filaParcial(opciones));
  });

  container.appendChild(boton);
  return container;
}

function filaParcial(opciones) {
  return `<tr>
    <td><select name="dia[]" class="form-select" required><option value="">Seleccione</option>${opciones}</select></td>
    <td><input type="text" name="hora[]" class="form-control" required></td>
    <td>
      <select name="anio[]" class="form-select" required>
        <option value="">Seleccione un nivel</option>
        <option value="1° nivel">1° nivel</option>
        <option value="2° nivel">2° nivel</option>
        <option value="3° nivel">3° nivel</option>
      </select>
    </td>
    <td><input type="text" name="seccion[]" class="form-control" required></td>
  </tr>`;
}


// === Lógica Horario Tiempo Completo ===
function generarCompleto() {
  const dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
  return dias.map(dia => `
    <div class="mb-3 border p-3 rounded">
      <h6>${dia}</h6>
      <div id="bloques_${dia}">${bloqueCompletoHtml(dia)}</div>
      <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="agregarBloque('${dia}')">➕ Agregar clase</button>
    </div>
  `).join("");
}

function bloqueCompletoHtml(dia) {
  return `
    <div class="row g-2 mb-2">
      <div class="col-md-4">
        <input type="text" name="bloques_${dia}[]" class="form-control" placeholder="Bloque de hora" required>
      </div>
      <div class="col-md-4">
        <select name="anio_${dia}[]" class="form-select" required>
          <option value="">Seleccione un nivel</option>
          <option value="1° nivel">1° nivel</option>
          <option value="2° nivel">2° nivel</option>
          <option value="3° nivel">3° nivel</option>
         
        </select>
      </div>
      <div class="col-md-4">
        <input type="text" name="seccion_${dia}[]" class="form-control" placeholder="Sección" required>
      </div>
    </div>
  `;
}

function agregarBloque(dia) {
  document.getElementById(`bloques_${dia}`).insertAdjacentHTML("beforeend", bloqueCompletoHtml(dia));
}
</script>

</form>
<div class="pagination">
  <div class="pagination-buttons">
    <button onclick="prevPage()">Anterior</button>
    <button onclick="nextPage()">Siguiente</button>
  </div>
  <div class="page-numbers" id="pageNumbers"></div>

<div class="page-number active" onclick="showPage(1)">1</div>
</div></div>
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
    padding: 8px 10px;
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

</body>
</html>
