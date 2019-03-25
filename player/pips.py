from datetime import datetime
import player
import sys

song = sys.argv[1]

p = player.MusicPlayer()
p.set_media(song)
while datetime.now().minute == 59 and datetime.now().second < 54 and "force" not in sys.argv:
    continue
p.play()
p.set_volume(150)
while not p.has_ended():
    continue
