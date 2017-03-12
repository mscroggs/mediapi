<?php

$stat=file_get_contents('/home/pi/player/b');
$aim=file_get_contents('/home/pi/player/a');
$statr=file_get_contents('/home/pi/player/r2');
$aimr=file_get_contents('/home/pi/player/r');

$f=file("/home/pi/player/db");
for($i=0;$i<count($f);$i++){
$f[$i]=str_replace(" ","&nbsp;",$f[$i]);
$f[$i]=explode("#|#",$f[$i]);
}

$fr=file("/home/pi/.pyradio");
for($i=0;$i<count($fr);$i++){
$fr[$i]=str_replace(" ","&nbsp;",$fr[$i]);
$fr[$i]=explode(",&nbsp;",$fr[$i]);
}



echo("
<table width='100%'>");
echo("<tr");
if($stat=='on' || $aim=='on' || $statr=='on' || $aimr=='on'){echo(" class='r".rand(0,6)."'");}
echo(">
<td width=200><h3 style='margin:0'>");

if($stat=='on'){
$i=file_get_contents('/home/pi/player/cu');
$p=file_get_contents('/home/pi/player/p');
if($p=="off"){echo("
Now&nbsp;Playing");}
else{echo("-&nbsp;Paused&nbsp;-");}
echo("</h3></td><td>".$f[$i][1]."</td><td>".$f[$i][2]."</td><td>".$f[$i][3]."</td><td>".str_replace("
","",$f[$i][4])."</td>");
} else if($statr=='on'){
$i=file_get_contents('/home/pi/player/rad');
echo("
Now&nbsp;Playing</h3></td><td>".$fr[$i-1][0]."</td>");
} else if($aim=='off' && $aimr=='off'){
echo("Not&nbsp;Playing</h3></td>");
} else {
echo("Initialising");
}
echo("
<td width='200'></td>
</tr>
</table>");

?>
