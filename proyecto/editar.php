<?php
session_start();

// Verificar si la sesión está iniciada
if (!isset($_SESSION['usuarios_nombre'])) {
    header("Location: logins.php");
    exit();
}
if (!isset($_SESSION['usuarios_roles']) || $_SESSION['usuarios_roles'] != 'administrador') {
    header("Location: consultar.php");
    exit();
}
// Conexión a la base de datos
include "conexion.php";

// Obtener los departamentos
$query_departamentos = "SELECT id_dept, nom_dept FROM departamento";
$resultado_departamentos = mysqli_query($enlace, $query_departamentos);
$departamentos = mysqli_fetch_all($resultado_departamentos, MYSQLI_ASSOC);

// Obtener los profesores
$query_profesores = "SELECT id_prof, nom_prof FROM profesor";
$resultado_profesores = mysqli_query($enlace, $query_profesores);
$profesores = mysqli_fetch_all($resultado_profesores, MYSQLI_ASSOC);

if (isset($_GET['id'])) {
    $actividad_id = $_GET['id'];
    $query = "SELECT * FROM actividad WHERE id = $actividad_id";
    $resultado = mysqli_query($enlace, $query);
    $actividad = mysqli_fetch_assoc($resultado);
    mysqli_close($enlace);
} else {
    header("Location: consultar.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar la actualización de la actividad
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

    include "conexion.php";
    $update_query = "UPDATE actividad SET
        titulo = '$titulo',
        tipo = '$tipo',
        departamento_id = '$departamento_id',
        profesor_id = '$profesor_id',
        trimestre = '$trimestre',
        fecha_inicio = '$fecha_inicio',
        hora_inicio = '$hora_inicio',
        fecha_fin = '$fecha_fin',
        hora_fin = '$hora_fin',
        organizador = '$organizador',
        acompanantes = '$acompanantes',
        ubicacion = '$ubicacion',
        coste = '$coste',
        total_alumnos = '$total_alumnos',
        objetivo = '$objetivo'
        WHERE id = $actividad_id";

    mysqli_query($enlace, $update_query);
    mysqli_close($enlace);
    header("Location: consultar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="vie<?php
session_start();

// Verificar si la sesión está iniciada
if (!isset($_SESSION['usuarios_nombre'])) {
    header("Location: logins.php");
    exit();
}

// Conexión a la base de datos
include "conexion.php";

// Obtener los departamentos
$query_departamentos = "SELECT id_dept, nom_dept FROM departamento";
$resultado_departamentos = mysqli_query($enlace, $query_departamentos);
$departamentos = mysqli_fetch_all($resultado_departamentos, MYSQLI_ASSOC);

// Obtener los profesores
$query_profesores = "SELECT id_prof, nom_prof FROM profesor";
$resultado_profesores = mysqli_query($enlace, $query_profesores);
$profesores = mysqli_fetch_all($resultado_profesores, MYSQLI_ASSOC);

if (isset($_GET['id'])) {
    $actividad_id = $_GET['id'];
    $query = "SELECT * FROM actividad WHERE id = $actividad_id";
    $resultado = mysqli_query($enlace, $query);
    $actividad = mysqli_fetch_assoc($resultado);
    mysqli_close($enlace);
} else {
    header("Location: consultar.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar la actualización de la actividad
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

    include "conexion.php";
    $update_query = "UPDATE actividad SET
        titulo = '$titulo',
        tipo = '$tipo',
        departamento_id = '$departamento_id',
        profesor_id = '$profesor_id',
        trimestre = '$trimestre',
        fecha_inicio = '$fecha_inicio',
        hora_inicio = '$hora_inicio',
        fecha_fin = '$fecha_fin',
        hora_fin = '$hora_fin',
        organizador = '$organizador',
        acompanantes = '$acompanantes',
        ubicacion = '$ubicacion',
        coste = '$coste',
        total_alumnos = '$total_alumnos',
        objetivo = '$objetivo'
        WHERE id = $actividad_id";

    mysqli_query($enlace, $update_query);
    mysqli_close($enlace);
    header("Location: consultar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Actividad</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-primary, .btn-secondary {
            margin-top: 10px;
        }
        .header {
            margin-bottom: 20px;
        }
        .header a {
            margin-right: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .header a:hover {
            text-decoration: underline;
        }
        .mensaje {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #d1ecf1;
            background-color: #d1ecf1;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="gestion.php">Gestión</a>
            <a href="consultar.php">Consultar</a>
        </div>
        <h1 class="mb-4">Editar Actividad</h1>
        <form method="POST" action="editar.php?id=<?php echo $actividad['id']; ?>">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($actividad['titulo']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <select class="form-control" id="tipo" name="tipo" required>
                    <option value="extraescolar" <?php if ($actividad['tipo'] == 'extraescolar') echo 'selected'; ?>>Extraescolar</option>
                    <option value="complementaria" <?php if ($actividad['tipo'] == 'complementaria') echo 'selected'; ?>>Complementaria</option>
                </select>
            </div>
            <div class="form-group">
                <label for="departamento">Departamento:</label>
                <select class="form-control" id="departamento" name="departamento" required>
                    <?php foreach ($departamentos as $departamento): ?>
                        <option value="<?php echo $departamento['id_dept']; ?>" <?php if ($actividad['departamento_id'] == $departamento['id_dept']) echo 'selected'; ?>><?php echo $departamento['nom_dept']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="profesor">Profesor:</label>
                <select class="form-control" id="profesor" name="profesor" required>
                    <?php foreach ($profesores as $profesor): ?>
                        <option value="<?php echo $profesor['id_prof']; ?>" <?php if ($actividad['profesor_id'] == $profesor['id_prof']) echo 'selected'; ?>><?php echo $profesor['nom_prof']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="trimestre">Trimestre:</label>
                <select class="form-control" id="trimestre" name="trimestre" required>
                    <option value="primero" <?php if ($actividad['trimestre'] == 'primero') echo 'selected'; ?>>Primero</option>
                    <option value="segundo" <?php if ($actividad['trimestre'] == 'segundo') echo 'selected'; ?>>Segundo</option>
                    <option value="tercero" <?php if ($actividad['trimestre'] == 'tercero') echo 'selected'; ?>>Tercero</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo htmlspecialchars($actividad['fecha_inicio']); ?>" required>
            </div>
            <div class="form-group">
                <label for="hora_inicio">Hora de Inicio:</label>
                <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" value="<?php echo htmlspecialchars($actividad['hora_inicio']); ?>" required>
            </div>
            <div class="form-group">
                <label for="fecha_fin">Fecha de Fin:</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo htmlspecialchars($actividad['fecha_fin']); ?>" required>
            </div>
            <div class="form-group">
                <label for="hora_fin">Hora de Fin:</label>
                <input type="time" class="form-control" id="hora_fin" name="hora_fin" value="<?php echo htmlspecialchars($actividad['hora_fin']); ?>" required>
            </div>
            <div class="form-group">
                <label for="organizador">Organizador:</label>
                <input type="text" class="form-control" id="organizador" name="organizador" value="<?php echo htmlspecialchars($actividad['organizador']); ?>">
            </div>
            <div class="form-group">
                <label for="acompanantes">Acompañantes:</label>
                <input type="text" class="form-control" id="acompanantes" name="acompanantes" value="<?php echo htmlspecialchars($actividad['acompanantes']); ?>">
            </div>
            <div class="form-group">
                <label for="ubicacion">Ubicación:</label>
                <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="<?php echo htmlspecialchars($actividad['ubicacion']); ?>">
            </div>
            <div class="form-group">
                <label for="coste">Coste:</label>
                <input type="text" class="form-control" id="coste" name="coste" value="<?php echo htmlspecialchars($actividad['coste']); ?>">
            </div>
            <div class="form-group">
                <label for="total_alumnos">Total Alumnos:</label>
                <input type="text" class="form-control" id="total_alumnos" name="total_alumnos" value="<?php echo htmlspecialchars($actividad['total_alumnos']); ?>">
            </div>
            <div class="form-group">
                <label for="objetivo">Objetivo:</label>
                <input type="text" class="form-control" id="objetivo" name="objetivo" value="<?php echo htmlspecialchars($actividad['objetivo']); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>wport" content="width=device-width, initial-scale=1.0">
    <title>Editar Actividad</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-primary, .btn-secondary {
            margin-top: 10px;
        }
        .header {
            margin-bottom: 20px;
        }
        .header a {
            margin-right: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .header a:hover {
            text-decoration: underline;
        }
        .mensaje {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #d1ecf1;
            background-color: #d1ecf1;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="gestion.php">Gestión</a>
            <a href="consultar.php">Consultar</a>
        </div>
        <h1 class="mb-4">Editar Actividad</h1>
        <form method="POST" action="editar.php?id=<?php echo $actividad['id']; ?>">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($actividad['titulo']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <select class="form-control" id="tipo" name="tipo" required>
                    <option value="extraescolar" <?php if ($actividad['tipo'] == 'extraescolar') echo 'selected'; ?>>Extraescolar</option>
                    <option value="complementaria" <?php if ($actividad['tipo'] == 'complementaria') echo 'selected'; ?>>Complementaria</option>
                </select>
            </div>
            <div class="form-group">
                <label for="departamento">Departamento:</label>
                <select class="form-control" id="departamento" name="departamento" required>
                    <?php foreach ($departamentos as $departamento): ?>
                        <option value="<?php echo $departamento['id_dept']; ?>" <?php if ($actividad['departamento_id'] == $departamento['id_dept']) echo 'selected'; ?>><?php echo $departamento['nom_dept']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="profesor">Profesor:</label>
                <select class="form-control" id="profesor" name="profesor" required>
                    <?php foreach ($profesores as $profesor): ?>
                        <option value="<?php echo $profesor['id_prof']; ?>" <?php if ($actividad['profesor_id'] == $profesor['id_prof']) echo 'selected'; ?>><?php echo $profesor['nom_prof']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="trimestre">Trimestre:</label>
                <select class="form-control" id="trimestre" name="trimestre" required>
                    <option value="primero" <?php if ($actividad['trimestre'] == 'primero') echo 'selected'; ?>>Primero</option>
                    <option value="segundo" <?php if ($actividad['trimestre'] == 'segundo') echo 'selected'; ?>>Segundo</option>
                    <option value="tercero" <?php if ($actividad['trimestre'] == 'tercero') echo 'selected'; ?>>Tercero</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo htmlspecialchars($actividad['fecha_inicio']); ?>" required>
            </div>
            <div class="form-group">
                <label for="hora_inicio">Hora de Inicio:</label>
                <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" value="<?php echo htmlspecialchars($actividad['hora_inicio']); ?>" required>
            </div>
            <div class="form-group">
                <label for="fecha_fin">Fecha de Fin:</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo htmlspecialchars($actividad['fecha_fin']); ?>" required>
            </div>
            <div class="form-group">
                <label for="hora_fin">Hora de Fin:</label>
                <input type="time" class="form-control" id="hora_fin" name="hora_fin" value="<?php echo htmlspecialchars($actividad['hora_fin']); ?>" required>
            </div>
            <div class="form-group">
                <label for="organizador">Organizador:</label>
                <input type="text" class="form-control" id="organizador" name="organizador" value="<?php echo htmlspecialchars($actividad['organizador']); ?>">
            </div>
            <div class="form-group">
                <label for="acompanantes">Acompañantes:</label>
                <input type="text" class="form-control" id="acompanantes" name="acompanantes" value="<?php echo htmlspecialchars($actividad['acompanantes']); ?>">
            </div>
            <div class="form-group">
                <label for="ubicacion">Ubicación:</label>
                <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="<?php echo htmlspecialchars($actividad['ubicacion']); ?>">
            </div>
            <div class="form-group">
                <label for="coste">Coste:</label>
                <input type="text" class="form-control" id="coste" name="coste" value="<?php echo htmlspecialchars($actividad['coste']); ?>">
            </div>
            <div class="form-group">
                <label for="total_alumnos">Total Alumnos:</label>
                <input type="text" class="form-control" id="total_alumnos" name="total_alumnos" value="<?php echo htmlspecialchars($actividad['total_alumnos']); ?>">
            </div>
            <div class="form-group">
                <label for="objetivo">Objetivo:</label>
                <input type="text" class="form-control" id="objetivo" name="objetivo" value="<?php echo htmlspecialchars($actividad['objetivo']); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>