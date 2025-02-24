<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
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

// Variables para mantener los valores del formulario
$titulo = $tipo = $departamento_id = $profesor_id = $trimestre = $fecha_inicio = $hora_inicio = $fecha_fin = $hora_fin = $organizador = $acompanantes = $ubicacion = $coste = $total_alumnos = $objetivo = '';

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    // Validar que el coste no sea negativo
    if ($coste < 0) {
        $mensaje = "El coste no puede ser negativo.";
        $error_coste = true;
    }
    // Validar que la fecha de finalización no sea anterior a la fecha de inicio
    elseif (strtotime($fecha_fin . ' ' . $hora_fin) <= strtotime($fecha_inicio . ' ' . $hora_inicio)) {
        $mensaje = "La fecha de finalización no puede ser anterior a la fecha de inicio.";
        $error_fecha = true;
    } else {
        $query = "INSERT INTO actividad (titulo, tipo, departamento_id, profesor_id, trimestre, fecha_inicio, hora_inicio, fecha_fin, hora_fin, organizador, acompanantes, ubicacion, coste, total_alumnos, objetivo)
                  VALUES ('$titulo', '$tipo', $departamento_id, $profesor_id, '$trimestre', '$fecha_inicio', '$hora_inicio', '$fecha_fin', '$hora_fin', '$organizador', '$acompanantes', '$ubicacion', $coste, $total_alumnos, '$objetivo')";

        if (mysqli_query($enlace, $query)) {
            $mensaje = "Actividad añadida correctamente.";
            // Limpiar los valores del formulario después de un éxito
            $titulo = $tipo = $departamento_id = $profesor_id = $trimestre = $fecha_inicio = $hora_inicio = $fecha_fin = $hora_fin = $organizador = $acompanantes = $ubicacion = $coste = $total_alumnos = $objetivo = '';
        } else {
            $mensaje = "Error al añadir la actividad: " . mysqli_error($enlace);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nueva Actividad</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="style.css">
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
        .mensaje {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #d1ecf1;
            background-color: #d1ecf1;
            border-radius: 5px;
        }
        .error {
            border-color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Añadir Nueva Actividad</h1>
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-info"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <form method="POST" action="nueva.php">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($titulo); ?>" required>
            </div>

            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <select class="form-control" id="tipo" name="tipo" required>
                    <option value="extraescolar" <?php if ($tipo === 'extraescolar') echo 'selected'; ?>>Extraescolar</option>
                    <option value="complementaria" <?php if ($tipo === 'complementaria') echo 'selected'; ?>>Complementaria</option>
                </select>
            </div>

            <div class="form-group">
                <label for="departamento">Departamento:</label>
                <select class="form-control" id="departamento" name="departamento" required>
                    <?php foreach ($departamentos as $departamento): ?>
                        <option value="<?php echo $departamento['id_dept']; ?>" <?php if ($departamento_id == $departamento['id_dept']) echo 'selected'; ?>><?php echo $departamento['nom_dept']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="profesor">Profesor:</label>
                <select class="form-control" id="profesor" name="profesor" required>
                    <?php foreach ($profesores as $profesor): ?>
                        <option value="<?php echo $profesor['id_prof']; ?>" <?php if ($profesor_id == $profesor['id_prof']) echo 'selected'; ?>><?php echo $profesor['nom_prof']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="trimestre">Trimestre:</label>
                <select class="form-control" id="trimestre" name="trimestre" required>
                    <option value="primero" <?php if ($trimestre === 'primero') echo 'selected'; ?>>Primero</option>
                    <option value="segundo" <?php if ($trimestre === 'segundo') echo 'selected'; ?>>Segundo</option>
                    <option value="tercero" <?php if ($trimestre === 'tercero') echo 'selected'; ?>>Tercero</option>
                </select>
            </div>

            <div class="form-group <?php if (isset($error_fecha)) echo 'error'; ?>">
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="text" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo htmlspecialchars($fecha_inicio); ?>" required>
            </div>

            <div class="form-group <?php if (isset($error_fecha)) echo 'error'; ?>">
                <label for="hora_inicio">Hora de Inicio:</label>
                <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" value="<?php echo htmlspecialchars($hora_inicio); ?>" required>
            </div>

            <div class="form-group <?php if (isset($error_fecha)) echo 'error'; ?>">
                <label for="fecha_fin">Fecha de Fin:</label>
                <input type="text" class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo htmlspecialchars($fecha_fin); ?>" required>
            </div>

            <div class="form-group <?php if (isset($error_fecha)) echo 'error'; ?>">
                <label for="hora_fin">Hora de Fin:</label>
                <input type="time" class="form-control" id="hora_fin" name="hora_fin" value="<?php echo htmlspecialchars($hora_fin); ?>" required>
            </div>

            <div class="form-group">
                <label for="organizador">Organizador:</label>
                <input type="text" class="form-control" id="organizador" name="organizador" value="<?php echo htmlspecialchars($organizador); ?>">
            </div>

            <div class="form-group">
                <label for="acompanantes">Acompañantes:</label>
                <input type="text" class="form-control" id="acompanantes" name="acompanantes" value="<?php echo htmlspecialchars($acompanantes); ?>">
            </div>

            <div class="form-group">
                <label for="ubicacion">Ubicación:</label>
                <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="<?php echo htmlspecialchars($ubicacion); ?>">
            </div>

            <div class="form-group <?php if (isset($error_coste)) echo 'error'; ?>">
                <label for="coste">Coste:</label>
                <input type="number" step="0.01" class="form-control" id="coste" name="coste" value="<?php echo htmlspecialchars($coste); ?>">
            </div>

            <div class="form-group">
                <label for="total_alumnos">Total de Alumnos:</label>
                <input type="number" class="form-control" id="total_alumnos" name="total_alumnos" value="<?php echo htmlspecialchars($total_alumnos); ?>">
            </div>

            <div class="form-group">
                <label for="objetivo">Objetivo:</label>
                <textarea class="form-control" id="objetivo" name="objetivo"><?php echo htmlspecialchars($objetivo); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Añadir Actividad</button>
            <a href="consultar.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="modo.js"></script>
    <script>
        $(function() {
            // Configurar el datepicker para la fecha de inicio
            $("#fecha_inicio").datepicker({
                dateFormat: "yy-mm-dd",
                minDate: 0 // No se pueden seleccionar días anteriores a hoy
            });

            // Configurar el datepicker para la fecha de fin
            $("#fecha_fin").datepicker({
                dateFormat: "yy-mm-dd",
                minDate: 1 // No se pueden seleccionar días anteriores a la fecha de inicio
            });

            // Actualizar la fecha mínima de la fecha de fin cuando cambia la fecha de inicio
            $("#fecha_inicio").on("change", function() {
                var fechaInicio = $(this).datepicker("getDate");
                if (fechaInicio) {
                    fechaInicio.setDate(fechaInicio.getDate());
                    $("#fecha_fin").datepicker("option", "minDate", fechaInicio);
                }
            });
        });
    </script>
</body>
</html>