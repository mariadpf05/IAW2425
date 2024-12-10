
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feria</title>
</head>
<body>
    <?php
        date_default_timezone_set('Europe/Madrid');
        $diaActual = new DateTime();
        $diaFeria = new DateTime('06/05/2025');
        $diff = $diaActual->diff($diaFeria);
        // will output 2 days
        echo "Quedan " . $diff->days . ' días para la feria ';
    ?>
    <!--$fechaActual = date('Y-m-d');
    $datetime1 = date_create('2025-05-06');
    $datetime2 = date_create($fechaActual);
    $contador = date_diff($datetime1, $datetime2);
    $differenceFormat = $contador->days;
    echo "Quedan" . $differenceFormat . " días para la feria";-->
</body>
</html> 