from datetime import datetime
import player
import sys

song = sys.argv[1]

p = player.MusicPlayer()
p.set_media(song)
p.set_volume(120)
while datetime.now().minute == 59 and datetime.now().second < 54 and "force" not in sys.argv:
    continue
p.play()
while not p.has_ended():
    continue
