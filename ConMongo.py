import sys
from pymongo import MongoClient
from datetime import datetime, timedelta

def connect_to_mongodb():
    # Modifica la cadena de conexión según tu configuración
    client = MongoClient('mongodb://localhost:27017')
    return client

def madrid_time():
    # Obtenemos la hora actual en UTC
    utc_now = datetime.utcnow()
    # Ajustamos la hora a la de Madrid (UTC+1)
    madrid_now = utc_now + timedelta(hours=1)
    return madrid_now

def insert_record(client, session_id, user_name, file_name, file_path, action):
    db = client['Logs']
    collection = db['historial']

    timestamp = madrid_time()

    record = {
        'session_id': session_id,
        'user_name': user_name,
        'file_name': file_name,
        'file_path': file_path,
        'action': action,
        'timestamp': timestamp
    }

    result = collection.insert_one(record)
    return result

if __name__ == "__main__":
    try:
        session_id = sys.argv[1]
        user_name = sys.argv[2]
        file_name = sys.argv[3]
        file_path = sys.argv[4]
        action = sys.argv[5]  # Obtenemos el argumento 'subir' o 'eliminar' o 'descargar'

        print('Script de Python ejecutado con los siguientes parámetros:')
        print(f'Session ID: {session_id}')
        print(f'User Name: {user_name}')
        print(f'File Name: {file_name}')
        print(f'File Path: {file_path}')
        print(f'Action: {action}')  # Imprimimos el valor de 'action'

        # Conectarse a MongoDB
        client = connect_to_mongodb()

        # Insertar registro en la colección de MongoDB
        result = insert_record(client, session_id, user_name, file_name, file_path, action)

        if result.inserted_id:
            print('Datos almacenados en MongoDB correctamente.')
        else:
            print('Error: No se pudo insertar el registro en MongoDB.')

    except Exception as e:
        print(f'Error en el script Python: {e}')
