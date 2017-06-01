#!/usr/bin/python
import commands
import socket
import sys
import MySQLdb
import RPi.GPIO as GPIO
import time
HOST = 'localhost'
USER = 'root'
PASSWD = 'r00tman'
DB_NOMBRE = 'loginsegdb'
estado_led = False
GPIO.setmode(GPIO.BOARD)
GPIO.setup(7, GPIO.OUT)
def upServicios():
	commands.getoutput("/etc/init.d/networking restart")
	commands.getoutput("ifup wlan0")
	commands.getoutput("ifdown wlan0")
	commands.getoutput("ifup wlan0")
	print "Subiendo wlan0"
	commands.getoutput("/etc/init.d/isc-dhcp-server start")
	print "Iniciando DHCP"
	commands.getoutput("/etc/init.d/hostapd stop")
	commands.getoutput("/etc/init.d/hostapd start")
	print "Iniciando Hostpod"

class DNSQuery:
  def __init__(self, data):
    self.data=data
    self.dominio=''

    tipo = (ord(data[2]) >> 3) & 15   # 4bits de tipo de consulta
    if tipo == 0:                     # Standard query
      ini=12
      lon=ord(data[ini])
      while lon != 0:
	self.dominio+=data[ini+1:ini+lon+1]+'.'
	ini+=lon+1
	lon=ord(data[ini])

  def respuesta(self, ip):
    packet=''
    if self.dominio:
      packet+=self.data[:2] + "\x81\x80"
      packet+=self.data[4:6] + self.data[4:6] + '\x00\x00\x00\x00'   # Numero preg y respuestas
      packet+=self.data[12:]                                         # Nombre de dominio original
      packet+='\xc0\x0c'                                             # Puntero al nombre de dominio
      packet+='\x00\x01\x00\x01\x00\x00\x00\x3c\x00\x04'             # Tipo respuesta, ttl, etc
      packet+=str.join('',map(lambda x: chr(int(x)), ip.split('.'))) # La ip en hex
    return packet

def redireccionDNS():
	ip="192.168.10.1"
	udps = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
	udps.bind(('',53))
	try:
		while 1:
			data, addr = udps.recvfrom(1024)
			p=DNSQuery(data)
			udps.sendto(p.respuesta(ip), addr)
	except KeyboardInterrupt:
		print 'Finalizando'
		commands.getoutput("/etc/init.d/hostapd stop")
		commands.getoutput("/etc/init.d/isc-dhcp-server stop")
		udps.close()
		commands.getoutput("ifdown wlan0")

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

def gpioAccion(noparpadear=True):
	if noparpadear:
		GPIO.output(7, True)
		time.sleep(3)
		GPIO.output(7, False)
	else:
		intervalos = 5
		while intervalos >0:
			GPIO.output(7, True)
			time.sleep(0.3)
			GPIO.output(7, False)
			time.sleep(0.3)
			intervalos = intervalos - 1
	
def escucha():
	print "***Linea de comando Habilitada***"
	while True:
		comando = str(raw_input(">"))
		if comando != "":
			comando = comando.split(" ")
			if comando[0] == "qr":
				codeqr = comando[1]
				query = "SELECT user_id FROM registros WHERE hascode = '%s'" %(codeqr)
				#print query
				resultado = hacer_query(query)
				if len(resultado) > 0:
					gpioAccion()
					print "Acceso concedido"
				else:
					gpioAccion(False)
					print "QR invalido"


if __name__ == '__main__':
	
	try:
		if("start" == str(sys.argv[1])):
			upServicios()
			escucha()		
		elif("stop" == str(sys.argv[1])):
			commands.getoutput("/etc/init.d/hostapd stop")
			commands.getoutput("/etc/init.d/isc-dhcp-server stop")
			commands.getoutput("ifdown wlan0")
		else:
			print "comando invalido"
	except:
		print "Faltan argumentos"
		commands.getoutput("/etc/init.d/hostapd stop")
		commands.getoutput("/etc/init.d/isc-dhcp-server stop")
		commands.getoutput("ifdown wlan0")
		GPIO.cleanup()
