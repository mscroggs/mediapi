<?php

if(isset($_GET['p'])){
if($_GET['p']==1){
$ff=fopen('/home/pi/player/p','w');
fwrite($ff,'on');
fclose($ff);
}

if($_GET['p']==0){
$ff=fopen('/home/pi/player/p','w');
fwrite($ff,'off');
fclose($ff);
}
}

?>
