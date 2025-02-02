<?php
session_start();

// Verificar si la sesión está iniciada
if (!isset($_SESSION['usuarios_nombre'])) {
    header("Location: logins.php");
    exit();
}

// Conexión a la base de datos
include "conexion.php";

// Procesar la eliminación de actividades seleccionadas
if (isset($_POST['eliminar_seleccionadas'])) {
    $ids_actividades = $_POST['actividades'];
    if (!empty($ids_actividades)) {
        $query_eliminar = "DELETE FROM actividad WHERE id IN (" . implode(",", array_map('intval', $ids_actividades)) . ")";
        if (mysqli_query($enlace, $query_eliminar)) {
            header("Location: eliminar.php");
            exit();
        } else {
            echo "Error al eliminar las actividades: " . mysqli_error($enlace);
        }
    }
}

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
        a.objetivo
    FROM
        actividad a,
        departamento d,
        profesor p
    WHERE
        a.profesor_id = p.id_prof AND
        a.departamento_id = d.id_dept;
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
    <title>Eliminar Actividades</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .caja {
            margin-left: 10px;
            margin-right: 10px;
        }
        .table-container {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="caja">
        <h1>Eliminar Actividades</h1>
        <form method="POST" action="">
            <table class="table table-bordered table-hover table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Seleccionar</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Departamento</th>
                        <th>Profesor</th>
                        <th>Trimestre</th>
                        <th>Fecha de Inicio</th>
                        <th>Hora de Inicio</th>
                        <th>Fecha de Fin</th>
                        <th>Hora de Fin</th>
                        <th>Organizador</th>
                        <th>Acompañantes</th>
                        <th>Ubicación</th>
                        <th>Coste</th>
                        <th>Total de Alumnos</th>
                        <th>Objetivo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($actividades as $actividad): ?>
                        <tr>
                            <td><input type="checkbox" name="actividades[]" value="<?php echo $actividad['id']; ?>"></td>
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
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" name="eliminar_seleccionadas" class="btn btn-danger">Eliminar Seleccionadas</button>
            <a href="consultar.php" class="btn btn-secondary">Cancelar</a>

        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>