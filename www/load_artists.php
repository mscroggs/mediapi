<?php

$mode="artist";
if(isset($_GET['view']) && $_GET['view']=="playlists"){$mode="playlists";}
if(isset($_GET['p'])){$mode="playlists";}
if(isset($_GET['view']) && $_GET['view']=="options"){$mode="options";}

if($mode!="artist"){echo("<div class='tab'><a href='javascript:start_music_browser()'>");}
else{echo("<div class='tab active'>");}
echo("Artists");
if($mode!="artist"){echo("</a>");}
echo("</div>");

if($mode!="playlists"){echo("<div class='tab'><a href='javascript:show_playlists()'>");}
else{echo("<div class='tab active'>");}
echo("Playlists");
if($mode!="playlists"){echo("</a>");}
echo("</div>");

if($mode!="options"){echo("<div class='tab'><a href='javascript:show_options()'>");}
else{echo("<div class='tab active'>");}
echo("Options");
if($mode!="options"){echo("</a>");}
echo("</div>");

?>

<table>

<?php

if((isset($_GET['view']) && $_GET['view']=="playlists")|| isset($_GET['p'])){
    if(isset($_GET['p'])){
        $string = file_get_contents("../player/db/filters/".$_GET['p'].".json");
        $artists = json_decode($string, true);
        $n=0;
        foreach($artists as $i=>$a){
            echo("<tr class='tr".($n%2)."'>");
            echo("<td>".$a[0]."</td>");
            echo("<td><a href='javascript:queue_up_song(".$i.")'>".$a[1]."</a></td>");
            echo("<td>".$a[2]."</td>");
            echo("<td><a href='javascript:queue_up_album(\"".$a[6]."\")'>".$a[3]."</a></td>");
            echo("</tr>");
            $n+=1;
        }

    } else {
        $string = file_get_contents("../player/filters.json");
        $filters = json_decode($string, true);
        foreach($filters as $i=>$a){
            echo("<tr class='tr".($i%2)."'><td><a href='javascript:show_playlist(".$i.")'>".$a[0]."</a></td></tr>");
        }
    }
} else if((isset($_GET['view']) && $_GET['view']=="options")|| isset($_GET['p'])){
    $info = Array();
    while(!isset($info["play"])){
        $string = file_get_contents("../player/info.json");
        $info = json_decode($string, true);
    }
    echo("<tr class='tr0'><td>Shuffle: ");
    if($info["shuffle"]){echo(" <a style='color:blue' href='javascript:send_changes_reload(\"shuffle=OFF\")'>ON</a>");}
    else{echo(" <a style='color:red' href='javascript:send_changes_reload(\"shuffle=ON\")'>OFF</a>");}
    echo("</td></tr>");
    echo("<tr class='tr1'><td><form onsubmit='return update_playlist()'>Playlist: <select id='set-filter'>");
    $string = file_get_contents("../player/filters.json");
    $filters = json_decode($string, true);
    foreach($filters as $i=>$f){
        echo("<option value='".$i."'");
        if($info["filter"]==$i){echo(" selected");}
        echo(">".$f[0]."</option>");
    }
    echo("</select> Probability: ");
    echo("<input id='set-prob' size=3 value='".$info["prob"]."'>");
    echo("<input type='submit' value='Update'>");
    echo("</td></tr>");
} else {
    if(isset($_GET['i'])){
        $string = file_get_contents("../player/db/by_artist/".$_GET['i'].".json");
        $artists = json_decode($string, true);
        $n=0;
        foreach($artists as $i=>$a){
            echo("<tr class='tr".($n%2)."'>");
            echo("<td>".$a[0]."</td>");
            echo("<td><a href='javascript:queue_up_song(".$i.")'>".$a[1]."</a></td>");
            echo("<td>".$a[2]."</td>");
            echo("<td><a href='javascript:queue_up_album(\"".$a[6]."\")'>".$a[3]."</a></td>");
            echo("</tr>");
            $n+=1;
        }

    } else {
        $string = file_get_contents("../player/db/artists.json");
        $artists = json_decode($string, true);
        foreach($artists as $i=>$a){
            echo("<tr class='tr".($i%2)."'><td><a href='javascript:show_artist(".$i.")'>".$a."</a></td></tr>");
        }
    }
}
?>

</table>