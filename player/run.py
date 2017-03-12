from player import MusicPlayer, RadioPlayer
import tools

while True:
    if tools.play_music():
        player = MusicPlayer()
        while tools.play_music():
            # PAUSE
            if tools.pause():
                player.pause()
                while tools.pause() and tools.play_music():
                    pass
                player.unpause()
            # SKIP
            if tools.skip():
                player.skip()
            player.tick_over()
        player.stop()

    if tools.play_radio():
        player = RadioPlayer()
        while tools.play_radio():
            player.tick_over()
        player.stop()

    if tools.off():
        continue

initd=False;

