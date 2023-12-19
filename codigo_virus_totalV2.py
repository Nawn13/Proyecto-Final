import os
import hashlib
import requests
import time
import mysql.connector
import shutil
import sys

# Conexión a la base de datos
conn = mysql.connector.connect(
    host="127.0.0.1",
    user="root",
    password=""
)

# Cursor para ejecutar consultas SQL
cursor = conn.cursor()

# Crear la base de datos si no existe
cursor.execute("CREATE DATABASE IF NOT EXISTS VirusTotal")

# Usar la base de datos VirusTotal
cursor.execute("USE VirusTotal")

# Crear la tabla archivos
cursor.execute("""
    CREATE TABLE IF NOT EXISTS archivos (
        ID INT AUTO_INCREMENT PRIMARY KEY,
        Hash VARCHAR(64) NOT NULL,
        Nombre VARCHAR(255) NOT NULL,
        ID_analisis VARCHAR(255) NOT NULL,
        status VARCHAR(255) NOT NULL
    )
""")
# Crear la tabla usuarios
cursor.execute("""
    CREATE TABLE IF NOT EXISTS usuarios (
        ID INT AUTO_INCREMENT PRIMARY KEY,
        Nombre VARCHAR(255) NOT NULL,
        Contraseña VARCHAR(20) NOT NULL,
        ID_DEPARTAMENTO INT,
        FOREIGN KEY (ID_DEPARTAMENTO) REFERENCES departamentos(ID_DEPARTAMENTO)
    )
""")

cursor.execute("""
    CREATE TABLE IF NOT EXISTS departamentos (
        ID_DEPARTAMENTO INT AUTO_INCREMENT PRIMARY KEY,
        Nombre VARCHAR(255) NOT NULL
    )
""")

 # Cerrar la conexión
cursor.close()
conn.close()

def calcular_hash(archivo_ruta):
    sha256 = hashlib.sha256()
    with open(archivo_ruta, 'rb') as archivo:
        contenido = archivo.read()
        sha256.update(contenido)
    return sha256.hexdigest()

def Guardar_archivos():
    fase1 = os.path.join(os.path.expanduser("~"), "FASE1")
    carpeta_especifica = os.path.join(fase1, "Carpeta_Especifica")
    carpeta_hash = os.path.join(fase1, "carpeta_hash")
    
    # Verificar y crear carpeta "FASE1" si no existe
    if not os.path.exists(fase1):
        print("Carpeta FASE1: No encontrada")
        os.makedirs(fase1)
        print("Creada la carpeta 'FASE1'")
    
    # Verificar y crear carpeta "Carpeta_Especifica" si no existe
    if not os.path.exists(carpeta_especifica):
        print("Carpeta 'Carpeta_Especifica': No encontrada")
        os.makedirs(carpeta_especifica)
        print("Creada la carpeta 'Carpeta_Especifica'")
    
    # Verificar y crear carpeta "carpeta_hash" si no existe
    if not os.path.exists(carpeta_hash):
        print("Carpeta 'carpeta_hash': No encontrada")
        os.makedirs(carpeta_hash)
        print("Creada la carpeta 'carpeta_hash'")

    archivos = os.listdir(carpeta_especifica)
    
    if not archivos:
        print("Error: No hay archivos en la carpeta 'Carpeta_Especifica'")
        
    
    print(f"Archivos detectados en la 'Carpeta_Especifica': {archivos}")
    
    for archivo_nombre in archivos:
        archivo_ruta = os.path.join(carpeta_especifica, archivo_nombre)
        
        # Verificar el tamaño del archivo
        tamano_archivo = os.path.getsize(archivo_ruta) / (1024 * 1024)  # Convertir a MB
        if tamano_archivo > 32:
            print(f"Error: El archivo '{archivo_nombre}' excede los 32MB")
            return
        
        hash_archivo = calcular_hash(archivo_ruta)
        print(f"Hash de {archivo_nombre}: {hash_archivo}")

        # Insertar en la base de datos
        conn = mysql.connector.connect(
            host="127.0.0.1",
            user="root",
            password="",
            database="virustotal"
        )

        cursor = conn.cursor()

        # Verificar si el hash ya existe en la base de datos
        cursor.execute("SELECT * FROM archivos WHERE Hash = %s", (hash_archivo,))
        resultado = cursor.fetchone()

        # Cerrar la conexión
        cursor.close()
        conn.close()

        if resultado:
            print(f"El hash {hash_archivo} de {archivo_nombre} ya existe en la base de datos.")
        else:
            
            # Insertar en la base de datos
            conn = mysql.connector.connect(
            host="127.0.0.1",
            user="root",
            password="",
            database="virustotal"
            )
            cursor = conn.cursor()

            cursor.execute("""
                INSERT INTO archivos (Hash, Nombre, ID_analisis, status)
                VALUES (%s, %s, %s, %s)
            """, (hash_archivo, archivo_nombre, 0, "sin estado"))  # Aquí supongo que ID_analisis es 0, cámbialo según tu lógica

            # Confirmar los cambios
            conn.commit()

            # Cerrar la conexión
            cursor.close()
            conn.close()

        # Guardar el hash en un archivo txt en carpeta_hash
        nombre_txt = os.path.splitext(archivo_nombre)[0] + '.txt'
        ruta_txt = os.path.join(carpeta_hash, nombre_txt)
        with open(ruta_txt, 'w') as archivo_txt:
            archivo_txt.write(hash_archivo)
    return carpeta_especifica
    
# Llamamos a la función
carpeta_especifica = Guardar_archivos()

# Define tu clave de API de VirusTotal
API_KEY = '853d1b6e916cfe31463cf8295963e53d828479b6f015cccbd46f9e2bc4163913'

def subir_archivo_a_virustotal(carpeta_especifica):
    url = 'https://www.virustotal.com/vtapi/v2/file/scan'
    params = {'apikey': API_KEY}
    
    # Abre el archivo en modo binario
    with open(archivo_ruta, 'rb') as archivo:
        files = {'file': (os.path.basename(archivo_ruta), archivo)}
        response = requests.post(url, files=files, params=params)
        return response.json()

archivos_en_carpeta = os.listdir(carpeta_especifica)

# Contador para seguir el número de archivos subidos
contador_archivos_subidos = 0

# Después de obtener el resultado de VirusTotal

for nombre_archivo in archivos_en_carpeta:
    archivo_ruta = os.path.join(carpeta_especifica, nombre_archivo)
    
    # Verifica que el elemento sea un archivo
    if os.path.isfile(archivo_ruta):
        resultado = subir_archivo_a_virustotal(archivo_ruta)
        print(f"Archivo: {nombre_archivo}")
        print(f"Resultado de VirusTotal: {resultado}")
        
        contador_archivos_subidos += 1

        # Si se han subido 4 archivos, aplicamos el retraso de 1 minuto
        if contador_archivos_subidos % 4 == 0:
            print("Esperando 1 minuto...")
            time.sleep(60)

        # Si el análisis fue exitoso y hay un scan_id
        if resultado.get('response_code') == 1 and 'scan_id' in resultado:
            scan_id = resultado['scan_id']
            
            # Obtener el hash del archivo
            hash_archivo = calcular_hash(archivo_ruta)
            
            # Conectar a la base de datos
            conn = mysql.connector.connect(
                host="127.0.0.1",
                user="root",
                password="",
                database="VirusTotal"
            )

            cursor = conn.cursor()

            # Actualizar la base de datos con el ID del análisis
            cursor.execute("""
                UPDATE archivos
                SET ID_analisis = %s
                WHERE Hash = %s
            """, (scan_id, hash_archivo))

            # Confirmar los cambios
            conn.commit()

            # Cerrar la conexión
            cursor.close()
            conn.close()


def obtener_resultados_analisis(carpeta_especifica):
    archivos_infectados = []
    archivos_en_carpeta = os.listdir(carpeta_especifica)
    for nombre_archivo in archivos_en_carpeta:  # <-- Corregido el nombre de la variable
        archivo_ruta = os.path.join(carpeta_especifica, nombre_archivo)
        hash_archivo = calcular_hash(archivo_ruta)
        
        conn = mysql.connector.connect(
            host="127.0.0.1",
            user="root",
            password="",
            database="virustotal"
        )

        cursor = conn.cursor()

        # Verificar si el hash ya existe en la base de datos
        cursor.execute("SELECT ID_analisis FROM archivos WHERE Hash = %s and Nombre = %s", (hash_archivo, nombre_archivo))
        resultado = cursor.fetchone()
        cursor.execute("SELECT ID_analisis FROM archivos WHERE Hash = %s and Nombre = %s", (hash_archivo, nombre_archivo))
        resultado = cursor.fetchone()

        if resultado is not None:
            id_analisis = resultado[0]
            url = f"https://www.virustotal.com/api/v3/analyses/{id_analisis}"
            headers = {"x-apikey": "853d1b6e916cfe31463cf8295963e53d828479b6f015cccbd46f9e2bc4163913"}

            response = requests.get(url, headers=headers)

            if response.status_code == 200:
                informacion_analisis = response.json()
                if informacion_analisis["data"]["attributes"]["stats"]["malicious"] == 0:
                    cursor.execute("""
                        UPDATE archivos
                        SET status = %s
                        WHERE Hash = %s
                    """, ("no infectado", hash_archivo))
                    conn.commit()
                else:
                    cursor.execute("""
                        UPDATE archivos
                        SET status = %s
                        WHERE Hash = %s
                    """, ("infectado", hash_archivo))
                    conn.commit()

                    fase1 = os.path.join(os.path.expanduser("~"), "FASE1")
                    carpeta_infectados = os.path.join(fase1, "archivos_infectados")
                    os.makedirs(carpeta_infectados, exist_ok=True)  # Crea la carpeta si no existe

                    origen = os.path.join(carpeta_especifica, nombre_archivo)
                    destino = os.path.join(carpeta_infectados, nombre_archivo)

                    shutil.move(origen, destino)

                    print(f"Archivo infectado '{nombre_archivo}' movido a 'FASE1/archivos_infectados'.")
            else:
                print(f"Error al obtener información del análisis. Código de estado: {response.status_code}")
        else:
            print("No se encontró ID_analisis para el archivo.")
        # Cerrar la conexión
        cursor.close()
        conn.close()


# Llama a la función y obtén los resultados
obtener_resultados_analisis(carpeta_especifica)
