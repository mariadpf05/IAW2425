<?php
if ( isset( $_COOKIE[ 'color' ] ) ) {

    setcookie( 'color', $_COOKIE[ 'color' ] + 1, time() + 3600 * 24, httponly:true );
    setcookie('lang', $_SERVER['HTTP_ACCEPT_LANGUAGE'], time()+3600*24, httponly:true);
    $mensaje = 'Numero de color: '.$_COOKIE[ 'color' ]. " usando el idioma " .$_COOKIE['lang'];
}
else {

    setcookie( 'color', 1, time() + 3600 * 24, httponly:true );
    $mensaje = 'Bienvenido por primera vez a nuesta web' . " usando el idioma " .$_COOKIE['lang'];
}
//Esto froma parte de la cabecera
?>
<html>
    <head>
        <title>Cookie</title>
    </head>
    <body>
        <p>
            <?php     print_r($mensaje);?>
            
        </p>    
    </body>
</html> 