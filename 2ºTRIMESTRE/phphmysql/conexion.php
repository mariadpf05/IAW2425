<?php 
    $servername = "sql308.thsite.top"; //Nombre del servidor
    $username = "thsi_38097480"; //Nombre de usuario
    $password ="!GlJRfwv"; //Contraseña
    //Crear conexión
    $conn = new mysqli($servername, $username, $password);

    //Comprueba la conexión
    if ($conn->connect_error) {
        die("Falló l aconexión: " . $conn->connect_error);
    }
    echo "Conexión exitosa";
?>