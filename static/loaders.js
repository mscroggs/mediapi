var current_player = "none"

function load_buttons() {
    var buttonloader;
    if(window.XMLHttpRequest){buttonloader=new XMLHttpRequest();}
    else {buttonloader=new ActiveXObject('Microsoft.XMLHTTP');}
    buttonloader.open("GET", "/get_buttons");
    buttonloader.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        data = JSON.parse(this.responseText)
        if(data["player"] != current_player) {
          current_player = data["player"]
          document.getElementById("topbuttons").innerHTML = data["buttons"];
          document.getElementById("buttons").innerHTML = data["more_buttons"];
        }
      }
    };
    buttonloader.send(current_player);
}

setInterval(load_buttons, 3000);


function load_song_data() {
    var buttonloader;
    if(window.XMLHttpRequest){buttonloader=new XMLHttpRequest();}
    else {buttonloader=new ActiveXObject('Microsoft.XMLHTTP');}
    buttonloader.open("GET", "/get_song_data");
    buttonloader.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        data = JSON.parse(this.responseText)
        document.getElementById("progress-bar").setAttribute("style", "width:" + (100*data["fraction"]) + "vw");
        document.getElementById("song-info").innerHTML = data["title"] + "<br />" + data["artist"] + "<br />from <em>" + data["album"] + "</em>"
      }
    };
    buttonloader.send();
}

setInterval(load_song_data, 500);
