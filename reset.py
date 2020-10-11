import config
import os
from update import build_db

response = None
while response not in ["Y", "N"]:
    response = input("Are you sure you want to reset mediapi? y/n ").upper()
if response == "N":
    exit()

local_config = ""

music_dir = input("Where is your music? [default: ./Music] ")
if music_dir == "":
    music_dir = config.music_dir
else:
    if music_dir[0] != "/":
        music_dir = os.path.join(config._this_dir, music_dir)
    local_config += f"music_dir = \"{music_dir}\"\n"
if not os.path.isdir(music_dir):
    os.makedirs(music_dir)

os.system("rm -r {config.db_dir}")
db_dir = input("Where do you want to store the database? [default: ~/.mediapi/db/] ")
if db_dir == "":
    db_dir = config.db_dir
else:
    if db_dir[0] != "/":
        db_dir = os.path.join(config._this_dir, db_dir)
    local_config += f"db_dir = \"{db_dir}\"\n"
if not os.path.isdir(db_dir):
    os.makedirs(db_dir)

if local_config != "":
    with open(os.path.join(config._this_dir, "local_config.py"), "w") as f:
        f.write(local_config)

response = None
while response not in ["Y", "N"]:
    response = input("Do you want to build the database now? Enter Y/n ").upper()
    if response == "":
        response = "Y"
if response == "N":
    exit()

build_db()
