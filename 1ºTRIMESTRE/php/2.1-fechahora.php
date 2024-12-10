<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fecha hora</title>
</head>
<body>
    <h1>Fecha y hora actual</h1>
    <?php
        $locale = 'es_ES'; 
        // Crea un objeto IntlDateFormatter con la localización y el formato deseado 
        $formatter = new IntlDateFormatter($locale, IntlDateFormatter::LONG, IntlDateFormatter::NONE, 'Europe/Madrid', IntlDateFormatter::GREGORIAN, 'MMMM'); 
        // Obtiene la fecha actual 
        $fechaActual = new DateTime(); 
        // Formatea la fecha actual para obtener el mes en español 
        $mesActual = $formatter->format($fechaActual); echo "El mes actual es: $mesActual";
    ?>
</body>
</html>