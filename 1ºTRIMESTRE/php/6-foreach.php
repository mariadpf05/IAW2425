<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>foreach</title>
</head>
<body>
    <?php
    $refranes = [
        "Más vale pájaro en mano que ciento volando.",
        "A quien mucho tiene, más se le da.",
        "Tres son multitud.",
        "El que mucho abarca, poco aprieta.",
        "Quien no arriesga, no gana.",
        "Dos cabezas piensan mejor que una.",
        "Uno que no quiere dos que no pueden.",
        "No hay dos sin tres.",
        "En boca cerrada no entran moscas.",
        "A siete leguas se huele el lobo."
    ]
    echo "<ul>";
    foreach ($refranes as $refran){
        echo "<li>$refran</li>";
    }
    echo "</ul>";
    ?>
</body>
</html>