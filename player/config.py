import os as _os
import inspect as _inspect
import json as _json

current_dir = _os.path.dirname(_os.path.abspath(
    _inspect.getfile(_inspect.currentframe())))
music_dir = _os.path.join(current_dir,"../Music")
db_dir = _os.path.join(current_dir,"db")
player_dir = current_dir

def db_json(_name,_name2=None):
    if _name2 is None:
        return _os.path.join(db_dir,str(_name)+".json")
    else:
        return _os.path.join(db_dir,str(_name),str(_name2)+".json")

def read_options():
    with open(_os.path.join(player_dir,"options.json")) as f:
        return _json.load(f)
