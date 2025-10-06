<?php
include 'conexio.php';

$cedula = $_GET['cedula'] ?? '';
$mensaje = '';

if (!$cedula) {
  echo "<script>
    document.addEventListener('DOMContentLoaded', function () {
      Swal.fire({
        title: 'Error',
        text: '❌ Cédula no proporcionada.',
        icon: 'error',
        confirmButtonColor: '#2378B6'
      });
    });
  </script>";
  exit;
}

// Obtener datos del personal
$queryPersonal = "SELECT nombre, apellido, cargo FROM personal WHERE cedula = '$cedula'";
$resultadoPersonal = mysqli_query($conexion, $queryPersonal);
$personal = mysqli_fetch_assoc($resultadoPersonal);

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $dia = $_POST['dia'];
  $hora = $_POST['hora'];
  $nivel = $_POST['nivel'];
  $seccion = $_POST['seccion'];
  $tipo = $_POST['tipo'];

  $tabla = $tipo === 'parcial' ? 'bloques_parcial' : 'bloques_completo';
  $campoHora = $tipo === 'parcial' ? 'hora' : 'bloque_hora';

  $update = "UPDATE $tabla SET dia='$dia', $campoHora='$hora', nivel='$nivel', seccion='$seccion' WHERE id=$id";
  if (mysqli_query($conexion, $update)) {
    $mensaje = "✅ Cambios actualizados correctamente.";
  } else {
    $mensaje = "❌ Error al actualizar: " . mysqli_error($conexion);
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Editar horario</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
   #modalHorario {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background-color: rgba(0, 0, 0, 0.6);

  display: block;
}


    .modal-contenido {
      background-color: rgba(255, 255, 255, 0.95);
      margin: 5% auto;
      padding: 20px;
      border-radius: 10px;
      width: 80%;
      max-width: 800px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
      position: relative;
    }

    .cerrar-x {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 24px;
      font-weight: bold;
      color: #2378B6;
      cursor: pointer;
      text-decoration: none;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th {
      background-color: #2378B6;
      color: white;
      padding: 8px;
    }

    td {
      padding: 8px;
      border-bottom: 1px solid #ccc;
    }

    input[type="text"] {
      width: 100%;
      padding: 6px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .btn-actualizar {
      background-color: #2378B6;
      color: white;
      padding: 6px 12px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
  </style>
</head>
<body>

<div id="modalHorario">
  <div class="modal-contenido">
    <a href="MEDIA_GENERAL3.php" class="cerrar-x">✖</a>
    <h2 style="color:#2378B6;">Editar horario de <?= htmlspecialchars($personal['nombre'] . ' ' . $personal['apellido']) ?> (<?= htmlspecialchars($personal['cargo']) ?>)</h2>

    <?php
    $queryHorarios = "SELECT h.id AS horario_id, h.tipo, h.total_horas, m.nombre AS materia
                      FROM horarios h
                      JOIN materias m ON h.materia_id = m.id
                      WHERE h.cedula = '$cedula'";
    $resultadoHorarios = mysqli_query($conexion, $queryHorarios);

    while ($horario = mysqli_fetch_array($resultadoHorarios)):
      $tablaBloques = $horario['tipo'] === 'parcial' ? 'bloques_parcial' : 'bloques_completo';
      $campoHora = $horario['tipo'] === 'parcial' ? 'hora' : 'bloque_hora';
      $queryBloques = "SELECT id, dia, $campoHora AS hora, nivel, seccion FROM $tablaBloques WHERE horario_id = {$horario['horario_id']}";
      $resultadoBloques = mysqli_query($conexion, $queryBloques);
    ?>
      <h4 style="color:#2378B6;">Materia: <?= htmlspecialchars($horario['materia']) ?> | Tipo: <?= htmlspecialchars($horario['tipo']) ?> | Total horas: <?= htmlspecialchars($horario['total_horas']) ?></h4>
      <table>
        <thead>
          <tr>
            <th>Día</th>
            <th>Hora/Bloque</th>
            <th>Nivel</th>
            <th>Sección</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($bloque = mysqli_fetch_array($resultadoBloques)): ?>
            <tr>
              <form method="POST">
                <td><input type="text" name="dia" value="<?= htmlspecialchars($bloque['dia']) ?>"></td>
                <td><input type="text" name="hora" value="<?= htmlspecialchars($bloque['hora']) ?>"></td>
                <td><input type="text" name="nivel" value="<?= htmlspecialchars($bloque['nivel']) ?>"></td>
                <td><input type="text" name="seccion" value="<?= htmlspecialchars($bloque['seccion']) ?>"></td>
                <td>
                  <input type="hidden" name="id" value="<?= $bloque['id'] ?>">
                  <input type="hidden" name="tipo" value="<?= $horario['tipo'] ?>">
                  <button type="submit" class="btn-actualizar">Actualizar</button>
                </td>
              </form>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php endwhile; ?>
  </div>
</div>
<?php if ($mensaje): ?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
      title: 'Resultado de la actualización',
      text: '<?= addslashes($mensaje) ?>',
      icon: '<?= strpos($mensaje, "✅") !== false ? "success" : "error" ?>',
      confirmButtonColor: '#2378B6',
      confirmButtonText: 'Aceptar'
    });
  });
</script>
<?php endif; ?>


</body>
</html>
