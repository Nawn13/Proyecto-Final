<?php
// Iniciar la sesión
session_start();

// Obtener el nombre de usuario (por ejemplo, desde un formulario POST)
if(isset($_POST['username'])) {
    $username = $_POST['username'];

    // Guardar el nombre de usuario en la variable de sesión
    $_SESSION['username'] = $username;

    echo "Nombre de usuario guardado en la sesión.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Login.css">
    <title>Login Form</title>
</head>
<body>
    <form action="Login2.php" method="post">
        <label for="username">Usuario:</label>
        <input type="text" name="username" required><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Iniciar sesión">
    </form>

</body>
</html>
