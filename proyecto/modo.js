if (localStorage.getItem('modoOscuro') === 'true') {
    document.body.classList.add('modo-oscuro'); // Aplicar modo oscuro
    document.getElementById('cambiar-tema').innerHTML = '<i class="fas fa-sun"></i> Modo Claro'; // Cambiar ícono y texto
}

// Paso 2: Escuchar el clic en el botón
document.getElementById('cambiar-tema').addEventListener('click', function() {
    // Alternar la clase 'modo-oscuro' en el body
    document.body.classList.toggle('modo-oscuro');

    // Guardar la preferencia en localStorage
    if (document.body.classList.contains('modo-oscuro')) {
        localStorage.setItem('modoOscuro', 'true'); // Guardar que el modo oscuro está activado
        this.innerHTML = '<i class="fas fa-sun"></i> Modo Claro'; // Cambiar ícono y texto
    } else {
        localStorage.setItem('modoOscuro', 'false'); // Guardar que el modo oscuro está desactivado
        this.innerHTML = '<i class="fas fa-moon"></i> Modo Oscuro'; // Cambiar ícono y texto
    }
});