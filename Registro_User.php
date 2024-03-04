<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "admin";
$password = "user";
$dbname = "Empresa";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

// Verificar si se proporcionó el departamento
$departamento = isset($_POST['departamento']) ? $_POST['departamento'] : null;

// Inicializar la variable de la ID del departamento
$idDepartamento = null;

// Obtener la ID del departamento a partir del nombre si se proporciona
if ($departamento !== null && $departamento !== "") {
    $subconsulta = "SELECT Id_Depart FROM Departamentos WHERE Nombre = '$departamento'";
    $resultado = $conn->query($subconsulta);

    if ($resultado && $resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $idDepartamento = $fila['Id_Depart'];
    } else {
        echo "Error: No se encontró el departamento. El usuario se registrará sin asociación a departamento.";
    }
}

// Preparar la consulta SQL para la inserción
$sql = "INSERT INTO Usuarios (Nombre, Password";

// Agregar la columna Id_Depart si se proporciona el departamento
if ($idDepartamento !== null) {
    $sql .= ", Id_Depart) VALUES ('$nombre', '$contrasena', $idDepartamento)";
} else {
    $sql .= ") VALUES ('$nombre', '$contrasena')";
}

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    echo "Usuario registrado con éxito";
} else {
    echo "Error al registrar usuario: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
