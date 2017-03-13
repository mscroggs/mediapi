from player import MusicPlayer, RadioPlayer
import tools
from time import sleep
tools.save_info({"play":"off"})

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
                    player.unpause()
                # SKIP
                if tools.skip():
                    player.skip()
                player.tick_over()
            player.stop()
            tools.save_info({"play":"off"})

        if tools.play_radio():
            player = RadioPlayer()
            while tools.play_radio():
                # PAUSE
                if tools.pause():
                    player.pause()
                    while tools.pause() and tools.play_music():
                        player.tick_over()
                    player.unpause()
                player.tick_over()
            player.stop()
            tools.save_info({"play":"off"})

        if tools.off():
            sleep(5)
#except BaseException as e:
#    tools.write_exception(e)
