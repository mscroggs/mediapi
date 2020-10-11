#!/usr/bin/env python
import config
import web
import os
import json
from player import MediaPi
from web.template import ALLOWED_AST_NODES

ALLOWED_AST_NODES.append('Constant')

urls = (
    '/', 'Root',
    '/send_command', 'SendCommand',
    '/get_buttons', 'GetButtons',
    '/get_song_data', 'GetSongData',
    '/get_artist_list', 'GetArtistList',
    '/add_to_queue', 'AddToQueue',
    '/get_artist', 'GetArtist')
app = web.application(urls, globals())
player = MediaPi()


def make_buttons():
    out = ""
    if player.player_type() == "cd":
        out += svg_button("cd.svg", "STOP", "cd-on")
    else:
        out += svg_button("cd.svg", "PLAY CD", "cd-off")
    if player.player_type() == "mp3":
        out += svg_button("mp3.svg", "STOP", "mp3-on")
    else:
        out += svg_button("mp3.svg", "PLAY MP3", "mp3-off")
    return out


def make_more_buttons():
    out = ""
    if player.player_type() == "cd" or player.player_type() == "mp3":
        if player.is_playing():
            out += smaller_svg_button("pause.svg", "PAUSE", "play")
        else:
            out += smaller_svg_button("pause.svg", "UNPAUSE", "pause")
        out += smaller_svg_button("skip.svg", "SKIP", "skip")
    return out


def actual_svg_button(filename, command, id, classname):
    with open(os.path.join("static", filename)) as f:
        return f"<button class='{classname}' id='{id}' onclick=\"return send_command('{command}')\">{f.read()}</button>"


def svg_button(filename, command, id):
    return actual_svg_button(filename, command, id, "button")


def smaller_svg_button(filename, command, id):
    return actual_svg_button(filename, command, id, "button small")


def get_artist_list():
    if player.player_type() != "mp3":
        return ""
    return "".join([f"<a class='listlink t{i%2}' href='javascript:show_artist({i})'>{a}</div>"
                    for i, a in enumerate(player.player.library.get_artists())])


def get_artist(i):
    if player.player_type() != "mp3":
        return ""
    out = f"<a class='back' href='javascript:show_all_artists()'><< back to artists</a>"
    out += f"<div class='artist-title'>{player.player.library.get_artists()[i]}</div>"
    album = None
    for i, (a, t) in enumerate(player.player.library.get_artist(i).items()):
        if t[3] != album:
            album = t[3]
            out += f"<a class='albumlink' href='javascript:add_to_queue([{t[6]}])'>{album}</a>"
        out += f"<a class='listlink t{i%2}' href='javascript:add_to_queue([{a}])'>"
        out += f"<span class='number'>{t[0]}</span>"
        out += f"<span class='title'>{t[1]}</span>"
        out += f"<span class='artist'>{t[2]}</span>"
        out += "</a>"
    out += f"<a class='back' href='javascript:show_all_artists()'><< back to artists</a>"
    return out
    return f"{player.player.library.get_artist(i)}"
    return "".join([f"<a class='listlink t{i%2}' href='javascript:show_artist({i})'>{a}</div>"
                    for i, a in enumerate(player.player.library.get_artist(i))])


class Root:
    def __init__(self):
        self.head = "<html>\n"
        self.head += "<head>\n"
        self.head += "<title>MediaPi</title>\n"
        self.head += "<link rel='shortcut icon' href='/static/favicon.ico' type='image/x-icon'>\n"
        self.head += "<link rel='stylesheet' href='/static/sty.css' type='text/css'>\n"
        self.head += "</head>\n"
        self.head += "<body>\n"
        self.head += f"<div id='version'><a href='https://github.com/mscroggs/mediapi'>MediaPi v{config.version}</a></div>"
        self.head += "<div id='topbuttons'>\n"

        self.mid = "</div>\n"
        self.mid += "<div id='button-container'>\n"
        self.mid += "<div id='progress-bar' style='width:0'>\n"
        self.mid += "</div>\n"
        self.mid += "<div id='song-info'>\n"
        self.mid += "</div>\n"
        self.mid += "<span id='buttons'>\n"

        self.mid2 = "</span>\n"
        self.mid2 += "</div>\n"
        self.mid2 += "<div id='list-area'>\n"
        self.foot = "</div>\n"
        self.foot += "<script type='text/javascript'>\n"
        with open("static/loaders.js") as f:
            self.foot2 = f.read()
        self.foot2 += "</script>\n"
        self.foot2 += "</body>\n"
        self.foot2 += "</html>"

    def GET(self):
        out = self.head
        out += make_buttons()
        out += self.mid
        out += make_more_buttons()
        out += self.mid2
        out += get_artist_list()
        out += self.foot
        if player.is_playing():
            out += f"var current_player = '{player.player_type()}-play'\n"
        else:
            out += f"var current_player = '{player.player_type()}-pause'\n"
        out += f"var current_view = '{player.player_type()}'\n\n"
        out += self.foot2
        return out


class SendCommand:
    def POST(self):
        command = json.loads(web.data().decode("utf-8"))["command"]
        player.parse_instruction(command)
        return ""


class GetButtons:
    def GET(self):
        data = {"player": player.player_type(),
                "buttons": make_buttons(),
                "more_buttons": make_more_buttons()}
        if player.is_playing():
            data["playing"] = "play"
        else:
            data["playing"] = "pause"
        return json.dumps(data)


class GetSongData:
    def GET(self):
        data = player.get_info()
        data["fraction"] = player.fraction()
        return json.dumps(data)


class GetArtistList:
    def GET(self):
        return get_artist_list()


class GetArtist:
    def POST(self):
        return get_artist(int(web.data()))


class AddToQueue:
    def POST(self):
        assert player.player_type() == "mp3"
        for i in json.loads(web.data().decode("utf-8")):
            player.player.add_to_medialist(player.player.library.get_filename(i))
        return ""


if __name__ == "__main__":
    app.run()
