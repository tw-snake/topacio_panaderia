<?php
// Conexión a la base de datos
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idPanes = $_POST['idPanes'] ?? null;
    $nombrePan = $_POST['nombrePan'];
    $precioPan = $_POST['precioPan'];
    $descripcionPan = $_POST['descripcionPan'];
    $categoriaPan = $_POST['categoriaPan'];

    // Verificar si se ha cargado una imagen
    $imagenPan = null;  // Inicializar la variable de la imagen

    if (isset($_FILES['imagenPan']) && $_FILES['imagenPan']['error'] == 0) {
        // Obtener información del archivo
        $archivoTemp = $_FILES['imagenPan']['tmp_name'];
        $nombreArchivo = $_FILES['imagenPan']['name'];
        $tipoArchivo = $_FILES['imagenPan']['type'];
        $tamanoArchivo = $_FILES['imagenPan']['size'];

        // Establecer el directorio de destino
        $directorioDestino = 'img/';  // La carpeta donde se almacenarán las imágenes

        // Generar un nombre único para la imagen para evitar conflictos
        $nombreArchivoNuevo = uniqid() . '-' . $nombreArchivo;

        // Verificar si el archivo es una imagen
        if (in_array($tipoArchivo, ['image/jpeg', 'image/png', 'image/gif'])) {
            // Mover el archivo a la carpeta destino
            if (move_uploaded_file($archivoTemp, $directorioDestino . $nombreArchivoNuevo)) {
                $imagenPan = $nombreArchivoNuevo;  // Guardar el nombre del archivo
            } else {
                echo 'Error al mover el archivo a la carpeta de destino.';
                exit;
            }
        } else {
            echo 'El archivo no es una imagen válida.';
            exit;
        }
    }

    // Si estamos editando, actualizamos el registro existente, sino lo insertamos
    if ($idPanes) {
        // Actualizar producto
        $sql = "UPDATE panes SET nombrePan = :nombrePan, precioPan = :precioPan, descripcionPan = :descripcionPan, categoriaPan = :categoriaPan, imagenPan = :imagenPan WHERE idPanes = :idPanes";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombrePan', $nombrePan);
        $stmt->bindParam(':precioPan', $precioPan);
        $stmt->bindParam(':descripcionPan', $descripcionPan);
        $stmt->bindParam(':categoriaPan', $categoriaPan);
        $stmt->bindParam(':imagenPan', $imagenPan);
        $stmt->bindParam(':idPanes', $idPanes);
        $stmt->execute();
    } else {
        // Insertar nuevo producto
        $sql = "INSERT INTO panes (nombrePan, precioPan, descripcionPan, categoriaPan, imagenPan) VALUES (:nombrePan, :precioPan, :descripcionPan, :categoriaPan, :imagenPan)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombrePan', $nombrePan);
        $stmt->bindParam(':precioPan', $precioPan);
        $stmt->bindParam(':descripcionPan', $descripcionPan);
        $stmt->bindParam(':categoriaPan', $categoriaPan);
        $stmt->bindParam(':imagenPan', $imagenPan);
        $stmt->execute();
    }

    // Redirigir después de guardar los datos
    header('Location: inventario.php?categoria=' . $categoriaPan);
    exit;
}
?>

