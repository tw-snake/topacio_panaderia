<?php
// Incluir la conexión a la base de datos
include 'conexion.php';

// Comprobar si se ha recibido un idPanes
if (isset($_POST['idPanes'])) {
    $idPanes = $_POST['idPanes'];

    try {
        // Obtener el nombre del archivo de la imagen asociada
        $sqlImagen = "SELECT imagenPan FROM panes WHERE idPanes = :idPanes";
        $stmtImagen = $conexion->prepare($sqlImagen);
        $stmtImagen->bindParam(':idPanes', $idPanes);
        $stmtImagen->execute();
        $imagen = $stmtImagen->fetch(PDO::FETCH_ASSOC)['imagenPan'];

        // Eliminar la imagen del servidor si existe
        if ($imagen && file_exists("img/$imagen")) {
            unlink("img/$imagen");
        }

        // Eliminar el producto de la base de datos
        $sql = "DELETE FROM panes WHERE idPanes = :idPanes";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':idPanes', $idPanes);
        $stmt->execute();

    } catch (PDOException $e) {
        echo "Error al eliminar el producto: " . $e->getMessage();
    }
}

// Redirigir al inventario después de eliminar
header('Location: inventario.php');
exit();
?>