<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

// Conexión a la base de datos
include "conexion.php";

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['numero'];

    // Validar que el numero no sea negativo
    if ($numero < 0) {
        $mensaje = "El numero no puede ser negativo.";
        $error_numero = true;
    } else
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
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
        <h1 class="mb-4">Ejercicio 1</h1>
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-info"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        
            <div class="form-group <?php if (isset($error_numero)) echo 'error'; ?>">
                <label for="numero">numero:</label>
                <input type="number" step="0" class="form-control" id="numero" name="numero" value="<?php echo htmlspecialchars($numero); ?>">
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="modo.js"></script>
</body>
</html>