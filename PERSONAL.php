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
                text: 'No tienes permiso para acceder al módulo personal',
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
.p, h2{

    color:#2378b6;
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
        <div align="left">
            <h2>Perfil de Usuario</h2>
            <div class="p">
            <p><strong>Nombre de Usuario:</strong> <?php echo htmlspecialchars($usuario); ?></p>
            <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($correo); ?></p>
   
            </div>
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
    <div class="fixed-message">Principal / Personal</div>
   
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
left:80%;
margin-top: -30px;
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
top: -14%;

}

 .boot{
width: 5px;
height: 5px;
          }
 
</style>
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = this.value.toUpperCase();
    const table = document.getElementById('miTabla');
    const tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) { // Empieza desde 1 para ignorar la cabecera
        const td = tr[i].getElementsByTagName('td');
        let visible = false;
        
        for (let j = 0; j < td.length; j++) {
            if (td[j] && td[j].textContent.toUpperCase().includes(filter)) {
                visible = true;
                break;
            }
        }
        tr[i].style.display = visible ? '' : 'none';
    }
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
  <div class="letra">
<h1>Gestión De Personal</h1>
</div>
<style>
   .button {
       
        padding: 8px 16px;
        margin: 8px 0;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }
   </style>      
  
     <div class="button">
  <div onclick="showModal()"><img src="añadir.png" alt="añadir" width="150" height="45"></div></div>

  <form id="formPersonal" action="update.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" onsubmit="return validarCedula()">
<div id="myModal" class="modal">
    <div id="modalConte" class="modal-conte">
      

    <style>
       
        .image-tooltip-container {
            justify-content:center;
            align-items:center;
            position: relative;
            display: inline-block;
            cursor: pointer;
            left:-20%;
        }
        .image-tooltip-container .tooltiptext {
            visibility: hidden;
            width: 140px;
          
            background-color: rgba(0, 0, 0, 0.7); /* Fondo negro con opacidad */
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: 105%;
            left: 50%;
            margin-left: -70px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .image-tooltip-container:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
        .boton {
            border: none;
            background-color: transparent;
            cursor: pointer;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class align="center">
    <div class="image-tooltip-container" style="position: relative; display: inline-block;">
        <img src="huella3.png" width="55" height="55" alt="Usuario">
        <div onclick="showAlert()" style="position: absolute; bottom: 4px; right: 1px; width: 20px; height: 20px; background-color: blue; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
            <span style="color: white; font-size: 18px; font-weight: bold;">+</span>
        </div>
        <span class="tooltiptext">Registra tu huella</span>
    </div>
</div>
<input type="hidden" name="huella_dactilar" id="huella_dactilar">

<script>
function showAlert() {
    Swal.fire({
        title: '¿Desea registrar su huella?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            registrarHuella();
        }
    });
}

function registrarHuella() {
    // Validar inputs antes de enviar
    if (!validarInputs()) return;

    Swal.fire({
        title: 'Registrando huella...',
        text: 'Por favor, espere mientras procesamos la operación.',
        icon: 'info',
        showConfirmButton: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading(); // Muestra un indicador de carga
        }
    });

    // Crear objeto FormData para enviar los datos al servidor
    const formData = new FormData();
    formData.append('nombre_personal', document.getElementById("nombre_personal").value);
    formData.append('apellido_personal', document.getElementById("apellido_personal").value);
    formData.append('nacionalidad', document.getElementById("nacionalidad").value);
    formData.append('cedula_personal', document.getElementById("cedula_personal").value);
    formData.append('titulo_personal', document.getElementById("titulo_personal").value);
    formData.append('correo_personal', document.getElementById("correo_personal").value);
    formData.append('nacimiento_personal', document.getElementById("nacimiento_personal").value);
    formData.append('ingreso_personal', document.getElementById("ingreso_personal").value);
    formData.append('cargo_personal', document.getElementById("cargo_personal").value);

    // Llamada al archivo PHP
    fetch('procesar_huella.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al conectar con el servidor.');
        }
        return response.json();
    })
    .then(data => {
        Swal.close(); // Cierra la alerta de carga

        if (data.error) {
            throw new Error(data.error); // Manejo de errores desde el servidor
        }

        // Mensajes según la respuesta del servidor
        if (data.id_personal) {
            Swal.fire({
                title: 'Éxito',
                text: `Huella registrada exitosamente para el usuario ID: ${data.id_personal}.`,
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
        } else if (data.new_user) {
            Swal.fire({
                title: 'Usuario Registrado',
                text: 'Se ha registrado un nuevo usuario y su huella fue almacenada correctamente.',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
        }

        // Mostrar imagen de la huella (si se devuelve)
        const container = document.querySelector('.image-tooltip-container') || crearContenedorImagen();
        container.innerHTML = ''; // Limpia cualquier imagen previa
        if (data.base64Image) {
            const huellaImg = document.createElement('img');
            huellaImg.src = `data:image/png;base64,${data.base64Image}`;
            huellaImg.alt = 'Huella Registrada';
            huellaImg.width = 200;
            huellaImg.height = 200;
            container.appendChild(huellaImg);
        }
    })
    .catch(error => {
        Swal.fire({
            title: 'Error',
            text: error.message,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    });
}

function validarInputs() {
    const campos = [
        { id: "nombre_personal", nombre: "Nombre" },
        { id: "apellido_personal", nombre: "Apellido" },
        { id: "nacionalidad", nombre: "Nacionalidad" },
        { id: "cedula_personal", nombre: "Cédula" },
        { id: "correo_personal", nombre: "Correo Electrónico" },
        { id: "nacimiento_personal", nombre: "Fecha de Nacimiento" },
        { id: "ingreso_personal", nombre: "Fecha de Ingreso" },
        { id: "cargo_personal", nombre: "Cargo" }
    ];

    for (const campo of campos) {
        const valor = document.getElementById(campo.id)?.value || "";
        if (!valor) {
            Swal.fire({
                title: 'Error',
                text: `El campo "${campo.nombre}" es obligatorio.`,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            return false;
        }
    }

    return true;
}

function crearContenedorImagen() {
    const newContainer = document.createElement('div');
    newContainer.className = 'image-tooltip-container';
    document.body.appendChild(newContainer);
    return newContainer;
}


</script>


            <div class="form-row">
                <div class="form-group form-half">
                    <label for="nombre_personal">Nombre:<span style="color: red;">*</span></label>
                    <input type="text" id="nombre_personal" name="nombre_personal" required>
                </div>
                <div class="form-group form-half">
                    <label for="apellido_personal">Apellido:<span style="color: red;">*</span></label>
                    <input type="text" id="apellido_personal" name="apellido_personal" required>
                </div>
            </div>
<div class="form-row">
    <div class="form-group form-half">
        <label for="cedula_personal">Cédula de Identidad:<span style="color: red;">*</span>
        <div style="display: flex; align-items: center;">
            <select id="nacionalidad" name="nacionalidad" style="width: 60px;" required>
                <option value="" disabled selected>Seleccione</option>
                <option value="V">V</option>
                <option value="E">E</option>
            </select>
            <input type="text" id="cedula_personal" name="cedula_personal" required style="flex: 1; margin-left: 5px;">
        </div>
        <span id="cedulaError" class="error" style="color: red;"></span></label>
    </div>

                <div class="form-group form-half">
                    <label for="titulo_personal">Nivel Académico:<span style="color: red;">*</span></label>
                    <select id="titulo_personal" name="titulo_personal" required>
                        <option value="" disabled selected>Seleccione</option>
                        <option value="bachiller">Bachiller</option>
                        <option value="ingeniero">Ingeniero</option>
                        <option value="doctor">Doctor</option>
                        <option value="licenciado">Licenciado</option>
                        <option value="tsu">TSU</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="correo_personal">Correo Electrónico:<span style="color: red;">*</span></label>
                <input type="email" id="correo_personal" name="correo_personal" required>
                <span id="correoError" class="error"></span>
            </div>

            <div class="form-row">
                <div class="form-group form-half">
                    <label for="nacimiento_personal">Fecha de Nacimiento:<span style="color: red;">*</span></label>
                    <input type="date" id="nacimiento_personal" name="nacimiento_personal" required>
                    <span id="nacimientoError" class="error"></span>
                </div>
                <div class="form-group form-half">
                    <label for="ingreso_personal">Fecha de Ingreso:<span style="color: red;">*</span></label>
                    <input type="date" id="ingreso_personal" name="ingreso_personal" required>
                    <span id="ingresoError" class="error"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="cargo_personal"> Cargo:<span style="color: red;">*</span></label>
                <select id="cargo_personal" name="cargo_personal" required>
                    <option value="" disabled selected>Seleccione</option>
                    <option value="Profesor">Profesor</option>
                     <option value="Profesora">Profesora</option>
                    <option value="Coordinadora">Coordinadora</option>
                     <option value="Coordinador">Coordinador</option>
                    <option value="Asistente administrativo">Asst.administrativo</option>
                 <option value="Aux.Inicial">Aux.Inicial</option>
                   <option value="Prof.Matematica/fisica">Prof.Matematica/fisica</option>
                     <option value="Prof.Sociales">Prof.Sociales</option>
                       <option value="Prof.Biologia">Prof.Biologia</option>
                 <option value="Prof.Ingles">Prof.Ingles</option>
                       <option value="Prof.Quimica">Prof.Quimica</option>
                             <option value="Castellano y Proyecto">Castellano y Proyecto</option>
                    <option value="Director">Director G</option>
                    <option value="Obrero">Obrero</option>
                    <option value="Directora">Directora</option>
                    <option value="Maestra">Maestra</option>
                    <option value="Administradora">Administradora</option>
                    <option value="Contador"> Contador</option>
                    <option value="RRHH"> RRHH</option>
                    <option value="Conserje">Conserje</option>
                    <option value="Mensajero">Mensajero</option>
                    <option value="Secretaria">Secretaria</option>
                </select>
            </div>

            <div class="button-row">
                <button type="submit">Guardar</button>
                <button type="button" onclick="ocultarModal()">Cancelar</button>


            </div>   
     
   </div></div></form>
    
<script>
  function ocultarModal() {
    // Aquí va el código para cerrar el modal
    var modal = document.getElementById('myModal');
    modal.style.display = 'none';
  }
</script>
<!-- Tus estilos existentes -->
<style>
    .modal {
    display: none;
    justify-content: center;
    align-items: center;
    position: fixed; /* Ensures the modal is fixed over the entire screen */
    left: 0;
    width: 100%;
    height: 100%; /* Covers the entire viewport */
    background-color:transparent; /* Adds a semi-transparent black background */
}

.modal-conte {
    padding: 15px;
    width: 50%;
    max-width: 400px;
    font-size: 12px;
    margin-top: -8%;  
    background-color: #fff;
    border-radius: 10px;
    border: 0px solid #fff;
    box-shadow: rgba(2,2,5,5) 0px 1px 4px 0px;
    animation: modalFadeIn 0.5s ease-in-out;
}

@keyframes modalFadeIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.form-group {
    display: flex;
    flex-direction: column;
    margin: 2px;
}

input, select, label {
    width: 100%;
    padding: 3px;
    margin: 4px 0;
    font-size: 12px;
}

.form-row {
    display: flex;
    justify-content: space-between;
}

.form-half {
    width: 48%;
}

.button-row {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 8px;
}

button {
    background-color: #2378b6;
    color: white;
    padding: 8px 10px;
    margin: 8px 0;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

button:hover {
    background-color: #41a7f5;
}

.error {
    color: red;
    font-size: 12px;
}

.tooltip {
    justify-content: center;
    align-items: center;
    position: relative;
    display: inline-block;
    cursor: pointer;
    font-size: 12px;
    margin-left: 30%;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: #333;
    opacity: 90%;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;
    position: absolute;
    z-index: 1;
    bottom: 10%;
    left: -70px;
    opacity: 0;
    transition: opacity 0.3s;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
}

.tooltip .plus-icon {
    color: white;
    background-color: #2378b6;
    border-radius: 70%;
    padding: 3px;
    position: relative;
    top: 15px;
    right: 80%;
}

.image-tooltip-container {
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    margin-bottom: 5px;
    margin-left: 42%;
}

input[type="file"] {
    display: none;
}

</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showModal() {
        document.getElementById("myModal").style.display = "flex";
    }

    function validateForm() {
        let valid = true;
        let mensajesError = "";

        const nacionalidad = document.getElementById("nacionalidad").value;
        const cedula = document.getElementById("cedula_personal").value;
        const correo = document.getElementById("correo_personal").value;
        const nacimiento = document.getElementById("nacimiento_personal").value;
        const ingreso = document.getElementById("ingreso_personal").value;
        const nombre = document.getElementById("nombre_personal").value;
        const apellido = document.getElementById("apellido_personal").value;

        // Validar si la cédula ya existe en la base de datos
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "verificar_cedula.php?cedula=" + cedula, false); // Sincrónico para esperar la respuesta
        xhr.send();

        if (xhr.responseText === "existe") {
            Swal.fire({
                icon: 'error',
                title: 'Error de Registro',
                text: 'La cédula ingresada ya ha sido registrada.',
                confirmButtonText: 'Entendido'
            });
            return false;
        }

        // Validar Cédula (solo números y entre 7 y 8 dígitos, excluyendo nacionalidad)
        function validarCedula(cedula) {
            let mensajesError = "";
            let valid = true;

            if (!/^[VE]-\d{7,8}$/.test(cedula)) {
                mensajesError += "• Cédula debe contener entre 7 y 8 números y debe tener el formato V-00000000 o E-00000000.<br>";
                valid = false;
            }

            return {
                mensajesError: mensajesError,
                valid: valid
            };
        }

        const resultadoCedula = validarCedula(cedula);
        if (!resultadoCedula.valid) {
            mensajesError += resultadoCedula.mensajesError;
            valid = false;
        }

        // Validar Nombres y Apellidos (primera letra mayúscula y sin números)
        const nombreApellidoRegex = /^[A-Z][a-zA-Z]*$/;

        if (!nombreApellidoRegex.test(nombre)) {
            mensajesError += "• El nombre debe comenzar con una letra mayúscula y no debe contener números.<br>";
            valid = false;
        }

        if (!nombreApellidoRegex.test(apellido)) {
            mensajesError += "• El apellido debe comenzar con una letra mayúscula y no debe contener números.<br>";
            valid = false;
        }

        // Validar Correo
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo)) {
            mensajesError += "• Correo electrónico no válido.<br>";
            valid = false;
        }

        // Validar Fechas
        const currentDate = new Date().toISOString().split("T")[0];

        if (nacimiento > currentDate) {
            mensajesError += "• Fecha de nacimiento no puede ser en el futuro.<br>";
            valid = false;
        }

        if (ingreso > currentDate) {
            mensajesError += "• Fecha de ingreso no puede ser posterior a la actual.<br>";
            valid = false;
        }

        if (!valid) {
            // Mostrar mensajes de error con SweetAlert2
            Swal.fire({
                icon: 'error',
                title: 'Errores en el formulario',
                html: mensajesError,
                confirmButtonText: 'Entendido'
            });

            return false;
        } else {
            // Mostrar mensaje de registro exitoso y ocultar el formulario
            Swal.fire({
                icon: 'success',
                title: 'Registro Exitoso',
                text: 'El personal ha sido registrado correctamente.',
                confirmButtonText: 'Entendido',
              
            });

            return true;
        }
    }

    let cedulaMessageDisplayed = false;

    // Validaciones mientras el usuario escribe
    document.getElementById("cedula_personal").addEventListener("input", function(event) {
        const cedula = event.target.value;
        if (!cedulaMessageDisplayed) {
            if (!/^[VE]-/.test(cedula) || /[^0-9-]/.test(cedula) || !/^[VE]-\d*$/.test(cedula)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error en el campo cédula',
                    text: 'El campo cédula debe tener el formato V-00000000 o E-00000000 y contener solo números.',
                    confirmButtonText: 'Entendido'
                });
                cedulaMessageDisplayed = true;
            } else if (!/^\d{7,8}$/.test(cedula.split('-')[1])) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error en el campo cédula',
                    text: 'La cédula debe contener entre 7 y 8 números.',
                    confirmButtonText: 'Entendido'
                });
                cedulaMessageDisplayed = true;
            }
        }
    });

    document.getElementById("nacionalidad").addEventListener("change", function() {
        const nacionalidad = this.value;
        const cedulaInput = document.getElementById("cedula_personal");
        cedulaInput.value = `${nacionalidad}-`;
    });

    document.getElementById("nombre_personal").addEventListener("input", function(event) {
        const nombre = event.target.value;
        if (!/^[A-Z][a-zA-Z]*$/.test(nombre)) {
            Swal.fire({
                icon: 'error',
                title: 'Error en el campo nombre',
                text: 'El nombre debe comenzar con una letra mayúscula y no debe contener números.',
                confirmButtonText: 'Entendido'
            });
        }
    });

    document.getElementById("apellido_personal").addEventListener("input", function(event) {
        const apellido = event.target.value;
        if (!/^[A-Z][a-zA-Z]*$/.test(apellido)) {
            Swal.fire({
                icon: 'error',
                title: 'Error en el campo apellido',
                text: 'El apellido debe comenzar con una letra mayúscula y no debe contener números.',
                confirmButtonText: 'Entendido'
            });
        }
    });

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
<style>
       table {
        width: 100%;
        border-collapse: collapse;
    }
    tbody{
          
        padding: 8px 16px;
       
        font-size: 14px; 
    }
    th, td {
        padding: 0px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #2378b6;
        color: white;
        padding: 8px 16px;
        margin: 0px 0;
        border: none;
        cursor: pointer;
        font-size: 14px;
    }
        .hidden {
            display: none;
        }
       
    </style>


<?php
// Conexión a la base de datos
$host = "localhost";
$user = "root";
$password = "";
$dbname = "base_kam";

$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar la actualización al enviar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar'])) {

    $id = $_POST['id_personal'];
    $nombre = $_POST['nombre_personal'];
    $apellido = $_POST['apellido_personal'];
    $cedula = $_POST['cedula_personal'];
    $correo = $_POST['correo_personal'];
    $nacimiento = $_POST['nacimiento_personal'];
    $ingreso = $_POST['ingreso_personal'];
    $cargo = $_POST['cargo_personal'];

    $sql = "UPDATE persona SET 
                nombre_personal='$nombre', 
                apellido_personal='$apellido', 
                cedula_personal='$cedula', 
                correo_personal='$correo', 
                nacimiento_personal='$nacimiento', 
                ingreso_personal='$ingreso', 
                cargo_personal='$cargo' 
            WHERE id_personal=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Cambios actualizados correctamente',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al actualizar: " . $conn->error . "',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
              </script>";
    }
}

// Consultar los datos para llenar la tabla
$sql = "SELECT id_personal, nombre_personal, apellido_personal, cedula_personal, correo_personal, nacimiento_personal, ingreso_personal, cargo_personal FROM persona";
$result = $conn->query($sql);
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <style>
        /* Modal */
        .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 50;
    top: 0;
    width: 50%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-conten {
    background-color: white;
    margin: -3% auto;
    padding: 20px;
    border-radius: 10px;
    width: 30%;
    animation: modalFadeIn 0.5s ease-in-out;
}

@keyframes modalFadeIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

    </style>
<head>
    <meta charset="UTF-8">
    <title>Tabla de Personal</title>
    <!-- Incluye Font Awesome para los íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>

    <link rel="stylesheet" href="path/to/your/switch.css"> <!-- Enlace a tu archivo CSS -->
</head>

<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<table id="miTabla" class="display">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Cédula</th>
            <th>Correo</th>
            <th>Nacimiento</th>
            <th>Ingreso</th>
            <th>Cargo</th>
            <th>Acciones</th>
            <th>Estatus</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if ($result->num_rows > 0) { 
            $numeroFila = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr id='row-" . htmlspecialchars($row['id_personal']) . "'> 
                        <td>" . htmlspecialchars($numeroFila) . "</td> 
                        <td>" . htmlspecialchars($row['nombre_personal']) . "</td>
                        <td>" . htmlspecialchars($row['apellido_personal']) . "</td>
                        <td>" . htmlspecialchars($row['cedula_personal']) . "</td> 
                        <td>" . htmlspecialchars($row['correo_personal']) . "</td> 
                        <td>" . htmlspecialchars($row['nacimiento_personal']) . "</td>
                        <td>" . htmlspecialchars($row['ingreso_personal']) . "</td>
                        <td>" . htmlspecialchars($row['cargo_personal']) . "</td> 
                        <td>
                            <i class='fa fa-pencil' style='color: blue; cursor: pointer;' title='Editar'
                                onclick=\"openEditModal('" . htmlspecialchars($row['id_personal']) . "', 
                                '" . htmlspecialchars($row['nombre_personal']) . "', 
                                '" . htmlspecialchars($row['apellido_personal']) . "', 
                                '" . htmlspecialchars($row['cedula_personal']) . "', 
                                '" . htmlspecialchars($row['correo_personal']) . "', 
                                '" . htmlspecialchars($row['nacimiento_personal']) . "', 
                                '" . htmlspecialchars($row['ingreso_personal']) . "', 
                                '" . htmlspecialchars($row['cargo_personal']) . "')\"></i> 

                            <i class='fa fa-eye' style='color: blue; cursor: pointer;' title='Previsualizar'
                                onclick=\"openPreviewModal('" . htmlspecialchars($row['id_personal']) . "', 
                                '" . htmlspecialchars($row['nombre_personal']) . "', 
                                '" . htmlspecialchars($row['apellido_personal']) . "', 
                                '" . htmlspecialchars($row['cedula_personal']) . "', 
                                '" . htmlspecialchars($row['correo_personal']) . "', 
                                '" . htmlspecialchars($row['nacimiento_personal']) . "', 
                                '" . htmlspecialchars($row['ingreso_personal']) . "', 
                                '" . htmlspecialchars($row['cargo_personal']) . "')\"></i>
                        </td> 
                        <td class='status-switch'>
                            <label class='switch'>
                                <input type='checkbox' onclick='toggleStatus(this)' data-id='" . htmlspecialchars($row['id_personal']) . "'>
                                <span class='slider round'></span>
                            </label>
                            <span class='status-text'>Activo</span>
                        </td> 
                      </tr>";
                $numeroFila++;
            }
        }else {
                echo "<tr><td colspan='7'>No se encontraron resultados.</td></tr>";
            }
        ?>
    </tbody>
</table>
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


    <style>
        .inactive-row {
            background-color: red !important;
            color: white !important;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
            border-radius: 34px; /* Para un círculo más perfecto */
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
            left: 1px;
            bottom: 7px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 50%; /* Para hacer el círculo interior más redondo */
        }

        input:checked + .slider {
            background-color: #0b05ff; /* Color azul para el interruptor activo */
        }

        input:focus + .slider {
            box-shadow: 0 0px #c3c2ff;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Si deseas agregar iconos personalizados puedes hacerlo de la siguiente manera */
        input:checked + .slider:before {
            content: url('check.svg');
            text-align: center;
            line-height: 15px;
        }

        input:not(:checked) + .slider:before {
            content: url('cross.svg');
            text-align: center;
            line-height: 15px;
        }
    </style>

    <!-- Incluye la librería SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    
    <script>
        // Función para guardar el estado del interruptor en localStorage
        function saveStatus(id, status) {
            localStorage.setItem(`status-${id}`, status);
        }

        // Función para cargar el estado del interruptor desde localStorage
        function loadStatus() {
            var rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                var checkbox = row.querySelector('.status-switch input');
                var statusText = row.querySelector('.status-text');
                var id = checkbox.getAttribute('data-id');
                var status = localStorage.getItem(`status-${id}`);
                if (status === 'inactivo') {
                    checkbox.checked = false;
                    row.classList.add('inactive-row');
                    statusText.textContent = 'Inactivo';
                } else {
                    checkbox.checked = true;
                    row.classList.remove('inactive-row');
                    statusText.textContent = 'Activo';
                }
            });
        }

        function toggleStatus(checkbox) {
            var row = checkbox.closest('tr');
            var statusText = row.querySelector('.status-text');
            var nombre = row.children[1].textContent;
            var apellido = row.children[2].textContent;
            var id = checkbox.getAttribute('data-id');

            if (!checkbox.checked) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: `¿Deseas desactivar a ${nombre} ${apellido}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, desactivar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        row.classList.add('inactive-row');
                        statusText.textContent = 'Inactivo';
                        saveStatus(id, 'inactivo');
                    } else {
                        checkbox.checked = true;
                    }
                });
            } else {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: `¿Deseas activar a ${nombre} ${apellido}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, activar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        row.classList.remove('inactive-row');
                        statusText.textContent = 'Activo';
                        saveStatus(id, 'activo');
                    } else {
                        checkbox.checked = false;
                    }
                });
            }
        }

        // Cargar el estado del interruptor al cargar la página
        window.onload = loadStatus;
    </script>
</body>


  <!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-conten">
    <div class align="center">
    <h2 style="color: #2378b6;">Editar Personal</h2>
</div>

        <form method="post">
            <input type="hidden" id="modal-id" name="id_personal"> 
            <label>Nombre:</label><br> 
            <input type="text" id="modal-nombre" name="nombre_personal" required><br><br>
            <label>Apellido:</label><br> 
            <input type="text" id="modal-apellido" name="apellido_personal" required><br><br>
            <label>Cédula:</label><br> 
            <input type="text" id="modal-cedula" name="cedula_personal" required><br><br>
            <label>Correo:</label><br> 
            <input type="email" id="modal-correo" name="correo_personal" required><br> <br>
            <label>Fecha de Nacimiento:</label><br> 
            <input type="date" id="modal-nacimiento" name="nacimiento_personal" required><br><br>
            <label>Fecha de Ingreso:</label><br> 
            <input type="date" id="modal-ingreso" name="ingreso_personal" required><br><br>
            <label>Cargo:</label><br> 
            <input type="text" id="modal-cargo" name="cargo_personal" required><br>
            <div align="center">
                <button type="submit" name="actualizar">Guardar</button>
                <button onclick="closeModal()">Cancelar</button>
            </div>
        </form>
    </div>
</div>


<!-- Preview Modal -->
<div id="previewModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&#x2715;</span> <!-- Replaced button with "X" -->
      
        <div id="previewContent"></div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> 
<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script> 
<!-- Custom JS -->

<style>
    /* Ocultar la columna de ID */
    #miTabla th:first-child, #miTabla td:first-child {
        display: none;
    }
    /* Estilos para el paginador */
 

    .status-switch {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
        padding-top: 60px;
    }
    .modal-content {
        font-family: 'Arial', sans-serif;
    background-color: #e3f2fd; /* Azul claro */
    border-radius: 8px;
    padding: 20px;
    max-width: 700px;
    margin:1% auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    animation: modalFadeIn 0.5s ease-in-out;
    } 
 
@keyframes modalFadeIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

    .close {
        color: black;
        float: right;
        font-size: 15px;
        font-weight: bold;
    }
    .close:hover, .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    .cv-vitae {
        font-family: 'Arial', sans-serif;
    background-color: #ffff; /* Azul claro */
    border-radius: 8px;
    padding: 20px;
    max-width: 600px;
    margin: auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    animation: fadeIn 0.5s;
    }
    .cv-vitae h2 {
        font-family: 'Arial', sans-serif;
    background-color: #e3f2fd; /* Azul claro */
    border-radius: 8px;
    padding: 20px;
    max-width: 700px;
    margin: auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    animation: fadeIn 0.5s;
    }
    .cv-vitae p {
        margin: 5px 0;
        font-size:14px;
    }
    .cv-vitae label {
        font-weight: bold;
        
    }
</style>
<script>


// Función para abrir el modal de edición con los datos de la persona
function openEditModal(id, nombre, apellido, cedula, correo, nacimiento, ingreso, cargo) {
    document.getElementById('modal-id').value = id;
    document.getElementById('modal-nombre').value = nombre;
    document.getElementById('modal-apellido').value = apellido;
    document.getElementById('modal-cedula').value = cedula;
    document.getElementById('modal-correo').value = correo;
    document.getElementById('modal-nacimiento').value = nacimiento;
    document.getElementById('modal-ingreso').value = ingreso;
    document.getElementById('modal-cargo').value = cargo;
    document.getElementById('editModal').style.display = "block";
}

// Función para abrir el modal de vista previa con los datos de la persona
function openPreviewModal(id, nombre, apellido, cedula, correo, nacimiento, ingreso, cargo) {
    const previewContent = `
        <div class="cv-vitae">
        <div class align="center">
    <h2 style="color: #2378b6;">Vista Previa</h2>
</div><br>

            <p><label>Nombre:</label> ${nombre}</p>  <br>
            <p><label>Apellido:</label> ${apellido}</p>  <br>
            <p><label>Cédula:</label> ${cedula}</p>  <br>
            <p><label>Correo:</label> ${correo}</p>  <br>
            <p><label>Fecha de Nacimiento:</label> ${nacimiento}</p>  <br>
            <p><label>Fecha de Ingreso:</label> ${ingreso}</p>  <br>
            <p><label>Cargo:</label> ${cargo}</p>  <br>
        </div>
    `;
    document.getElementById('previewContent').innerHTML = previewContent;
    document.getElementById('previewModal').style.display = "block";
}

// Función para cerrar el modal
function closeModal() {
    document.getElementById('editModal').style.display = "none";
    document.getElementById('previewModal').style.display = "none";
}

// Código actualizado para alternar el estado de la fila


    </script>
</body>
</html>

