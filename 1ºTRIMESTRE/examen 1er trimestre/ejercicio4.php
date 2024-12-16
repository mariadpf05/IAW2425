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
            <label for="nombre">Nombre: </label><input type="text" name="nombre">
            <label for="apellidos">Apellidos: </label><input type="text" name="apellidos">
            <label for="email">Email: </label><input type="email" name="email" required>
            <label for="dni">DNI: </label><input type="text" name="dni">
            <label for="diaEntrada">Día de entrada: </label><input type="number" name="diaEntrada">
            <label for="numDias">Duración de la estancia: </label><input type="number" id="numDias" name="numDias">
            <label for="habitacion">Tipo de habitación:</label>
            <select name="habitacion" id="habitacion">
                <option value="hab0">Simple(30€)</option>
                <option value="hab1">Doble(50€)</option>
                <option value="hab2">Triple(80€)</option>
                <option value="hab3">Suite(100€)</option>
            </select>
            <input type="submit" value="Login">
    </form>
    <?php
        if (isset($_POST["nombre"]) && isset($_POST["apellidos"])){
            $nombre = htmlspecialchars($_POST["nombre"]);
            $apellidos = htmlspecialchars($_POST["apellidos"]);
            $email = htmlspecialchars($_POST["email"]);
            $dni = htmlspecialchars($_POST["dni"]);
            $diaEntrada = htmlspecialchars($_POST["diaEntrada"]);
            $numDias = htmlspecialchars($_POST["numDias"]);
            $habitación = htmlspecialchars($_POST["habitación"]);
            $importeTotal = calculaTotal();
            // Verificamos si ambos campos están llenos
            if (!empty($usuario) && !empty($apellidos) && !empty($email) && !empty($dni) && !empty($diaEntrada) && !empty($numDias) && !empty($habitaciones)) {
                echo "<p> La reserva ha sido realizada por $mombre. $apellidos. con DNI: $dni. , con el correo $correo. para el día $diaEntrada. , la duración de la estancia será de $numDias. días y la habitación será $habitacion. y el importe total es de $importeTotal.€</p>"
            } 
            else {
                echo "<p>Por favor, ingrese ambos campos.</p>";
            }
            if ($habitacion = "hab0"){
                "<img scr='hab0.png'>"
            }
            else if ($habitacion = "hab1"){
                "<img scr='hab1.png'>"
            }
            else if ($habitacion = "hab2"){
                "<img scr='hab2.png'>"
            }
            else ($habitacion = "hab3"){
                "<img scr='hab3.png'>"
            }
        }
    ?>
    <script>
            function calculaTotal(){
            
            var dia = parseFloat(document.getElementById("numDias").value);
            var precio = parseFloat(document.getElementById("velocidad").value);
        
            if (isNaN(masa) || isNaN(velocidad) || masa <= 0 || velocidad <= 0) {
                document.getElementById("resultado").innerHTML = "Por favor, ingrese valores válidos de masa y velocidad.";
                document.getElementById("recomendacion").innerHTML = "";
                return;
            }
        
            var Total = dia * precio;
        }
    </script>
</body>
</html>