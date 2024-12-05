<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio examen</title>
</head>
<body>
<!-- formulario en el que se introduce un número > 0 y genera con ese número una piramide con ese número de filas-->
    <form id="formulario" action="triangulo.php">
        <input type="number" name="numero" id="numero" pleaceholder="Introduce un número">
        <input type="submit" value="Enviar">
    </form>
    <?php
        if (isset($_POST["numero"])){
            $numero = htmlspecialchars($_POST["numero"]);
            if ($numero>0){
                
            }
            else {
                echo "<p>Introduce un número positivo</p>";
            }
        }
    ?>

    <script>
        
    </script>
</body>
</html>