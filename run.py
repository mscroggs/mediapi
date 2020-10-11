#!/usr/bin/env python
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
    '/get_song_data', 'GetSongData')
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


class Root:
    def __init__(self):
        self.head = "<html>\n"
        self.head += "<head>\n"
        self.head += "<title>MediaPi</title>\n"
        self.head += "<link rel='shortcut icon' href='/static/favicon.ico' type='image/x-icon'>\n"
        self.head += "<link rel='stylesheet' href='/static/sty.css' type='text/css'>\n"
        self.head += "</head>\n"
        self.head += "<body>\n"
        self.head += "<div id='topbuttons'>\n"

        self.mid = "</div>\n"
        self.mid += "<div id='button-container'>\n"
        self.mid += "<div id='progress-bar' style='width:0'>\n"
        self.mid += "</div>\n"
        self.mid += "<div id='song-info'>\n"
        self.mid += "</div>\n"
        self.mid += "<span id='buttons'>\n"

        self.foot = "</span>\n"
        self.foot += "</div>\n"
        self.foot += "<script type='text/javascript'>\n"
        with open("static/loaders.js") as f:
            self.foot += f.read()
        self.foot += "</script>\n"
        self.foot += "</body>\n"
        self.foot += "</html>"

    def GET(self):
        return self.head + make_buttons() + self.mid + make_more_buttons() + self.foot


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


if __name__ == "__main__":
    app.run()
