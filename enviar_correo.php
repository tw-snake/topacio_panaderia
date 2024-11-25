<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailUsuario = $_POST['email']; 
    $correoDestino = $emailUsuario; 
 
    $asunto = "¡SÍ FUNCIONA!";
    $mensaje = "¡Hola! Este es un mensaje de prueba para verificar que el formulario funciona.";

    $headers = "From: no-reply@topaciopanaderia.com" . "\r\n" .
               "Reply-To: no-reply@topaciopanaderia.com" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();


    if (mail($correoDestino, $asunto, $mensaje, $headers)) {
        echo "Correo enviado exitosamente.";
    } else {
        echo "Error al enviar el correo.";
    }
}
?>
