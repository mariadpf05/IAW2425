<?php
// Ruta al archivo que se va a descargar
$archivo = 'ruta/al/archivo.txt';

// Verificar si el archivo existe
if (file_exists($archivo)) {
    // Establecer los encabezados para forzar la descarga
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($archivo) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($archivo));

    // Limpiar la salida del búfer
    ob_clean();
    flush();

    // Leer el archivo y enviarlo al navegador
    readfile($archivo);

    // Finalizar el script
    exit;
} else {
    echo "El archivo no existe.";
}
?>
