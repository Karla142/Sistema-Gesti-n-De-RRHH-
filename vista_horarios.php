<?php
include 'conexio.php';

$cedula = $_GET['cedula'] ?? '';
if (!$cedula) {
  echo "<div style='color:red;'>❌ Cédula no proporcionada.</div>";
  exit;
}

// Obtener datos del personal
$queryPersonal = "SELECT nombre, apellido, cargo FROM personal WHERE cedula = '$cedula'";
$resultadoPersonal = mysqli_query($conexion, $queryPersonal);

if (!$resultadoPersonal || mysqli_num_rows($resultadoPersonal) === 0) {
  echo "<div style='color:red;'>❌ No se encontró personal con la cédula: $cedula</div>";
  exit;
}

$personal = mysqli_fetch_assoc($resultadoPersonal);

// Obtener horarios
$queryHorarios = "SELECT h.id AS horario_id, h.tipo, h.total_horas, m.nombre AS materia
                  FROM horarios h
                  JOIN materias m ON h.materia_id = m.id
                  WHERE h.cedula = '$cedula'";
$resultadoHorarios = mysqli_query($conexion, $queryHorarios);

if (!$resultadoHorarios || mysqli_num_rows($resultadoHorarios) === 0) {
  echo "<div style='color:red;'>❌ No se encontró horario para la cédula: $cedula</div>";
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Vista previa de horario</title>
  <link rel="stylesheet" href="estilos.css">
  <style>
    /* Fondo del modal */
    #modalHorario {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background-color: rgba(0, 0, 0, 0.6);
      z-index: 9999;
      display: block;
    }

    /* Contenedor del contenido */
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

    /* Botón X en la esquina superior derecha */
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

    /* Tabla */
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
  </style>
</head>
<body>

<div id="modalHorario">
  <div class="modal-contenido">
    <!-- Ícono de cierre -->
    <a href="PREESCOLAR1.php" class="cerrar-x">✖</a>

    <h2 style="color:#2378B6;">Horario de <?= htmlspecialchars($personal['nombre'] . ' ' . $personal['apellido']) ?> (<?= htmlspecialchars($personal['cargo']) ?>)</h2>

    <?php while ($horario = mysqli_fetch_array($resultadoHorarios)): ?>
      <div style="margin-bottom:20px;">
        <h4 style="color:#2378B6;">Materia: <?= htmlspecialchars($horario['materia']) ?> | Tipo: <?= htmlspecialchars($horario['tipo']) ?> | Total horas: <?= htmlspecialchars($horario['total_horas']) ?></h4>
        <table>
          <thead>
            <tr>
              <th>Día</th>
              <th>Hora/Bloque</th>
              <th>Nivel</th>
              <th>Sección</th>
            </tr>
          </thead>
          <tbody>
            <?php
              if ($horario['tipo'] === 'parcial') {
                $queryBloques = "SELECT dia, hora, nivel, seccion FROM bloques_parcial WHERE horario_id = {$horario['horario_id']}";
              } else {
                $queryBloques = "SELECT dia, bloque_hora AS hora, nivel, seccion FROM bloques_completo WHERE horario_id = {$horario['horario_id']}";
              }
              $resultadoBloques = mysqli_query($conexion, $queryBloques);
              while ($bloque = mysqli_fetch_array($resultadoBloques)):
            ?>
              <tr>
                <td><?= htmlspecialchars($bloque['dia']) ?></td>
                <td><?= htmlspecialchars($bloque['hora']) ?></td>
                <td><?= htmlspecialchars($bloque['nivel']) ?></td>
                <td><?= htmlspecialchars($bloque['seccion']) ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php endwhile; ?>
  </div>
</div>

</body>
</html>
