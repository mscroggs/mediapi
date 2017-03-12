import config as _config
import json as _json

def _o(item):
    return _config.read_options()[item]

def play_music():
    return _o("play") == "music"

def play_radio():
    return _o("play") == "radio"

def off():
    return _o("play") == "off"

def shuffle():
    return _o("shuffle")

def pause():
    return _o("pause")

def queue():
    return []

def probability():
    return _o("prob")

def filt():
    return _o("filter")

def length():
    with open(_config.db_json("info")) as f:
        return _json.load(f)["length"]

