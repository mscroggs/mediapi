#!/usr/bin/env python
import web
import os
import json
import config
from web.template import ALLOWED_AST_NODES
from player import MediaPi

ALLOWED_AST_NODES.append('Constant')

urls = (
    '/', 'Root',
    '/send_command', 'SendCommand',
    '/get_buttons', 'GetButtons')
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


def svg_button(filename, command, id):
    with open(os.path.join("static", filename)) as f:
        return f"<button id='{id}' onclick=\"return send_command('{command}')\">{f.read()}</button>"


class Root:
    def __init__(self):
        self.head = "<html>\n"
        self.head += "<head>\n"
        self.head += "<title>MediaPi</title>\n"
        self.head += "<link rel='shortcut icon' href='/static/favicon.ico' type='image/x-icon'>\n"
        self.head += "<link rel='stylesheet' href='/static/sty.css' type='text/css'>\n"
        self.head += "<script type='text/javascript' src='/static/player.js'></script>\n"
        self.head += "</head>\n"
        self.head += "<body>\n"
        self.head += "<div id='topbuttons'>\n"

        self.foot = "</div>\n"
        self.foot += "<script type='text/javascript'>\n"
        with open("static/loaders.js") as f:
            self.foot += f.read()
        self.foot += "</script>\n"
        self.foot += "</body>\n"
        self.foot += "</html>"

    def GET(self):
        return self.head + make_buttons() + self.foot


class SendCommand:
    def POST(self):
        command = json.loads(web.data().decode("utf-8"))["command"]
        player.parse_instruction(command)
        return ""


class GetButtons:
    def GET(self):
        data = {"player": player.player_type(),
                "html": make_buttons()}
        return json.dumps(data)


if __name__ == "__main__":
    player.start_tick_thread()
    app.run()
