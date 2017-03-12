<?php

$q=$_GET['q'];
//$q="Rain Dogs";

$db=file('/home/pi/player/db');
$ff=fopen('/home/pi/player/queue','a');
$x=file_get_contents("/home/pi/player/queue");
$X=false;
if($x!=""){$X=true;}

for($i=0;$i<count($db);$i++){
$db[$i]=explode('#|#',$db[$i]);
$db[$i][4]=str_replace('
','',$db[$i][4]);
if($q==$db[$i][4]){
if($X){fwrite($ff,"
");}
$X=true;
fwrite($ff,$i);
}}
fclose($ff);
?>
