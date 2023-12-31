import psycopg2
import csv
import sys

# Datos de conexión a la base de datos PostgreSQL
db_name = 'ci4_postgre'
db_user = 'root'
db_password = 'root'
db_host = 'localhost'  # o el host donde se encuentre la base de datos
db_port = '5432'  # el puerto por defecto de PostgreSQL es 5432

# Nombre del archivo CSV o TXT a utilizar
file_name = sys.argv[1]
if(file_name=="Clientes"):
    file_name="Clientes.csv"
elif(file_name=="Usuarios"):
    file_name="Usuarios.csv"

# Conexión a la base de datos
conn = psycopg2.connect(database=db_name, user=db_user, password=db_password, host=db_host, port=db_port)
cursor = conn.cursor()

# Lectura del archivo CSV o TXT
with open(file_name, 'r') as file:
    reader = csv.reader(file)
    next(reader)  # omitimos la primera fila si contiene el encabezado
    for row in reader:
        # Insertamos los datos en la base de datos
        if(file_name=="Clientes.csv"):
            if row[-2] == '':
                row = list(row)
                row[-2] = None
                row = tuple(row)
            cursor.execute("INSERT INTO clientes (id_cliente, name_surname, email_cliente, phone, addres, cif, fecha_alta, fecha_baja, estado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)", row)
        elif(file_name=="Usuarios.csv"):
            cursor.execute("INSERT INTO usuarios (id_user, username, email, pass) VALUES (%s, %s, %s, %s)", row)

# Guardamos los cambios en la base de datos y cerramos la conexión
conn.commit()
conn.close()

print('Datos insertados exitosamente en la base de datos')
