<?php
$queue = NULL;
while(is_null($queue)){
    $string = file_get_contents("../player/queue.json");
    $queue = json_decode($string, true);
}

// song
if(isset($_GET['song'])){
    $queue[] = $_GET['song']/1;
}
// list
if(isset($_GET['list'])){
    /* NOT IMPLEMENTED */
}

$fp = fopen("../player/queue.json","w");
fwrite($fp, json_encode($queue));
fclose($fp);

print_r($queue);

?>
