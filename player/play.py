import pygame
#from random import randrange
import random

f=open("/home/pi/player/db");
db=f.read().splitlines()
f.close()

pygame.mixer.init()
pygame.mixer.music.set_volume(1.0)

initd=False;

g='on'
while g=='on':
	q=True
	while q:
		opos=0
		pos=1
		f=open("/home/pi/player/s")
		s=f.read()
		f.close()
		
		f=open("/home/pi/player/ne")
		cu=f.read()
		f.close()
		f=open("/home/pi/player/cu","w")
		f.write(cu)
		f.close()
		
		f=open("/home/pi/player/queue")
                que=f.read().splitlines(True)
                f.close()
		
		cu=int(cu)
		if len(que)>0:
			cu=int(que[0])
			f=open("/home/pi/player/queue","w")
                	if len(que)>1:
				f.writelines(que[1:])
			else:
				f.write("")
                	f.close()
		elif s=='on':
			cun=cu
			while cun==cu:
				f=open("/home/pi/player/prob")
		                prob=f.read()
                		f.close()
				f=open("/home/pi/player/db-xmas")
                		filt=f.read().splitlines(True)
		                f.close()
				if random.random()<float(prob) and len(filt)>1:
					cun=int(random.choice(filt))
				else:
					cun=random.randrange(len(db))
			cu=cun
		else:
			cu+=1
			cu%=len(db)
		f=open("/home/pi/player/ne","w")
		f.write(str(cu))
		f.close()
		if pygame.mixer.music.get_busy():
			pygame.mixer.music.queue(db[cu].partition('#|#')[0])
			q=False
		else:
			pygame.mixer.music.load(db[cu].partition('#|#')[0])
			pygame.mixer.music.play()
	started=True
	while (pos>=1000 or started) and pygame.mixer.music.get_busy():
		f=open("/home/pi/player/a","r")
		g=f.read()
		f.close()
		if g=='off':
			pygame.mixer.music.stop()
		else:
			f=open("/home/pi/player/p","r")
                	p=f.read()
                	f.close()
			if p=='on':
				pygame.mixer.music.pause()
				while p=='on' and g=='on':
					f=open("/home/pi/player/p","r")
                        		p=f.read()
                        		f.close()
				pygame.mixer.music.unpause()
				while pygame.mixer.music.get_busy()==False:
					pos=pygame.mixer.music.get_pos()
			f=open("/home/pi/player/f","r")
                        skip=f.read()
                        f.close()
			if skip=='on':
				pygame.mixer.music.stop()
				pygame.mixer.music.load(db[cu].partition('#|#')[0])
	                        pygame.mixer.music.play()
				f=open("/home/pi/player/f","w")
				f.write("off")
				f.close()
			pos=pygame.mixer.music.get_pos()
			if(pos>1000):
				started=False
			continue

f=open("/home/pi/player/a","w")
f.write("off")
f.close()

f=open("/home/pi/player/b","w")
f.write("off")
f.close()
