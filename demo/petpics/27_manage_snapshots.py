import os, time
import ftplib

# first we get this device's serial number
fSN = open('/etc/SN', 'r')
sn = fSN.readline().rstrip()
fSN.close()

path_to_watch = "."
before = dict ([(f, None) for f in os.listdir (path_to_watch)])
while 1:
	time.sleep (1)
	after = dict ([(f, None) for f in os.listdir (path_to_watch)])
	added = [f for f in after if not f in before]
	removed = [f for f in before if not f in after]
	if added:
		#print "Added: ", ", ".join (added)
		#print 'for now, we\'ll send ', added[0]
		ftp = ftplib.FTP('pet.buygood.us', 'projectpet', 'good&$3(uR3')
		ftp.cwd('/var/www/vhosts/pet.buygood.us/htdocs/demo/petpics')
		for pic in added:
			newFile = open(pic, 'rb')
			storeCom = 'STOR ' + sn + '_' + pic # append device's serial number to each photo
			ftp.storbinary(storeCom, newFile)
			newFile.close()
	#if removed: print "Removed: ", ", ".join (removed)
	before = after
