import tools
import json

class MusicLibrary:
    def __init__(self):
        self.length = tools.length()

    def get_filtered_list(self):
        with open(tools.db_json("filters",tools.filt())) as f:
            return json.load(f)

    def get_item(self,i):
        with open(tools.db_json("full",i)) as f:
            return json.load(f)

    def get_track_number(self,i):
        return self.get_item(i)[0]

    def get_title(self,i):
        return self.get_item(i)[1]

    def get_artist(self,i):
        return self.get_item(i)[2]

    def get_album(self,i):
        return self.get_item(i)[3]

    def get_filename(self,i):
        return self.get_item(i)[4]

    def get_length(self,i):
        return self.get_item(i)[5]

class RadioLibrary:
    def get_item(self,i):
        return tools.get_radio_list()[i]

    def get_name(self,i):
        return self.get_item(i)[0]

    def get_url(self,i):
        return self.get_item(i)[1]
