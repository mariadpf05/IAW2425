var datos = [];
let almacenado = null;
function iniciar(){
    almacenado = localStorage.getItem("datos");
    if (almacenado!=null){ 
        almacenado = JSON.parse(almacenado); 
        datos = almacenado;
    }
    else{
        iniciar();
    }
}


function validar(elementos){
    let estanCorrectos = true;  
    for (var i=0;i<elementos.length;i++){
        document.getElementById("campo"+(i+1).toString()).innerHTML = ""; 
        if (elementos[i].value == "" || (i==7 && !elementos[i].checked)){
            document.getElementById("campo"+(i+1).toString()).innerHTML = "El campo " + elementos[i].id + " está vacío";
            estanCorrectos = false;
        }
        
    }
    if (!validarEmail()){ 
        document.getElementById("campo3").innerHTML = "Email no válido";        
        estanCorrectos = false;
    }
    if (!validaPasswords()){ 
        document.getElementById("campo4").innerHTML = "La contraseña no cumple con requisitos de longitud o no coinciden";        
        document.getElementById("campo5").innerHTML = "La contraseña no cumple con requisitos de longitud o no coinciden";
        estanCorrectos = false;
    }
    if (!validarDNI()){
        document.getElementById("campo6").innerHTML = "DNI no válido (12345678X)";
        estanCorrectos = false;
    }
    return estanCorrectos;
}

function validarEmail(){              
	var valido;
	var emailField = document.getElementById('email');
	var validEmail =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
	if( validEmail.test(emailField.value) ){
		valido=true;
        localStorage.setItem('datos', 'email');
	}else{
        valido=false;
	}
    return valido;
    
} 
function validaPasswords(){
    let clave1 = document.getElementById("password1").value;
    let clave2 = document.getElementById("password2").value;
    let passwordsOK = true;
    localStorage.setItem('datos', 'contraseña'); 
    if (clave1.length>8 || (clave1!=clave2))
        passwordsOK = false;
    return passwordsOK;
}

function validarDNI(){
    var letra=['T','R','W','A','G','M','Y','F','P','D','X','B','N','J','Z','S','Q','V','H','L','C','K','E'];
    var cadena = document.getElementById("dni").value; 
    var numero = parseInt(cadena.substring(0,8)); 
    var letraUsuario = cadena[8]; 
    var letraReal = letra[numero%23]; 
    var dniValido =true;
    localStorage.setItem('datos', 'DNI');
    
    if (letraUsuario!=letraReal) 
        dniValido = false;
    return dniValido;
}