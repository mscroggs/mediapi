from mutagen.id3 import ID3
from mutagen import ogg
import os
import re

def sorty(tx):
	tx2=tx.lower().split(u"#|#")
	if tx2[3][0:3]=='the':
		tx2[3]=tx2[3][4:]
	return tx2[3]+" "+tx2[4]+" "+('{0}'.format(tx2[1].zfill(2)))


output=[]
for root, dirs, files in os.walk("/home/pi/Music"):
	dirs.sort()
	print root
	files.sort()
	for file in files:
		a=os.path.join(root,file)
		audio=ID3(a)
		b=audio.pprint().splitlines()
		dict={}
		for c in b:
			c=c.partition("=")
			inn=c[0]
			outt=c[2]
			if inn=="TRCK":
				outt=outt.partition("/")[0]
			dict[inn]=outt
		output.append((a+"#|#"+dict["TRCK"]+"#|#"+dict["TIT2"]+"#|#"+dict["TPE1"]+"#|#"+dict["TALB"]+"\n").encode('ascii','ignore'))

output.sort(key=sorty)

#print output

#output2=output2.encode('ascii','ignore')

f=open("/home/pi/player/db","w")
f.writelines(output)
f.close()

#def xmas(inp):
#	return re.search(r'christmas|xmas|fairytale of new york',inp,re.I)
#
#def jazz(inp):
#return re.search(r'john coltrane|miles davis|eric dolphy|keith jarrett|charles mingus|billie holiday|nina simone|louis armstrong|fela kuti|charles mingus|sun ra',inp,re.I)
#
#output2=filter(xmas,output)
#
#f=open("/home/pi/player/db-xmas","w")
#f.writelines(output2)
#f.close()
#
#output2=filter(jazz,output)
#
#f=open("/home/pi/player/db-jazz","w")
#f.writelines(output2)
#f.close()
#
