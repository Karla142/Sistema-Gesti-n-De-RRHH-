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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAM</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
 
<style>

/*estilo de fondo*/

body{


      background-image: url("FONDO3.jpg");
      background-size:110%;
      margin: auto;
      background-attachment: fixed;
      background-repeat: no-repeat;
      background-position: top center;
      font-family: sans-serif;

}

.right{

display:flex;
justify-content:right;
margin:0em 0em 0em 0em;

}

.left{

position:absolute;
top:20px;
left:20px;
margin:0em 0em 0em 2em;

}

.container{


margin:2em 0em 0em 0em;

}
.logos{

position:absolute;
margin-top:0px;
right:50px;

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

        .modal {
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

        .modal-content {
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

        .calendar {
            max-width: 500px;
            margin: auto;

        }

        .calendar input[type="date"], .calendar input[type="text"] {
            display: block;
            margin: 10px 0;
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .calendar button {
            display: block;
            width: 50%;
            padding: 10px;
            background-color: #2378b2;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .calendar button:hover {
            background-color: #1e6d99;
        }

        
        .notifications {
            display: none;
            background-color: #fff;
            opacity:70%;
            border-radius: 15px;
            border: 2px solid #2378b6;
    box-shadow: rgba(5,2,5,5.14902) 0px 2px 6px 0px;
            padding: 10px;
            width: 50%;
            margin-top:35px;
            margin-left:30%;
            animation: zoom 0.5s;
        }

         .carousel-container {
      width: 500px; 
      overflow: hidden;
      margin: 0 auto; 
      margin-top: 50px;
      background-color: none; 
      padding: 1px; 
      border-radius: 20px;
      }

    .carousel {
      display: flex;
      transition: transform 0.5s ease-in-out;
    }

    .carousel img {
      width: 100%;
      border-radius: 10px;
    }

    .cerrar {
      cursor: pointer;
      position: absolute;
      top: 80px;
      left: 68%;
      background: #00FF0000; 
      color: white;
      border: none;
      border-radius: 5px;
      padding: 5px 10px;
    }

    .cerrar img {
      width: 20px; 
      height: 20px;
    }

    /* Estilos de las gráficas */
    @keyframes rellenar {
      to {
        stroke-dasharray: var(--porcentaje) 100;
      }
    }

    @keyframes zoom {
      from {
        transform: scale(0);
      }
      to {
        transform: scale(1);
      }
    }

    body {
      font-family: Arial, sans-serif;
      text-align: center;
      color: #2378b6;
      font-size: 20px;
      margin: 3.6em 0em 0em 0em;

    }

    .hidden {
      display: none;
    }

 .modulo {
      display: flex; /* Usar flexbox para alinear elementos */
      align-items: center; /* Centra verticalmente los elementos */
      background-color: #00FF0000; 
      padding: 0px; 
      border-radius: 10px; 
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
      width: 260px;
      height: 180px;
      margin-left: 45px;
      margin-top: 28px;
      align-items: center;
    }
    .grafica {
   
      width: 400px;
      height: 400px;
      border-left: 2px solid black;
      border-bottom: 2px solid black;
      position: relative;
      margin: 20px auto;
    }

    .barra {
      position: absolute;
      bottom: 0;
      width: 60px;
      background-color: #2378b6;
      text-align: center;
      color: white;
      font-size: 14px;
      transition: height 1s ease-in-out; 
      border-top-right-radius: 30px;
      border-top-left-radius: 30px;
    }

    .barra span {
      position: absolute;
      top: -50px;
      left: 50%;
      transform: translateX(-50%);
    }

    .eje-x {
      position: absolute;
      bottom: -0px;
      width: 100%;
      display: flex;
      justify-content: space-around;
      font-size: 14px;
    }

    .titulo {
      margin-bottom: 20px;
      font-size: 20px;
      font-weight: bold;
    }

    .eje-y {
      position: absolute;
      left: -30px;
      top: 0;
      height: 80%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      font-size: 14px;
    }

    .linea {
      position: absolute;
      width: 60%;
      height: 1px;
      background-color: #ccc;
    }

     circle {
      fill: none;
      stroke-width: 15px; /* Ancho del trazo ajustado */
      transform: rotate(-90deg);
      transform-origin: 50%;
      stroke-dasharray: 90 90;
      stroke: white;
    }

    circle:nth-child(2) {
      stroke: var(--color);
      stroke-dasharray: 0 100;
      animation: rellenar .35s linear forwards;
    }

 .porcentajes {
      position: relative;
      margin-right: 2px; /* Espacio entre la gráfica y el título */
    }

    .porcentajes span {
      position: absolute;
      top: 50%; /* Centra verticalmente el texto */
      left: 50%; /* Centra horizontalmente el texto */
      transform: translate(-50%, -50%); /* Ajusta la posición del texto */
      font: 15px/1em Verdana; /* Tamaño de fuente ajustado */
      color: black;
    }


    .modulo_grafica {
      display: inline-block;
      background-color:#00FF0000;
      padding: 10px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 505px;
      align-items: center;
      margin-top: -500%;
      margin-left: 2%;
    
    
    }


.modulo_1 {
      display: flex; /* Usar flexbox para alinear elementos */
      flex-direction: column; /* Cambia a columna para que el título esté arriba */
      align-items: center; /* Centra horizontalmente los elementos */
      background-color: #00FF0000; 
      padding: 10px; 
      border-radius: 20px; 
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); 
      width: 200px;
      margin-left: 80%;
      margin-top: -350px; 

    }


    .grafica {
      display: inline-block;
      width: 310px;
      height: 200px;
      border-left: 2px solid black;
      border-bottom: 2px solid black;
      position: relative;
      margin: 20px auto;
    }

    .barra {
      position: absolute;
      bottom: 0px;
      width: 60px;
      background-color: #2378b6;
      text-align: center;
      color: white;
      font-size: 12px;
      transition: height 1s ease-in-out; 
      border-top-right-radius: 30px;
      border-top-left-radius: 30px;
    }

    .barra span {
      position: absolute;
      top: -20px;
      left: 50%;
      transform: translateX(-50%);
    }

    .eje-x {
      position: absolute;
      bottom: -20px;
      width: 100%;
      display: flex;
      justify-content: space-around;
      font-size: 14px;
    }

    .titulo {
      margin-bottom: 0px;
      font-size: 18px;
      font-weight: bold;
    }

    .eje-y {
      position: absolute;
      left: -30px;
      top: 0;
      height: 60%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      font-size: 14px;
    }

    .linea {
      position: absolute;
      width: 100%;
      height: 1px;
      background-color: #ccc;
    }

 

     
    </style>

       

    <div class="left">
        <img src="KAM.png" width="220" height="40" alt="#">
      </div>
  <style>
        .hover-message1, .hover-message2, .hover-message3 {
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

        .hover-container1:hover .hover-message1,
        .hover-container2:hover .hover-message2,
        .hover-container3:hover .hover-message3 {
            display: block;
        }

        .container {
            margin: 0em 0em 0em 0em;
        }

            .logos {
            position: absolute;
            margin-top: -50px;
            right: 50px;
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
        .hover-container1, .hover-container2, .hover-container3 {
            position: relative;
            display: inline-block;
        }
    </style>
</head>
<body>


<body>
<div class="container">
    <div class="logos">
        <div class="hover-container1">
            <a href="#" id="notificationsButton">
                <img src="notificaciones.png" alt="Notificaciones">
                <div class="hover-message1">Notificaciones</div>
            </a>
        </div>
        <div class="hover-container2">
            <a href="#" id="calendarButton">
                <img src="calendario.png" alt="Calendario">
                <div class="hover-message2">Calendario</div>
            </a>
        </div>
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
    <div class="modal-content">
        <span class="close" id="closeProfile">&times;</span>
        <div align="left">
            <h2>Perfil de Usuario</h2>
            <p><strong>Nombre de Usuario:</strong> <?php echo htmlspecialchars($usuario); ?></p>
            <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($correo); ?></p>
   
        </div>
    </div>
</div>
<div id="calendarModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeCalendar">&times;</span>
        <div align="center">
            <h2>Calendario</h2>
        </div>
        <div class="calendar">
            <h6>Fecha de inicio</h6>
            <input type="date" id="startDate" placeholder="Fecha de inicio">
            <h6>Fecha de fin</h6>
            <input type="date" id="endDate" placeholder="Fecha de fin">
            <input type="text" id="commitment" placeholder="Compromiso">
            <div align="center">
                <button id="addCommitment">Agendar</button>
            </div>
        </div>
    </div>
</div>
<div id="notifications" class="modal">
    <div class="modal-content">
        <span class="close" id="closeNotifications">&times;</span>
        <h3>Notificaciones</h3>
        <ul id="notificationList"></ul>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Utilidades para compromisos
    function saveCommitments(commitments) {
        localStorage.setItem('commitments', JSON.stringify(commitments));
    }

    function loadCommitments() {
        const stored = localStorage.getItem('commitments');
        return stored ? JSON.parse(stored) : [];
    }

    function renderCommitments() {
        const list = document.getElementById('notificationList');
        list.innerHTML = '';
        const today = new Date().toISOString().split('T')[0];
        const commitments = loadCommitments();

        commitments.forEach((item, index) => {
            const li = document.createElement('li');
            let status = '';
            if ((item.endDate && item.endDate < today) || (!item.endDate && item.startDate < today)) {
                status = ' ⚠️ Compromiso caducado';
            }
            li.textContent = `Compromiso: ${item.commitment} - Inicio: ${item.startDate}` +
                (item.endDate ? ` - Fin: ${item.endDate}` : '') + status;
            list.appendChild(li);
        });
    }

    // Modal perfil
    const userProfileButton = document.getElementById('userProfileButton');
    const userProfileModal = document.getElementById('userProfileModal');
    const closeProfile = document.getElementById('closeProfile');
    userProfileButton.onclick = () => userProfileModal.style.display = "block";
    closeProfile.onclick = () => userProfileModal.style.display = "none";

    // Modal calendario
    const calendarButton = document.getElementById('calendarButton');
    const calendarModal = document.getElementById('calendarModal');
    const closeCalendar = document.getElementById('closeCalendar');
    const addCommitment = document.getElementById('addCommitment');
    calendarButton.onclick = () => calendarModal.style.display = "block";
    closeCalendar.onclick = () => calendarModal.style.display = "none";

    addCommitment.onclick = function() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        const commitment = document.getElementById('commitment').value;
        const today = new Date().toISOString().split('T')[0];

        if (!startDate || !commitment) {
            Swal.fire('Por favor, complete todos los campos.');
            return;
        }
        if (startDate < today) {
            Swal.fire('Fecha inválida', 'La fecha de inicio no puede ser anterior al día agendado.', 'error');
            return;
        }
        if (endDate && endDate < startDate) {
            Swal.fire('Fecha inválida', 'La fecha de fin no puede ser anterior a la fecha de inicio.', 'error');
            return;
        }

        const commitments = loadCommitments();
        commitments.push({ startDate, endDate, commitment });
        saveCommitments(commitments);
        renderCommitments();

        document.getElementById('startDate').value = '';
        document.getElementById('endDate').value = '';
        document.getElementById('commitment').value = '';
        Swal.fire('Éxito', 'Su compromiso ha sido agendado correctamente', 'success');
        calendarModal.style.display = "none";
    }

    // Modal notificaciones
    const notificationsButton = document.getElementById('notificationsButton');
    const notifications = document.getElementById('notifications');
    const closeNotifications = document.getElementById('closeNotifications');
    notificationsButton.onclick = () => {
        notifications.style.display = "block";
        renderCommitments();
    };
    closeNotifications.onclick = () => notifications.style.display = "none";

    // Cierre de modales al hacer clic fuera
    window.onclick = function(event) {
        if (event.target == userProfileModal) userProfileModal.style.display = "none";
        if (event.target == calendarModal) calendarModal.style.display = "none";
        if (event.target == notifications) notifications.style.display = "none";
    }

    // Alerta automática de compromisos vencidos al cargar
    window.onload = function() {
        renderCommitments();

        const today = new Date().toISOString().split('T')[0];
        const commitments = loadCommitments();
        const expired = commitments.filter(item =>
            (item.endDate && item.endDate < today) ||
            (!item.endDate && item.startDate < today)
        );

        if (expired.length > 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Compromisos vencidos',
                html: `Tienes <strong>${expired.length}</strong> compromiso(s) que ya han caducado.<br>Revisa tus notificaciones para más detalles.`,
                confirmButtonText: 'Entendido'
            });
        }
    };
</script>
<body>

<div class="carousel-container" id="carousel">
    <button class="cerrar" onclick="cerrarCarrusel()">
     
    </button>
    <div class="carousel">
      <img src="bienvenida.png" alt="Imagen 1">
      <img src="carrusel_personal.png" alt="Imagen 2">
    <img src="carrusel_asistencia.png" alt="Imagen 3">
      <img src="carrusel_horario.png" alt="Imagen 4">
      <img src="carrusel_reportes.png" alt="Imagen 5">
      <img src="carrusel_permisos.png" alt="Imagen 6">
      <img src="carrusel_ayuda.png" alt="Imagen 7">
      <img src="carrusel_mante.png" alt="Imagen 8">
    </div>
  </div>

  <!-- Gráficas -->
  <div id="graficas" class="hidden">
    <div class="modulo">
      <div class='porcentajes' style="--porcentaje: 75; --color: #2378b6">
        <svg width="150" height="150">
          <circle r="65" cx="50%" cy="50%" pathlength="100" />
          <circle r="65" cx="50%" cy="50%" pathlength="100" />
        </svg>
        <span>75%</span>
      </div>
      <h5>Personal Activo</h5>
    </div>

    <div class="modulo">
      <div class='porcentajes' style="--porcentaje: 25; --color: #2378b6">
        <svg width="150" height="150">
          <circle r="65" cx="50%" cy="50%" pathlength="100" />
          <circle r="65" cx="50%" cy="50%" pathlength="100" />
        </svg>
        <span>25%</span>
      </div>
      <h5>Personal Inactivo</h5>
    </div>

<div class="modulo_1">
      <div class='porcentajes' style="--porcentaje: 50; --color: #2378b6">
        <svg width="150" height="150">
          <circle r="65" cx="50%" cy="50%" pathlength="100" />
          <circle r="65" cx="50%" cy="50%" pathlength="100" />
        </svg>
        <span>50%</span>
      </div>
      <h5> Horarios Generados</h5>
    </div>
    <div class="modulo_grafica">
      <div class="titulo">Asistencias e Inasistencias</div>
      <div class="grafica">
        <div class="linea" style="bottom: 20%;"></div>
        <div class="linea" style="bottom: 40%;"></div>
        <div class="linea" style="bottom: 60%;"></div>
        <div class="linea" style="bottom: 80%;"></div>
        <div class="eje-y">
          <div>8</div>
          <div>6</div>
          <div>4</div>
          <div>2</div>
          <div>0</div>
        </div>
        <div class="barra" id="asistencias" style="left: 80px; height: 0;">
          <span>5</span>
        </div>
        <div class="barra" id="inasistencias" style="left: 250px; height: 0; background-color: #779ef4;">
          <span>3</span>
        </div>
        <div class="eje-x">
          <div>Asistencias</div>
          <div>Inasistencias</div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const carousel = document.querySelector('.carousel');
    const images = carousel.querySelectorAll('img');
    let currentIndex = 0;

    function nextImage() {
      currentIndex = (currentIndex + 1) % images.length;
      carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
    }

    setInterval(nextImage, 3000); 

    function cerrarCarrusel() {
      const carousel = document.getElementById('carousel');
      const graficas = document.getElementById('graficas');
      carousel.style.display = 'none'; // Oculta el carrusel
      graficas.classList.remove('hidden'); // Muestra las gráficas
    }

    window.onload = function() {
      setTimeout(() => {
        document.getElementById('asistencias').style.height = '83.3%';
        document.getElementById('inasistencias').style.height = '50%';
      }, 500); // Retraso para que la animación de zoom sea visible
    };
  </script>






     <nav class="menu-inferior">
               <li> 
            <a href="principal.html">
                <div class="logo-container">
                    <img src="casita.png" alt="Logo" class="logo">
                    <div class="hover-message">Inicio</div>
                </div>
            </a>
        </li>
        <li> 
            <a href="PERSONAL.php">
                <div class="logo-container">
                    <img src="personal.png" alt="tabla de personal" class="logo">
                    <div class="hover-message">Personal</div>
                </div>
            </a>
        </li>
        <li> 
    <a href="asistencia.php">
                <div class="logo-container">
                    <img src="huella.png" alt="asistencia" class="logo">
                    <div class="hover-message">Asistencia</div>
                </div>
            </a>
        </li>
        <li> 
     <a href="horarios.php">
     <div class="logo-container">
    <img src="Horarios.png" width="40" height="40" alt="horarios" class="logo">
                    <div class="hover-message">Horarios</div>
                </div>
            </a>
        </li>


<li> 
  <a href="MODULOS_REPORTES.php">
    <div class="logo-container">
      <img src="formato.png" width="40" height="40" alt="reportes " class="logo">
     <div class="hover-message">Reportes </div>
    </div>
  </a>
</li>


 <li> 
     <a href="formato.php">
     <div class="logo-container">
    <img src="permisos.png" width="40" height="100" alt="permisos" class="logo">
                    <div class="hover-message">Permisos</div>
                </div>
            </a>
        </li>



<li> 
  <a href="manual.html" style="color: white;">
    <div class="logo-container">
      <img src="ayuda.png" width="40" height="150" alt="horarios" class="logo">
      <div class="hover-message">Ayuda</div>
    </div>
  </a>
</li>



<li> 
     <a href="mantenibilidad.php">
     <div class="logo-container">
    <img src="engranaje2.png" width="40" height="40" alt="horarios" class="logo">
                    <div class="hover-message">Mantenibilidad</div>
                </div>
            </a>
        </li>


      
        <li> 
            <a href="Logout.php">
                <div class="logo-container">
                    <img src="cerrar.png" alt="cerrar" class="logo">
                    <div class="hover-message">Cerrar sesión</div>
                </div>
            </a>
        </li>
    </nav>

    <style>

.menu-inferior {
    list-style: none;
    display: flex;
    justify-content:center;
    color: #333;
    border-radius: 75px;
    position: fixed;
    bottom: 10px;
    left: 10%;
    width: 80%;
    background-color: #2378b6;
}

.menu-inferior li {
    display: inline-block;
    background-color:none;
    list-style: none;
    margin: 0.8em;
    text-align: center; 
}

.menu-inferior img {
    width: 49px;
    height: 41px;
}

.menu-inferior a {
    display: block;
    border-radius: 10px;
    padding: 2px;
}

.logo-container {
    position: relative;
    display: inline-block;
}

.logo {
    width: 150px;
    height: auto;

}

.hover-message {
    display: none;
    position: absolute;
    top: -50px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #333;
    opacity: 60%;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    white-space: nowrap;
    font-size: 0.9em;
}


.menu-inferior a:hover {
    background-color: #64b7f6;
}

.dropdown-menu {
  display: none;
  position: absolute;
  top: -290%;
    background-color: #333;
    opacity: 60%;
    color: #fff;
    padding: 5px 5px;
    border-radius: 10px;
    font-size: 1em;
 
}




.text{

color:#fff ;
font-size: 1px;


}

.logo-container:hover .dropdown-menu{
  display: block;
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





</body>
</html>
