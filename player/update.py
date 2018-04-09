import tools

from mutagen.id3 import ID3
from mutagen.mp3 import MP3
from mutagen import ogg
import os
import re
import json

def sort_key(a):
    return a[2]+" "+a[3]+" "+str(a[0]).zfill(4)

def zero(a):
    return a[0]

def case(a):
    a = a.lower()
    if a[:4] == "the ":
        a = a[4:]
    a = "".join(a.split("."))
    return a

def wanted(f):
    if f[-4:].lower()!=".mp3":
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

both_artists = []

artists = []
uncapped = []

for root, dirs, files in os.walk(tools.music_dir):
    print(root)
    for file in [f for f in files if wanted(f)]:
        full_file = os.path.join(root, file)
        tags = ID3(full_file)
        audio = MP3(full_file)

        num = get_tag(tags,"TRCK")
        title = get_tag(tags,"TIT2")
        artist = get_tag(tags,"TPE1")
        album = get_tag(tags,"TALB")
        length = audio.info.length
        track = [num, title, artist, album, full_file, length]
        all_music.append(track)

        if case(artist) not in artists:
            artists.append(case(artist))
            both_artists.append([case(artist),artist])

all_music.sort(key=sort_key)
both_artists.sort(key=zero)

artists = [i[0] for i in both_artists]
uncapped = [i[1] for i in both_artists]

print("Making albums")
albums = {}
for i,s in enumerate(all_music):
    if s[3] not in albums:
        albums[s[3]] = []
    albums[s[3]].append(i)

print("Writing songs to file")
for i,s in enumerate(all_music):
    all_music[i].append(",".join([str(j) for j in albums[s[3]]]))


for i,s in enumerate(all_music):
    with open(tools.db_json("full",i),"w") as f:
        json.dump(s,f)

with open(tools.db_json("artists"),"w") as f:
    json.dump(uncapped,f)

print("Making artist list")
for i,a in enumerate(artists):
    with open(tools.db_json("by_artist",i),"w") as f:
        json.dump({i:s for i,s in enumerate(all_music) if case(s[2])==a},f)

maap = {}
for i,j in enumerate(all_music):
    maap[j[4]] = (i,j)

print("Filtering")
with open(os.path.join(tools.player_dir,"filters.json")) as f:
    filters = json.load(f)

for i,filt in enumerate(filters):
    print(filt)
    with open(tools.db_json("filters",i)) as f:
        ls = [a[4] for a in json.load(f).values()]
    out = {}
    for l in ls:
        try:
            out[maap[l][0]] = maap[l][1]
        except KeyError:
            pass
    with open(tools.db_json("filters",i),"w") as f:
        json.dump(out,f)

print("Saving info")
with open(tools.db_json("info"),"w") as f:
    json.dump({"length":len(all_music),"artists":len(artists)},f)

print("Done")
