<?php
//Conexión BD
    $servername = "sql308.thsite.top"; //Nombre del servidor
    $username = "thsi_38097480"; //Nombre de usuario
    $password ="!GlJRfwv"; //Contraseña
    $bd = "thsi_38097480_ejemplo";
    $enlace = mysqli_connect($servername, $username, $password, $bd);
    if (!$enlace) {
        die("Ocurrio un problema con la conexión: " . mysqli_connect_error());
    }
//Construcción de la Query
    $query = "SELECT * FROM usuarios LIMIT 1";
//Ejecución de la Query
    $resultado = mysqli_query($enlace, $query);
    print_r ($resultado);
//Procesamiento de la Query
    if (mysqli_num_rows($resultado) > 0) {
        //Al menos tengo un registro
        while($fila = mysqli_fetch_assoc($resultado)) {
            echo "Nombre: " . $fila["nombre"]. "<br>Apellido:" . $fila["apellidos"] . "<br>Email: " . $fila["email"]. "<br>";
        }
    } else {
        echo "<p>No hubo resultados en la tabla</p>";
    };
//Cierre de la conexión
    mysqli_close($enlace);
?> 