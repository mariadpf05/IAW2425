<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="formulario.php">
        <input type="text" name="caja" pleaceholder="Escribe aqui">
        <input type="submit" value="Enviar">
    </form>
    <?php
    if (!isset($GET["caja"])){
        echo 'Hola' . htmlspecialchars($_GET["name"]) . '!';
    }
    else {
        echo 'Hola' . htmlspecialchars($_GET["name"]) . '!';
    }
    ?>
</body>
</html>
