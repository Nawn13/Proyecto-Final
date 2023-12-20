# Proyecto-Final
En el branch de fase 0 tienes un rar con el resultado final de esta fase el resto son pruebas que todavia no hemos añadido en esta fase

Debes instalar el servidor web XAMPP y crear dentro de el una carpeta llamada pagina y dentro de ella las carpetas pertinentes que ya tendras creadas en el rar.

Todo sobre la base de datos estara en el github en la branch de fase 0 con el nombre estrcutruraMariadb.
Para la base de datos relacional en mariadb tendras las estructuras en una imagen llamada Estructura mariadb tienes un ejemplo de creacion de tabla con sus foraneas en una imagen llamada Ejemplo tabla.
Esta imagen es el como debes crear la tabla ficheros aparte lo unico que tendrias que hacer guiandote en la otra imagen con los describe que la Id_Depart de la tabla usuarios indique como clave foranea al Id_Depart de la tabla departamentos.

En el caso de la no relacional que la hemos hecho en mongodb para crear la base de datos use Logs y para crear la coleccion db.createCollection('historial').

Los logs se pueden revisar desde el panel de admin pero no te los muestra por pantall sino que lo guarda en un archivo que se llama logs_output.txt.

Para el funcionamiento de los algunos de los codigos necesitaras realizar los siguientes pip para descargar las extensiones.
pip install requests
pip install mysql-connector-python
pip install pymongo
