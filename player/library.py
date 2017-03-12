import config
import json
import options

class Library:
    def __init__(self):
        self.length = options.length()

    def get_filtered_list(self):
        with open(config.db_json("filters",options.filt())) as f:
            return json.load(f)

    def get_item(self,i):
        with open(config.db_json("full",i)) as f:
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
