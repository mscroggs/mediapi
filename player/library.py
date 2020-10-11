import config
import json
import os
import random


class MusicLibrary:
    def __init__(self):
        with open(os.path.join(config.db_dir, "info.json")) as f:
            data = json.load(f)
        self.length = data["length"]
        self.artists = data["artists"]
        self._artistlist = None

    def get_track_info(self, i):
        with open(os.path.join(config.db_dir, "full", f"{i}.json")) as f:
            data = json.load(f)
        return {"track_n": data[0],
                "title": data[1],
                "artist": data[2],
                "album": data[3],
                "filename": data[4],
                "length": data[5]}

    def get_filename(self, i):
        return self.get_track_info(i)["filename"]

    def choose_next(self, current=None):
        next = current
        while next == current:
            next = random.randrange(self.length)
        return self.get_filename(next)

    def get_artists(self):
        if self._artistlist is None:
            with open(os.path.join(config.db_dir, "artists.json")) as f:
                self._artistlist = json.load(f)
        return self._artistlist

    def get_artist(self, i):
        with open(os.path.join(config.db_dir, f"by_artist/{i}.json")) as f:
            return json.load(f)
