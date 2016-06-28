from filters import filters
import re

f=open("/home/pi/player/filt")
filt=f.read()
f.close()

f=open("/home/pi/player/filtnow")
filtnow=f.read()
f.close()

if filtnow!=filt:
   
  f=open('/home/pi/player/db')
  lines=f.readlines()
  f.close()
  reg = filt
  for f,r in filters.items():
      if filt == f:
        reg = r
  i=0
  output=[]
  for line in lines:
    if re.search(reg,line,re.I):
      output.append(str(i)+"\n")
    i+=1
  
  f=open("/home/pi/player/db-xmas","w")
  f.writelines(output)
  f.close()
  
  f=open("/home/pi/player/filtnow","w")
  f.writelines(filt)
  f.close()
