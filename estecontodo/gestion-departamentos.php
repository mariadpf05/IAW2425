<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
// Verificar si el usuario es administrador
if ($_SESSION['usuarios_roles'] != 'administrador') {
    header("Location: index.php"); // Redirigir si no es administrador
    exit();
}

// Conexión a la base de datos
include "conexion.php";

// Procesar la eliminación de un departamento
if (isset($_GET['eliminar'])) {
    $departamento_id = filter_var($_GET['eliminar'], FILTER_VALIDATE_INT);

    if ($departamento_id) {
        // Eliminar las actividades asociadas al departamento
        $query_eliminar_actividades = "DELETE FROM actividad WHERE departamento_id = $departamento_id";
        if (mysqli_query($enlace, $query_eliminar_actividades)) {
            // Eliminar el departamento
            $query_eliminar_departamento = "DELETE FROM departamento WHERE id_dept = $departamento_id";
            if (mysqli_query($enlace, $query_eliminar_departamento)) {
                $mensaje = "Departamento y actividades asociadas eliminados correctamente.";
            } else {
                $error = "Error al eliminar el departamento.";
            }
        } else {
            $error = "Error al eliminar las actividades asociadas.";
        }
    } else {
        $error = "ID de departamento inválido.";
    }
}

// Obtener la lista de departamentos
$query_departamentos = "SELECT * FROM departamento";
$resultado_departamentos = mysqli_query($enlace, $query_departamentos);
$departamentos = mysqli_fetch_all($resultado_departamentos, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Departamentos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            margin-top: 20px;
        }
        .table {
            margin-top: 20px;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <a href="consultar.php" class="btn btn-primary m-3">Volver a Gestión de Actividades</a>

        <h1 class="mb-4">Eliminar Departamentos</h1>

        <!-- Mostrar mensajes de éxito o error -->
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-success"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Tabla de departamentos -->
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre del Departamento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($departamentos as $departamento): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($departamento['nom_dept']); ?></td>
                        <td>
                            <a href="eliminar_departamentos.php?eliminar=<?php echo $departamento['id_dept']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este departamento y sus actividades asociadas?');">Eliminar</a>
                        </td>
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