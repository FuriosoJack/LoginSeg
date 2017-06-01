import MySQLdb
HOST = 'localhost'
USER = 'root'
PASSWD = 'r00tman'
DB_NOMBRE = 'loginsegdb'
def hacer_query(query=''):
    datos = [HOST, USER, PASSWD, DB_NOMBRE]
    conectar = MySQLdb.connect(*datos)
    cursor = conectar.cursor()
    cursor.execute(query)
    if query.upper().startswith('SELECT'):
        data = cursor.fetchall()  #Si se estan leyendo datos: obtener todos los registros hallados
    else:
        conectar.commit() #Si se esta agregando, editando o eliminando un registro: hacer un commit a la base de datos
        data = None
    return data
    cursor.close()
    conectar.close()
query = 'SELECT * FROM users;'
print hacer_query(query)
