<?php
// Iniciar la sesión
session_start();

// Verificar si la variable de sesión 'visitas' existe
if (!isset($_SESSION['visitas'])) {
    // Si no existe, es la primera visita
    $_SESSION['visitas'] = 1;
    echo "Bienvenido, es tu primera visita.";
} else {
    // Si existe, incrementar el contador de visitas
    $_SESSION['visitas']++;
    echo "Has visitado esta página " . $_SESSION['visitas'] . " veces.";
}
?>
