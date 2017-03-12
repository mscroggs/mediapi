import os

with open("/home/pi/.pyradio") as f:
    db=f.readlines()

#os.system("vlc -Idummy http://bbc.co.uk/radio/listen/live/r4lw.asx &")

rad = 0
r = 'on'

while r == 'on':
    with open("/home/pi/player/r") as f:
        r = f.read()
  
    oldrad = rad
    with open("/home/pi/player/rad") as f:
        rad = f.read()
  
    if oldrad!=rad:
        with open("/home/pi/player/rad","w") as f:
            f.write(rad)
        stream = db[int(rad)-1].split(", ")[1]
        os.system("python /home/pi/player/killradio.py")
        os.system("vlc -Idummy "+stream+" --volume 400&")
#    continue

os.system("python /home/pi/player/killradio.py")
with open("/home/pi/player/r2","w") as f:
    f.write("off")
