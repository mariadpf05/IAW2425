<?php
session_start();

// Verificar si la sesión está iniciada
if (!isset($_SESSION['usuarios_nombre'])) {
    header("Location: login.php");
    exit();
}

// Registrar el acceso en el archivo de logs
$log_message = date('Y-m-d H:i:s') . " - Usuario: " . $_SESSION['usuarios_nombre'] . " accedió a la gestión de actividades." . PHP_EOL;
file_put_contents('logs.txt', $log_message, FILE_APPEND);

// Conexión a la base de datos
include "conexion.php";

if (!$enlace) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Establecer cabeceras para la descarga del archivo
header('Content-Type: text/plain; charset=utf-8');
header('Content-Disposition: attachment; filename="actividades.txt"');

// Consulta para obtener todas las actividades
$query_actividades = "
    SELECT
        a.id,
        a.titulo,
        a.tipo,
        d.nom_dept AS departamento,
        p.nom_prof AS profesor,
        a.trimestre,
        a.fecha_inicio,
        a.hora_inicio,
        a.fecha_fin,
        a.hora_fin,
        a.organizador,
        a.acompanantes,
        a.ubicacion,
        a.coste,
        a.total_alumnos,
        a.objetivo,
        a.aprobada
    FROM
        actividad a,
        departamento d,
        profesor p
    WHERE
        a.profesor_id = p.id_prof AND
        a.departamento_id = d.id_dept
";

$resultado = mysqli_query($enlace, $query_actividades); // Usar $enlace en lugar de $conn

// Verificar si hay datos
if (mysqli_num_rows($resultado) > 0) {
    // Escribir los datos en el archivo de salida
    echo "ID | Título | Tipo | Departamento | Profesor | Trimestre | Fecha Inicio | Hora Inicio | Fecha Fin | Hora Fin | Organizador | Acompañantes | Ubicación | Coste | Total Alumnos | Objetivo | Aprobada\n";
    echo str_repeat("-", 160) . "\n";

    while ($actividad = mysqli_fetch_assoc($resultado)) {
        echo "{$actividad['id']} | {$actividad['titulo']} | {$actividad['tipo']} | {$actividad['departamento']} | {$actividad['profesor']} | {$actividad['trimestre']} | {$actividad['fecha_inicio']} | {$actividad['hora_inicio']} | {$actividad['fecha_fin']} | {$actividad['hora_fin']} | {$actividad['organizador']} | {$actividad['acompanantes']} | {$actividad['ubicacion']} | {$actividad['coste']} | {$actividad['total_alumnos']} | {$actividad['objetivo']} | {$actividad['aprobada']}\n";
    }
} else {
    echo "No hay actividades registradas.\n";
}

// Cerrar conexión
mysqli_close($enlace); // Usar $enlace en lugar de $conn
?>