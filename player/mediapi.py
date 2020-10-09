import _thread
from .player import MusicPlayer, CDPlayer, DummyPlayer
from time import sleep


class MediaPi:
    def __init__(self):
        self.player = DummyPlayer()

    def parse_instruction(self, i):
        i = i.split(" ")
        if i[0] == "PLAY":
            self.player.stop()
            if i[1] == "CD":
                self.player = CDPlayer()
            elif i[1] == "MP3":
                self.player = MusicPlayer()
            else:
                raise ValueError(f"Unknown player type: {i[1]}")
        elif i[0] == "PAUSE":
            self.player.pause()
        elif i[0] == "UNPAUSE":
            self.player.unpause()
        elif i[0] == "SKIP":
            self.player.next()
        elif i[0] == "STOP":
            self.player.stop()
            self.player = DummyPlayer()

        else:
            raise ValueError(f"Unknown command: {' '.join(i)}")

    def tick_loop(self):
        while True:
            self.player.tick_over()
            sleep(5)

    def start_tick_thread(self):
        _thread.start_new_thread(self.tick_loop, ())

    def player_type(self):
        return self.player.player_type
