<?php
session_start();

// Conexión a la base de datos
include "conexion.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar campos vacíos
    if (empty($_POST['nombre']) || empty($_POST['apellidos']) || empty($_POST['email']) || empty($_POST['password'])) {
        $error = "Error: Todos los campos son obligatorios.";
    } else {
        // Saneamiento de las entradas
        $nombre = htmlspecialchars(trim($_POST['nombre']));
        $apellidos = htmlspecialchars(trim($_POST['apellidos']));
        $email = htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars(trim($_POST['password']));

        // Validar que el correo pertenece a @iesamachado.org
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@iesamachado\.org$/', $email)) {
            $error = "Error: El correo electrónico debe pertenecer al dominio @iesamachado.org.";
        } else {
            // Verificar si el usuario ya existe
            $query = "SELECT id FROM usuarios WHERE email='$email'";
            $resultado = mysqli_query($enlace, $query);

            if (mysqli_num_rows($resultado) > 0) {
                $error = "Error: El usuario ya está registrado.";
            } else {
                // Cifrar la contraseña
                $password_encrypted = crypt($password, '$6$rounds=5000$' . uniqid(mt_rand(), true) . '$');

                // Insertar datos en la base de datos
                $query = "INSERT INTO usuarios (nombre, apellidos, email, password) VALUES ('$nombre', '$apellidos', '$email', '$password_encrypted')";

                if (mysqli_query($enlace, $query)) {
                    // Enviar correo electrónico de confirmación
                    $asunto = "Registro exitoso";
                    $mensaje = "Hola $nombre,\n\nGracias por registrarte. Estos son tus datos:\nNombre: $nombre\nApellidos: $apellidos\nEmail: $email\n\nSaludos.";
                    $cabeceras = "From: no-reply@mi-sitio.com";

                    if (mail($email, $asunto, $mensaje, $cabeceras)) {
                        $error = "Usuario registrado correctamente. Se ha enviado un correo de confirmación.";
                    } else {
                        $error = "Usuario registrado, pero no se pudo enviar el correo.";
                    }
                } else {
                    $error = "Error al registrar el usuario: " . mysqli_error($enlace);
                }
            }
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
    <title>Registro</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .enlace {
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-primary">
    <div class="bg-light p-5 rounded shadow-lg text-center">
        <h3 class="text-primary">IES Antonio Machado</h3>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="registros.php" class="text-primary">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block"><a href="logins.php" class="enlace">Registrarse</a></button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>