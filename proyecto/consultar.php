<?php
session_start();

// Verificar si la sesión está iniciada
if (!isset($_SESSION['usuarios_nombre'])) {
    header("Location: logins.php");
    exit();
}

// Conexión a la base de datos
include "conexion.php";

// Obtener las actividades
$query_actividades = "
    SELECT
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Actividades</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #000066;
            font-family: Arial, sans-serif;
        }

        .container {
            background-color: #fafafa;
            padding: 50px;
            border: 3px solid #FFFF00;
            border-radius: 10px;
            box-shadow: 0 0 10px #FFFF00;
            text-align: center;
            width: 90%;
            max-width: 1600px; /* Ajustar el ancho máximo */
            overflow-x: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .header a {
            background-color: #000066;
            color: #FFFF00;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 0 10px #FFFF00;
        }

        .header a:hover {
            background-color: #0056b3;
        }

        h1 {
            color: #000066;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #000066;
            color: #FFFF00;
        }

        td {
            background-color: #fafafa;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="gestion.php">Gestión</a>
        </div>
        <h1>Consultar Actividades</h1>
        <table>
            <thead>
                <tr>
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
    </div>
</body>
</html>