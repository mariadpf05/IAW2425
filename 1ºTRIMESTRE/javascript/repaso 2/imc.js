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
        document.getElementById("resultado").innerHTML = "Su índice de masa corporal es " + IMC.toFixed(2) + ". Esto indica: Peso inferior al normal.";
        document.getElementById("recomendacion").innerHTML = "Es recomendable consultar con un nutricionista para ganar peso de forma saludable.";
    } 
    else if (IMC >= 18.5 && IMC <= 24.9) {
        document.getElementById("resultado").innerHTML = "Su índice de masa corporal es " + IMC.toFixed(2) + ". Esto indica: Peso normal.";
        document.getElementById("recomendacion").innerHTML = "Mantenga una dieta balanceada y actividad física regular para conservar su salud.";
    } 
    else if (IMC >= 25.0 && IMC <= 29.9) {
        document.getElementById("resultado").innerHTML = "Su índice de masa corporal es " + IMC.toFixed(2) + ". Esto indica: Peso superior al normal.";
        document.getElementById("recomendacion").innerHTML = "Considere realizar más actividad física y ajustar su dieta para reducir el peso.";
    } 
    else {
        document.getElementById("resultado").innerHTML = "Su índice de masa corporal es " + IMC.toFixed(2) + ". Esto indica: Obesidad.";
        document.getElementById("recomendacion").innerHTML = "Es recomendable acudir a un profesional de la salud para obtener ayuda en la pérdida de peso.";
    }
}