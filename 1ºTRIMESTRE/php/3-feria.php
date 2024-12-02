<?php
$fechaActual = date('Y-m-d');
$datetime1 = date_create('2025-05-06');
$datetime2 = date_create($fechaActual);
$contador = date_diff($datetime1, $datetime2);
$differenceFormat = $contador->days;
echo "Quedan" . $differenceFormat . " días para la feria";
?>