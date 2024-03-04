import os
import requests
import mysql.connector
from mysql.connector import Error
import sys

# Obtener la ruta del directorio base del segundo argumento (avg[1])
if len(sys.argv) > 1:
    base_directory = "./usuarios/Informatica/"
else:
    base_directory = r"C:\xampp\htdocs\pagina\usuarios\Informatica"  # Ruta por defecto si no se proporciona

# Nombre del archivo en el que deseas guardar el contenido
nombre_archivo = "archivo.txt"

# Abrir el archivo en modo escritura
with open(nombre_archivo, 'w') as archivo:
    # Escribir el contenido de la variable en el archivo
    archivo.write(base_directory)

# URL para enviar el archivo a VirusTotal
url_submit = "https://www.virustotal.com/api/v3/files"
# URL para verificar mediante ID si el archivo está infectado
url_report = "https://www.virustotal.com/api/v3/analyses/{file_id}"
# Clave de API para conectarse con VirusTotal
api_key = "d5e210bf79752ea55de896f234c5c9a66c97cff3cc711b6fdbb2127a726a4b7b"

# Autenticación de la solicitud para la solicitud HTTP
headers = {
    "x-apikey": api_key
}

# Intentamos la conexión con la base de datos MariaDB
try:
    conn = mysql.connector.connect(
        host='localhost',
        database='Empresa',
        user='admin',
        password='user'
    )

    if conn.is_connected():
        print("Conexión establecida con MariaDB")

        cursor = conn.cursor()

        # Creamos la tabla 'ficheros' si no existe
        cursor.execute('''
            CREATE TABLE IF NOT EXISTS ficheros (
                Id_Fichero INT AUTO_INCREMENT PRIMARY KEY,
                Nombre VARCHAR(50),
                Ruta VARCHAR(100),
                Id_user INT,
                Id_Depart INT,
                Id_virustotal VARCHAR(100),
                Malicioso_no BOOLEAN,
                Hash VARCHAR(255),
                Cant_anti INT,
                Estado VARCHAR(15)
            )
        ''')
        conn.commit()

        # Función para explorar recursivamente los archivos y subdirectorios
        def explorar_directorio(directory):
            print(f"Explorando directorio: {directory}")
            for root, _, files in os.walk(directory):
                for filename in files:
                    file_path = os.path.join(root, filename)
                    print(f"Procesando archivo: {file_path}")

                    # Enviar el archivo a VirusTotal
                    with open(file_path, "rb") as file:
                        files = {"file": (filename, file, "application/x-msdownload")}
                        response = requests.post(url_submit, files=files, headers=headers)
                        print(f"Respuesta de la primera llamada a VirusTotal: {response.status_code}")
                        print("Contenido de la respuesta:")
                        print(response.text)

                        # Si el servidor responde, obtenemos la ID para la segunda llamada
                        if response.status_code == 200:
                            json_response = response.json()
                            file_id = json_response.get("data", {}).get("id") or json_response.get("id")
                            print(f"ID del archivo en VirusTotal: {file_id}")

                            # Obtener información sobre el análisis del archivo
                            url_report_current = url_report.format(file_id=file_id)
                            response_report = requests.get(url_report_current, headers=headers)
                            print(f"Respuesta de la segunda llamada a VirusTotal: {response_report.status_code}")
                            print("Contenido de la respuesta:")
                            print(response_report.text)

                            if response_report.status_code == 200:
                                json_report = response_report.json()
                                attributes = json_report.get("data", {}).get("attributes", {})

                                # Extraer la información relevante de VirusTotal
                                analysis_results = attributes.get("results", {}).get("Bkav", {}).get("category")
                                print(f"Resultado del análisis: {analysis_results}")

                                # Determinar si el archivo es malicioso
                                malicioso = analysis_results == 'malicious'

                                # Asignar valor a Malicioso_no
                                malicioso_no = True if malicioso else False

                                # Simular valores para Id_user, Id_Depart y Hash
                                id_user = 1
                                id_depart = 1
                                hash_value = "1234567890"  # Simulación de un valor de hash

                                # Almacenar la información en la base de datos
                                cursor.execute("INSERT INTO ficheros (Nombre, Ruta, Id_user, Id_Depart, Id_virustotal, Malicioso_no, Hash, Estado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                                               (filename, file_path, id_user, id_depart, file_id, malicioso_no, hash_value, "Revisado"))

                                conn.commit()
                                print("Información del archivo almacenada en la base de datos.")

                                # Si el archivo es malicioso, eliminarlo
                                if malicioso:
                                    os.remove(file_path)
                                    print(f"Archivo malicioso {filename} eliminado.")

                            else:
                                print(f"Error en la segunda llamada a VirusTotal. Estado: {response_report.status_code}")

                        else:
                            print(f"Error en la primera llamada a VirusTotal. Estado: {response.status_code}")

        # Recorremos los usuarios en el directorio base y exploramos sus subdirectorios
        explorar_directorio(base_directory)

        cursor.close()
        conn.close()
        print("Conexión cerrada con MariaDB")
    else:
        print("La conexión a MariaDB falló.")

except Error as e:
    print(f"Error: {e}")
