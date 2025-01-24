<?php
session_start();

// Verificar si la sesión está iniciada
if (!isset($_SESSION['usuarios_nombre'])) {
    header("Location: logins.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Actividades</title>
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
        }

        h1 {
            color: #000066;
            margin-bottom: 20px;
        }

        .button-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .button-container a {
            margin: 10px;
            padding: 10px 20px;
            background-color: #000066;
            color: #FFFF00;
            text-decoration: none;
            border: 2px solid #FFFF00;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .button-container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuarios_nombre']); ?>!</h1>
        <p>¿Qué desea hacer?</p>
        <div class="button-container">
            <a href="consultar.php">Consultar Actividades</a>
            <a href="nueva.php">Añadir Nueva Actividad</a>
            <a href="editar.php">Modificar Actividad Existente</a>
            <a href="eliminar.php">Eliminar Actividad</a>
        </div>
    </div>
</body>
</html>