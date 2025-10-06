<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    $response = array();

    $conn = new mysqli("localhost", "root", "", "base_kam");

    if ($conn->connect_error) {
        $response['status'] = 'error';
        $response['message'] = 'Conexión fallida: ' . $conn->connect_error;
    } else {
        $stmt = $conn->prepare("SELECT usuario FROM usuarios WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $response['status'] = 'error';
            $response['message'] = 'Usuario ya existe, intente con otro usuario.';
        } else {
            if ($contrasena != $confirmar_contrasena) {
                $response['status'] = 'error';
                $response['message'] = 'Las contraseñas no coinciden.';
            } else {
                $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO usuarios (usuario, correo, contrasena) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $usuario, $correo, $hashed_password);
                if ($stmt->execute()) {
                    $response['status'] = 'success';
                    $response['message'] = 'Registro exitoso.';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Error: ' . $stmt->error;
                }
                $stmt->close();
            }
        }

        $conn->close();
    }

    // Enviar la respuesta como JSON
    echo json_encode($response);
    exit;
}
?>


<!DOCTYPE html>
<html lagn="es">
<meta charset="UTF-8"> 
<div class align ="center">
   
    <title>KAM</title>
    <link rel="stylesheet" href="estilo.css">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script>
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
            
 margin: 0;
      background-image: url("FONDO2 (1).png");
      background-size: 85,15%;
      background-attachment: fixed;
      background-repeat: no-repeat;
      background-position: top center;
      font-family: sans-serif;

     }

form {
    width: 300px;
    margin:auto;
    padding: 2em 2em 2em 2em;
    background-color:rgb(255,255,255, 0.8) ;
    border: 0px solid #fff;
    box-shadow: rgba(5,2,5,5.14902) 0px 2px 6px 0px;
    
}

.group { 
    position: relative; 
   
    margin-top: 18px;
}

input{

    font-size: 15px;
    padding: 15px 10px 10px 6px;
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
    top: -23px;
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
font-family: Arial, Helvetica, sans-serif;
border :none;
margin-top: 10px;
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

.form-icon{

 margin-left: 195px;
 margin-top:-20px;
 transform:translateY(-100%);
 pointer-events: none; 


}

footer { text-align: center; }

footer a:hover {
    color: #666;
    text-decoration: underline;
}

footer img:focus , footer a:focus { outline: none; }

</style>


<div class align="center">
<div class="login">
<div class="login-triangle"></div>
<div class="login-container">

<form method="post" action="registrar.php">
 <div class="group">
   <label for="usuario"> Usuario<span style="color: red;">*</span></label>
    <input type="text"name="usuario" required><span class="highlight"></span><span class="bar"></span>
   
    </div><br>

 
    <div class="group">
     <label for="email">Correo electr&oacutenico<span style="color: red;">*</span></label>
      <input type="email"  name="correo" required><span class="highlight"></span><span class="bar"></span>
     
      </div><br>

    <div class="group">
      <label for="password">Contraseña <span style="color: red;">*</span></label>
      <input type="password"  name="contrasena" required><span class="highlight"></span><span class="bar"></span>
      
    </div><br>
     
    <div class="group">
     <label for="password">Confirmar contraseña <span style="color: red;">*</span></label>
      <input type="password" name="confirmar_contrasena" required><span class="highlight"></span><span class="bar"></span>


  <br>
  

      <br>

    <a href="#"><button type="submit" class="button"> Registrar</button></a>
   
    <a href="Login.php"><button type="button" class="button">Volver </button></a>

</form>

    </div>

</div>
</body>
</html>
