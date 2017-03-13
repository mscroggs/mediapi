import os as _os
import inspect as _inspect
import json as _json
from time import sleep as _sleep


current_dir = _os.path.dirname(_os.path.abspath(
    _inspect.getfile(_inspect.currentframe())))
music_dir = _os.path.join(current_dir,"../Music")
db_dir = _os.path.join(current_dir,"db")
player_dir = current_dir

def save_blank_info():
    save_info({"play":"off","volume":0})

def db_json(_name,_name2=None):
    if _name2 is None:
        return _os.path.join(db_dir,str(_name)+".json")
    else:
        return _os.path.join(db_dir,str(_name),str(_name2)+".json")

def read_options():
    try:
        with open(_os.path.join(player_dir,"options.json")) as f:
            return _json.load(f)
    except ValueError:
        _sleep(1)
        return read_options()

def _o(item):
    return read_options()[item]

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

def volume():
    return _o("volume")

def probability():
    return _o("prob")

def filt():
    return _o("filter")

def radio_channel():
    return _o("radioc")

def skip():
    return _o("skip")

def set_skip_to_false():
    o = read_options()
    o["skip"] = False
    with open(_os.path.join(player_dir,"options.json"),"w") as f:
        _json.dump(o,f)

def length():
    with open(db_json("info")) as f:
        return _json.load(f)["length"]

def queue():
    with open(_os.path.join(player_dir,"queue.json")) as f:
        return _json.load(f)

def get_radio_list():
    with open(_os.path.join(player_dir,"radio.json")) as f:
        return _json.load(f)

def remove_first_from_queue():
    q = queue()
    with open(_os.path.join(player_dir,"queue.json"),"w") as f:
        return _json.dump(q[1:],f)

def save_info(info):
    if info["play"] != "off":
        info["pause"] = pause()
        info["shuffle"] = shuffle()
        info["filter"] = filt()
        info["prob"] = probability()
    with open(_os.path.join(player_dir,"info.json"),"w") as f:
        return _json.dump(info,f)

def write_exception(e):
    from datetime import datetime
    n = datetime.now()
    with open(_os.path.join(player_dir,"log"),"w") as f:
        f.write(n.strftime("%Y-%m-%d %H:%M") + "\n"
              + str(e.__class__) + "\n"
              + str(e) + "\n"
              + str(e.message))
