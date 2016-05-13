<?php

if(isset($_GET['p'])){
$ff=fopen('/home/pi/player/prob','w');
fwrite($ff,$_GET['p']);
fclose($ff);
}

if(isset($_GET['filt'])){
$ff=fopen('/home/pi/player/filt','w');
fwrite($ff,$_GET['filt']);
fclose($ff);
}

?>

