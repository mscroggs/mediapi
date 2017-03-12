import tools
import random
import vlc
from time import time

class GenericVLCPlayer(object):
    def __init__(self):
        self.vlc_i = vlc.Instance()
        self.vlc_p = self.vlc_i.media_player_new()
        self.time = int(time())

    def tick_over(self):
        pass

    def get_pos(self):
        return self.vlc_p.get_position()

    def get_length(self):
        return self.vlc_p.get_length()

    def is_playing(self):
        return self.vlc_p.get_state() == vlc.State.Playing

    def has_ended(self):
        return self.vlc_p.get_state() == vlc.State.Ended

    def play(self):
        self.vlc_p.play()

    def unpause(self):
        self.vlc_p.play()

    def pause(self):
        self.vlc_p.pause()

    def stop(self):
        self.vlc_p.stop()

    def set_media(self, filepath):
        self.vlc_p.set_media(self.vlc_i.media_new(filepath))



class MusicPlayer(GenericVLCPlayer):
    def __init__(self):
        super(MusicPlayer, self).__init__()
        import library
        self.library = library.MusicLibrary()
        self.info = {"play":"music","current":-1,"pos":0,"more":None}
        self.play_next()

    def get_pos(self):
        return self.vlc_p.get_position()

    def get_length(self):
        return self.vlc_p.get_length()

    def tick_over(self):
        if self.has_ended():
            self.play_next()
        if int(time())!=self.time:
            self.info["pos"] = self.get_pos()
            tools.save_info(self.info)
            self.time = int(time())

    def play_track(self,i):
        self.set_media(self.library.get_filename(i))
        self.play()
        self.info["current"] = i
        self.info["more"] = self.library.get_item(i)

    def play_next(self):
        self.play_track(self.get_next())

    def get_next(self):
        q = tools.queue()
        if len(q) > 0:
            tools.remove_first_from_queue()
            return q[0]
        if tools.shuffle():
            fl = self.library.get_filtered_list()
            if random.random() > tools.probability() and len(fl)>0:
                return random.choice(self.library.get_filtered_list())
            else:
                return random.randrange(self.library.length)
        return (self.info["current"] + 1) % self.library.length

    def skip(self):
        self.stop()
        tools.set_skip_to_false()
        self.play_next()

    def has_queue(self):
        return len(tools.queue())>0

class RadioPlayer(GenericVLCPlayer):
    def __init__(self):
        super(RadioPlayer, self).__init__()
        import library
        self.library = library.RadioLibrary()
        self.info = {"play":"radio","playing":0,"more":None}

    def tick_over(self):
        rc = tools.radio_channel()
        if rc != self.info["playing"]:
            self.info["playing"] = rc
            self.info["more"] = self.library.get_item(rc)
            self.set_media = self.library.get_url(rc)
        if int(time())!=self.time:
            self.info["pos"] = self.get_pos()
            tools.save_info(self.info)
            self.time = int(time())
