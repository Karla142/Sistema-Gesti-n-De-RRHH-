<?php
// Configuración PDO
$host = 'localhost';
$db = 'sistema_horarios';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  die("Error de conexión a sistema_horarios: " . $e->getMessage());
}

// Validación mínima
if (empty($_POST['cedula']) || empty($_POST['materia']) || empty($_POST['tipo_horario'])) {
  die("Faltan datos obligatorios.");
}

$cedula = $_POST['cedula'];
$materia = $_POST['materia'];
$nuevaMateria = trim($_POST['nueva_materia'] ?? '');
$tipo = $_POST['tipo_horario'];
$totalHoras = $_POST['total_horas'] ?? null;

// Verificar si la cédula existe en personal
$stmt = $pdo->prepare("SELECT COUNT(*) FROM personal WHERE cedula = ?");
$stmt->execute([$cedula]);
$existe = $stmt->fetchColumn();

if (!$existe) {
  try {
    $pdoKam = new PDO("mysql:host=localhost;dbname=base_kam;charset=utf8mb4", "root", "", $options);
  } catch (PDOException $e) {
    die("Error conectando con base_kam: " . $e->getMessage());
  }

  $stmt = $pdoKam->prepare("SELECT nombre_personal, apellido_personal, cargo_personal FROM persona WHERE cedula_personal = ?");
  $stmt->execute([$cedula]);
  $datos = $stmt->fetch();

  if ($datos) {
    $stmt = $pdo->prepare("INSERT INTO personal (cedula, nombre, apellido, cargo) VALUES (?, ?, ?, ?)");
    $stmt->execute([
      $cedula,
      $datos['nombre_personal'],
      $datos['apellido_personal'],
      $datos['cargo_personal']
    ]);
  } else {
    die("La cédula no está en base_kam.persona.");
  }
}

// Insertar materia si es necesario
if ($materia === 'añadir' && $nuevaMateria !== '') {
  $stmt = $pdo->prepare("INSERT INTO materias (nombre) VALUES (?)");
  $stmt->execute([$nuevaMateria]);
  $materia_id = $pdo->lastInsertId();
} else {
  $stmt = $pdo->prepare("SELECT id FROM materias WHERE nombre = ?");
  $stmt->execute([$materia]);
  $materia_id = $stmt->fetchColumn();

  if (!$materia_id) {
    die("La materia no existe.");
  }
}

// Insertar horario
$stmt = $pdo->prepare("INSERT INTO horarios (cedula, materia_id, tipo, total_horas) VALUES (?, ?, ?, ?)");
$stmt->execute([$cedula, $materia_id, $tipo, $totalHoras]);
$horario_id = $pdo->lastInsertId();

// Insertar bloques
if ($tipo === 'parcial') {
  $dias = $_POST['dia'] ?? [];
  $horas = $_POST['hora'] ?? [];
  $niveles = $_POST['anio'] ?? [];
  $secciones = $_POST['seccion'] ?? [];

  for ($i = 0; $i < count($dias); $i++) {
    $stmt = $pdo->prepare("INSERT INTO bloques_parcial (horario_id, dia, hora, nivel, seccion) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$horario_id, $dias[$i], $horas[$i], $niveles[$i], $secciones[$i]]);
  }

} elseif ($tipo === 'tiempo_completo') {
  $dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
  foreach ($dias as $dia) {
    $bloques = $_POST["bloques_$dia"] ?? [];
    $niveles = $_POST["anio_$dia"] ?? [];
    $secciones = $_POST["seccion_$dia"] ?? [];

    for ($i = 0; $i < count($bloques); $i++) {
      $stmt = $pdo->prepare("INSERT INTO bloques_completo (horario_id, dia, bloque_hora, nivel, seccion) VALUES (?, ?, ?, ?, ?)");
      $stmt->execute([$horario_id, $dia, $bloques[$i], $niveles[$i], $secciones[$i]]);
    }
  }
}

// Mostrar alerta emergente y redirigir
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Guardado</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
Swal.fire({
  icon: 'success',
  title: '¡Horario guardado!',
  text: 'Los datos se registraron correctamente.',
  confirmButtonText: 'Aceptar'
}).then(() => {
  window.location.href = 'PRIMARIA2.php';
});
</script>
</body>     
</html>
