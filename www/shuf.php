<?php

if(isset($_GET['s'])){
if($_GET['s']==1){
$ff=fopen('/home/pi/player/s','w');
fwrite($ff,'on');
fclose($ff);
}

if($_GET['s']==0){
$ff=fopen('/home/pi/player/s','w');
fwrite($ff,'off');
fclose($ff);
}
}

?>
