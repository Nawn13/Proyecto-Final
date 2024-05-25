<?php
// Iniciar la sesión (si aún no está iniciada)
session_start();

// Verificar si el usuario tiene permisos de administrador (ajusta esto según tus necesidades)
//if (!isset($_SESSION['username']) || $_SESSION['username'] !== "Admin") {
//    die("Acceso no autorizado");
//}

// Verificar si se ha enviado el formulario
if (empty($_POST['nombre_eliminar'])) {
    echo "Esta vacio";
}

else{
    // Depuración: Imprimir información sobre el formulario enviado
   # echo "Depuración: Formulario enviado - ";
    #print_r($_POST);

    // Aquí debes manejar la conexión a la base de datos y realizar la eliminación del usuario
    $servername = "localhost";
    $username = "admin";
    $password = "user";
    $dbname = "Empresa";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtener el nombre del usuario a eliminar
    $nombreEliminar = $_POST['nombre_eliminar'];
    //echo "$nombreEliminar";
    // Consulta para eliminar usuario
    $consultaEliminarUsuario = "DELETE FROM Usuarios WHERE Nombre = '$nombreEliminar'";
    //echo "Consulta SQL: $consultaEliminarUsuario";  // Añadido para depuración

    if ($conn->query($consultaEliminarUsuario) === TRUE) {
        echo "Usuario '$nombreEliminar' eliminado correctamente.";
    } else {
        echo "Error al ejecutar la consulta: " . $conn->error;
        //echo "Consulta SQL: $consultaEliminarUsuario";  // Añadido para depuración
    }

    $conn->close();
}
//echo "hola2";
?>
