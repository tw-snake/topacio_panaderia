<?php
// Incluir conexión a la base de datos
include 'conexion.php';

// Iniciar sesión
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['admin'])) {
    header('Location: admin.php'); // Redirige al login si no hay sesión activa
    exit();
}

// Obtener la categoría seleccionada, con valores que coincidan con el ENUM
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : 'blanco'; // 'blanco' es el valor predeterminado

try {
    // Consultar los panes filtrados por la categoría seleccionada
    $sql = "SELECT * FROM panes WHERE categoriaPan = :categoria";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener todos los resultados como un array asociativo
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inventario || Topacio®</title>
        <link rel="icon" type="icon" href="img/icono.png">
        <link rel="stylesheet" href="estilo.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400..800&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    </head>

    <body id="Admin-body">
        <div id="Nav-Admin">
            <aside class="sidebar">
                <div class="admin-logo">
                    <img src="img/Logotipo.png" alt="logo" style="width: 200px;">
                </div>
                <nav>
                    <ul>
                        <li class="<?= $categoria == 'blanco' ? 'activo' : '' ?>"><a href="?categoria=blanco">Pan Blanco</a></li>
                        <li class="<?= $categoria == 'integral' ? 'activo' : '' ?>"><a href="?categoria=integral">Pan Integral</a></li>
                        <li class="<?= $categoria == 'dulce' ? 'activo' : '' ?>"><a href="?categoria=dulce">Pan Dulce</a></li>
                        <li class="<?= $categoria == 'otros' ? 'activo' : '' ?>"><a href="?categoria=otros">Otros</a></li>
                    </ul>
                </nav>
            </aside>

            <main class="contenido-admin">
                <header class="header-admin">
                    <h2>Inventario: <?= htmlspecialchars($categoria) ?></h2>
                    <button class="agregar-producto" onclick="mostrarPopup('Agregar')">Agregar producto +</button>
                    <button class="cerrar-sesion" onclick="window.location.href='cerrar_sesion.php'">Cerrar sesión</button>
                </header>

                <!-- Tabla de productos -->
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Precio c/u</th>
                            <th>Descripción</th>
                            <th>Foto</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nombrePan']) ?></td>
                        <td>$<?= htmlspecialchars($row['precioPan']) ?> MXN</td>
                        <td><?= htmlspecialchars($row['descripcionPan']) ?></td>
                        <td><img src="img/<?= htmlspecialchars($row['imagenPan']) ?>" alt="Foto de <?= htmlspecialchars($row['nombrePan']) ?>" width="80"></td>
                        <td>
                            <!-- Campo oculto para el idPanes -->
                            <input type="hidden" class="idPanesFila" value="<?= htmlspecialchars($row['idPanes']) ?>">

                            <button class="editar" onclick="mostrarPopup('Editar', <?= htmlspecialchars(json_encode($row)) ?>)">Editar</button>
                            <button class="eliminar" onclick="mostrarPopupEliminar(this)">Eliminar</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </main>
        </div>

        <!-- Popup para agregar/editar producto -->
        <div id="popupForm" class="popup-form oculto">
            <div class="popup-contenido">
                <button class="cerrar-popup" onclick="cerrarPopup()">×</button>
                <h2 id="popupTitulo">Agregar producto</h2>
                <form id="popupFormulario" method="POST" action="guardar.php" enctype="multipart/form-data">
                    <!-- Campo oculto para el ID del pan (solo para editar) -->
                    <input type="hidden" name="idPanes" id="idPanes">

                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombrePan" required>

                    <label for="precio">Precio c/u</label>
                    <input type="number" id="precio" name="precioPan" step="0.01" required>

                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcionPan" required></textarea>

                    <label for="categoria">Categoría</label>
                    <select name="categoriaPan" id="categoria" required>
                        <option value="blanco">Pan Blanco</option>
                        <option value="integral">Pan Integral</option>
                        <option value="dulce">Pan Dulce</option>
                        <option value="otros">Otros</option>
                    </select>

                    <label for="foto">Foto</label>
                    <input type="file" id="foto" name="imagenPan" accept="image/*">

                    <button type="submit" id="btnFormulario">Guardar</button>
                </form>
            </div>
        </div>


        <!-- Popup de confirmación de eliminación -->
        <div id="popupEliminar" class="popup-form oculto">
            <div class="popup-contenido-eliminar">
                <p>¿Estás seguro de que deseas eliminar este producto?</p>
                <div class="botones-eliminar">
                    <form id="formEliminar" method="POST" action="eliminar.php">
                        <input type="hidden" name="idPanes" id="idProductoEliminar">
                        <button type="submit" class="btn-confirmar">Aceptar</button>
                        <button type="button" class="btn-cancelar" onclick="cerrarPopupEliminar()">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>

        <script>
             // JavaScript para manejar el popup (Agregar y Editar)
             function mostrarPopup(accion, producto = null) {
                const popupForm = document.getElementById('popupForm');
                popupForm.classList.add('mostrar');
                document.getElementById('popupTitulo').textContent = accion === 'Agregar' ? 'Agregar producto' : 'Editar producto';

                // Si es editar, llenar los datos del producto
                if (producto) {
                    document.getElementById('idPanes').value = producto.idPanes;
                    document.getElementById('nombre').value = producto.nombrePan;
                    document.getElementById('precio').value = producto.precioPan;
                    document.getElementById('descripcion').value = producto.descripcionPan;
                    document.getElementById('categoria').value = producto.categoriaPan;  // Seleccionar la categoría correspondiente
                } else {
                    document.getElementById('popupFormulario').reset(); // Limpiar el formulario si es para agregar
                }
            }

            function cerrarPopup() {
                document.getElementById('popupForm').classList.remove('mostrar');
            }

            let productoAEliminar = null;


            function mostrarPopupEliminar(botonEliminar) {
                const popupEliminar = document.getElementById('popupEliminar');
                popupEliminar.classList.add('mostrar');

                // Obtener la fila (tr) donde está el botón
                const fila = botonEliminar.closest('tr');
                
                // Obtener el valor del idPanes desde el campo oculto en esa fila
                const idPanes = fila.querySelector('.idPanesFila').value;

                // Asignar el id al campo oculto del formulario
                document.getElementById('idProductoEliminar').value = idPanes;
            }

            // Función para cerrar el popup de eliminación
            function cerrarPopupEliminar() {
                const popupEliminar = document.getElementById('popupEliminar');
                popupEliminar.classList.remove('mostrar');
            }

            // Función para confirmar la eliminación
            function confirmarEliminar() {
                if (productoAEliminar) {
                    // Redirigir a eliminar.php con el idPanes
                    document.getElementById('formEliminar').submit(); // Enviar el formulario con el id
                }
            }

            // Función para cerrar sesión
            function cerrarSesion() {
                window.location.href = 'cerrar_sesion.php'; // Asegúrate de tener un archivo cerrar_sesion.php que cierre la sesión
            }
        </script>
    </body>
</html>

