<?php
// Iniciar la sesión
session_start();

// Verificar si se ha enviado el formulario
if (empty($_POST['nombre_departamento'])) {
    echo "El campo 'nombre_departamento' está vacío.";
} else {
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

    // Obtener el nombre del departamento a eliminar
    $nombreEliminarDepartamento = $_POST['nombre_departamento'];

    // Consulta para eliminar departamento
    $consultaEliminarDepartamento = "DELETE FROM Departamentos WHERE Nombre = '$nombreEliminarDepartamento'";

    if ($conexion->query($consultaEliminarDepartamento) === TRUE) {
        echo "Departamento '$nombreEliminarDepartamento' eliminado correctamente.";
    } else {
        echo "Error al ejecutar la consulta: " . $conexion->error;
    }

    $conexion->close();
}
?>
