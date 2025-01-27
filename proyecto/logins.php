<?php
session_start();

// Conexión a la base de datos
$servername = "sql308.thsite.top"; // Nombre del servidor
$username = "thsi_38097480"; // Nombre de usuario
$password = ""; // Contraseña
$database = "thsi_38097480_proyecto";
$enlace = mysqli_connect($servername, $username, $password, $database);

// Verificar conexión
if (!$enlace) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Procesar formulario al enviarlo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que los campos no estén vacíos
    if (empty($_POST['email']) || empty($_POST['password'])) {
        echo "<script>alert('Error: Todos los campos son obligatorios.');</script>";
    } else {
        // Saneamiento de las entradas
        $email = htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars(trim($_POST['password']));

        $query = "SELECT * FROM usuarios WHERE email='$email'";
        $resultado = mysqli_query($enlace, $query);

        if (mysqli_num_rows($resultado) === 1) {
            $usuario = mysqli_fetch_assoc($resultado);

            // Verificar la contraseña
            if (password_verify($password, $usuario['password'])) {
                // Inicio de sesión exitoso, establecer la variable de sesión
                $_SESSION['usuarios_nombre'] = $usuario['nombre'];
                header("Location: gestion.php");
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

        .login {
            background-color: #fafafa;
            padding: 50px;
            border: 3px solid #FFFF00;
            border-radius: 10px;
            box-shadow: 0 0 10px #FFFF00;
            text-align: center;
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

        input {
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
    </style>
</head>
<body>
    <div class="login">
        <h3>IES Antonio Machado</h3>
        <form method="POST" action="">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Iniciar sesión</button>
        </form>
    </div>
</body>
</html>