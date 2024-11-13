/* Rellena este fichero */
$(document).ready(function(){
    $("#btn-mostrar").click(function(){
      $("p, h1").show();
    });

    $("#btn-ocultar").click(function(){
      $("p, h1").hide();
    });
  });