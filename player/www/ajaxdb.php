<?php

if(isset($_GET['s'])){$s=$_GET['s'];}
else{$s="";}

$a=file_get_contents('/home/pi/player/a');
if($a=='on'){


$f=file("/home/pi/player/db");
echo("<table width=100%>");
for($i=0;$i<count($f);$i++){
if(preg_match('/'.$s.'/i',$f[$i])){
//$f[$i]=str_replace(" ","&nbsp;",$f[$i]);
$f[$i]=explode("#|#",$f[$i]);
$f[$i][2]=str_replace("&nbsp;"," ",$f[$i][2]);
$album_name=$f[$i][4];
if(strlen($f[$i][2])>30){$f[$i][2]=substr($f[$i][2],0,27)."...";}
if(strlen($f[$i][3])>30){$f[$i][3]=substr($f[$i][3],0,27)."...";}
if(strlen($f[$i][4])>30){$f[$i][4]=substr($f[$i][4],0,27)."...";}
$f[$i][2]=str_replace(" ","&nbsp;",$f[$i][2]);
$f[$i][3]=str_replace(" ","&nbsp;",$f[$i][3]);
$f[$i][4]=str_replace(" ","&nbsp;",$f[$i][4]);
echo("<tr class='r".($i%7)."'><td>".$f[$i][1]."</td><td><a href='javascript:addQ(".$i.")'>".$f[$i][2]."</a></td><td>".$f[$i][3]."</td><td><a href=\"javascript:addQA('".str_replace("'","\'",$album_name)."')\">".str_replace("
","",$f[$i][4])."</a></td></tr>");
}}
echo("</table>");
}

$r=file_get_contents('/home/pi/player/r');
if($r=='on'){


$f=file("/home/pi/.pyradio");
echo("<table width=100%>");
for($i=0;$i<count($f);$i++){
$f[$i]=str_replace(" ","&nbsp;",$f[$i]);
$f[$i]=explode(",&nbsp;",$f[$i]);
echo("<tr class='r".($i%7)."'><td><a href='javascript:chRad(".($i+1).")'>".$f[$i][0]."</a></td></tr>");
}
echo("</table>");
}
?>
