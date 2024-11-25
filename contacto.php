<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto || Topacio®</title>

    <link rel="icon" type="icon" href="img/icono.png">
    <link rel="stylesheet" href="estilo.css">

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

    <div id="Contenido-Contacto">
        <img src="img/contacto-foto-principal.jpg" alt="lobby" width="450px">
        <br><br><br><br>
        <div>
            <h3>¡Cóntactanos!</h3>
            <p>Floresta de San José, 32534 Juárez, Chih.<br>
                (656) - 899 - 1125 <br>
                <i class="fa-solid fa-envelope"></i>  topacio.panaderia@gmail.com
            </p>
        </div>
        <div>
            <h3>Horarios</h3>
            <p>Lunes, Martes, Miércoles: 7:30 AM - 5:00 PM <br>
                Jueves, Viernes: 7:30 AM - 6:30 PM <br>
                Sábado: 8:00 AM - 8:00 PM <br>
                Domingo: 8:00 AM - 5:00 PM
            </p>
        </div>
    </div>

    <!--<div id="Form-Contenedor">
        <form id="Form-suscripcion" action="enviar_correo.php" method="POST">
            <p style="color: white;">¡Suscríbete para recibir ofertas!</p>
            <input type="email" id="email" name="email" placeholder="ejemplo@gmail.com" required>
            <button type="submit">Enviar</button>
        </form>
    </div>-->

    <!-- Popup de suscripción
    <div id="popupSuscripcion" class="popup-form">
        <div class="popup-contenido-suscripcion">
            <h2>¡Gracias por suscribirte!</h2>
            <p>Ahora recibirás nuestras ofertas y promociones.</p>
            <button id="btnCerrarPopup" class="btn-cancelar">Cerrar</button>
        </div>
    </div> -->



    <div id="Contenido-Contacto">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1697.3236575815927!2d-106.4104440699781!3d31.6982081806664!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x86e75c4f33e29e39%3A0x4a4e52fff2624afd!2sPlaza%20Nacional!5e0!3m2!1ses-419!2smx!4v1730691676733!5m2!1ses-419!2smx"
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        <br><br><br>
        <p>Si tienes algún problema al obtener información sobre nuestro negocio, <br>
            por favor llámanos directamente al 656-899-1125 para recibir asistencia.</p>
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
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("Form-suscripcion");
            const popup = document.getElementById("popupSuscripcion");
            const btnCerrarPopup = document.getElementById("btnCerrarPopup");

            // Muestra el popup al enviar el formulario
            form.addEventListener("submit", (e) => {
                e.preventDefault(); // Evita que el formulario se envíe de la manera convencional
                
                // Aquí hacemos la solicitud AJAX para el envío del correo
                const formData = new FormData(form);

                fetch('enviar_correo.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data);  // Esto muestra si el correo fue enviado correctamente en la consola
                    popup.classList.add("mostrar");  // Muestra el popup si todo es correcto
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });

            // Cierra el popup al hacer clic en el botón "Cerrar"
            btnCerrarPopup.addEventListener("click", () => {
                popup.classList.remove("mostrar");
            });

            // Cierra el popup al hacer clic fuera del contenido del popup
            popup.addEventListener("click", (e) => {
                if (e.target === popup) {
                    popup.classList.remove("mostrar");
                }
            });
        });

    </script>
    
    


</body>

</html>