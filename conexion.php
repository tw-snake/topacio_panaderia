<?php
// Detectar si estás en local o en el servidor real
$isLocal = ($_SERVER['HTTP_HOST'] === 'localhost');

// Configuración para local y servidor real
if ($isLocal) {
    $host = 'localhost'; 
    $dbname = 'bd_local'; 
    $username = 'root';
    $password = '';
} else {
    $host = 'fdb1028.awardspace.net'; // Host del servidor real
    $dbname = '4555267_panes'; // Nombre de la base de datos en el servidor real
    $username = '4555267_panes'; // Usuario del servidor real
    $password = 'Topacio.441'; // Contraseña del servidor real
}

try {
    // Crear conexión con PDO
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Manejo de errores de conexión
    die("Error en la conexión: " . $e->getMessage());
}
?>
