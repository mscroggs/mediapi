<table>

<?php

if(isset($_GET['i'])){
    $string = file_get_contents("../player/db/by_artist/".$_GET['i'].".json");
    $artists = json_decode($string, true);
    $n=0;
    foreach($artists as $i=>$a){
        echo("<tr class='tr".($n%2)."'>");
        echo("<td>".$a[0]."</td>");
        echo("<td><a href='javascript:queue_up_song(".$i.")'>".$a[1]."</a></td>");
        echo("<td>".$a[2]."</td>");
        echo("<td><a href='javascript:queue_up_album(".$i.")'>".$a[3]."</a></td>");
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
?>

</table>
