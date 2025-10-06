<?php
$conn_base_kam = new mysqli('localhost', 'root', '', 'base_kam');
$conn_base_ka = new mysqli('localhost', 'root', '', 'base_ka');

if ($conn_base_kam->connect_error || $conn_base_ka->connect_error) {
    die("Error de conexión a las bases de datos.");
}

$mensaje = "";
$datos_profesor = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cedula'])) {
    $cedula = trim($_POST['cedula']);

    // Verificar existencia del profesor
    $sql_validar = "SELECT id_personal, nombre_personal, apellido_personal FROM base_kam.persona WHERE cedula_personal = ?";
    $stmt = $conn_base_kam->prepare($sql_validar);

    if (!$stmt) {
        die("<p class='alert alert-danger'>Error en la consulta: " . $conn_base_kam->error . "</p>");
    }

    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_personal, $nombre, $apellido);
        $stmt->fetch();
        $datos_profesor = "<p class='alert alert-info'><strong>Profesor:</strong> $nombre $apellido</p>";
    } else {
        $mensaje = "<p class='alert alert-danger'>Error: La cédula no está registrada.</p>";
    }
    $stmt->close();
}

$conn_base_kam->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Horarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        #formularioHorario {
            display: none;
            opacity: 0;
            transform: scale(0.5);
            transition: opacity 0.4s ease, transform 0.4s ease;
            max-width: 600px;
        }
        #formularioHorario.mostrar {
            display: block;
            opacity: 1;
            transform: scale(1);
        }
    </style>
</head>
<body>

<div class="container text-center">
    <h2>Gestión de Horarios</h2>
    <button class="btn btn-primary mt-3" onclick="mostrarFormulario()">Añadir Horario</button>

    <div id="formularioHorario" class="card p-4 mt-4 shadow">
        <?= $mensaje ?>

        <h4 class="text-center">Registro de Horario</h4>

        <!-- Formulario -->
        <form method="POST">
            <div class="input-group mb-3">
                <input type="text" name="cedula" id="cedula" class="form-control" placeholder="Ingrese la cédula" required>
                <button type="button" class="btn btn-secondary" onclick="verificarCedula()">Verificar</button>
            </div>

            <div id="datosProfesor"><?= $datos_profesor ?></div>

            <label>Materia:</label>
            <select name="id_materia" class="form-control mb-2">
                <option value="1">Matemáticas</option>
                <option value="2">Historia</option>
                <option value="nuevo">Añadir Nueva Materia</option>
            </select>

            <label>Hora Inicio:</label>
            <input type="time" name="hora_inicio" class="form-control mb-2" required>

            <label>Hora Fin:</label>
            <input type="time" name="hora_fin" class="form-control mb-2" required>

            <label>Total de Horas:</label>
            <input type="number" name="total_horas" class="form-control mb-2" readonly>

            <h5>Tipo de Horario:</h5>
            <div class="mb-2">
                <input type="radio" name="tipo_horario" value="Parcial" onclick="mostrarHorario('Parcial')"> Parcial
                <input type="radio" name="tipo_horario" value="Completo" onclick="mostrarHorario('Completo')"> Completo
            </div>

            <button type="submit" class="btn btn-success btn-sm">Guardar</button>
            <button type="button" class="btn btn-danger btn-sm" onclick="cerrarFormulario()">Cancelar</button>
        </form>
    </div>

    <!-- Tabla de Horarios -->
    <h4 class="mt-5">Horarios Asignados</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Profesor</th>
                <th>Materia</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Total Horas</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí puedes cargar los horarios desde la base de datos -->
        </tbody>
    </table>
</div>

<script>
function mostrarFormulario() {
    let formulario = document.getElementById("formularioHorario");
    formulario.style.display = "block";
    setTimeout(() => {
        formulario.classList.add("mostrar");
    }, 50);
}

function cerrarFormulario() {
    let formulario = document.getElementById("formularioHorario");
    formulario.classList.remove("mostrar");
    setTimeout(() => {
        formulario.style.display = "none";
    }, 400);
}

function verificarCedula() {
    let cedula = document.getElementById("cedula").value;
    fetch("verificar_profesor.php?cedula=" + cedula)
        .then(response => response.text())
        .then(data => document.getElementById("datosProfesor").innerHTML = data);
}

document.querySelector("[name='hora_inicio']").addEventListener("change", calcularHoras);
document.querySelector("[name='hora_fin']").addEventListener("change", calcularHoras);

function calcularHoras() {
    let inicio = document.querySelector("[name='hora_inicio']").value;
    let fin = document.querySelector("[name='hora_fin']").value;
    
    if (inicio && fin) {
        let inicioDate = new Date("2000-01-01 " + inicio);
        let finDate = new Date("2000-01-01 " + fin);
        let horas = (finDate - inicioDate) / (1000 * 60 * 60);
        document.querySelector("[name='total_horas']").value = horas;
    }
}
</script>

</body>
</html>
