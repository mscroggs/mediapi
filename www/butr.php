<?php

if(isset($_GET['a'])){
if($_GET['a']==1){
$ff=fopen('/home/pi/player/r','w');
fwrite($ff,'on');
fclose($ff);
$ff=fopen('/home/pi/player/a','w');
fwrite($ff,'off');
fclose($ff);
}

if($_GET['a']==0){
$ff=fopen('/home/pi/player/r','w');
fwrite($ff,'off');
fclose($ff);
}
}

?>
