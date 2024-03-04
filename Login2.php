<?php
// Iniciar la sesión
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username_db = "admin";
$password_db = "user";
$dbname = "Empresa";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

$substitucion = array("&", "&&", ";", "|", "||", "$", "$$", "(", ")", "'", "or", "OR", "-", "--", "#", "##");

$target = $_REQUEST['username'];
$target = str_replace($substitucion, "", $target);
$target2 = $_REQUEST['password'];
$target2 = str_replace($substitucion, "", $target2);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos del formulario
$username = $_POST['username'];
$password_input = $_POST['password'];

// Consulta SQL para obtener el hash almacenado en la base de datos
$sql = "SELECT Password FROM Usuarios WHERE Nombre = '$target'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Usuario encontrado
    $row = $result->fetch_assoc();
    $stored_hash = $row['Password'];

    // Verificar la contraseña
    if (password_verify($password_input, $stored_hash)) {
        // Usuario autenticado correctamente
        $_SESSION['username'] = $username;

        if ($username == "Admin" or $username == "admin") {
            header("Location: adminpanel.php");
        } else {
            header("Location: Inicio.php");
        }
    } else {
        // Contraseña incorrecta
        echo "Contraseña incorrecta";
    }
} else {
    // Usuario no encontrado
    echo "Nombre de usuario incorrecto";
}

// Cerrar la conexión
$conn->close();
?>
