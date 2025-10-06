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
        margin-top: 25px;
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

<head>
  <!-- Biblioteca FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
  <h1>Gestión de Usuario</h1>


<style>

  /* Modal general */
.modal {
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);
}

/* Contenido del modal */
.modal-contenido {
  background-color: rgb(255, 255, 255, 0.8);
  margin: 3% auto;
  padding: 2em 3em 2em 2em;
  width: 300px;
  border: 0px solid #fff;
  box-shadow: rgba(5, 2, 5, 0.5) 0px 2px 6px 0px;
  border-radius: 10px;
  position: relative;
}

/* Botón de cierre */
.cerrar {
  color: #999;
  font-size: 28px;
  font-weight: bold;
  position: absolute;
  right: 15px;
  top: 10px;
  cursor: pointer;
}

.cerrar:hover {
  color: #666;
}
/* Estilos generales del formulario */
.group {
  margin-bottom: 15px;
}

label {
  color: #333;
  font-size: 15px;
  font-weight: bold;
  display: block; /* Etiqueta encima del campo */
  margin-bottom: 5px;
}

input {
  font-size: 15px;
  padding: 10px;
  display: block;
  background: #fafafa;
  color: #020202;
  width: 99%;
  border: none;
  border-bottom: 1px solid #757575;
}

input:focus {
  outline: none;
  border-bottom: 1px solid #2378b6;
}
button {
      background-color: #2378b6;
      color: white;
      padding: 12px 15px;
      border-radius: 5px;
      border:none;
      font-size: 12px;
      cursor: pointer;
      transition: background-color 0.3s;
   
    }

    button:hover {
      background-color: #41a7f5;
    }



input:focus ~ label, input.used ~ label {
  top: -20px;
  transform: scale(0.75);
  left: -2px;
  color: #2378b6;
}

.bar {
  position: relative;
  display: block;
  width: 100%;
}

.bar:before, .bar:after {
  content: '';
  height: 2px;
  width: 0;
  bottom: 1px;
  position: absolute;
  background: #4a89dc;
  transition: all 0.5s ease;
}

.bar:before {
  left: 50%;
}

.bar:after {
  right: 50%;
}

input:focus ~ .bar:before, input:focus ~ .bar:after {
  width: 50%;
}

/* Animación de highlight */
.highlight {
  position: absolute;
  width: 100px;
  top: 50%;
  left: 50px;
  pointer-events: visible;
  opacity: 0.5;
}

input:focus ~ .highlight {
  animation: inputHighlighter 0.3s ease;
}

@keyframes inputHighlighter {
  from {
    background: #1d68c9;
  }
  to {
    width: 5;
    background: transparent;
  }
}


.mensaje-popup {
            font-size: 0.8rem;
            opacity: 0.8;
        }
        select {
  font-size: 15px;
  padding: 10px;
  width: 105%;
  background: #fafafa;
  color: #020202;
  border: none;
  border-bottom: 1px solid #757575;
}

select:focus {
  outline: none;
  border-bottom: 1px solid #2378b6;
}

</style>
<!-- Botón para abrir el modal -->
<div class="right">
  <button id="btnAbrirModal" class="button">Añadir usuario</button>
</div>
<!-- Modal -->
<!-- Modal -->
<div id="miModal" class="modal" style="display:none;">
  <div class="modal-contenido">
    <span id="cerrarModal" class="cerrar">&times;</span>
    <!-- Formulario dentro del modal -->
    <form method="post" action="registrar.php">
      <div class="group">
        <label for="usuario">Usuario<span style="color: red;">*</span></label>
        <input type="text" name="usuario" required>
      </div><br>
      <div class="group">
        <label for="nivel_usuario">Nivel de usuario<span style="color: red;">*</span></label>
        <select name="nivel_usuario" required>
          <option value="" disabled selected>Seleccione una opción</option>
          <option value="administrador">Administrador</option>
          <option value="secretaria">Secretaria</option>
          <option value="recursos_humanos">Recursos Humanos</option>
        </select>
      </div><br>
      <div class="group">
        <label for="correo">Correo electr&oacute;nico<span style="color: red;">*</span></label>
        <input type="email" name="correo" required>
      </div><br>

      <div class="group">
        <label for="contrasena">Contraseña<span style="color: red;">*</span></label>
        <input type="password" name="contrasena" required>
      </div><br>

      <div class="group">
        <label for="confirmar_contrasena">Confirmar contraseña<span style="color: red;">*</span></label>
        <input type="password" name="confirmar_contrasena" required>
      </div><br>

    
<div class align="center">
      <button type="submit" class="button">Registrar</button>  </div>
    </form>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script>

document.getElementById('btnAbrirModal').onclick = function() {
  document.getElementById('miModal').style.display = 'block';
};

document.getElementById('cerrarModal').onclick = function() {
  document.getElementById('miModal').style.display = 'none';
};

window.onclick = function(event) {
  if (event.target == document.getElementById('miModal')) {
    document.getElementById('miModal').style.display = 'none';
  }
};

function mostrarMensaje(mensaje, tipo) {
    let iconColor = tipo === 'success' ? '#4caf50' : '#f44336'; // Verde para éxito, rojo para error
    Swal.fire({
        icon: tipo,
        title: mensaje,
        background: 'white',
        iconColor: iconColor,
        color: 'black',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: {
            popup: 'mensaje-popup'
        }
    });
}

function redireccionarExito() {
    // Cambia la URL de redirección por la que necesites
    window.location.href = 'http://localhost/html/Configuracion.php';
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const usuario = form.usuario.value.trim();
        const correo = form.correo.value.trim();
        const contrasena = form.contrasena.value.trim();
        const confirmar_contrasena = form.confirmar_contrasena.value.trim();

        if (!usuario || !correo || !contrasena || !confirmar_contrasena) {
            mostrarMensaje('Por favor, completa todos los campos.', 'error');
            return;
        }

        const contrasenaRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[._*]).{8,}$/;
        if (!contrasenaRegex.test(contrasena)) {
            mostrarMensaje('La contraseña debe tener mínimo 8 caracteres, incluyendo una letra mayúscula, un número y un símbolo (., *, _).', 'error');
            return;
        }

        const formData = new FormData(form);
        const response = await fetch(form.action, { method: 'POST', body: formData });
        const result = await response.json();

        mostrarMensaje(result.message, result.status === 'success' ? 'success' : 'error');

        if (result.status === 'success') {
            redireccionarExito();
            limpiarFormulario();
        }
    });
});
</script>

<div class align="center">
  <table id="dataTable">
    <thead>
      <tr>
        <th>N° Usuario</th>
        <th>Usuario</th>
        <th>Correo</th>
        <th>Rol</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <!-- Datos dinámicos llenados con JavaScript -->
    </tbody>
  </table>
  </div></div>
  <style>
  /* Centrar el modal */
.swal2-popup {
  font-size: 1rem; /* Ajusta el tamaño de fuente */
  width: 400px; /* Tamaño adecuado para el modal */
}

.swal2-input,
.swal2-select {
  display: block;
  width: 90%; /* Haz que todos los campos ocupen el mismo espacio */
  margin: 0 auto 15px auto; /* Centra los campos y añade espacio entre ellos */
  font-size: 16px; /* Tamaño de texto más legible */
  padding: 10px; /* Más espacio dentro del campo */
  border: 1px solid #ccc; /* Borde estándar */
  border-radius: 5px; /* Bordes redondeados */
}

.swal2-select {
  text-align: left; /* Asegura que el texto del select esté alineado */
}

.swal2-title {
  font-size: 20px; /* Tamaño de título mejorado */
  margin-bottom: 20px; /* Espacio entre el título y los campos */
}

.swal2-confirm {
  background-color: #4CAF50; /* Color verde para el botón guardar */
  color: white; /* Color del texto */
  border-radius: 5px; /* Bordes redondeados */
  padding: 10px 20px; /* Ajusta el tamaño del botón */
}

.swal2-cancel {
  background-color: #f44336; /* Color rojo para cancelar */
  color: white; /* Color del texto */
  border-radius: 5px; /* Bordes redondeados */
  padding: 10px 20px; /* Ajusta el tamaño del botón */
}
</style>
<script>
document.addEventListener('DOMContentLoaded', () => {
  cargarUsuarios();
});

// Función para cargar usuarios desde la API
function cargarUsuarios() {
  fetch('api_usuarios.php')
    .then((response) => {
      if (!response.ok) throw new Error('Error al obtener los usuarios.');
      return response.json();
    })
    .then((data) => {
      const userTableBody = document.querySelector('#dataTable tbody');
      userTableBody.innerHTML = ''; // Limpiar tabla antes de cargar datos
      data.forEach((user) => {
        userTableBody.innerHTML += `
          <tr>
            <td>${user.id}</td>
            <td>${user.usuario}</td>
            <td>${user.correo}</td>
            <td>${user.nivel_usuario}</td>
            <td>
              <a href="javascript:editarUsuario(${user.id})" title="Editar">
                <i class="fas fa-edit" style="color:blue; cursor:pointer;"></i>
              </a>
              <a href="javascript:eliminarUsuario(${user.id})" title="Eliminar">
                <i class="fas fa-trash" style="color:red; cursor:pointer;"></i>
              </a>
            </td>
          </tr>`;
      });
    })
    .catch((error) => {
      console.error(error);
      Swal.fire('Error', 'No se pudieron cargar los usuarios.', 'error');
    });
}

// Función para editar usuario con rol
function editarUsuario(id) {
  fetch(`api_usuarios.php?id=${id}`)
    .then((response) => {
      if (!response.ok) throw new Error('Error al cargar los datos del usuario.');
      return response.json();
    })
    .then((data) => {
      Swal.fire({
        title: 'Editar Usuario',
        html: `
          <label for="usuario">Usuario</label>
          <input type="text" id="usuario" class="swal2-input" value="${data.usuario}">
          <label for="correo">Correo</label>
          <input type="email" id="correo" class="swal2-input" value="${data.correo}">
          <label for="nivel_usuario">Rol</label>
          <select id="nivel_usuario" class="swal2-input">
            <option value="administrador" ${data.nivel_usuario === 'administrador' ? 'selected' : ''}>Administrador</option>
            <option value="Secretaria" ${data.nivel_usuario === 'Secretaria' ? 'selected' : ''}>Secretaria</option>
            <option value="RRHH" ${data.nivel_usuario === 'RRHH' ? 'selected' : ''}>RRHH</option>
          </select>
        `,
        confirmButtonText: 'Guardar',
        showCancelButton: true,
        preConfirm: () => {
          const usuario = document.getElementById('usuario').value.trim();
          const correo = document.getElementById('correo').value.trim();
          const nivel_usuario = document.getElementById('nivel_usuario').value;

          if (!usuario || !correo || !nivel_usuario) {
            Swal.showValidationMessage('Todos los campos son obligatorios');
            return null;
          }

          return { usuario, correo, nivel_usuario };
        },
      }).then((result) => {
        if (result.isConfirmed && result.value) {
          fetch(`api_usuarios.php?id=${id}`, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(result.value),
          })
            .then((response) => {
              if (!response.ok) throw new Error('Error al guardar los datos del usuario.');
              return response.json();
            })
            .then(() => {
              Swal.fire('¡Hecho!', 'Usuario actualizado correctamente.', 'success');
              cargarUsuarios();
            })
            .catch((error) => {
              console.error(error);
              Swal.fire('Error', 'No se pudo actualizar el usuario.', 'error');
            });
        }
      });
    })
    .catch((error) => {
      console.error(error);
      Swal.fire('Error', 'No se pudieron cargar los datos del usuario.', 'error');
    });
}

// Función para eliminar usuario
function eliminarUsuario(id) {
  Swal.fire({
    title: '¿Estás seguro?',
    text: "No podrás revertir esta acción.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`api_usuarios.php?id=${id}`, {
        method: 'DELETE',
      })
        .then((response) => {
          if (!response.ok) throw new Error('Error al eliminar el usuario.');
          return response.json();
        })
        .then(() => {
          Swal.fire('¡Eliminado!', 'El usuario ha sido eliminado.', 'success');
          cargarUsuarios();
        })
        .catch((error) => {
          console.error(error);
          Swal.fire('Error', 'No se pudo eliminar el usuario.', 'error');
        });
    }
  });
}

// Función para buscar en la tabla
document.getElementById('searchInput').addEventListener('keyup', function() {
  const filter = document.getElementById('searchInput').value.toUpperCase();
  const table = document.getElementById('dataTable');
  const tr = table.getElementsByTagName('tr');
  
  for (let i = 1; i < tr.length; i++) {
    const td = tr[i].getElementsByTagName('td');
    tr[i].style.display = 'none'; // Ocultar fila por defecto
    for (let j = 0; j < td.length; j++) {
      if (td[j] && td[j].innerHTML.toUpperCase().includes(filter)) {
        tr[i].style.display = ''; // Mostrar fila si coincide
        break;
      }
    }
  }
});

</script>
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