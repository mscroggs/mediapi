<?php
$fp = fopen("../player/queue.json","w");
fwrite($fp, json_encode(Array()));
fclose($fp);
?>
