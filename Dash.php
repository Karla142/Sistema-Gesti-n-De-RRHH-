<?php
session_start();

if (!isset($_SESSION['roles'])) {
    header("Location: login.php");
    exit;
}

$roles = $_SESSION['roles'];

function checkAccess($seccion) {
    global $roles;

    $accessMatrix = [
        'secretaria' => ['permisos', 'reportes'],
        'RRHH' => ['personal'],
        'administrador' => ['todo']
    ];

    $isAuthorized = false;
    foreach ($roles as $rol) {
        if (in_array($seccion, $accessMatrix[$rol]) || $rol === 'administrador') {
            $isAuthorized = true;
            break;
        }
    }

    if (!$isAuthorized) {
        echo "<script>alert('ACCESO DENEGADO');</script>";
        return false;
    }
    return true;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Bienvenido, <?php echo htmlentities($_SESSION['usuario']); ?></h2>

    <ul>
        <li><a href="?seccion=permisos" onclick="return checkSec('permisos')">Permisos</a></li>
        <li><a href="?seccion=reportes" onclick="return checkSec('reportes')">Reportes</a></li>
        <li><a href="?seccion=personal" onclick="return checkSec('personal')">Personal</a></li>
    </ul>

    <script>
        function checkSec(seccion) {
            return <?php echo json_encode(array_intersect(
                ['secretaria' => ['permisos', 'reportes'], 'RRHH' => ['personal'], 'administrador' => ['todo']]
                [$_SESSION['rol']], [$seccion])) === true ? 'true' : 'false' ?>;
            }
        </script>
</html>
