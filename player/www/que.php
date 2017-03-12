<?php

if(isset($_GET['q'])){
$x=file_get_contents("/home/pi/player/queue");
$ff=fopen('/home/pi/player/queue','a');
if($x!=""){fwrite($ff,"
");}
fwrite($ff,$_GET['q']);
fclose($ff);
}

?>
