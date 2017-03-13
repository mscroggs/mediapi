from player import MusicPlayer, RadioPlayer
import tools
from time import sleep
tools.save_blank_info()

#try:
if True:
    while True:
        if tools.play_music():
            player = MusicPlayer()
            while tools.play_music():
                # PAUSE
                if tools.pause():
                    player.pause()
                    while tools.pause() and tools.play_music():
                        player.tick_over()
                        sleep(1)
                    player.unpause()
                # SKIP
                if tools.skip():
                    player.skip()
                player.tick_over()
            player.stop()
            tools.save_blank_info()

        if tools.play_radio():
            player = RadioPlayer()
            while tools.play_radio():
                # PAUSE
                if tools.pause():
                    player.pause()
                    while tools.pause() and tools.play_music():
                        player.tick_over()
                        sleep(1)
                    player.unpause()
                player.tick_over()
            player.stop()
            tools.save_blank_info()

        if tools.off():
            sleep(5)
#except BaseException as e:
#    tools.write_exception(e)
