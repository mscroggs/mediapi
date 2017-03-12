from player import MusicPlayer, RadioPlayer
import options

while True:
    if options.play_music():
        player = MusicPlayer()
        while options.play_music():
            if options.pause():
                player.pause()
                while options.pause() and options.play_music():
                    pass
                player.unpause()
            if not player.is_queued():
                player.queue_next()
        player.stop()

    if options.play_radio():
        pass
    if options.off():
        continue

initd=False;

