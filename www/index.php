<html>
<head>
<title>MediaPi</title>
<link rel='stylesheet' type='text/css' href='sty.css'>
<script type='text/javascript'>
first=true;
loading = 0;
browser_showing="off"
gap = " &nbsp; &nbsp; "

timer = ""
notificationFader = ""
editAmp = ""
editQ = ""

showOptionsChange = false
showQueueClear = false

function stop_edit_playlist(n) {
    editAmp = ""
    editQ = ""
    show_playlist(n)
}
function edit_playlist(n) {
    editAmp = "&edit="+n
    editQ = "?edit="+n
    show_playlist(n)
}

function add_to_playlist(n){
    var changer;
    if(window.XMLHttpRequest){changer=new XMLHttpRequest();}
    else {changer=new ActiveXObject('Microsoft.XMLHTTP');}
    changer.onreadystatechange=function(){
        if (changer.readyState==4 && changer.status==200){
            loading--;
            notify("Added "+changer.responseText+" to playlist")
            document.getElementById("song"+n+"edit").innerHTML="<a href='javascript:remove_from_playlist("+n+")' style='color:red'>&times;</a>";
        }
    }
    changer.open('GET','add_to_playlist.php?n='+n+editAmp,true);
    changer.send();
    showOptionsChange = false
    showQueueClear = false
    loading++;
}
function remove_from_playlist(n){
    var changer;
    if(window.XMLHttpRequest){changer=new XMLHttpRequest();}
    else {changer=new ActiveXObject('Microsoft.XMLHTTP');}
    changer.onreadystatechange=function(){
        if (changer.readyState==4 && changer.status==200){
            loading--;
            notify("Removed "+changer.responseText+" from playlist")
            document.getElementById("song"+n+"edit").innerHTML="<a href='javascript:add_to_playlist("+n+")' style='color:green'>+</a>";
        }
    }
    changer.open('GET','remove_from_playlist.php?n='+n+editAmp,true);
    changer.send();
    showOptionsChange = false
    showQueueClear = false
    loading++;
}

function fade_out(element) {
    var op = 1;
    timer = setInterval(function () {
        if (op <= 0.05){
            clearInterval(timer);
            element.style.display = 'none';
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        op -= op * 0.1;
    }, 50);
}
function fade_in(element) {
    element.style.display = 'block';
    element.style.opacity = 1;
}


function notify(txt){
    document.getElementById("notification").innerHTML=txt
    if(notificationFader!=""){clearTimeout(notificationFader)}
    if(timer!=""){clearInterval(timer)}
    fade_in(document.getElementById("notification"))
    notificationFader = setTimeout(hide_notification,1500);
}
function hide_notification(txt){
    fade_out(document.getElementById("notification"))
}
function send_changes(ch){
    var changer;
    if(window.XMLHttpRequest){changer=new XMLHttpRequest();}
    else {changer=new ActiveXObject('Microsoft.XMLHTTP');}
    changer.onreadystatechange=function(){
        if (changer.readyState==4 && changer.status==200){
            loading--;
        }
    }
    changer.open('GET','ajax.php?'+ch+editAmp,true);
    changer.send();
    loading++;
}
function clear_queue(){
    var changer;
    if(window.XMLHttpRequest){changer=new XMLHttpRequest();}
    else {changer=new ActiveXObject('Microsoft.XMLHTTP');}
    changer.onreadystatechange=function(){
        if (changer.readyState==4 && changer.status==200){
            loading--;
            notify("Queue cleared")
            setTimeout(ifshow_queue,1500);
        }
    }
    changer.open('GET','clear_queue.php'+editQ,true);
    changer.send();
    showOptionsChange = false
    showQueueClear = true
    loading++;
}
function send_changes_reload(ch){
    var changer;
    if(window.XMLHttpRequest){changer=new XMLHttpRequest();}
    else {changer=new ActiveXObject('Microsoft.XMLHTTP');}
    changer.onreadystatechange=function(){
        if (changer.readyState==4 && changer.status==200){
            loading--;
            setTimeout(ifshow_options,1500);
        }
    }
    changer.open('GET','ajax.php?'+ch+editAmp,true);
    changer.send();
    showOptionsChange = true
    loading++;
}

function update_playlist(){
    setf = document.getElementById("set-filter").value
    setp = document.getElementById("set-prob").value
    send_changes("filter="+setf)
    send_changes_reload("prob="+setp)
    return false;
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
                    if(first){
                        first = false
                        document.getElementById("thevolume").value = info["volume"]
                    }
                }
                document.getElementById("pause").innerHTML=pause;
                if(info["play"]=="music"){
                    document.getElementById("skip").style.display="inline";
                } else {
                    document.getElementById("skip").style.display="none";
                }
                if(info["play"]=="music" && browser_showing!="music"){
                    start_music_browser(-1)
                }
                if(info["play"]=="radio" && browser_showing!="radio"){
                    start_radio_browser()
                }
                if(info["play"]=="off" && browser_showing!="off"){
                    start_off_browser()
                }
            }
        }
        loader.open('GET','load_info.php'+editQ,true);
        loader.send();
        loading++;
    }
}

function turn_off(){
    send_changes("play=off")
}
function turn_music_on(){
    send_changes("play=music")
}
function turn_radio_on(){
    send_changes("play=radio")
}

function start_off_browser(){
    document.getElementById("browser").innerHTML=""
    browser_showing="off"
}

function start_music_browser(n){
    browser_showing="music"
    var loader;
    if(window.XMLHttpRequest){loader=new XMLHttpRequest();}
    else {loader=new ActiveXObject('Microsoft.XMLHTTP');}
    loader.onreadystatechange=function(){
        if (loader.readyState==4 && loader.status==200){
            loading--;
            document.getElementById("browser").innerHTML=loader.responseText
            if(n>=0){location.hash = "#artist" + n}
        }
    }
    loader.open('GET','load_artists.php'+editQ,true);
    loader.send();
    showOptionsChange = false
    showQueueClear = false
    loading++;
}
function show_playlists(){
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
    loader.open('GET','load_artists.php?view=playlists'+editAmp,true);
    loader.send();
    showOptionsChange = false
    showQueueClear = false
    loading++;
}
function show_playlist(p){
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
    loader.open('GET','load_artists.php?p='+p+editAmp,true);
    loader.send();
    showQueueClear = false
    showOptionsChange = false
    loading++;
}
function ifshow_options(){
    if(showOptionsChange){show_options()}
}
function show_options(){
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
    loader.open('GET','load_artists.php?view=options'+editAmp,true);
    loader.send();
    showOptionsChange = false
    showQueueClear = false
    loading++;
}
function ifshow_queue(){
    if(showQueueClear){show_queue();}
}
function show_queue(){
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
    loader.open('GET','load_artists.php?view=queue'+editAmp,true);
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
    loader.open('GET','load_artists.php?i='+i+editAmp,true);
    loader.send();
    showOptionsChange = false
    showQueueClear = false
    loading++;
}

function start_radio_browser(){
    browser_showing="radio"
    var loader;
    if(window.XMLHttpRequest){loader=new XMLHttpRequest();}
    else {loader=new ActiveXObject('Microsoft.XMLHTTP');}
    loader.onreadystatechange=function(){
        if (loader.readyState==4 && loader.status==200){
            loading--;
            document.getElementById("browser").innerHTML=loader.responseText
        }
    }
    loader.open('GET','load_radio.php'+editQ,true);
    loader.send();
    showOptionsChange = false
    showQueueClear = false
    loading++;
}
function queue_up_song(i){
    var queuer;
    if(window.XMLHttpRequest){queuer=new XMLHttpRequest();}
    else {queuer=new ActiveXObject('Microsoft.XMLHTTP');}
    queuer.onreadystatechange=function(){
        if (queuer.readyState==4 && queuer.status==200){
            notify("Added "+queuer.responseText+" to playlist")
            loading--;
        }
    }
    queuer.open('GET','add_to_queue.php?song='+i+editAmp,true);
    queuer.send();
    showOptionsChange = false
    showQueueClear = false
    loading++;
}
function queue_up_album(i){
    var queuer;
    if(window.XMLHttpRequest){queuer=new XMLHttpRequest();}
    else {queuer=new ActiveXObject('Microsoft.XMLHTTP');}
    queuer.onreadystatechange=function(){
        if (queuer.readyState==4 && queuer.status==200){
            loading--;
        }
    }
    queuer.open('GET','add_to_queue.php?list='+i+editAmp,true);
    queuer.send();
    showOptionsChange = false
    showQueueClear = false
    loading++;
}

window.setInterval(load_info,1000)
</script>
</head>
<body>
<div id='white'></div>
<div id='notification'></div>
<div id='time-background'></div>
<div id='playing-info'></div>
<div class='cent'>
<div id='onoff'></div>
<span id='pause'></span><span id='skip'><a href="javascript:send_changes('skip=ON')"><img src='skip.png'></a></span>
<br /><img src='volume.png' height=26><input type='range' id='thevolume' min='0' max='125' onchange='send_changes("volume="+this.value)'>
</div>
<div id='browser'></div>
</body>
</html>
