<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "base_kam");

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL
$sql = "SELECT * FROM horarios";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Mostrar datos de cada fila
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["docente"]) . "</td>
                <td>" . htmlspecialchars($row["nivel_academico"]) . "</td>
                <td>" . htmlspecialchars($row["cargo_personal"]) . "</td>
                <td class='acciones'>
                    <a href='editar_horario.php?id=" . $row["id"] . "' title='Editar'><i class='fas fa-edit'></i></a>
                    <a href='vista_horario.php?id=" . $row["id"] . "' title='Vista Previa'><i class='fas fa-eye'></i></a>
                    <a href='eliminar_horario.php?id=" . $row["id"] . "' title='Eliminar'><i class='fas fa-trash-alt'></i></a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No hay datos disponibles</td></tr>";
}

// Cerrar la conexión
$conn->close();
?>
