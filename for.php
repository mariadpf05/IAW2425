<!DOCTYPE html>
<html>
  <head>
    <title>Tabla de multiplicar - Versión 2</title>
  </head>
  <body>

	<?php
	if (!isset($_REQUEST["numero"])) {
		// Si no tenemos un número pasado por POST, significa que estamos en la primera ejecución,
		// así que mostramos el formulario
		echo "<form action='for.php' method='POST'>
		Introduce un número:
		<input type='text' name='numero'>
		<br>
		<input type='submit'>
		</form>";
	}
	else {
		// Ya tenemos número pasado por POST. Vamos a calcular su tabla de multiplicar.
		$multiplicando= $_REQUEST["numero"];;
        $multiplicador;

        for ($multiplicador=1; $multiplicador <=10 ; $multiplicador++) { 
	        echo "$multiplicando" . " X " . $multiplicador . " = " . $multiplicando * $multiplicador;
	        echo "<br>";
	    }
    }
	?>

  </body>
</html>
