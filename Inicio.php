<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$usname = $_SESSION['username'];

$servername = "localhost";
$username = "admin";
$password = "user";
$dbname = "Empresa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$queryDepartamento = "SELECT Nombre FROM departamentos WHERE Id_Depart = (SELECT Id_Depart FROM usuarios WHERE Nombre = ?)";
$stmtDepartamento = $conn->prepare($queryDepartamento);
$stmtDepartamento->bind_param("s", $usname);
$stmtDepartamento->execute();
$resultDepartamento = $stmtDepartamento->get_result();

$nombreDepartamento = "";

if ($resultDepartamento->num_rows > 0) {
    $rowDepartamento = $resultDepartamento->fetch_assoc();
    $nombreDepartamento = $rowDepartamento['Nombre'];
}

$queryEmpleados = "SELECT Nombre FROM usuarios WHERE Id_Depart = (SELECT Id_Depart FROM usuarios WHERE Nombre = ?)";
$stmtEmpleados = $conn->prepare($queryEmpleados);
$stmtEmpleados->bind_param("s", $usname);
$stmtEmpleados->execute();
$resultEmpleados = $stmtEmpleados->get_result();

$userFilesDirectory = "./usuarios/" . $nombreDepartamento . "/";
$allFiles = array_diff(scandir($userFilesDirectory), array('..', '.'));

$userFiles = array_diff(scandir($userFilesDirectory), array('..', '.'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete-file'])) {
        $selectedFileName = $_POST['file-to-delete'];

        // Elimina el archivo seleccionado
        $filePathToDelete = $userFilesDirectory . $selectedFileName;
        if (file_exists($filePathToDelete)) {
            unlink($filePathToDelete);
            echo "El archivo se ha eliminado correctamente.";
            
            // Registra la eliminación en MongoDB
            $pythonCommand = 'python C:\xampp\htdocs\pagina\ConMongo.py ' .
                escapeshellarg(session_id()) . ' ' .
                escapeshellarg($usname) . ' ' .
                escapeshellarg($selectedFileName) . ' ' .
                escapeshellarg($filePathToDelete) . ' eliminar'; // Pasamos 'eliminar' como argumento

            $output = [];
            $returnVar = 0;
            exec($pythonCommand, $output, $returnVar);

            if ($returnVar === 0) {
                echo " Eliminación registrada correctamente en MongoDB.";
            } else {
                echo " Error al registrar la eliminación en MongoDB.";
                echo "<pre>";
                print_r($output);
                echo "</pre>";
            }

    } else {
        echo "El archivo no existe o ya ha sido eliminado.";
    }
    } elseif (isset($_POST['download-file'])) {
        $selectedFileName = $_POST['file-to-download'];
        $filePathToDownload = $userFilesDirectory . $selectedFileName;

        if (file_exists($filePathToDownload)) {
            // Registra la descarga en MongoDB
            $pythonCommand = 'python C:\xampp\htdocs\pagina\ConMongo.py ' .
                escapeshellarg(session_id()) . ' ' .
                escapeshellarg($usname) . ' ' .
                escapeshellarg($selectedFileName) . ' ' .
                escapeshellarg($filePathToDownload) . ' descargar'; // Pasamos 'descargar' como argumento

            $output = [];
            $returnVar = 0;
            exec($pythonCommand, $output, $returnVar);

            if ($returnVar === 0) {
                echo " Descarga registrada correctamente en MongoDB.";
            } else {
                echo " Error al registrar la descarga en MongoDB.";
                echo "<pre>";
                print_r($output);
                echo "</pre>";
            }

            // Descargar el archivo
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePathToDownload) . '"');
            readfile($filePathToDownload);
            exit;
        } else {
            echo "El archivo no existe.";
        }
    } elseif (isset($_FILES['file-upload']) && isset($_POST['department'])) {
        $uploadedFile = $_FILES['file-upload'];
        $selectedDepartment = $_POST['department'];

        $destinationDirectory = "./usuarios/" . $selectedDepartment . "/";



        if (!file_exists($destinationDirectory)) {
            mkdir($destinationDirectory, 0777, true);
        }



        $fileName = basename($uploadedFile['name']);
        $filePath = $destinationDirectory . $fileName;

        if (move_uploaded_file($uploadedFile['tmp_name'], $filePath)) {
            echo "El archivo se ha subido correctamente.";

            // Ejecutar script Python con argumento 'subir' y luego 'codigo_virus_total.py'
            $pythonCommand1 = 'python C:\xampp\htdocs\pagina\ConMongo.py ' .
                escapeshellarg(session_id()) . ' ' .
                escapeshellarg($usname) . ' ' .
                escapeshellarg($fileName) . ' ' .
                escapeshellarg($filePath) . ' subir'; // Pasamos 'subir' como argumento
            $output1 = [];
            $returnVar1 = 0;
            exec($pythonCommand1, $output1, $returnVar1);

            if ($returnVar1 === 0) {
                echo " Script Python ejecutado correctamente. Verifica la salida para más detalles.";
            } else {
                echo " Error al ejecutar el script Python. Consulta la salida para más detalles.";
                echo "<pre>";
                print_r($output1);
                echo "</pre>";
            }

            // Ejecutar script codigo_virus_total.py
            $avg[1] = escapeshellarg($destinationDirectory); // Almacenar el directorio en la variable avg[1]
            $pythonCommand2 = 'python .\codigo_virus_total.py ' .
                $avg[1]; // Pasar la ruta del directorio como argumento
            $output2 = [];
            $returnVar2 = 0;
            exec($pythonCommand2, $output2, $returnVar2);

            if ($returnVar2 === 0) {
                echo " Script codigo_virus_total.py ejecutado correctamente. Verifica la salida para más detalles.";
            } else {
                echo " Error al ejecutar el script codigo_virus_total.py. Consulta la salida para más detalles.";
                echo "<pre>";
                print_r($output2);
                echo "</pre>";
            }

            // Insertar en la base de datos
            $queryInsertFile = "INSERT INTO ficheros (Nombre, Ruta, Id_user, Id_Depart) VALUES (?, ?, (SELECT Id_user FROM usuarios WHERE Nombre = ?), (SELECT Id_Depart FROM departamentos WHERE Nombre = ?))";
            $stmtInsertFile = $conn->prepare($queryInsertFile);
            $stmtInsertFile->bind_param("ssss", $fileName, $filePath, $usname, $selectedDepartment);

            if ($stmtInsertFile->execute()) {
                echo " Datos almacenados en la base de datos correctamente.";
            } else {
                echo " Error al almacenar los datos en la base de datos.";
                echo "<pre>";
                print_r($output2);
                echo "</pre>";
            }

            $stmtInsertFile->close();
        } else {
            echo "Error al mover el archivo al directorio de destino.";
            echo "Error: " . $_FILES['file-upload']['error'];
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tu Página</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #222;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-between;
      min-height: 100vh;
    }

    header {
      background-color: #222;
      color: #fff;
      padding: 20px;
      text-align: center;
    }

    header img {
      max-width: 50%;
      height: auto;
      margin-right: 10px;
    }

    footer button {
      padding: 15px 30px;
      background-color: #3498db;
      color: #fff;
      border: none;
      cursor: pointer;
      font-size: 18px;
      margin-top: 10px;
    }

    main {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      flex-grow: 1;
    }

    footer {
      background-color: #222;
      color: #fff;
      padding: 20px;
      text-align: center;
    }

    #file-upload {
      display: none;
    }

    #upload-btn {
      padding: 20px 40px;
      background-color: #3498db;
      color: #fff;
      border: none;
      cursor: pointer;
      font-size: 20px;
      margin-top: 20px;
    }

    #delete-file {
      padding: 20px 40px;
      background-color: #e74c3c;
      color: #fff;
      border: none;
      cursor: pointer;
      font-size: 20px;
      margin-top: 20px;
    }

    #download-file {
      padding: 20px 40px;
      background-color: #2ecc71;
      color: #fff;
      border: none;
      cursor: pointer;
      font-size: 20px;
      margin-top: 20px;
    }

    #file-name {
      color: white;
      margin-top: 10px;
      font-size: 16px;
    }

    #upload-title {
      font-size: 30px;
      margin-bottom: 10px;
      color: #fff;
    }

    #upload-subtitle {
      font-size: 18px;
      color: #fff;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <header>
    <img src="nemp.png" alt="Logo">
  </header>

  <main>
    <div id="upload-title">Enviar Archivo</div>
    <div id="upload-subtitle">Envía el archivo por aquí para revisar si está infectado o no.</div>

    <form action="Inicio.php" method="post" enctype="multipart/form-data">
      <label for="department">Selecciona tu departamento o usuario:</label>
      <select name="department" id="department">
        <?php
          echo "<option value='$nombreDepartamento'>$nombreDepartamento</option>";

          if ($resultEmpleados->num_rows > 0) {
              while ($rowEmpleado = $resultEmpleados->fetch_assoc()) {
                  $nombreEmpleado = $rowEmpleado['Nombre'];
                  echo "<option value='$nombreEmpleado'>$nombreEmpleado</option>";
              }
          }
        ?>
      </select>

      <label for="file-upload" id="upload-btn" onclick="document.getElementById('file-upload').click()">Subir Archivo</label>
      <input type="file" name="file-upload" id="file-upload" onchange="displayFileName()" style="display: none;">

      <div id="file-name"></div>
      <input type="submit" value="Enviar Archivo">
    </form>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> <!-- Usamos $_SERVER['PHP_SELF'] para enviar el formulario a la misma página -->
      <label for="file-to-delete">Selecciona el archivo a eliminar:</label>
      <select name="file-to-delete" id="file-to-delete">
        <?php
          if (!empty($userFiles)) {
            foreach ($userFiles as $file) {
              if ($file !== '.' && $file !== '..') {
                echo "<option value='$file'>$file</option>";
              }
            }
          } else {
            echo "<option>No hay archivos disponibles para eliminar.</option>";
          }
        ?>
      </select>
      <input type="submit" name="delete-file" id="delete-file" value="Eliminar Archivo">
    </form>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> <!-- Usamos $_SERVER['PHP_SELF'] para enviar el formulario a la misma página -->
      <label for="file-to-download">Selecciona el archivo a descargar:</label>
      <select name="file-to-download" id="file-to-download">
        <?php
          foreach ($allFiles as $file) {
              echo "<option value='$file'>$file</option>";
          }
        ?>
      </select>
      <input type="submit" name="download-file" id="download-file" value="Descargar Archivo">
    </form>
  </main>

  <footer>
    <button onclick="window.location.href='index.php'">Home</button>
  </footer>

  <script>
    function displayFileName() {
        const fileInput = document.getElementById('file-upload');
        const fileNameDisplay = document.getElementById('file-name');

        if (fileInput.files.length > 0) {
            const fileName = fileInput.files[0].name;
            fileNameDisplay.textContent = `Archivo seleccionado: ${fileName}`;
        } else {
            fileNameDisplay.textContent = '';
        }
    }
  </script>
</body>
</html>
