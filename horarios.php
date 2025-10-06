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
                text: 'No tienes permiso para acceder al módulo horarios',
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>KAM</title>
 
    
    
  <style>

/*estilo de fondo*/

body{

	  background:url(FONDO3.jpg) no-repeat;
  	  background-size: 110%;
  	  margin:auto;
      background-attachment: fixed;
      background-repeat: no-repeat;
      background-position: top center;
      font-family: sans-serif;


}


/*posicion logos*/
.container{
display: flex;
justify-content: space-around;

}

.section{

    text-align: center;
    margin-left: 4em;
    margin-right: 4em;
}
.logo-container{

position:absolute;
top:10px;
right:10px;

}
.containe{



margin:0px; 

}
.logo{

position:absolute;
top:20px;
right:0px;

}
.image{

position:relative;
display: flex;
  margin-top: 20px;
margin: 20px 0px;

}


@media (max-width: 600px) {
  table, th, td {
    display: block;
    width: 100%;
  }
}

table {
  width: 80%;
  border-collapse: collapse;
}

th, td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: center;
}

th {
  background-color: #f2f2f2;
  color: black;
}
    .modules-container {
            display: flex;
            justify-content: center; 
            flex-wrap: wrap;
            
        }

        .module { 
            width: 250px;
            height: 300px;
            background-color: #fff;
            border: 1px solid #ccc;
            text-align: center;
            padding: 20px;
       
            margin: 60px;
            border-radius: 20px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: center; 
            align-items: center;
        }
.module:hover {
            background-color: #B1D0E2;
        }
        .module i {
            font-size: 30px;
            color: #333;
            margin-bottom: 10px;
        }

        .module h2 {
    font-family: 'Arial', sans-serif;
    font-size: 30px;
    font-weight: bold;
    color: #2378B2;

}

.module img {
    width: 200px;
    height: 150px;
}


button {
  background-color: #ffffff; 
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px; 
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 4px;
}

button:hover {
            background-color: #B1D0E2;
            
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
        top: 40px;
        left: 12px;
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
    <div class="fixed-message">Principal / Horarios</div>
</div><br><br>
<br><br>



    <div class="containe"> 
	<div class="logo">

<img src="edupalcubo.png" width="120" height="85"   alt="perfil">
 	
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
          <div class align="left">
            <div class="p">
              <h2>Perfil de Usuario</h2>
              <p><strong>Nombre de Usuario:</strong> <?php echo htmlspecialchars($usuario); ?></p>
              <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($correo); ?></p>
     
              </div>
          </div>
      </div>
  </div>
    <body><br><br>

        <div class="letra">
            <h1>Gestión De Horarios</h1>
            </div>
    <div class="modules-container">
        <div class="module">
        <button>
          <li></li>
          <a href="PREESCOLAR1.php">
  <img src="reloj_horario.png" alt="Preescolar"></a>
  <h2> Preescolar</h2>
 </button>

        </div>
        <div class="module">
       <button>
        <a href="PRIMARIA2.php">
  <img src="reloj_horario.png" alt="Primaria"></a>
  <h2>Primaria</h2>
 </button>
        </div>
        <div class="module">
     <button><a href="MEDIA_GENERAL3.php">
  <img src="reloj_horario.png" alt="Media General "></a>
  <h2> Media General</h2>
 </button>
        </div>
    </div>
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
              margin-top:-27px;
              right: 110px;
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
.p{
    color:#2378b6;
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
