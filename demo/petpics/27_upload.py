import os, time
import ftplib

# first we get this device's serial number
fSN = open('/etc/SN', 'r')
sn = fSN.readline().rstrip()
fSN.close()

path_to_watch = "."
ftp = ftplib.FTP('pet.buygood.us', 'projectpet', 'good&$3(uR3')
ftp.cwd('/var/www/vhosts/pet.buygood.us/htdocs/demo/petpics')
for f in os.listdir (path_to_watch):
	newFile = open(f, 'rb')
	storeCom = 'STOR ' + sn + '_' + f # append device's serial number to each photo
	ftp.storbinary(storeCom, newFile)
	newFile.close()
