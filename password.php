<?php
$passwordPlano = "adminTopacio.0441";
$passwordHash = password_hash($passwordPlano, PASSWORD_DEFAULT);
echo $passwordHash; 
?>