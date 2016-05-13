<?php

if(isset($_GET['q'])){//if(is_int($_GET['q'])){
$ff=fopen('/home/pi/player/rad','w');
fwrite($ff,$_GET['q']);
fclose($ff);
}//}

?>
