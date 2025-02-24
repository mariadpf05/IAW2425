document.addEventListener('DOMContentLoaded', function() {
    const modoOscuroButton = document.getElementById('modo-oscuro');

    // Verificar si el modo oscuro está almacenado en localStorage
    if (localStorage.getItem('modoOscuro') === 'enabled') {
        document.body.classList.add('modo-oscuro');
    }

    // Agregar evento de clic al botón
    modoOscuroButton.addEventListener('click', function() {
        document.body.classList.toggle('modo-oscuro');

        // Guardar la preferencia en localStorage
        if (document.body.classList.contains('modo-oscuro')) {
            localStorage.setItem('modoOscuro', 'enabled');
        } else {
            localStorage.setItem('modoOscuro', 'disabled');
        }
    });
});
