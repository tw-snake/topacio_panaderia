<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú || Topacio®</title>

    <link rel="icon" type="icon" href="img/icono.png">
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="modal.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400..800&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div id="Nav-General">
        <a href="index.html"><img src="img/Logotipo.png" width="350px"></a>

        <nav class="estilo-Nav-General">
            <a href="menu.php" class="estilo-nav">Menú</a>
            <span class="separador"></span>
            <a href="contacto.php" class="estilo-nav">Contacto</a>
        </nav>
    </div>

    <nav id="Nav-Panes">
        <a href="#" class="estilo-nav" data-filter="blanco">Pan Blanco</a>
        <span class="separador"></span>
        <a href="#" class="estilo-nav" data-filter="integral">Pan Integral</a>
        <span class="separador"></span>
        <a href="#" class="estilo-nav" data-filter="dulce">Pan Dulce</a>
        <span class="separador"></span>
        <a href="#" class="estilo-nav" data-filter="otros">Otros</a>
    </nav>


    <div id="productos" class="productos-grid">
        
    </div>

    

    <footer id="Footer-General">
        <div class="footer-contenido">
            <div class="footer-logo">
                <a href="index.html"><img src="img/isotipo.png" alt="isotipo" width="80px"></a>
            </div>
    
            <div class="footer-links">
                <div class="footer-nav">
                    <a href="menu.php">Menú</a>
                    <a href="contacto.php">Contacto</a>
                </div>
                <div class="separador-footer"></div>
                <div class="footer-redesSociales">
                    <a href="https://www.instagram.com"><i class="fa-brands fa-instagram"></i> @topacio.panaderia</a><br>
                    <a href="https://www.facebook.com"><i class="fa-brands fa-facebook"></i> Topacio Panaderia</a> <br>
                    <a href="https://wa.me/5211234567890?text=Hola,%20me%20interesa%20tu%20producto"><i class="fa-brands fa-whatsapp"></i>(656)-899-1125</a> <br>
                    <a href="https://workspace.google.com/intl/es-419_mx/gmail/"><i class="fa-solid fa-envelope"></i> topacio.panaderia@gmail.com</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navLinks = document.querySelectorAll('#Nav-Panes a');
            const productosGrid = document.getElementById('productos');
            const modal = document.getElementById('detalleModal');
            const modalImgContainer = document.getElementById('modalImgContainer');
            const modalTextContainer = document.getElementById('modalTextContainer');
            const modalClose = document.querySelector('.modal .close');

            // Función para cargar los productos
            function cargarProductos(categoria) {
                // Limpiar productos actuales
                productosGrid.innerHTML = '';

                // Crear la solicitud AJAX para obtener los productos
                const xhr = new XMLHttpRequest();
                xhr.open('GET', `cargar_productos.php?categoria=${categoria}`, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const productos = JSON.parse(xhr.responseText);

                        // Si hay productos, crearlos y agregarlos al grid
                        productos.forEach(producto => {
                            const divProducto = document.createElement('div');
                            divProducto.classList.add('producto', producto.categoriaPan);

                            // Crear el HTML del producto
                            divProducto.innerHTML = `
                                <img src="img/${producto.imagenPan}" alt="${producto.nombrePan}" class="producto-img" />
                                <h3>${producto.nombrePan} <span class="flecha">➤</span></h3>
                            `;

                            // Añadir evento para abrir el modal
                            divProducto.addEventListener('click', function () {
                                modal.classList.add('visible');  // Mostrar el modal

                                // Limpiar el contenido previo del modal
                                modalImgContainer.innerHTML = '';
                                modalTextContainer.innerHTML = '';

                                // Crear y añadir imagen
                                const img = document.createElement('img');
                                img.src = `img/${producto.imagenPan}`;
                                img.alt = producto.nombrePan;
                                img.classList.add('modal-img');
                                modalImgContainer.appendChild(img);

                                // Crear y añadir nombre
                                const nombre = document.createElement('div');
                                nombre.id = 'modalNombre';
                                nombre.textContent = producto.nombrePan;
                                modalTextContainer.appendChild(nombre);

                                // Crear y añadir descripción
                                const descripcion = document.createElement('div');
                                descripcion.id = 'modalDescripcion';
                                descripcion.textContent = producto.descripcionPan;
                                modalTextContainer.appendChild(descripcion);

                                // Crear y añadir precio
                                const precio = document.createElement('div');
                                precio.id = 'modalPrecio';
                                precio.textContent = `Precio: $${producto.precioPan} MXN`;
                                modalTextContainer.appendChild(precio);
                            });

                            // Agregar el producto al contenedor
                            productosGrid.appendChild(divProducto);
                        });
                    } else {
                        console.error("Error al cargar los productos.");
                    }
                };
                xhr.send();
            }

            // Al cargar la página por primera vez, mostrar todos los productos
            cargarProductos(''); // Esto cargará todos los productos sin filtrarlos.

            // Añadir eventos a los filtros
            navLinks.forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    const filter = this.getAttribute('data-filter');
                    cargarProductos(filter); // Llamar a cargarProductos con el filtro seleccionado
                });
            });

            // Cerrar el modal
            modalClose.addEventListener('click', function () {
                modal.classList.remove('visible');
            });

            // Cerrar el modal al hacer clic fuera del contenido
            window.addEventListener('click', function (e) {
                if (e.target === modal) {
                    modal.classList.remove('visible');
                }
            });
        });

    </script>

    <!-- Modal -->
    <div id="detalleModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modalImgContainer" class="modal-img-container">
                <!-- La imagen del producto se insertará dinámicamente -->
            </div>
            <div id="modalTextContainer" class="modal-text-container">
                <!-- El nombre, descripción y precio se insertarán dinámicamente -->
            </div>
        </div>
    </div>



</body>

</html>