<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva</title>
</head>
<body>
<h1>Reserva de habitaciones</h1>
    <form action="" method="POST">
        <div class="formulario">
            <label for="nombre">Nombre: </label>
            <input type="text" name="nombre">
        </div>
        <div class="formulario">
            <label for="apellidos">Apellidos: </label>
            <input type="text" name="apellidos">
        </div>
        <div class="formulario">
            <label for="email">Email: </label>
            <input type="email" name="email" required>
        </div>
        <div class="formulario">
            <label for="dni">DNI: </label>
            <input type="text" name="dni">
        </div>
        <div class="formulario">
            <label for="diaEntrada">Día de entrada: </label>
            <input type="number" name="diaEntrada">
        </div>
        <div class="formulario">
            <label for="numDias">Duración de la estancia: </label>
            <input type="number" name="numDias">
        </div>
        <div class="formulario"></div>
        <label for="habitacion">Tipo de habitación:</label>
        <select name="habitacion" id="habitacion">
            <option value="hab0">Simple(30€)<img src="hab0"></option>
            <option value="hab1">Doble(50€)<img src="hab1"></option>
            <option value="hab2">Triple(80€)<img src="hab2"></option>
            <option value="hab3">Suite(100€)<img src="hab3"></option>
        </select>
        </div>
        <div class="formulario"><input type="submit" value="Reserva"></div>
    </form>
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener los datos del formulario
        $nombre = $_POST['nombre'];
        $apellido1 = $_POST['apellido1'];
        $apellido2 = $_POST['apellido2'];

        // Mostrar el mensaje de bienvenida
        echo "Bienvenido, " . htmlspecialchars($nombre) . " " . htmlspecialchars($apellido1) . " " . htmlspecialchars($apellido2) . "!";
        }
    ?>

</body>
</html>