<?php
include('conexion.php'); // Incluir el archivo de conexión

// Obtener la categoría desde la URL (o vacío si no hay filtro)
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

// Consulta SQL según la categoría
$sql = "SELECT * FROM panes";
if ($categoria) {
    $sql .= " WHERE categoriaPan = :categoria";
}

try {
    $stmt = $conexion->prepare($sql);
    
    // Si hay categoría, agregamos el filtro en la consulta
    if ($categoria) {
        $stmt->bindParam(':categoria', $categoria);
    }

    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los productos como JSON
    echo json_encode($productos);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
?>