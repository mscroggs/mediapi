from threading import Thread
from time import sleep
from .player import MusicPlayer, CDPlayer, DummyPlayer


class MediaPi:
    class __MediaPi:
        def __init__(self):
            self.player = DummyPlayer()
            t = Thread(target=self.tick_loop)
            t.start()

        def tick_loop(self):
            while True:
                self.tick_over()
                sleep(10)

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
            elif i[0] == "PASS":
                pass

            else:
                raise ValueError(f"Unknown command: {' '.join(i)}")
            self.tick_over()

        def fraction(self):
            if isinstance(self.player, DummyPlayer):
                return 0
            return self.player.get_pos() / self.player.info()["length"]

        def is_playing(self):
            return self.player.is_playing()

        def get_info(self):
            return self.player.info()

        def player_type(self):
            return self.player.player_type

        def tick_over(self):
            self.player.tick_over()
            if self.player.has_ended():
                self.player = DummyPlayer()

    instance = None

    def __init__(self):
        if not MediaPi.instance:
            MediaPi.instance = MediaPi.__MediaPi()

    def __getattr__(self, name):
        return getattr(self.instance, name)
