<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
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

// Obtener el parámetro de ordenamiento
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'titulo';
$direccion = isset($_GET['direccion']) && $_GET['direccion'] === 'desc' ? 'desc' : 'asc';

// Asegurarse de que el nombre de la columna sea seguro
$columnas_validas = [
    'titulo', 'tipo', 'departamento', 'profesor', 'trimestre',
    'fecha_inicio', 'hora_inicio', 'fecha_fin', 'hora_fin',
    'organizador', 'acompanantes', 'ubicacion', 'coste',
    'total_alumnos', 'objetivo', 'aprobada'
];

if (!in_array($orden, $columnas_validas)) {
    $orden = 'titulo'; // Valor predeterminado si el nombre de la columna no es válido
}

// Obtener el parámetro de página
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$actividades_por_pagina = 5;
$inicio = ($pagina - 1) * $actividades_por_pagina;

// Obtener el total de actividades
$query_total_actividades = "SELECT COUNT(*) AS total FROM actividad;";
$resultado_total_actividades = mysqli_query($enlace, $query_total_actividades);
$total_actividades = mysqli_fetch_assoc($resultado_total_actividades)['total'];
$total_paginas = ceil($total_actividades / $actividades_por_pagina);

// Obtener las actividades para la página actual
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
    ORDER BY `$orden` $direccion
    LIMIT $actividades_por_pagina OFFSET $inicio;
";
$resultado_actividades = mysqli_query($enlace, $query_actividades);
$actividades = mysqli_fetch_all($resultado_actividades, MYSQLI_ASSOC);

// Obtener totales
$query_total_aprobadas = "SELECT COUNT(*) AS total FROM actividad WHERE aprobada = 1;";
$query_total_pendientes = "SELECT COUNT(*) AS total FROM actividad WHERE aprobada = 0;";

$resultado_aprobadas = mysqli_query($enlace, $query_total_aprobadas);
$resultado_pendientes = mysqli_query($enlace, $query_total_pendientes);

$total_aprobadas = mysqli_fetch_assoc($resultado_aprobadas)['total'];
$total_pendientes = mysqli_fetch_assoc($resultado_pendientes)['total'];

mysqli_close($enlace);

// Establecer el huso horario de España
date_default_timezone_set('Europe/Madrid');

// Formatear la última conexión en español
$ultima_conexion = new DateTime($_SESSION['ultima_conexion']);
$formatter = new IntlDateFormatter(
    'es_ES',
    IntlDateFormatter::FULL,
    IntlDateFormatter::SHORT,
    'Europe/Madrid',
    IntlDateFormatter::GREGORIAN
);
$ultima_conexion_formateada = $formatter->format($ultima_conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Actividades</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="cerrar.php" class="btn btn-danger m-3">Cerrar Sesión</a>
    <?php if ($_SESSION['usuarios_roles'] == 'administrador'): ?>
        <a href="gestion-departamentos.php" class="btn btn-primary">Gestionar departamentos</a>
    <?php endif; ?>
    <a href="estadisticas.php" class="btn btn-warning m-3">Estadísticas</a>
    <?php if ($_SESSION['usuarios_roles'] == 'administrador'): ?>
        <a href="gestion_usuarios.php" class="btn btn-primary">Gestionar usuarios</a>
    <?php endif; ?>
    <a href="descargar_actividades.php" class="btn btn-warning m-3">Descargar actividades</a>
    <button id="modo-oscuro" class="btn btn-secondary m-3">Modo Oscuro</button>
    <h1 class="mb-4">
        Bienvenido, <?php echo htmlspecialchars($_SESSION['usuarios_nombre']); ?>, se conectó por última vez el <?php echo $ultima_conexion_formateada; ?>
    </h1>
    <h1 class="mb-4">Consultar Actividades</h1>

    <div class="d-flex justify-content-between mb-4">
        <div class="bg-secondary text-white p-2 rounded text-center flex-fill mx-1">
            <strong>Total Actividades Propuestas:</strong> <?php echo $total_actividades; ?>
        </div>
        <div class="bg-secondary text-white p-2 rounded text-center flex-fill mx-1">
            <strong>Total Actividades Aprobadas:</strong> <?php echo $total_aprobadas; ?>
        </div>
        <div class="bg-secondary text-white p-2 rounded text-center flex-fill mx-1">
            <strong>Total Actividades Pendientes:</strong> <?php echo $total_pendientes; ?>
        </div>
    </div>

    <table class="table table-bordered table-hover table-striped">
        <thead class="thead-dark">
            <tr>
                <th><a href="?orden=titulo&direccion=<?php echo $direccion == 'asc' ? 'desc' : 'asc'; ?>">Título</a></th>
                <th><a href="?orden=tipo&direccion=<?php echo $direccion == 'asc' ? 'desc' : 'asc'; ?>">Tipo</a></th>
                <th><a href="?orden=departamento&direccion=<?php echo $direccion == 'asc' ? 'desc' : 'asc'; ?>">Departamento</a></th>
                <th><a href="?orden=profesor&direccion=<?php echo $direccion == 'asc' ? 'desc' : 'asc'; ?>">Profesor</a></th>
                <th><a href="?orden=trimestre&direccion=<?php echo $direccion == 'asc' ? 'desc' : 'asc'; ?>">Trimestre</a></th>
                <th><a href="?orden=fecha_inicio&direccion=<?php echo $direccion == 'asc' ? 'desc' : 'asc'; ?>">Fecha de Inicio</a></th>
                <th><a href="?orden=hora_inicio&direccion=<?php echo $direccion == 'asc' ? 'desc' : 'asc'; ?>">Hora de Inicio</a></th>
                <th><a href="?orden=fecha_fin&direccion=<?php echo $direccion == 'asc' ? 'desc' : 'asc'; ?>">Fecha de Fin</a></th>
                <th><a href="?orden=hora_fin&direccion=<?php echo $direccion == 'asc' ? 'desc' : 'asc'; ?>">Hora de Fin</a></th>
                <th><a href="?orden=organizador&direccion=<?php echo $direccion == 'asc' ? 'desc' : 'asc'; ?>">Organizador</a></th>
                <th><a href="?orden=acompanantes&direccion=<?php echo $direccion == 'asc' ? 'desc' : 'asc'; ?>">Acompañantes</a></th>
                <th><a href="?orden=ubicacion&direccion=<?php echo $direccion == 'asc' ? 'desc' : 'asc'; ?>">Ubicación</a></th>
                <th><a href="?orden=coste&direccion=<?php echo $direccion == 'asc' ? 'desc' : 'asc'; ?>">Coste</a></th>
                <th><a href="?orden=total_alumnos&direccion=<?php echo $direccion == 'asc' ? 'desc' : 'asc'; ?>">Total de Alumnos</a></th>
                <th><a href="?orden=objetivo&direccion=<?php echo $direccion == 'asc' ? 'desc' : 'asc'; ?>">Objetivo</a></th>
                <th><a href="?orden=aprobada&direccion=<?php echo $direccion == 'asc' ? 'desc' : 'asc'; ?>">Aprobada</a></th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($actividades as $actividad): ?>
                <tr>
                    <td><?php echo htmlspecialchars($actividad['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($actividad['tipo']); ?></td>
                    <td><?php echo htmlspecialchars($actividad['departamento']); ?></td>
                    <td><?php echo htmlspecialchars($actividad['profesor']); ?></td>
                    <td><?php echo htmlspecialchars($actividad['trimestre']); ?></td>
                    <td><?php echo htmlspecialchars($actividad['fecha_inicio']); ?></td>
                    <td><?php echo htmlspecialchars($actividad['hora_inicio']); ?></td>
                    <td><?php echo htmlspecialchars($actividad['fecha_fin']); ?></td>
                    <td><?php echo htmlspecialchars($actividad['hora_fin']); ?></td>
                    <td><?php echo htmlspecialchars($actividad['organizador']); ?></td>
                    <td><?php echo htmlspecialchars($actividad['acompanantes']); ?></td>
                    <td><?php echo htmlspecialchars($actividad['ubicacion']); ?></td>
                    <td><?php echo htmlspecialchars($actividad['coste']); ?></td>
                    <td><?php echo htmlspecialchars($actividad['total_alumnos']); ?></td>
                    <td><?php echo htmlspecialchars($actividad['objetivo']); ?></td>
                    <td><?php echo $actividad['aprobada'] ? 'Sí' : 'No'; ?></td>
                    <td>
                        <?php if ($_SESSION['usuarios_roles'] == 'administrador'): ?>
                            <a href="editar.php?id=<?php echo $actividad['id']; ?>" class="btn btn-primary">Modificar</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($pagina > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?php echo $pagina - 1; ?>&orden=<?php echo $orden; ?>&direccion=<?php echo $direccion; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <li class="page-item <?php echo $i == $pagina ? 'active' : ''; ?>">
                    <a class="page-link" href="?pagina=<?php echo $i; ?>&orden=<?php echo $orden; ?>&direccion=<?php echo $direccion; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($pagina < $total_paginas): ?>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?php echo $pagina + 1; ?>&orden=<?php echo $orden; ?>&direccion=<?php echo $direccion; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <a href="nueva.php" class="btn btn-primary">Añadir Actividad</a>
    <?php if ($_SESSION['usuarios_roles'] == 'administrador'): ?>
        <a href="eliminar.php" class="btn btn-danger">Eliminar Actividad</a>
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="modo.js"></script>
</body>
</html>