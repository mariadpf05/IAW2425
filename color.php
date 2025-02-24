<?php
  setcookie("color", $_REQUEST["cambio"], time() + 60 * 60 * 24 * 365, "/");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie</title>
</head>
<body <?php if (isset($_COOKIE['color'])) echo " style=\"background:$_COOKIE[color]\"" ?>>
<form action="color.php" method="post">
    Seleccione de que color desea que sea la página de ahora en más:<br>
    <input type="color" value="rojo" name="cambio"><br>
    <input type="submit" value="Cambiar color">
  </form>
</body>
</html>