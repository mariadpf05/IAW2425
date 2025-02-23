<?php
session_start();

// Verificar si la sesión está iniciada y si el usuario es administrador
if (!isset($_SESSION['usuarios_nombre']) || $_SESSION['usuarios_roles'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
include "conexion.php";

if (!$enlace) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Obtener todos los usuarios
$query_usuarios = "SELECT id, nombre, roles FROM usuarios;";
$resultado_usuarios = mysqli_query($enlace, $query_usuarios);
$usuarios = mysqli_fetch_all($resultado_usuarios, MYSQLI_ASSOC);

// Procesar eliminación de usuario
if (isset($_GET['eliminar'])) {
    $usuario_id = intval($_GET['eliminar']);

    // Eliminar actividades asociadas al usuario
    $query_eliminar_actividades = "DELETE FROM actividad WHERE organizador_id = $usuario_id;";
    mysqli_query($enlace, $query_eliminar_actividades);

    // Eliminar usuario
    $query_eliminar_usuario = "DELETE FROM usuarios WHERE id = $usuario_id;";
    mysqli_query($enlace, $query_eliminar_usuario);

    header("Location: gestion_usuarios.php");
    exit();
}

// Procesar cambio de contraseña
if (isset($_POST['cambiar_contrasena'])) {
    $usuario_id = intval($_POST['usuario_id']);
    $nueva_contrasena = password_hash($_POST['nueva_contrasena'], PASSWORD_DEFAULT);

    $query_cambiar_contrasena = "UPDATE usuarios SET contrasena = '$nueva_contrasena' WHERE id = $usuario_id;";
    mysqli_query($enlace, $query_cambiar_contrasena);

    header("Location: gestion_usuarios.php");
    exit();
}

mysqli_close($enlace);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
    <a href="consultar.php" class="btn btn-primary m-3">Volver a Gestión de Actividades</a>

    <h1 class="mb-4">Gestión de Usuarios</h1>

    <table class="table table-bordered table-hover table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Nombre</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['roles']); ?></td>
                    <td>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#cambiarContrasenaModal<?php echo $usuario['id']; ?>">Cambiar Contraseña</button>
                        <a href="?eliminar=<?php echo $usuario['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
                    </td>
                </tr>

                <!-- Modal para cambiar contraseña -->
                <div class="modal fade" id="cambiarContrasenaModal<?php echo $usuario['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="cambiarContrasenaModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="cambiarContrasenaModalLabel">Cambiar Contraseña</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST">
                                    <input type="hidden" name="usuario_id" value="<?php echo $usuario['id']; ?>">
                                    <div class="form-group">
                                        <label for="nueva_contrasena">Nueva Contraseña</label>
                                        <input type="password" class="form-control" id="nueva_contrasena" name="nueva_contrasena" required>
                                    </div>
                                    <button type="submit" name="cambiar_contrasena" class="btn btn-primary">Guardar Cambios</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>