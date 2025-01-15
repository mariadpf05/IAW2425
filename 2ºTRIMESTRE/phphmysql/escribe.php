<?php
//Conexión con BD
    $servername = "sql308.thsite.top"; //Nombre del servidor
    $username = "thsi_38097480"; //Nombre de usuario
    $password ="!GlJRfwv"; //Contraseña
    $bd = "thsi_38097480_ejemplo";
    $enlace= mysqli_connect($servername,$username,$password,$bd);
    if (!$enlace){
        die("Ocurrió algún problema con la conexión :" . mysqli_connect_error());
    }

//Construcción de la Query
    $query= "INSERT INTO usuarios (nombre, apellidos, email) VALUES ('Alberto', 'Moreno Carrero', 'alberto@gmail.com')";
//Ejecución de la Query
    $resultado = mysqli_query($enlace, $query);

//Procesamiento de los resultados
    if ($resultado){
        echo "Registrado correctamente";
    }
    else{
        echo "Error";
    }
//Cierre de la conexión
    mysqli_close($enlace);
?>