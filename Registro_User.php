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

    // Crear la carpeta para el usuario
    $rutaCarpetaUsuario = "C:/xampp/htdocs/pagina/usuarios/$nombre";
    if (!file_exists($rutaCarpetaUsuario)) {
        mkdir($rutaCarpetaUsuario, 0777, true);
        echo "Se ha creado la carpeta del usuario.";

        // Generar clave privada
        $privateKey = openssl_pkey_new();
        if ($privateKey) {
            $privateKeyString = '';
            openssl_pkey_export($privateKey, $privateKeyString);
            if ($privateKeyString !== false) {
                file_put_contents("$rutaCarpetaUsuario/private_key.pem", $privateKeyString);
                echo "Se ha generado y guardado la clave privada.";
            } else {
                echo "Error al exportar la clave privada.";
            }
        } else {
            echo "Error al generar la clave privada.";
        }
    } else {
        echo "La carpeta del usuario ya existe.";
    }
} else {
    echo "Error al registrar usuario: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
