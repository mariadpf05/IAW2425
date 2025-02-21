<?php
session_start();

// Conexión a la base de datos
include "conexion.php";

// Procesar formulario al enviarlo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que los campos no estén vacíos
    if (empty($_POST['email']) || empty($_POST['password'])) {
        echo "<script>alert('Error: Todos los campos son obligatorios.');</script>";
    } else {
        // Saneamiento de las entradas
        $email = htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars(trim($_POST['password']));

        // Usar sentencias preparadas para prevenir inyecciones SQL
        $query = "SELECT * FROM usuarios WHERE email=?";
        $stmt = mysqli_prepare($enlace, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultado) === 1) {
            $usuario = mysqli_fetch_assoc($resultado);

            // Verificar la contraseña
            if (password_verify($password, $usuario['password'])) {
                // Inicio de sesión exitoso, establecer la variable de sesión
                $_SESSION['usuarios_nombre'] = $usuario['nombre'];
                $_SESSION['usuarios_roles'] = $usuario['roles'];
                $_SESSION['ultima_conexion'] = $usuario['ultima_conexion'];

                // Actualizar la última conexión
                $query_update = "UPDATE usuarios SET ultima_conexion = NOW() WHERE email = ?";
                $stmt_update = mysqli_prepare($enlace, $query_update);
                mysqli_stmt_bind_param($stmt_update, "s", $email);
                mysqli_stmt_execute($stmt_update);

                header("Location: consultar.php");
                exit();
            } else {
                echo "<script>alert('Error: Contraseña incorrecta.');</script>";
            }
        } else {
            echo "<script>alert('Error: Usuario no encontrado.');</script>";
        }
    }
}

mysqli_close($enlace);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-primary">
    <div class="bg-light p-5 rounded shadow-lg text-center">
        <h3 class="text-primary">IES Antonio Machado</h3>
        <form method="POST" action="" class="text-primary">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>