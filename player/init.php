<?php

$a=file_get_contents("/home/pi/player/a");
if($a=='on'){
$b=file_get_contents("/home/pi/player/b");
if($b!='on'){
$ff=fopen("/home/pi/player/b","w");
fwrite($ff,'on');
fclose($ff);
exec("python /home/pi/player/killradio.py &");
exec("python /home/pi/player/play.py &");
}
}

$r=file_get_contents("/home/pi/player/r");
if($r=='on'){
$r2=file_get_contents("/home/pi/player/r2");
if($r2!='on'){
$ff=fopen("/home/pi/player/r2","w");
fwrite($ff,'on');
fclose($ff);
exec("python /home/pi/player/killradio.py &");
exec("python /home/pi/player/radio.py &");

}
}


?>
