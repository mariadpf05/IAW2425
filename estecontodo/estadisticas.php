<?php
session_start();

// Verificar si la sesión está iniciada
if (!isset($_SESSION['usuarios_nombre'])) {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
include "conexion.php";

if (!$enlace) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Obtener estadísticas por departamento y trimestre
$query_estadisticas = "
    SELECT
        (SELECT nom_dept FROM departamento WHERE id_dept = a.departamento_id) AS departamento,
        a.trimestre,
        SUM(CASE WHEN a.aprobada = 1 THEN 1 ELSE 0 END) AS aprobadas,
        SUM(CASE WHEN a.aprobada = 0 THEN 1 ELSE 0 END) AS no_aprobadas
    FROM
        actividad a
    GROUP BY
        a.departamento_id, a.trimestre
    ORDER BY
        departamento, a.trimestre;
";

$resultado_estadisticas = mysqli_query($enlace, $query_estadisticas);
$estadisticas = mysqli_fetch_all($resultado_estadisticas, MYSQLI_ASSOC);

mysqli_close($enlace);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas de Actividades</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="consultar.php" class="btn btn-primary m-3">Volver a Gestión de Actividades</a>

    <h1 class="mb-4">Estadísticas de Actividades</h1>

    <table class="table table-bordered table-hover table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Departamento</th>
                <th>Trimestre</th>
                <th>Aprobadas</th>
                <th>No Aprobadas</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estadisticas as $estadistica): ?>
                <tr>
                    <td><?php echo htmlspecialchars($estadistica['departamento']); ?></td>
                    <td><?php echo htmlspecialchars($estadistica['trimestre']); ?></td>
                    <td><?php echo htmlspecialchars($estadistica['aprobadas']); ?></td>
                    <td><?php echo htmlspecialchars($estadistica['no_aprobadas']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="modo.js"></script>
</body>
</html>
