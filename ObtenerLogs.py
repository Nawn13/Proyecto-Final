from pymongo import MongoClient

def obtener_logs():
    client = MongoClient('mongodb://localhost:27017/')
    db = client['Logs']
    collection = db['historial']

    logs = list(collection.find())
    return logs

# Llamada a la función e impresión de los resultados
logs = obtener_logs()
for log in logs:
    print(log)
