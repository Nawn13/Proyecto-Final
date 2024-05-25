<?php
// Iniciar la sesión
session_start();

// Verificar si se ha enviado el formulario de modificar usuario
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
    $nombreModificar = $_POST["nombre_modificar"];
    $nuevoNombre = $_POST["nuevo_nombre"];
    $nuevaContrasena = $_POST["nueva_contrasena"];
    $nuevoDepartamento = $_POST["nuevo_departamento"];

    // Utilizar una subconsulta para obtener la ID del departamento
    $subconsulta = $conn->prepare("SELECT Id_Depart FROM Departamentos WHERE Nombre = ?");
    $subconsulta->bind_param("s", $nuevoDepartamento);
    $subconsulta->execute();
    $subconsulta->bind_result($idDepartamento);
    $subconsulta->fetch();
    $subconsulta->close();

    // Encriptar la nueva contraseña
    $hashedPassword = password_hash($nuevaContrasena, PASSWORD_DEFAULT);

    // Prevenir inyección SQL utilizando declaraciones preparadas
    $consulta = $conn->prepare("UPDATE Usuarios SET Nombre=?, Password=?, Id_Depart=? WHERE Nombre=?");
    $consulta->bind_param("ssss", $nuevoNombre, $hashedPassword, $idDepartamento, $nombreModificar);

    // Ejecutar la consulta
    if ($consulta->execute()) {
        echo "Usuario modificado con éxito.";
    } else {
        echo "Error al modificar el usuario: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // Redireccionar si se intenta acceder directamente al script sin enviar el formulario
    header("Location: index.php");
    exit();
}
?>
