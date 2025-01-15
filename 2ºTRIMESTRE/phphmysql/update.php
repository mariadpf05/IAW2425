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
    $query= "UPDATE usuarios SET nombre='Juan', apellidos='Perez Loperz' WHERE id=2";
//Ejecución de la Query
    $resultado = mysqli_query($enlace, $query);

//Procesamiento de los resultados
    if ($resultado){
        echo "Registro actualizado correctamente";
    }
    else{
        echo "Error en la actualización";
    }
//Cierre de la conexión
    mysqli_close($enlace);
?>