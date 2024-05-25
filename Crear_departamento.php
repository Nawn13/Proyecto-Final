<?php
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
$nombre_departamento = $_POST['nombre_departamento'];

// Insertar nuevo departamento en la tabla
$sql = "INSERT INTO departamentos (Nombre) VALUES ('$nombre_departamento')";

if ($conn->query($sql) === TRUE) {
    echo "Nuevo departamento creado exitosamente";
} else {
    echo "Error al crear el departamento: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
