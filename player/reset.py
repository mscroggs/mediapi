import config
import os
response = None

while response not in ["Y", "N"]:
    response = input("Are you sure you want to reset mediapi? Enter Y/N ").upper()

if response == "N":
    raise KeyboardInterrupt

if not os.path.isdir(config.data_dir):
    os.makedirs(config.data_dir)

with open("commands", "w") as f:
    pass
with open("status.json", "w") as f:
    f.write("{}")

os.system(f"chmod 777 {config.data_dir} {config.data_dir}/*")
