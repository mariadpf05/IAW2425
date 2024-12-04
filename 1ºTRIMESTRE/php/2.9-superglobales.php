<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        echo 'Te estas conectando desde la IP:' . ($_SERVER["REMOTE_ADDR"]);
        echo "<br>";
        echo 'Tu navegador está catalogado como' . ($_SERVER["HTTP_USER_AGENT"]);
        echo "<br>";
        echo 'Vienes de la página:' . ($_SERVER["REQUEST_URL"]);
    ?>
</body>
</html>
