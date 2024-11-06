function CalcularIMC(){
            
    var peso = parseFloat(document.getElementById("peso").value);
    var alturaCentimetros = parseFloat(document.getElementById("altura").value);

    if (isNaN(peso) || isNaN(alturaCentimetros) || peso <= 0 || alturaCentimetros <= 0) {
        document.getElementById("resultado").innerHTML = "Por favor, ingrese valores válidos de peso y altura.";
        document.getElementById("recomendacion").innerHTML = "";
        return;
    }

    var alturaMetros = alturaCentimetros * 0.01;
    var IMC = peso / (alturaMetros * alturaMetros);

    if (IMC < 18.5) {
        document.getElementById("resultado").innerHTML = "Su índice de masa corporal es " + IMC.toFixed(2);
        document.getElementById("recomendacion").innerHTML = "Su peso es inferior al normal.";
    } 
    else if (IMC >= 18.5 && IMC <= 24.9) {
        document.getElementById("resultado").innerHTML = "Su índice de masa corporal es " + IMC.toFixed(2);
        document.getElementById("recomendacion").innerHTML = "Su peso es normal.";
    } 
    else if (IMC >= 25.0 && IMC <= 29.9) {
        document.getElementById("resultado").innerHTML = "Su índice de masa corporal es " + IMC.toFixed(2);
        document.getElementById("recomendacion").innerHTML = "Su peso es superior al normal.";
    } 
    else {
        document.getElementById("resultado").innerHTML = "Su índice de masa corporal es " + IMC.toFixed(2);
        document.getElementById("recomendacion").innerHTML = "Su peso es de obesidad.";
    }
}