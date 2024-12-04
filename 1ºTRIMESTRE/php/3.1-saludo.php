<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="saludo.php" method="POST">
        <label for="">Introduce tu nombre:</label>
        <input type="text" name="nombre">
        <input type="submit" value="Enviar">
    </form>
    <?php
        if (isset($_POST["nombre"])){
            echo "hola" . htmlspecialchars($_POST["nombre"]) . " hoy es " . date("d/m/Y");
        }
    ?>
</body>
</html>