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
          document.getElementById("topbuttons").innerHTML = data["html"];
        }
      }
    };
    buttonloader.send(current_player);
}

var current_player = "none"
setInterval(load_buttons, 3000);
