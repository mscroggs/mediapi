<html>
<head>
<title>MediaPi</title>
<link rel='stylesheet' type='text/css' href='sty.css'>
<script type='text/javascript'>
loading = 0;
browser_showing="off"
gap = " &nbsp; &nbsp; "

function send_changes(ch){
    var changer;
    if(window.XMLHttpRequest){changer=new XMLHttpRequest();}
    else {changer=new ActiveXObject('Microsoft.XMLHTTP');}
    changer.onreadystatechange=function(){
        if (changer.readyState==4 && changer.status==200){
            loading--;
        }
    }
    changer.open('GET','ajax.php?'+ch,true);
    changer.send();
    loading++;
}

function load_info(){
    var loader;
    if(loading==0){
        if(window.XMLHttpRequest){loader=new XMLHttpRequest();}
        else {loader=new ActiveXObject('Microsoft.XMLHTTP');}
        loader.onreadystatechange=function(){
            if (loader.readyState==4 && loader.status==200){
                loading--;
                info = JSON.parse(loader.responseText)
                out = ""
                if(info["play"]=="music"){
                    out += "Now playing:"
                    out += gap
                    out += info["more"][0]
                    out += gap
                    out += "<b>" + info["more"][1] + "</b>"
                    out += gap
                    out += "by"
                    out += gap
                    out += "<b>" + info["more"][2] + "</b>"
                    out += gap
                    out += "from the album"
                    out += gap
                    out += "<b>" + info["more"][3] + "</b>"
                    document.getElementById("time-background").style.width = 100*info["pos"]+"%"
                } else {
                    document.getElementById("time-background").style.width = 0
                }
                if(info["play"]=="radio"){
                    out += "Now playing:"
                    out += gap
                    out += "<b>" + info["more"][0] + "</b>"
                }
                document.getElementById("playing-info").innerHTML = out
                onoff = "Music: "
                if(info["play"] == "music"){
                    onoff += "<a style='color:blue' href='javascript:turn_off()'>ON</a>"
                } else {
                    onoff += "<a style='color:red' href='javascript:turn_music_on()'>OFF</a>"
                }
                onoff += gap
                onoff += "Radio: "
                if(info["play"] == "radio"){
                    onoff += "<a style='color:blue' href='javascript:turn_off()'>ON</a>"
                } else {
                    onoff += "<a style='color:red' href='javascript:turn_radio_on()'>OFF</a>"
                }
                document.getElementById("onoff").innerHTML=onoff
                pause = ""
                if(info["play"]!="off"){
                    if(info["pause"]){
                        pause="<a class='pause' href=\"javascript:send_changes('pause=OFF')\"><img src='paused.png'></a>";
                    } else {
                        pause="<a class='pause' href=\"javascript:send_changes('pause=ON')\"><img src='playing.png'></a>";
                    }
                }
                document.getElementById("pause").innerHTML=pause;
                if(info["play"]=="music"){
                    document.getElementById("skip").style.display="inline";
                } else {
                    document.getElementById("skip").style.display="none";
                }
                if(info["play"]=="music" && browser_showing!="music"){
                    start_music_browser()
                }
                if(info["play"]=="radio" && browser_showing!="radio"){
                    start_radio_browser()
                }
            }
        }
        loader.open('GET','load_info.php',true);
        loader.send();
        loading++;
    }
}

function turn_off(){
    document.getElementById("browser").innerHTML=""
    send_changes("play=off")
    browser_showing="off"
}
function turn_music_on(){
    send_changes("play=music")
    start_music_browser()
}
function turn_radio_on(){
    send_changes("play=radio")
    start_radio_browser()
}

function start_music_browser(){
    browser_showing="music"
    var loader;
    if(window.XMLHttpRequest){loader=new XMLHttpRequest();}
    else {loader=new ActiveXObject('Microsoft.XMLHTTP');}
    loader.onreadystatechange=function(){
        if (loader.readyState==4 && loader.status==200){
            loading--;
            document.getElementById("browser").innerHTML=loader.responseText
        }
    }
    loader.open('GET','load_artists.php',true);
    loader.send();
    loading++;
}
function show_artist(i){
    browser_showing="music"
    var loader;
    if(window.XMLHttpRequest){loader=new XMLHttpRequest();}
    else {loader=new ActiveXObject('Microsoft.XMLHTTP');}
    loader.onreadystatechange=function(){
        if (loader.readyState==4 && loader.status==200){
            loading--;
            document.getElementById("browser").innerHTML=loader.responseText
        }
    }
    loader.open('GET','load_artists.php?i='+i,true);
    loader.send();
    loading++;
}
function start_radio_browser(){
    browser_showing="radio"
    /* NOT IMPLEMENTED */
}
function queue_up_song(i){
    var queuer;
    if(window.XMLHttpRequest){queuer=new XMLHttpRequest();}
    else {queuer=new ActiveXObject('Microsoft.XMLHTTP');}
    queuer.onreadystatechange=function(){
        if (queuer.readyState==4 && queuer.status==200){
            loading--;
        }
    }
    queuer.open('GET','add_to_queue.php?song='+i,true);
    queuer.send();
    loading++;
}
function queue_up_album(i){
    /* NOT IMPLEMENTED */
}

window.setInterval(load_info,1000)
</script>
</head>
<body>
<div id='time-background'></div>
<div id='playing-info'></div>
<div id='onoff'></div>
<div class='cent'>
<span id='pause'></span><span id='skip'><a href="javascript:send_changes('skip=ON')"><img src='skip.png'></a></span>
</div>
<div id='browser'></div>
</body>
</html>

<?php

?>
