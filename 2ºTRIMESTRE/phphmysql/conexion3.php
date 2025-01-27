<?php
$servername = "sql308.thsite.top"; //Nombre del servidor
$username = "thsi_38097480"; //Nombre de usuario
$password =""; //Contraseña

try {
  $conn = new PDO("mysql:host=$servername;dbname=thsi_38097480_ejemplo", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Conexión exitosa";
} catch(PDOException $e) {
  echo "Conexión fallida: " . $e->getMessage();
}
?> 