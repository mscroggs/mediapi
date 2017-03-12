import pygame
import options
import random

class MusicPlayer:
    def __init__(self):
        import library
        self.library = library.Library()
        pygame.mixer.init()
        pygame.mixer.music.set_volume(1.0)
        self.current = -1
        self.next = -1
        self.queue = False
        self.queue_next()

    def queue_next(self):
        self.next = self.get_next()
        if pygame.mixer.music.get_busy():
            pygame.mixer.music.queue(self.library.get_filename(
                                                             self.get_next()))
            self.queue = True
        else:
            pygame.mixer.music.load(self.library.get_filename(
                                                             self.get_next()))
            pygame.mixer.music.play()

    def get_next(self):
        q = options.queue()
        if len(q) > 0:
            return q[0]
        if options.shuffle():
            fl = self.library.get_filtered_list()
            if random.random() > options.probability() and len(fl)>0:
                return random.choice(self.library.get_filtered_list())
            else:
                return random.randrange(self.library.length)
        return (self.current + 1) % self.library.length

    def unpause(self):
        pygame.mixer.music.unpause()

    def pause(self):
        pygame.mixer.music.pause()

    def stop(self):
        pygame.mixer.music.stop()

    def is_queued(self):
        return self.queue

    def has_queue(self):
        return len(options.queue())>0

class RadioPlayer:
    pass
