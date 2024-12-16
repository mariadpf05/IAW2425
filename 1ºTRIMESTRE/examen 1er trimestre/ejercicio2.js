function CalcularEnergia(){
            
    var masa = parseFloat(document.getElementById("masa").value);
    var velocidad = parseFloat(document.getElementById("velocidad").value);

    if (isNaN(masa) || isNaN(velocidad) || masa <= 0 || velocidad <= 0) {
        document.getElementById("resultado").innerHTML = "Por favor, ingrese valores válidos de masa y velocidad.";
        document.getElementById("recomendacion").innerHTML = "";
        return;
    }

    var EC = 0.5 * masa * (velocidad * velocidad);
    if (EC < 10) {
        document.getElementById("resultado").innerHTML = "La energía cinética es baja: " + EC.toFixed(2) + " Joules";
    } 
    else if (EC >= 10 && EC <= 100) {
        document.getElementById("resultado").innerHTML = "La energía cinética es moderada: " + EC.toFixed(2) + " Joules";
    }  
    else {
        document.getElementById("resultado").innerHTML = "La energía cinética es alta: " + EC.toFixed(2) + " Joules";
    }
}