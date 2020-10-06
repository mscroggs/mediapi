import config
import os
from player import MusicPlayer, CDPlayer
from time import sleep


def load_instruction():
    with open(os.path.join(config.player_dir, "commands")) as f:
        data = [i.strip() for i in f.readlines()]
    with open(os.path.join(config.player_dir, "commands"), "w") as f:
        f.write("\n".join(data[1:]))
    if len(data) > 0:
        return data[0].split()
    return None


player = None

while True:
    i = load_instruction()
    print(i)
    if i is not None:
        if i[0] == "PLAY":
            if player is not None:
                player.stop()
            if i[1] == "CD":
                player = CDPlayer()
            elif i[1] == "MP3":
                player = MusicPlayer()
            else:
                raise ValueError(f"Unknown player type: {i[1]}")
        elif i[0] == "PAUSE":
            player.pause()
        elif i[0] == "UNPAUSE":
            player.unpause()
        elif i[0] == "SKIP":
            player.next()

        else:
            raise ValueError(f"Unknown command: {' '.join(i)}")

    if player is not None:
        player.tick_over()
        print(player.info())
        print(player.get_pos())
    sleep(3)
    continue
