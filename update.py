import config
from mutagen.id3 import ID3
from mutagen.mp3 import MP3
import os
import json


def db_json(*args):
    folder = os.path.join(config.db_dir, *args[:-1])
    file = os.path.join(folder, f"{args[-1]}.json")
    if not os.path.isdir(folder):
        os.makedirs(folder)
    if not os.path.isfile(file):
        with open(file, "w") as f:
            json.dump({}, f)
    return file


def case(a):
    a = a.lower()
    if "clancy brothers" in a:
        return "clancy brothers"
    if a[:4] == "the ":
        a = a[4:]
    a = " and ".join(a.split("&"))
    for c in ".!\"'?,":
        a = "".join(a.split(c))
    for c in "-":
        a = " ".join(a.split(c))
    while "  " in a:
        a = " ".join(a.split("  "))
    while a[-1] == " ":
        a = a[:-1]
    while a[0] == " ":
        a = a[1:]
    return a


def get_tag(tags, t):
    out = tags[t].text[0]
    if t == "TRCK":
        out = int(out.split("/")[0])
    return out


def build_db():
    all_music = []
    both_artists = []
    artists = []
    uncapped = []

    for root, dirs, files in os.walk(config.music_dir):
        print(root)
        for file in [f for f in files if f.lower().endswith(".mp3")]:
            full_file = os.path.join(root, file)
            tags = ID3(full_file)
            audio = MP3(full_file)

            num = get_tag(tags, "TRCK")
            title = get_tag(tags, "TIT2")
            artist = get_tag(tags, "TPE1")
            album = get_tag(tags, "TALB")
            length = audio.info.length
            track = [num, title, artist, album, full_file, length]
            all_music.append(track)

            if case(artist) not in artists:
                artists.append(case(artist))
                both_artists.append([case(artist), artist])

    all_music.sort(key=lambda a: a[2] + " " + a[3] + " " + str(a[0]).zfill(4))
    both_artists.sort(key=lambda a: a[0])

    artists = [i[0] for i in both_artists]
    uncapped = [i[1] for i in both_artists]

    print("Making albums")
    albums = {}
    for i, s in enumerate(all_music):
        if s[3] not in albums:
            albums[s[3]] = []
        albums[s[3]].append(i)

    print("Writing songs to file")
    for i, s in enumerate(all_music):
        all_music[i].append(",".join([str(j) for j in albums[s[3]]]))

    for i, s in enumerate(all_music):
        with open(db_json("full", i), "w") as f:
            json.dump(s, f)

    with open(db_json("artists"), "w") as f:
        json.dump(uncapped, f)

    print("Making artist list")
    for i, a in enumerate(artists):
        with open(db_json("by_artist", i), "w") as f:
            json.dump({i: s for i, s in enumerate(all_music) if case(s[2]) == a}, f)

    maap = {}
    for i, j in enumerate(all_music):
        maap[j[4]] = (i, j)

    print("Filtering")
    with open(db_json("filters")) as f:
        filters = json.load(f)

    for i, filt in enumerate(filters):
        print(filt)
        with open(db_json("filters", i)) as f:
            ls = [a[4] for a in json.load(f).values()]
        out = {}
        for a in ls:
            try:
                out[maap[a][0]] = maap[a][1]
            except KeyError:
                pass
        with open(db_json("filters", i), "w") as f:
            json.dump(out, f)

    print("Saving info")
    with open(db_json("info"), "w") as f:
        json.dump({"length": len(all_music), "artists": len(artists)}, f)

    print("Done")


if __name__ == "__main__":
    build_db()
