<?php
// Aquí iría tu código PHP para manejar la lógica de la página
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Actividades</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #000066;
            font-family: Arial, sans-serif;
            color: #FFFF00;
            padding: 20px;
        }

        h1, h2 {
            color: #FFFF00;
            margin-bottom: 20px;
        }

        .form-container {
            background-color: #fafafa;
            padding: 20px;
            border: 3px solid #FFFF00;
            border-radius: 10px;
            box-shadow: 0 0 10px #FFFF00;
            width: 80%;
            max-width: 600px;
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

        table {
            width: 80%;
            max-width: 1200px;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid white;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #000066;
            color: #FFFF00;
        }

        td {
            background-color: #fafafa;
        }

        a {
            color: #000066;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Gestión de Actividades</h1>
    <div class="form-container">
        <h2><?php echo $id ? 'Actualizar Actividad' : 'Crear Actividad'; ?></h2>
        <form action="formulario.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" value="<?php echo $actividad['titulo'] ?? ''; ?>" required><br>

            <label for="tipo">Tipo:</label>
            <select name="tipo" required>
                <option value="extraescolar" <?php echo ($actividad['tipo'] ?? '') == 'extraescolar' ? 'selected' : ''; ?>>Extraescolar</option>
                <option value="complementaria" <?php echo ($actividad['tipo'] ?? '') == 'complementaria' ? 'selected' : ''; ?>>Complementaria</option>
            </select><br>

            <label for="departamento_nombre">Departamento:</label>
            <input type="text" name="departamento_nombre" value="<?php echo $actividad['departamento_nombre'] ?? ''; ?>" required><br>

            <label for="profesor_nombre">Profesor:</label>
            <input type="text" name="profesor_nombre" value="<?php echo $actividad['profesor_nombre'] ?? ''; ?>" required><br>

            <label for="trimestre">Trimestre:</label>
            <select name="trimestre" required>
                <option value="primero" <?php echo ($actividad['trimestre'] ?? '') == 'primero' ? 'selected' : ''; ?>>Primero</option>
                <option value="segundo" <?php echo ($actividad['trimestre'] ?? '') == 'segundo' ? 'selected' : ''; ?>>Segundo</option>
                <option value="tercero" <?php echo ($actividad['trimestre'] ?? '') == 'tercero' ? 'selected' : ''; ?>>Tercero</option>
            </select><br>

            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" name="fecha_inicio" value="<?php echo $actividad['fecha_inicio'] ?? ''; ?>" required><br>

            <label for="hora_inicio">Hora de Inicio:</label>
            <input type="time" name="hora_inicio" value="<?php echo $actividad['hora_inicio'] ?? ''; ?>" required><br>

            <label for="fecha_fin">Fecha de Fin:</label>
            <input type="date" name="fecha_fin" value="<?php echo $actividad['fecha_fin'] ?? ''; ?>" required><br>

            <label for="hora_fin">Hora de Fin:</label>
            <input type="time" name="hora_fin" value="<?php echo $actividad['hora_fin'] ?? ''; ?>" required><br>

            <label for="organizador">Organizador:</label>
            <input type="text" name="organizador" value="<?php echo $actividad['organizador'] ?? ''; ?>"><br>

            <label for="acompañantes">Acompañantes:</label>
            <input type="text" name="acompañantes" value="<?php echo $actividad['acompañantes'] ?? ''; ?>"><br>

            <label for="ubicacion">Ubicación:</label>
            <input type="text" name="ubicacion" value="<?php echo $actividad['ubicacion'] ?? ''; ?>"><br>

            <label for="coste">Coste:</label>
            <input type="number" step="0.01" name="coste" value="<?php echo $actividad['coste'] ?? ''; ?>"><br>

            <label for="total_alumnos">Total de Alumnos:</label>
            <input type="number" name="total_alumnos" value="<?php echo $actividad['total_alumnos'] ?? ''; ?>"><br>

            <label for="objetivo">Objetivo:</label>
            <textarea name="objetivo"><?php echo $actividad['objetivo'] ?? ''; ?></textarea><br>

            <button type="submit"><?php echo $id ? 'Actualizar' : 'Crear'; ?></button>
        </form>
    </div>

    <h2>Lista de Actividades</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Tipo</th>
                <th>Departamento</th>
                <th>Profesor</th>
                <th>Trimestre</th>
                <th>Fecha de Inicio</th>
                <th>Hora de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Hora de Fin</th>
                <th>Organizador</th>
                <th>Acompañantes</th>
                <th>Ubicación</th>
                <th>Coste</th>
                <th>Total de Alumnos</th>
                <th>Objetivo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($actividades as $actividad): ?>
                <tr>
                    <td><?php echo $actividad['id']; ?></td>
                    <td><?php echo $actividad['titulo']; ?></td>
                    <td><?php echo $actividad['tipo']; ?></td>
                    <td><?php echo $actividad['departamento_nombre']; ?></td>
                    <td><?php echo $actividad['profesor_nombre']; ?></td>
                    <td><?php echo $actividad['trimestre']; ?></td>
                    <td><?php echo $actividad['fecha_inicio']; ?></td>
                    <td><?php echo $actividad['hora_inicio']; ?></td>
                    <td><?php echo $actividad['fecha_fin']; ?></td>
                    <td><?php echo $actividad['hora_fin']; ?></td>
                    <td><?php echo $actividad['organizador']; ?></td>
                    <td><?php echo $actividad['acompañantes']; ?></td>
                    <td><?php echo $actividad['ubicacion']; ?></td>
                    <td><?php echo $actividad['coste']; ?></td>
                    <td><?php echo $actividad['total_alumnos']; ?></td>
                    <td><?php echo $actividad['objetivo']; ?></td>
                    <td>
                        <a href="formulario.php?id=<?php echo $actividad['id']; ?>">Editar</a> |
                        <a href="formulario.php?borrar=<?php echo $actividad['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas borrar esta actividad?');">Borrar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>