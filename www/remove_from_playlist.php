<?php

if(isset($_GET['edit'])){

$playlist = json_decode(file_get_contents("../player/db/filters/".$_GET['edit'].".json"), true);

$n = $_GET['n'];

$song = json_decode(file_get_contents("../player/db/full/".$n.".json"),true);
echo("<i>".$song[1]."</i> by ".$song[2]);

unset($playlist[$n]);

$fp = fopen("../player/db/filters/".$_GET['edit'].".json","w");
fwrite($fp, json_encode($playlist));
fclose($fp);

}

?>
