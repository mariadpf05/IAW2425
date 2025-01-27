<?php
$servername = "sql308.thsite.top"; //Nombre del servidor
$username = "thsi_38097480"; //Nombre de usuario
$password =""; //Contraseña

// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
  die("Conexión fallida: " . mysqli_connect_error());
}
echo "Conexión exitosa";
?> 