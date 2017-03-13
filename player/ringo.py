import tools
import os
import json
import player

song = sys.argv[1]

paused_before = tools.pause()

opts = tools.read_coptions()
opts["pause"] = True

with open(os.path.join(tools.player_dir,"options.json")) as f:
     json.dump(opts,f)

p = MusicPlayer()
p.set_media(song)
while not p.has_ended():
    continue

opts["pause"] = paused_before
with open(os.path.join(tools.player_dir,"options.json")) as f:
     json.dump(opts,f)
