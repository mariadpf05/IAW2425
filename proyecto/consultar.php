<?php
session_start();

// Verificar si la sesión está iniciada
if (!isset($_SESSION['usuarios_nombre'])) {
    header("Location: logins.php");
    exit();
}

// Conexión a la base de datos
include "conexion.php";

if (!$enlace) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Obtener el parámetro de ordenamiento
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'titulo';
$direccion = isset($_GET['direccion']) && $_GET['direccion'] === 'desc' ? 'desc' : 'asc';

// Obtener las actividades
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
    ORDER BY $orden $direccion;
";
$resultado_actividades = mysqli_query($enlace, $query_actividades);
$actividades = mysqli_fetch_all($resultado_actividades, MYSQLI_ASSOC);

mysqli_close($enlace);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Actividades</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .caja {
            margin-left: 10px;
            margin-right: 10px;
        }
        .btn-gestion {
            margin-bottom: 20px;
        }
        .table-container {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="caja">
        <h1 class="mb-4">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuarios_nombre']); ?>!</h1>
        <h1 class="mb-4">Consultar Actividades</h1>
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
        <a href="nueva.php" class="btn btn-primary">Añadir Actividad</a>
        <?php if ($_SESSION['usuarios_roles'] == 'administrador'): ?>
            <a href="eliminar.php?id=<?php echo $actividad['id']; ?>" class="btn btn-danger">Eliminar</a>
        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>