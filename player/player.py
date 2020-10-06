import vlc
from library import MusicLibrary
from mutagen.id3 import ID3
from time import sleep


class VLCPlayer(object):
    def __init__(self, player_type):
        self.player_type = player_type

        self.instance = vlc.Instance()

        self.medialist = self.instance.media_list_new()
        self.player = self.instance.media_list_player_new()
        self.player.set_media_list(self.medialist)
        self.add_to_medialist()
        self.play()

    def tick_over(self):
        pass

    def info(self):
        raise NotImplementedError

    def add_to_medialist(self, i=None):
        raise NotImplementedError

    def get_pos(self):
        return self.player.get_media_player().get_time()

    def get_length(self):
        return self.player.get_length()

    def is_playing(self):
        return self.player.get_state() == vlc.State.Playing

    def has_ended(self):
        return self.player.get_state() == vlc.State.Ended

    def play(self):
        self.player.play()

    def unpause(self):
        self.player.play()

    def pause(self):
        self.player.pause()

    def set_volume(self, n):
        self.player.audio_set_volume(n)

    def get_volume(self):
        return self.player.audio_get_volume()

    def stop(self):
        self.player.stop()

    def next(self):
        self.player.next()


class CDPlayer(VLCPlayer):
    def __init__(self):
        super().__init__("cd")

    def add_to_medialist(self, i=None):
        assert i is None
        self.medialist.add_media(self.instance.media_new("cdda:///dev/cdrom"))


class MusicPlayer(VLCPlayer):
    def __init__(self):
        self.library = MusicLibrary()
        self.shuffle = True
        self.current_mrl = None
        self.current_info = None

        super().__init__("music")

    def add_to_medialist(self, i=None):
        if i is None:
            if self.shuffle:
                i = self.library.choose_next(self.current_mrl)
            else:
                raise NotImplementedError
        self.medialist.add_media(self.instance.media_new(i))

    def info(self):
        mrl = self.player.get_media_player().get_media().get_mrl()
        file = mrl_to_file(mrl)
        if self.current_mrl != mrl:
            tags = ID3(file)
            while self.player.get_media_player().get_media().get_duration() == -1:
                sleep(1)
            self.current = mrl
            self.current_info = {
                "filename": file,
                "track_n": get_tag(tags, "TRCK"),
                "title": get_tag(tags, "TIT2"),
                "artist": get_tag(tags, "TPE1"),
                "album": get_tag(tags, "TALB"),
                "length": self.player.get_media_player().get_media().get_duration()}
        return self.current_info

    def tick_over(self):
        media = self.player.get_media_player().get_media()
        if self.medialist.index_of_item(media) + 1 == len(self.medialist):
            self.add_to_medialist()


def get_tag(tags, t):
    out = tags[t].text[0]
    if t == "TRCK":
        out = int(out.split("/")[0])
    return out


def mrl_to_file(mrl):
    mrl = mrl[7:]
    mrl = mrl.replace("%20", " ")
    return mrl
