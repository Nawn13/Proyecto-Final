<?php
// Iniciar la sesión
session_start();

// Verificar si se ha enviado el formulario de modificar departamento
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos
    $servername = "localhost";
    $username = "admin";
    $password = "user";
    $dbname = "Empresa";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtener datos del formulario
    $idDepartamentoModificar = $_POST["nombre_departamento"];
    $nuevoNombreDepartamento = $_POST["nuevo_nombre_departamento"];

    // Prevenir inyección SQL utilizando declaraciones preparadas
    $consulta = $conn->prepare("UPDATE departamentos SET Nombre=? WHERE Nombre=?");
    $consulta->bind_param("ss", $nuevoNombreDepartamento, $idDepartamentoModificar);

    // Ejecutar la consulta
    if ($consulta->execute()) {
        echo "Departamento modificado con éxito.";
    } else {
        echo "Error al modificar el departamento: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // Redireccionar si se intenta acceder directamente al script sin enviar el formulario
    header("Location: index.php");
    exit();
}
?>
