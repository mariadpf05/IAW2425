<?php 
    $servername = ""; //Nombre del servidor
    $username = ""; //Nombre de usuario
    $password =""; //Contraseña
    $database = "";
    $enlace = mysqli_connect($servername, $username, $password, $database);
    
    if (!$enlace) {
        die("Ocurrió algún problema con la conexión: " . mysqli_connect_error());
    }
?>