/* Rellena este fichero */
$(document).ready(function(){
    $(".btn-aumentar").click(function(){
        $("#encabezado, .pares").css({
            "font-size": "+=2",
            "color": "black" 
        });
    });

    $(".btn-disminuir").click(function(){
        $("#encabezado, .pares").css({
            "font-size": "-=2",
            "color": "black" 
        });
    });

    $(".btn-rojo").click(function(){
        $("#encabezado, .pares").css({
            "color": "red"
        });
    });

    $(".btn-azul").click(function(){
        $("#encabezado, .pares").css({
            "color": "blue"
        });
    });
});