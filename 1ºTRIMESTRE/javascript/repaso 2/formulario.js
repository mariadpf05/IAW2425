function validar(elementos){
    let estanCorrectos = true;  //Se declara la variable estanCorrectos con el valor true (dira si los campos están llenos y son válidos)
    for (var i=0;i<elementos.length;i++){
        document.getElementById("campo"+(i+1).toString()).innerHTML = ""; // Por defecto el campo está OK       
        if (elementos[i].value == "" || (i==6 && !elementos[i].checked)){
            // Si el campo está vacío o (el campo es la casilla de verificación y no está marcada) entonces ...
            document.getElementById("campo"+(i+1).toString()).innerHTML = "El campo " + elementos[i].id + " está vacío";
            estanCorrectos = false;
//Se establece el contenido del elemento HTML con el ID "campo" + (i+1).toString() a una cadena vacía. 
//Esto se hace para borrar cualquier mensaje de error previamente mostrado.
//Se verifica si el valor del elemento actual (elementos[i].value) está vacío ("") o si es una casilla de verificación (checkbox) que no está marcada.
//Si alguna de estas condiciones se cumple, se establece un mensaje de error en el elemento HTML correspondiente al campo afectado. 
//El mensaje indica que el campo está vacío.
//Además, se cambia el valor de estanCorrectos a false para indicar que al menos uno de los campos no está lleno o no es válido.
        }
        
    }
    if (!validarEmail()){ // Si no es válido el correo
        document.getElementById("campo3").innerHTML = "Email no válido";        
        estanCorrectos = false;
    }
    if (!validaPasswords()){ // Si no son válidas las contraseñas
        document.getElementById("campo4").innerHTML = "El PIN no cumple con requisitos de longitud o no coinciden";        
        document.getElementById("campo5").innerHTML = "El PIN no cumple con requisitos de longitud o no coinciden";
        estanCorrectos = false;
    }
    if (!validarDNI()){
        document.getElementById("campo6").innerHTML = "DNI no válido (12345678X)";
        estanCorrectos = false;
    }
    return estanCorrectos;
}
/* Función validarEmail tomada de:
* https://www.coderbox.net/blog/validar-email-usando-javascript-y-expresiones-regulares/
*/
function validarEmail(){              
	var valido;
	var emailField = document.getElementById('email');
	var validEmail =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
	if( validEmail.test(emailField.value) ){
		valido=true;
	}else{
        valido=false;
	}
    return valido;
} 
function validaPasswords(){
    // return (document.getElementById("password1").value == document.getElementById("password2").value) && document.getElementById("password2").value.length>=8;
    let clave1 = document.getElementById("password1").value;
    let clave2 = document.getElementById("password2").value;
    let passwordsOK = true; // Cumple con los requisitos establecidos
    if (clave1.length<8 || (clave1!=clave2))
        passwordsOK = false;
    return passwordsOK;
}

function validarDNI(){
    var letra=['T','R','W','A','G','M','Y','F','P','D','X','B','N','J','Z','S','Q','V','H','L','C','K','E'];
    var cadena = document.getElementById("dni").value; // DNI Completo
    var numero = parseInt(cadena.substring(0,8)); // Parte numérica
    var letraUsuario = cadena[8]; // Letra escrita por el usuario
    var letraReal = letra[numero%23]; // Letra "real" del DNI calculada según "fórmula"
    var dniValido =true;
    
    if (letraUsuario!=letraReal) // Si no coincide letras es falso
        dniValido = false;
    return dniValido;
}
function limpia(){
    let cadena = document.getElementById("cadena").value;
    let cadenaSinEspacios = cadena.replace(/ /g,"");
//Se utiliza el método replace() para eliminar todos los espacios en blanco de la cadena utilizando una expresión regular / /g que busca todos los espacios en blanco y los reemplaza con una cadena vacía. 
//El resultado se almacena en la variable cadenaSinEspacios.
    let cadenaLimpia = cadenaSinEspacios.toUpperCase();
//Se utiliza el método toUpperCase() para convertir todos los caracteres de la cadena a mayúsculas. 
//El resultado se almacena en la variable cadenaLimpia.
    document.getElementById(resultado).innerHTML =  cadenaLimpia;
// Se actualiza el contenido del elemento HTML con el ID "resultado" con el valor de cadenaLimpia. 
//Esto mostrará la cadena limpia y en mayúsculas en la página web.
}