<?php
session_start();

// Verificar si la sesión está iniciada
if (!isset($_SESSION['usuarios_nombre'])) {
    header("Location: logins.php");
    exit();
}

// Conexión a la base de datos
$servername = "sql308.thsite.top"; //Nombre del servidor
$username = "thsi_38097480"; //Nombre de usuario
$password = "!GlJRfwv"; //Contraseña
$database = "thsi_38097480_proyecto";
$enlace = mysqli_connect($servername, $username, $password, $database);

if (!$enlace) {
    die("Ocurrió algún problema con la conexión: " . mysqli_connect_error());
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

// Obtener los departamentos
$query_departamentos = "SELECT id_dept, nom_dept FROM departamento";
$resultado_departamentos = mysqli_query($enlace, $query_departamentos);
$departamentos = mysqli_fetch_all($resultado_departamentos, MYSQLI_ASSOC);

// Obtener los profesores
$query_profesores = "SELECT id_prof, nom_prof FROM profesor";
$resultado_profesores = mysqli_query($enlace, $query_profesores);
$profesores = mysqli_fetch_all($resultado_profesores, MYSQLI_ASSOC);

// Procesar el formulario de edición
$mensaje = "";
$actividad_editar = null;
if (isset($_GET['editar'])) {
    $id_actividad = intval($_GET['editar']);
    $query_actividad = "SELECT * FROM actividad WHERE id = $id_actividad";
    $resultado_actividad = mysqli_query($enlace, $query_actividad);
    $actividad_editar = mysqli_fetch_assoc($resultado_actividad);

    if (!$actividad_editar) {
        $mensaje = "Actividad no encontrada.";
    }
} elseif (isset($_POST['editar'])) {
    $id_actividad = intval($_POST['id']);
    $titulo = $_POST['titulo'];
    $tipo = $_POST['tipo'];
    $departamento_id = $_POST['departamento'];
    $profesor_id = $_POST['profesor'];
    $trimestre = $_POST['trimestre'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $hora_inicio = $_POST['hora_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $hora_fin = $_POST['hora_fin'];
    $organizador = $_POST['organizador'];
    $acompanantes = $_POST['acompanantes'];
    $ubicacion = $_POST['ubicacion'];
    $coste = $_POST['coste'];
    $total_alumnos = $_POST['total_alumnos'];
    $objetivo = $_POST['objetivo'];

    $query = "UPDATE actividad SET
                titulo = '$titulo',
                tipo = '$tipo',
                departamento_id = $departamento_id,
                profesor_id = $profesor_id,
                trimestre = '$trimestre',
                fecha_inicio = '$fecha_inicio',
                hora_inicio = '$hora_inicio',
                fecha_fin = '$fecha_fin',
                hora_fin = '$hora_fin',
                organizador = '$organizador',
                acompanantes = '$acompanantes',
                ubicacion = '$ubicacion',
                coste = $coste,
                total_alumnos = $total_alumnos,
                objetivo = '$objetivo'
              WHERE id = $id_actividad";

    if (mysqli_query($enlace, $query)) {
        header("Location: editar.php");
        exit();
    } else {
        $mensaje = "Error al actualizar la actividad: " . mysqli_error($enlace);
    }
}
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
            max-width: 1200px; /* Aumentar el ancho máximo */
            overflow-y: auto; /* Permitir desplazamiento vertical */
            margin: 50px 0; /* Añadir margen arriba y abajo */
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

        form {
            display: flex;
            flex-wrap: wrap; /* Permitir que los elementos se envuelvan en múltiples líneas */
            justify-content: space-between; /* Espacio entre los elementos */
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
            width: 30%; /* Ajustar el ancho de los grupos de formulario */
        }

        .center-button {
            width: 100%; /* Ajustar el ancho del botón */
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #000066;
            color: #FFFF00;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 0 10px #FFFF00;
            margin-top: 20px; /* Añadir margen superior */
        }

        .center-button:hover {
            background-color: #0056b3;
        }

        label {
            margin-bottom: 5px;
            color: #000066;
        }

        input, select, textarea {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 5px #ccc;
        }

        .mensaje {
            color: red;
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

        .editar-btn {
            background-color: #ff0000;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            margin-right: 5px;
            background-color: #007BFF;
        }

        .editar-btn:hover {
            background-color: #cc0000;
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="gestion.php">Gestión</a>
        </div>
        <h1>Consultar Actividades</h1>
        <?php if ($mensaje): ?>
            <div class="mensaje"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <?php if (!$actividad_editar): ?>
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
                            <td>
                                <a href="?editar=<?php echo $actividad['id']; ?>" class="editar-btn">Editar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <?php if ($actividad_editar): ?>
            <div class="form-container">
                <h2>Editar Actividad</h2>
                <form method="POST" action="consultar.php">
                    <input type="hidden" name="editar" value="1">
                    <input type="hidden" name="id" value="<?php echo $actividad_editar['id']; ?>">
                    <div class="form-group">
                        <label for="titulo">Título:</label>
                        <input type="text" name="titulo" value="<?php echo htmlspecialchars($actividad_editar['titulo']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo">Tipo:</label>
                        <select name="tipo" required>
                            <option value="extraescolar" <?php echo $actividad_editar['tipo'] === 'extraescolar' ? 'selected' : ''; ?>>Extraescolar</option>
                            <option value="complementaria" <?php echo $actividad_editar['tipo'] === 'complementaria' ? 'selected' : ''; ?>>Complementaria</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="departamento">Departamento:</label>
                        <select name="departamento" required>
                            <?php foreach ($departamentos as $departamento): ?>
                                <option value="<?php echo $departamento['id_dept']; ?>" <?php echo $actividad_editar['departamento_id'] == $departamento['id_dept'] ? 'selected' : ''; ?>>
                                    <?php echo $departamento['nom_dept']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="profesor">Profesor:</label>
                        <select name="profesor" required>
                            <?php foreach ($profesores as $profesor): ?>
                                <option value="<?php echo $profesor['id_prof']; ?>" <?php echo $actividad_editar['profesor_id'] == $profesor['id_prof'] ? 'selected' : ''; ?>>
                                    <?php echo $profesor['nom_prof']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="trimestre">Trimestre:</label>
                        <select name="trimestre" required>
                            <option value="primero" <?php echo $actividad_editar['trimestre'] === 'primero' ? 'selected' : ''; ?>>Primero</option>
                            <option value="segundo" <?php echo $actividad_editar['trimestre'] === 'segundo' ? 'selected' : ''; ?>>Segundo</option>
                            <option value="tercero" <?php echo $actividad_editar['trimestre'] === 'tercero' ? 'selected' : ''; ?>>Tercero</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha de Inicio:</label>
                        <input type="date" name="fecha_inicio" value="<?php echo htmlspecialchars($actividad_editar['fecha_inicio']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="hora_inicio">Hora de Inicio:</label>
                        <input type="time" name="hora_inicio" value="<?php echo htmlspecialchars($actividad_editar['hora_inicio']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_fin">Fecha de Fin:</label>
                        <input type="date" name="fecha_fin" value="<?php echo htmlspecialchars($actividad_editar['fecha_fin']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="hora_fin">Hora de Fin:</label>
                        <input type="time" name="hora_fin" value="<?php echo htmlspecialchars($actividad_editar['hora_fin']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="organizador">Organizador:</label>
                        <input type="text" name="organizador" value="<?php echo htmlspecialchars($actividad_editar['organizador']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="acompanantes">Acompañantes:</label>
                        <input type="text" name="acompanantes" value="<?php echo htmlspecialchars($actividad_editar['acompanantes']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="ubicacion">Ubicación:</label>
                        <input type="text" name="ubicacion" value="<?php echo htmlspecialchars($actividad_editar['ubicacion']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="coste">Coste:</label>
                        <input type="number" step="0.01" name="coste" value="<?php echo htmlspecialchars($actividad_editar['coste']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="total_alumnos">Total de Alumnos:</label>
                        <input type="number" name="total_alumnos" value="<?php echo htmlspecialchars($actividad_editar['total_alumnos']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="objetivo">Objetivo:</label>
                        <textarea name="objetivo"><?php echo htmlspecialchars($actividad_editar['objetivo']); ?></textarea>
                    </div>
                    <button type="submit" class="center-button">Actualizar Actividad</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>