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
$username = $_POST['username'];
$password = $_POST['password'];
//TODO sanitice estas entradas para que no me entren con sql injection el dia de la presentacion

// Consulta SQL para verificar el usuario y contraseña
$sql = "SELECT * FROM Usuarios WHERE Nombre = '$username' AND Password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   if ($username == "Admin" or $username == "admin"){
        header("Location: adminpanel.php");

   }
   else{
    // Usuario autenticado correctamente
    header("Location: Inicio.php");
    echo $username;
   }
} else {
    // Usuario o contraseña incorrectos
    echo "Nombre de usuario o contraseña incorrectos";
}

// Cerrar la conexión
$conn->close();
?>
