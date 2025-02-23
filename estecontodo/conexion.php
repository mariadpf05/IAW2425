<?php 
    $servername = "sql308.thsite.top"; //Nombre del servidor
    $username = "thsi_38097480"; //Nombre de usuario
    $password ="!GlJRfwv"; //Contraseña
    $database = "thsi_38097480_proyecto";
    $enlace = mysqli_connect($servername, $username, $password, $database);
    
    if (!$enlace) {
        die("Ocurrió algún problema con la conexión: " . mysqli_connect_error());
    }
?>