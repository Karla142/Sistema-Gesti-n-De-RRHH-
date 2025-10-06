<?php
try {
    // Configuración de la conexión a la base de datos
    $db = new PDO("mysql:host=localhost;dbname=base_kam;charset=utf8", "root", "");

    // Establece el modo de manejo de errores en excepciones para facilitar la depuración
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Opcional: Habilitar el modo de fetch predeterminado para obtener resultados asociativos
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Manejo de errores si la conexión falla
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

// Opcional: Puedes agregar comentarios explicativos aquí para las futuras modificaciones
// Ejemplo:
// $query = $db->prepare("SELECT * FROM usuarios");
// $query->execute();
// $resultados = $query->fetchAll();
// Este sería un ejemplo de uso para consultas posteriores
?>
