<?php
// Iniciar la sesión
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "admin";
$password = "user";
$dbname = "Empresa";

$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener nombres de usuario y nombres de departamento
$consultaUsuarios = "SELECT Nombre FROM Usuarios";
$resultadoUsuarios = $conexion->query($consultaUsuarios);

// Consulta para obtener nombres de departamento
$consultaDepartamentos = "SELECT Nombre FROM Departamentos";
$resultadoDepartamentos = $conexion->query($consultaDepartamentos);

// Almacenar nombres de usuario y nombres de departamento en arrays separados
$nombresUsuarios = [];
while ($fila = $resultadoUsuarios->fetch_assoc()) {
    $nombresUsuarios[] = $fila['Nombre'];
}

$nombresDepartamentos = [];
while ($fila = $resultadoDepartamentos->fetch_assoc()) {
    $nombresDepartamentos[] = $fila['Nombre'];
}

$conexion->close();

if (isset($_POST['mostrar_logs'])) {
    // Ejecutar el script de Python y guardar la salida en un archivo
    $outputFile = 'logs_output.txt';
    exec("python ObtenerLogs.py > $outputFile 2>&1", $output, $return_var);

    if ($return_var !== 0) {
        echo "Error al ejecutar el script de Python. Consulta el archivo $outputFile para más detalles.";
    } else {
        echo "La salida del script se ha guardado en el archivo $outputFile.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Página PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }

        #logo {
            width: 58%;
            padding: 20px;
            background-color: #f0f0f0;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
        }

        #forms {
            width: 40%;
            margin-left: 60%;
            padding: 20px;
            background-color: #e0e0e0;
            display: flex;
            flex-direction: column;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            margin-bottom: 10px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            padding: 10px;
            font-size: 16px;
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        #home-btn {
            width: 80%;
            height: 15%;
            margin-top: 20px;
            padding: 20px;
            background-color: black;
            color: #fff;
            font-size: 50px;
            cursor: pointer;
        }

        button:last-child {
            background-color: #e74c3c;
        }
    </style>
</head>

<body>

    <div id="logo">
        <br><br><br><br>
        <img src="logo.png" alt="Logo">
        <br><br><br>
        <a href="index.php"><button id="home-btn">Home</button></a>
    </div>

    <div id="forms">

        <!-- Registro de Usuario -->
        <h2>Registro de Usuario</h2>
        <form action="Registro_User.php" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" required>

            <label for="departamento">Departamento (opcional):</label>
            <input type="text" name="departamento">

            <button type="submit">Registrar Usuario</button>
        </form>

        <!-- Eliminar Usuario -->
        <h2>Eliminar Usuario</h2>
        <form action="procesar_eliminar.php" method="post">
            <label for="nombre_eliminar">Nombre del Usuario a Eliminar:</label>
            <select name="nombre_eliminar" required>
                <option value="">NULL</option>
                <?php
                // Mostrar opciones del dropdown con nombres de usuario
                foreach ($nombresUsuarios as $nombreUsuario) {
                    echo "<option value=\"$nombreUsuario\">$nombreUsuario</option>";
                }
                ?>
            </select>

            <button type="submit">Eliminar Usuario</button>
        </form>

        <!-- Modificar Usuario -->
        <h2>Modificar Usuario</h2>
        <form action="modificar_usuario.php" method="post">
            <label for="nombre_modificar">Nombre del Usuario a Modificar:</label>
            <select name="nombre_modificar" required>
                <option value="">NULL</option>
                <?php
                // Mostrar opciones del dropdown con nombres de usuario
                foreach ($nombresUsuarios as $nombreUsuario) {
                    echo "<option value=\"$nombreUsuario\">$nombreUsuario</option>";
                }
                ?>
            </select>

            <label for="nuevo_nombre">Nuevo Nombre:</label>
            <input type="text" name="nuevo_nombre">

            <label for="nueva_contrasena">Nueva Contraseña:</label>
            <input type="password" name="nueva_contrasena">

            <label for="nuevo_departamento">Nuevo Departamento:</label>
            <select name="nuevo_departamento">
                <option value="">NULL</option>
                <?php
                // Mostrar opciones del dropdown con nombres de departamento
                foreach ($nombresDepartamentos as $nombreDepartamento) {
                    echo "<option value=\"$nombreDepartamento\">$nombreDepartamento</option>";
                }
                ?>
            </select>

            <button type="submit">Modificar Usuario</button>
        </form>

        <!-- Crear Nuevo Departamento -->
        <h2>Crear Nuevo Departamento</h2>
        <form action="Crear_departamento.php" method="post">
            <label for="nombre_departamento">Nombre del Nuevo Departamento:</label>
            <input type="text" name="nombre_departamento" required>

            <button type="submit">Crear Departamento</button>
        </form>

        <!-- Eliminar Departamento -->
        <h2>Eliminar Departamento</h2>
        <form action="eliminar_departamento.php" method="post">
            <label for="nombre_departamento">Nombre del Departamento a Eliminar:</label>
            <input type="text" name="nombre_departamento" required>

            <button type="submit">Eliminar Departamento</button>
        </form>

        <!-- Modificar Departamento -->
        <h2>Modificar Departamento</h2>
        <form action="modificar_departamento.php" method="post">
            <label for="nombre_modificar_departamento">Nombre del Departamento a Modificar:</label>
            <select name="nombre_departamento" required>
                <option value="">NULL</option>
                <?php
                // Mostrar opciones del dropdown con nombres de departamento
                foreach ($nombresDepartamentos as $nombreDepartamento) {
                    echo "<option value=\"$nombreDepartamento\">$nombreDepartamento</option>";
                }
                ?>
            </select>

            <label for="nuevo_nombre_departamento">Nuevo Nombre del Departamento:</label>
            <input type="text" name="nuevo_nombre_departamento" required>

            <button type="submit">Modificar Departamento</button>
        </form>

        <!-- Mostrar Logs -->
        <form action="" method="post">
            <button type="submit" name="mostrar_logs">Mostrar Logs</button>
        </form>
    </div>

</body>

</html>
