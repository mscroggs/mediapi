function send_command(c){
    var xhttp;
    if(window.XMLHttpRequest){xhttp=new XMLHttpRequest();}
    else {xhttp=new ActiveXObject('Microsoft.XMLHTTP');}
    xhttp.open("POST", "/send_command", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(JSON.stringify({command:c}));
    return false;
}
