import os as _os

_dir = _os.path.dirname(_os.path.realpath(__file__))
music_dir = _os.path.join(_dir, "../Music")
db_dir = _os.path.join(_dir, "db")
data_dir = _os.path.join(_dir, "../data")
player_dir = _dir

try:
    from local_config import *  # noqa: F403,F401
except ImportError:
    pass
