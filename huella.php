
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

    
    width: 300px;
    margin:auto;
    padding: 3em 2em 2em 2em;
    background-color:rgb(255,255,255, 0.8) ;
    border: 0px solid #fff;
    box-shadow: rgba(2,2,5,5) 0px 1px 4px 0px;
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

   
width:100px;
height:auto;
}



.group { 
    position: relative; 
    margin-bottom: 5px;
}

input{
  
    font-size: 15px;
    padding: 25px 10px 10px 6px;
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
    top: 2px;
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



</style>

<div class="login-container">
    <div class="logo-container">
        <img src="edupal.png" alt="" border="0"/>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<form action="validar_cedula.php" method="post">
    <div class="group">
        <div class="form">
            <input type="text" id="cedula" name="cedula" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label for="cedula">Ingrese su cédula</label>
            <br><br>
            <button type="button" class="button" onclick="validarCedula()">Aceptar</button>
            <a href="inicio.html"><button type="button" class="button">Volver</button></a>
        </div>
    </div>
</form>


<head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<script>
function validarCedula() {
    const cedulaInput = document.getElementById('cedula');
    let cedula = cedulaInput.value;

    // Agregar automáticamente el prefijo "V-" si no está presente
    if (!cedula.startsWith("V-")) {
        cedula = "V-" + cedula.replace(/\D/g, ""); // Remover caracteres no numéricos
        cedulaInput.value = cedula; // Actualizar el valor en el campo
    }

    // Validar cédula (solo numérica después del prefijo "V-")
    const cedulaPattern = /^V-\d{7,8}$/;
    if (cedula) {
        if (cedulaPattern.test(cedula)) {
            fetch(`verificar_cedula.php?cedula=${cedula}`)
                .then(response => response.text())
                .then(data => {
                    if (data === "existe") {
                        mostrarSelectorTipoAsistencia(cedula);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Cédula no encontrada',
                            text: 'La cédula no existe en el sistema.'
                        });
                    }
                })
                .catch(error => {
                    console.error("Error al verificar la cédula:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error del servidor',
                        text: 'No se pudo verificar la cédula. Inténtelo más tarde.'
                    });
                });
        } else {
            Swal.fire('Formato Inválido', 'La cédula debe comenzar con V- seguido de 7 u 8 números.', 'error');
        }
    } else {
        Swal.fire('Campo Vacío', 'Por favor ingrese su cédula.', 'warning');
    }
}

document.getElementById('cedula').addEventListener('input', function (e) {
    let value = e.target.value.replace(/[^0-9]/g, ""); // Solo permitir números
    e.target.value = `V-${value}`;
});

function mostrarSelectorTipoAsistencia(cedula) {
    Swal.fire({
        title: 'Seleccione el Tipo de Asistencia',
        html: `
        <div style="display: flex; justify-content: center; gap: 20px; align-items: center;">
            <!-- Icono Manual -->
            <div style="text-align: center; display: flex; flex-direction: column; align-items: center;">
                <a href="#" style="cursor: pointer; text-decoration: none;" onclick="mostrarModalAsistencia('manual', '${cedula}')" title="Asistencia Manual">
                    <i class="fas fa-user-edit" style="font-size: 50px; color: #007bff;"></i>
                </a>
                <p style="margin: 5px 0; font-size: 18px; font-weight: bold;">Manual</p>
            </div>
            <!-- Icono Huella -->
            <div style="text-align: center; display: flex; flex-direction: column; align-items: center;">
                <a href="#" style="cursor: pointer; text-decoration: none;" onclick="mostrarModalAsistencia('huella', '${cedula}')" title="Huella Dactilar">
                    <i class="fas fa-fingerprint" style="font-size: 50px; color: #007bff;"></i>
                </a>
                <p style="margin: 5px 0; font-size: 18px; font-weight: bold;">Huella</p>
            </div>
        </div>
        `,
        showCloseButton: true,
        showConfirmButton: false
    });
}

function mostrarModalAsistencia(tipo, cedula) {
    Swal.fire({
        title: 'Marque su Asistencia',
        html: `
        <div style="display: flex; justify-content: center; align-items: center; margin-top: 20px; gap: 80px;">
            <!-- Icono Entrada -->
            <div style="display: flex; flex-direction: column; align-items: center;">
                <i class="fas fa-user-check" style="color: #1E90FF; font-size: 48px;"></i>
                <i id="flechaEntrada" class="fas fa-arrow-circle-left" style="color: #1E90FF; font-size: 36px; cursor: pointer;" title="Registrar Hora de Entrada"></i>
                <span style="margin-top: 10px; font-weight: bold;">Entrada</span>
            </div>
            <!-- Icono Salida -->
            <div style="display: flex; flex-direction: column; align-items: center;">
                <i class="fas fa-user-check" style="color: #2378b6; font-size: 48px;"></i>
                <i id="flechaSalida" class="fas fa-arrow-circle-right" style="color: #2378b6; font-size: 36px; cursor: pointer;" title="Registrar Hora de Salida"></i>
                <span style="margin-top: 10px; font-weight: bold;">Salida</span>
            </div>
        </div>
        `,
        showCloseButton: true,
        showConfirmButton: false
    });

    document.getElementById('flechaEntrada').onclick = () => {
        if (tipo === 'manual') {
            mostrarModalHoraEntrada(cedula);
        } else {
            registrarEntradaConHuella('entrada', cedula);
        }
    };

    document.getElementById('flechaSalida').onclick = () => {
        if (tipo === 'manual') {
            mostrarModalHoraSalida(cedula);
        } else {
            registrarSalidaConHuella('salida', cedula);
        }
    };
}


function registrarEntradaConHuella(cedula) {
    const horaActual = new Date().toLocaleTimeString('en-US', { hour12: false });
    const fechaActual = obtenerFechaActual();

    Swal.fire({
        title: 'Procesando Huella',
        text: 'Por favor espere mientras verificamos su huella...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch(`registra_entrada.php?cedula=${cedula}&hora_entrada=${horaActual}&fecha=${fechaActual}`)
        .then(response => response.json())
        .then(data => {
            Swal.close();
            if (data.success) {
                Swal.fire('Entrada Registrada', `Hora: ${horaActual}\nFecha: ${fechaActual}`, 'success');
            } else {
                Swal.fire('Error', data.error || 'No se pudo registrar la entrada.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Hubo un error al registrar la entrada.', 'error');
        });
}

function registrarSalidaConHuella(cedula) {
    const horaActual = new Date().toLocaleTimeString('en-US', { hour12: false });
    const fechaActual = obtenerFechaActual();

    Swal.fire({
        title: 'Procesando Huella',
        text: 'Por favor espere mientras verificamos su huella...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch(`registra_salida.php?cedula=${cedula}&hora_salida=${horaActual}&fecha=${fechaActual}`)
        .then(response => response.json())
        .then(data => {
            Swal.close();
            if (data.success) {
                Swal.fire('Salida Registrada', `Hora: ${horaActual}\nFecha: ${fechaActual}`, 'success');
            } else {
                Swal.fire('Error', data.error || 'No se pudo registrar la salida.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Hubo un error al registrar la salida.', 'error');
        });
}

function verificarRegistroCompleto(cedula) {
    fetch(`verificar_registro.php?cedula=${cedula}`)
        .then(response => response.json())
        .then(data => {
            if (data.registroCompleto) {
                Swal.fire('Registro Completado', 'Este usuario ya completó su registro diario.', 'info');
            } else {
                mostrarOpcionesDeRegistro(cedula);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Hubo un error al verificar el estado de registro.', 'error');
        });
}

function mostrarOpcionesDeRegistro(cedula) {
    Swal.fire({
        title: 'Seleccionar Acción',
        text: '¿Qué acción desea realizar?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Registrar Entrada',
        cancelButtonText: 'Registrar Salida'
    }).then((result) => {
        if (result.isConfirmed) {
            mostrarModalHoraEntrada(cedula);
        } else {
            mostrarModalHoraSalida(cedula);
        }
    });
}

function mostrarModalHoraEntrada(cedula) {
    const horaActual = new Date().toLocaleTimeString('en-US', { hour12: false });
    const fechaActual = obtenerFechaActual();
    Swal.fire({
        title: 'Confirmar Hora de Entrada',
        text: `Hora: ${horaActual}\nFecha: ${fechaActual}`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Registrar Entrada',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            registrarHoraEntrada(cedula, fechaActual, horaActual);
        }
    });
}

function mostrarModalHoraSalida(cedula) {
    const horaActual = new Date().toLocaleTimeString('en-US', { hour12: false });
    const fechaActual = obtenerFechaActual();
    Swal.fire({
        title: 'Confirmar Hora de Salida',
        text: `Hora: ${horaActual}\nFecha: ${fechaActual}`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Registrar Salida',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            registrarHoraSalida(cedula, fechaActual, horaActual);
        }
    });
}

function registrarHoraEntrada(cedula, fecha, hora) {
    fetch(`registra_entrada.php?cedula=${cedula}&hora_entrada=${hora}&fecha=${fecha}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire('Entrada Registrada', `Hora: ${hora}\nFecha: ${fecha}`, 'success');
            } else {
                Swal.fire('Error', data.error || 'No se pudo registrar la entrada.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Hubo un error al registrar la entrada.', 'error');
        });
}

function registrarHoraSalida(cedula, fecha, hora) {
    fetch(`registra_salida.php?cedula=${cedula}&hora_salida=${hora}&fecha=${fecha}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire('Salida Registrada', `Hora: ${hora}\nFecha: ${fecha}\nAsistencia diaria completada.`, 'success');
            } else {
                Swal.fire('Error', data.error || 'No se pudo registrar la salida.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Hubo un error al registrar la salida.', 'error');
        });
}

function obtenerFechaActual() {
    const hoy = new Date();
    const año = hoy.getFullYear();
    const mes = String(hoy.getMonth() + 1).padStart(2, '0');
    const dia = String(hoy.getDate()).padStart(2, '0');
    return `${año}-${mes}-${dia}`;
}
</script>
</body></html>