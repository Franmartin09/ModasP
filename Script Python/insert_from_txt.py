import psycopg2
import csv

# Datos de conexión a la base de datos PostgreSQL
db_name = 'nombre_de_la_base_de_datos'
db_user = 'nombre_de_usuario'
db_password = 'contraseña'
db_host = 'localhost'  # o el host donde se encuentre la base de datos
db_port = '5432'  # el puerto por defecto de PostgreSQL es 5432

# Nombre del archivo CSV o TXT a utilizar
file_name = 'nombre_del_archivo.csv'  # o 'nombre_del_archivo.txt'

# Conexión a la base de datos
conn = psycopg2.connect(database=db_name, user=db_user, password=db_password, host=db_host, port=db_port)
cursor = conn.cursor()

# Lectura del archivo CSV o TXT
with open(file_name, 'r') as file:
    reader = csv.reader(file)
    next(reader)  # omitimos la primera fila si contiene el encabezado
    for row in reader:
        # Insertamos los datos en la base de datos
        cursor.execute("INSERT INTO tabla (campo1, campo2, campo3) VALUES (%s, %s, %s)", row)

# Guardamos los cambios en la base de datos y cerramos la conexión
conn.commit()
conn.close()

print('Datos insertados exitosamente en la base de datos')
