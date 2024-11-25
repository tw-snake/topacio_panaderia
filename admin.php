<?php
session_start();
include 'conexion.php'; // Archivo con la conexión a la base de datos

$error = ''; // Variable para mostrar mensajes de error

// Procesar el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para buscar el usuario por email
    $query = $conexion->prepare("SELECT * FROM usuarios WHERE email = :email");
    $query->bindParam(':email', $email);
    $query->execute();
    $usuario = $query->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['password'])) {
        // Credenciales válidas, inicia sesión
        $_SESSION['admin'] = $usuario['id']; // Guarda el ID del usuario en la sesión
        header('Location: inventario.php'); // Redirige al inventario
        exit();
    } else {
        // Credenciales incorrectas
        $error = "Correo o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar Sesión || Topacio®</title>
    
        <link rel="icon" type="icon" href="img/icono.png">
        <link rel="stylesheet" href="estilo.css">
    
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400..800&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>
<body id="Contenido-Admin">
    <div class="centrar-contenedor">
        <div class="logo-admin">
            <img src="img/Logotipo.png" alt="Logo" width="350px"><br>
        </div>
        <h2>Bienvenido, administrador.</h2>
        <div class="login-contenedor">
            <!-- Mostrar mensaje de error -->
            <?php if (!empty($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form class="login-form" method="POST">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" placeholder="Correo electrónico" required>
                
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Contraseña" required>
                
                <button type="submit">Iniciar sesión</button>
            </form>
        </div>
    </div>
</body>
</html>
