<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $conn = new mysqli("localhost", "root", "", "base_kam");

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Función para registrar acciones en la bitácora
    function registrarAccion($conn, $usuario, $correo, $accion) {
        $stmt = $conn->prepare("INSERT INTO bitacora (usuario_id, nombre_usuario, correo, accion, fecha_hora) VALUES ((SELECT id FROM usuarios WHERE usuario = ?), ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $usuario, $usuario, $correo, $accion);
        $stmt->execute();
        $stmt->close();
    }

    // Consulta para obtener el usuario, contraseña y nivel
    $stmt = $conn->prepare("SELECT id, contrasena, correo, nivel_usuario FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    $response = array();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_usuario, $hashed_password, $correo, $nivel_usuario);
        $stmt->fetch();

        if (password_verify($contrasena, $hashed_password)) {
            // Almacenar los datos en las variables de sesión
            $_SESSION['usuario'] = $usuario;
            $_SESSION['correo'] = $correo;
            $_SESSION['nivel_usuario'] = $nivel_usuario; // Agregamos el nivel del usuario (Administrador, Secretaria, RRHH, etc.)

            // Registra el inicio de sesión en la bitácora
            registrarAccion($conn, $usuario, $correo, "Inicio de sesión");

            // Incluye más datos en la respuesta
            $response['status'] = 'success';
            $response['message'] = 'Ingreso exitoso!';
            $response['redirect'] = 'principal.php';
            $response['nombre'] = $usuario;
            $response['correo'] = $correo;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Contraseña incorrecta.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Usuario no encontrado.';
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
<div class align ="center">
   
    <title>KAM</title>


<link rel="" href="cargando.html">
<link rel="" href="Inicio.html">
<link rel="java" href="java inicio.js"> 
<link rel="stylesheet" href="estilo.css">
   
       <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
       <script>
        function mostrarMensaje(mensaje, tipo) {
            let iconColor = tipo === 'success' ? '#4caf50' : '#f44336'; // Green for success, red for error
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

        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('form');
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const usuario = form.usuario.value.trim();
                const contrasena = form.contrasena.value.trim();

                if (!usuario || !contrasena) {
                    mostrarMensaje('Por favor, completa todos los campos.', 'error');
                    return;
                }

                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                });

                const result = await response.json();
                mostrarMensaje(result.message, result.status === 'success' ? 'success' : 'error');

                if (result.status === 'success' && result.redirect) {
                    setTimeout(() => {
                        window.location.replace(result.redirect);
                    }, 2000);
                }
            });
        });
    </script>
    <style>
        .mensaje-popup {
            font-size: 0.8rem;
            opacity: 0.8;
        }
        </style>
   <style>

 
* { box-sizing:border-box; 
}

body{
            
      margin: auto;
      background-image: url("FONDO2 (1).png");
      background-size: 85,15%;
      background-attachment: fixed;
      background-repeat: no-repeat;
      background-position: top center;
      font-family: sans-serif;

     }

form {

    width: 320px;
    margin:auto;
    padding: 3em 2em 1em 2em;
    background-color:rgb(255,255,255, 0.8) ;
    border: 0px solid #fff;
    box-shadow: rgba(2,2,5,5) 0px 1px 4px 0px;
}


.form-icon{

 margin-left: 195px;
 margin-top: -8px;
 transform:translateY(-100%);
 pointer-events: none; 


}

.login-container{

position:relative;
width:300px;
}

.logo-container{

position: absolute;
top: -40px;
left:150px;
transform: translate(-50%);

}


.logo-container img{

width:125px;
height:80px;
}

.group { 
    position: relative; 
    margin-bottom: 20px; 
}


input{

    font-size: 15px;
    padding: 20px 10px 10px 6px;
    display: block;
    background: #fafafa;
    color: #020202;
    width: 100%;
    border: none;
    border-radius: 0;
    border-bottom: 1px solid #757575;
}

input:focus { outline: none; }


label {
    color: #999; 
    font-size: 18px;
    font-weight: normal;
    position: absolute;
    pointer-events: none;
    left: 2px;
    top: -22px;
    transition: all 0.5s ease;
}




input:focus ~ label, input.used ~ label {
    top: -20px;
  transform: scale(.75); left: -2px;

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
    width: 0px;
    bottom: 1px; 
    position: absolute;
    background: #4a89dc; 
    transition: all 0.5s ease;
}

.bar:before { left: 50%; }

.bar:after { right: 50%; }




input:focus ~ .bar:before, input:focus ~ .bar:after { width: 50%; }



/*usuario*/
.highlight {

    position: absolute;
    width: 100px; 
    top: 50%; 
    left: 50px;
    pointer-events:visible;
    opacity: 0.5;
}


input:focus ~ .highlight {
    animation: inputHighlighter 0.3s ease;
}


@keyframes inputHighlighter {
    from { background: #1d68c9; }
    to  { width: 5; background: transparent; }
}

.button{
  
padding: 8px 15px;
font-size: 15px;
background-color: #2378b2;
margin-top: 12px;
font-family: Arial, Helvetica, sans-serif;
border :none;
border-radius: 5px;
cursor: pointer;
}


.button:hover{

background-color: #41a7f5; 


}

.ripples {
  position: center;
  top: 0;
  left: 0;
  width: 70%;
  height: 50%;
  overflow: hidden;
  background: transparent;
}

footer { text-align: center; }

footer a:hover {
    color: #666;
    text-decoration: underline;
}

footer img:focus , footer a:focus { outline: none; }
.error-message {
      background-color: #fff;
      border: 1px solid #007bff;
      border-radius: 5px;
      padding: 10px;
      color: #007bff;
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
        background-color: rgba(0, 0, 0, 0.4); padding-top: 60px;
         } 
         .modal-content { 
          background-color: white;
           margin: 5% auto;
            padding: 20px; 
            border: 1px solid #888;
             width: 80%; 
             max-width: 400px; 
             text-align: center;
              } 
              .close { 
                color: #aaa;
                 float: right;
                  font-size: 28px; 
                  font-weight: bold;
                   } 
                   .close:hover, .close:focus { 
                    color: black; 
                    text-decoration: none;
                     cursor: pointer;
                      } 
                      .message { 
                        color: white; 
                        background-color: #2378b2; padding: 10px;
                         border-radius: 5px; margin-bottom: 10px; 
                       }


</style>
</head>

 
    <script>
        function mostrarError(mensaje) {
            alert(mensaje);
        }

        window.onload = function() {
            <?php if (!empty($error)): ?>
                mostrarError("<?php echo $error; ?>");
            <?php endif; ?>
        }
    </script>


<body>
    <div class="login-container">
    <div class="logo-container">
    <img src="edupal.png" width="160" height="80" alt="" border="0"/>
    </div></div>

    <form id="login-form" method="post" action="Login.php">    
    <div class="group">
        <div class="form">
            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" name="usuario" required>
            <div class="form-icon">
                <img src="silueta.png" width="20" height="15" alt="#">
            </div>
        </div>
    </div>

    <div class="group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="contrasena" required>
    </div>

    <button type="submit" class="button">Continuar</button>
 
    <!-- Espacio añadido entre los botones y el texto -->
    <div style="margin-top: 10px;">
    <a href="recuperar_contrasena.php" style="color: #2378b2; text-decoration: none; font-size: 13px;"
       onmouseover="this.style.color='#5faee3';" 
       onmouseout="this.style.color='#2378b2';">
        ¿Olvidaste tu usuario o contraseña?
    </a>
</div>


</form>

   
   <style>
       .floating-button{

background-color:#2378b2; 
opacity:60%;
padding-top: 4px;
border:none;
border-radius:50%;
width:60px;
height: 55px;
position:fixed;
bottom: 35px;
right: 20px;
cursor:pointer; 
}


       .hover-message {
           display: none;
           position: absolute;
           top: -30px; /* Ajusta la posición como sea necesario */
     left:10%;
           background-color: rgba(0, 0, 0, 0.8); /* Fondo negro con opacidad */
           color: white; /* Letras blancas */
          font-size: 15px;
           border-radius: 5px;
          padding: 4px;
           z-index: 2; /* Coloca el mensaje detrás de la imagen */
           opacity: 0.9; /* Ajusta la opacidad */
       }

       .floating-button:hover .hover-message {
           display: block; /* Muestra el mensaje al pasar el ratón */
       }
   </style>
        <a href="inicio.html">
          <div  class="floating-button">
        
            <img src="casita.png" width="45" height="40" alt="#">
            <div class="hover-message">Inicio</div></div>
       </a>

   



  <script>
    $(document).ready(function() {
      $("#login-form").submit(function(e) {
        e.preventDefault(); // Evita el envío del formulario por defecto

        // Validación básica del lado del cliente
        var usuario = $("#usuario").val();
        var contrasena = $("#contrasena").val();

        if (usuario === "" || contrasena === "") {
          alert("Por favor, complete todos los campos.");
          return false;
        }

        // Envío del formulario al servidor
        $.ajax({
          url: "Login.php",
          type: "POST",
          data: $(this).serialize(),
          success: function(response) {
            if (response === "") {
              window.location.href = "principal.php";
            } else {
        

              alert(response);
            }
          }
        });
      });
    });

       
  </script>
   
</body>
</html>

