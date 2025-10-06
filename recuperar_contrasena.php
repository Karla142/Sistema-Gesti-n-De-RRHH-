


<!DOCTYPE html>
<html lagn="es">
<meta charset="UTF-8"> 
<div class align ="center">
   
    <title>KAM</title>


<link rel="" href="cargando.html">
<link rel="" href="Inicio.html">
<link rel="java" href="java inicio.js"> 
<link rel="stylesheet" href="estilo.css">



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
    padding: 3em 2em 2em 2em;
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
font-size:12px;
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

h2{

    color:#2378b6;
    font-size:20px;
}
</style>







<body>
    <div class="login-container">
    <div class="logo-container">
    <img src="edupal.png" width="160" height="80" alt="" border="0"/>
    </div></div>


    <style>
  
    label {
        font-weight: bold;
        margin-bottom: 10px;
        display: inline-block;
    }

    select, input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    select {
        background-color: #f0f8ff;
    }

  
</style>
<form id="formulario">
    <h2>Actualizar Información</h2><br>
    <label for="opcion">¿Qué deseas actualizar?</label>
    <select id="opcion" name="opcion" required>
        <option value="seleccione">Seleccione</option>
        <option value="usuario">Usuario</option>
        <option value="contrasena">Contraseña</option>
    </select>

    <input type="email" name="correo" id="correo" placeholder="Correo electrónico" required>

    <div id="campo_usuario" style="display: none;">
        <input type="text" name="nuevo_usuario" id="nuevo_usuario" placeholder="Nuevo usuario">
        <input type="text" name="token_usuario" id="token_usuario" placeholder="introduzca el token recibido">
    </div>

    <div id="campo_contrasena" style="display: none;">
        <input type="password" name="nueva_contrasena" id="nueva_contrasena" placeholder="Nueva contraseña">
        <input type="text" name="token_contrasena" id="token_contrasena" placeholder="introduzca el token recibido">
    </div>

    <button class="button" type="button" id="enviar_token">Enviar Token</button>
    <button class="button" type="button" id="actualizar_dato">Actualizar</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Mostrar campos según selección
    $("#opcion").change(function() {
        const opcion = $(this).val();
        if (opcion === "usuario") {
            $("#campo_usuario").show();
            $("#campo_contrasena").hide();
        } else if (opcion === "contrasena") {
            $("#campo_usuario").hide();
            $("#campo_contrasena").show();
        }
    });

    // Enviar token al correo
    $("#enviar_token").click(function() {
        const correo = $("#correo").val();

        $.post("enviar_token.php", { correo: correo }, function(response) {
            const res = JSON.parse(response);
            Swal.fire({
                icon: res.status === "success" ? "success" : "error",
                title: res.status === "success" ? "¡Éxito!" : "Error",
                text: res.message,
            });
        });
    });

    // Actualizar usuario o contraseña
    $("#actualizar_dato").click(function() {
        const correo = $("#correo").val();
        const opcion = $("#opcion").val();
        let data = { correo: correo };

        if (opcion === "usuario") {
            data.nuevo_usuario = $("#nuevo_usuario").val();
            data.token = $("#token_usuario").val(); // Token para usuario
            $.post("actualizar_usuario.php", data, function(response) {
                const res = JSON.parse(response);
                if (res.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "¡Éxito!",
                        text: res.message,
                    });
                    $("#formulario")[0].reset(); // Reinicia el formulario
                    $("#campo_usuario, #campo_contrasena").hide(); // Oculta los campos
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: res.message,
                    });
                }
            });
        } else if (opcion === "contrasena") {
            data.nueva_contrasena = $("#nueva_contrasena").val();
            data.token = $("#token_contrasena").val(); // Token para contraseña
            $.post("actualizar_contrasena.php", data, function(response) {
                const res = JSON.parse(response);
                if (res.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "¡Éxito!",
                        text: res.message,
                    });
                    $("#formulario")[0].reset(); // Reinicia el formulario
                    $("#campo_usuario, #campo_contrasena").hide(); // Oculta los campos
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: res.message,
                    });
                }
            });
        }
    });
});
</script>


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
        <a href="Login.php">
          <div  class="floating-button">
        
            <img src="casita.png" width="45" height="40" alt="#">
            <div class="hover-message">Login</div></div>
       </a>

    </body></html>