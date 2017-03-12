import config

from mutagen.id3 import ID3
from mutagen import ogg
import os
import re
import json

def sort_key(a):
    return a[2]+" "+a[3]+" "+str(a[0]).zfill(4)

def wanted(f):
    if f[-4:]!=".mp3":
        return False
    return True

def get_tag(tags,t):
    out = tags[t].text[0]
    if t == "TRCK":
        out = int(out.split("/")[0])
    return out

def re_match(rex,s):
    if re.search(rex,s[1],re.IGNORECASE):
        return True
    if re.search(rex,s[2],re.IGNORECASE):
        return True
    if re.search(rex,s[3],re.IGNORECASE):
        return True
    return False

all_music = []
artists = []

for root, dirs, files in os.walk(config.music_dir):
    print root
    for file in [f for f in files if wanted(f)]:
        full_file = os.path.join(root, file)
        tags = ID3(full_file)

        num = get_tag(tags,"TRCK")
        title = get_tag(tags,"TIT2")
        artist = get_tag(tags,"TPE1")
        album = get_tag(tags,"TALB")
        track = [num, title, artist, album, full_file]
        all_music.append(track)

        if artist not in artists:
            artists.append(artist)

all_music.sort(key=sort_key)
artists.sort()

for i,s in enumerate(all_music):
    with open(config.db_json("full",i),"w") as f:
        json.dump(s,f)

with open(config.db_json("artists"),"w") as f:
    json.dump(artists,f)

for i,a in enumerate(artists):
    with open(config.db_json("by_artist",i),"w") as f:
        json.dump([i for i,s in enumerate(all_music) if s[2]==a],f)

with open(os.path.join(config.player_dir,"filters.json")) as f:
    filters = json.load(f)

for i,filt in enumerate(filters):
    with open(config.db_json("filters",i),"w") as f:
        json.dump([i for i,s in enumerate(all_music) if re_match(filt[1],s)],
                  f)

with open(config.db_json("info"),"w") as f:
    json.dump({"length":len(all_music),"artists":len(artists)},f)
