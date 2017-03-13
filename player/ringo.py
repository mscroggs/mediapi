import tools
import os
import json
import player
import sys

song = sys.argv[1]
print song
paused_before = tools.pause()

opts = tools.read_options()
opts["pause"] = True

with open(os.path.join(tools.player_dir,"options.json"),"w") as f:
     json.dump(opts,f)

p = player.MusicPlayer()
p.set_volume(120)
p.set_media(song)
p.play()
while not p.has_ended():
    continue

opts["pause"] = paused_before
with open(os.path.join(tools.player_dir,"options.json"),"w") as f:
     json.dump(opts,f)
