import os as _os

_this_dir = _os.path.dirname(_os.path.realpath(__file__))
_dir = _os.path.join(_os.path.expanduser("~"), ".mediapi")
music_dir = _os.path.join(_this_dir, "Music")
db_dir = _os.path.join(_dir, "db")
data_dir = _os.path.join(_dir, "data")

try:
    from local_config import *  # noqa: F403,F401
except ImportError:
    pass
