function send_command(c){
    var sender;
    if(window.XMLHttpRequest){sender=new XMLHttpRequest();}
    else {sender=new ActiveXObject('Microsoft.XMLHTTP');}
    sender.open("POST", "/send_command", true);
    sender.setRequestHeader("Content-Type", "application/json");
    sender.onreadystatechange = function() {
        load_buttons();
    }
    sender.send(JSON.stringify({command:c}));
    return false;
}

function load_buttons() {
    var buttonloader;
    if(window.XMLHttpRequest){buttonloader=new XMLHttpRequest();}
    else {buttonloader=new ActiveXObject('Microsoft.XMLHTTP');}
    buttonloader.open("GET", "/get_buttons");
    buttonloader.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        data = JSON.parse(this.responseText)
        if(data["player"] != current_player) {
          current_player = data["player"] + "-" + data["playing"]
          document.getElementById("topbuttons").innerHTML = data["buttons"];
          document.getElementById("buttons").innerHTML = data["more_buttons"];

          if(current_view != data["player"]) {
            current_view = data["player"]
            if(current_view == "mp3"){
              show_all_artists()
            } else {
              clear_listarea()
            }
          }
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
        if(data["fraction"] > 0){
          document.getElementById("song-info").innerHTML = data["title"] + "<br />" + data["artist"] + "<br />from <em>" + data["album"] + "</em>"
        } else {
          document.getElementById("song-info").innerHTML = ""
        }
      }
    };
    buttonloader.send();
}

setInterval(load_song_data, 500);

function show_all_artists(i) {
    var artistloader;
    if(window.XMLHttpRequest){artistloader=new XMLHttpRequest();}
    else {artistloader=new ActiveXObject('Microsoft.XMLHTTP');}
    artistloader.open("GET", "/get_artist_list");
    artistloader.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("list-area").innerHTML = this.responseText;
        if(n>=10){location.hash = "artist" + (n-10)}
      }
    };
    artistloader.send();
}

function show_artist(i) {
    var artistloader;
    if(window.XMLHttpRequest){artistloader=new XMLHttpRequest();}
    else {artistloader=new ActiveXObject('Microsoft.XMLHTTP');}
    artistloader.open("POST", "/get_artist");
    artistloader.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("list-area").innerHTML = this.responseText;
        location.hash = "top"
      }
    };
    artistloader.send(i);
}

function clear_listarea() {
    document.getElementById("list-area").innerHTML = "";
}

function add_to_queue(ls) {
    var sender;
    if(window.XMLHttpRequest){sender=new XMLHttpRequest();}
    else {sender=new ActiveXObject('Microsoft.XMLHTTP');}
    sender.open("POST", "/add_to_queue", true);
    sender.setRequestHeader("Content-Type", "application/json");
    sender.send(JSON.stringify(ls));
}
