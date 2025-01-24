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

// Obtener los departamentos
$query_departamentos = "SELECT id_dept, nom_dept FROM departamento";
$resultado_departamentos = mysqli_query($enlace, $query_departamentos);
$departamentos = mysqli_fetch_all($resultado_departamentos, MYSQLI_ASSOC);

// Obtener los profesores
$query_profesores = "SELECT id_prof, nom_prof FROM profesor";
$resultado_profesores = mysqli_query($enlace, $query_profesores);
$profesores = mysqli_fetch_all($resultado_profesores, MYSQLI_ASSOC);

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

    $query = "INSERT INTO actividad (titulo, tipo, departamento_id, profesor_id, trimestre, fecha_inicio, hora_inicio, fecha_fin, hora_fin, organizador, acompanantes, ubicacion, coste, total_alumnos, objetivo)
              VALUES ('$titulo', '$tipo', $departamento_id, $profesor_id, '$trimestre', '$fecha_inicio', '$hora_inicio', '$fecha_fin', '$hora_fin', '$organizador', '$acompanantes', '$ubicacion', $coste, $total_alumnos, '$objetivo')";

    if (mysqli_query($enlace, $query)) {
        $mensaje = "Actividad añadida correctamente.";
    } else {
        $mensaje = "Error al añadir la actividad: " . mysqli_error($enlace);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nueva Actividad</title>
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
            max-width: 800px;
        }

        h1 {
            color: #000066;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-bottom: 5px;
            color: #000066;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 5px #ccc;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #000066;
            color: #FFFF00;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 0 10px #FFFF00;
        }

        button:hover {
            background-color: #0056b3;
        }

        .mensaje {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Añadir Nueva Actividad</h1>
        <?php if (isset($mensaje)): ?>
            <div class="mensaje"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <form method="POST" action="nueva_actividad.php">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" required><br>

            <label for="tipo">Tipo:</label>
            <select name="tipo" required>
                <option value="extraescolar">Extraescolar</option>
                <option value="complementaria">Complementaria</option>
            </select><br>

            <label for="departamento">Departamento:</label>
            <select name="departamento" required>
                <?php foreach ($departamentos as $departamento): ?>
                    <option value="<?php echo $departamento['id_dept']; ?>"><?php echo $departamento['nom_dept']; ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="profesor">Profesor:</label>
            <select name="profesor" required>
                <?php foreach ($profesores as $profesor): ?>
                    <option value="<?php echo $profesor['id_prof']; ?>"><?php echo $profesor['nom_prof']; ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="trimestre">Trimestre:</label>
            <select name="trimestre" required>
                <option value="primero">Primero</option>
                <option value="segundo">Segundo</option>
                <option value="tercero">Tercero</option>
            </select><br>

            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" name="fecha_inicio" required><br>

            <label for="hora_inicio">Hora de Inicio:</label>
            <input type="time" name="hora_inicio" required><br>

            <label for="fecha_fin">Fecha de Fin:</label>
            <input type="date" name="fecha_fin" required><br>

            <label for="hora_fin">Hora de Fin:</label>
            <input type="time" name="hora_fin" required><br>

            <label for="organizador">Organizador:</label>
            <input type="text" name="organizador"><br>

            <label for="acompanantes">Acompañantes:</label>
            <input type="text" name="acompanantes"><br>

            <label for="ubicacion">Ubicación:</label>
            <input type="text" name="ubicacion"><br>

            <label for="coste">Coste:</label>
            <input type="number" step="0.01" name="coste"><br>

            <label for="total_alumnos">Total de Alumnos:</label>
            <input type="number" name="total_alumnos"><br>

            <label for="objetivo">Objetivo:</label>
            <textarea name="objetivo"></textarea><br>

            <button type="submit">Añadir Actividad</button>
        </form>
    </div>
</body>
</html>