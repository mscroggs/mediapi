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
    $lsp = explode(",",$_GET['list']);
    foreach($lsp as $s){
        $queue[] = $s/1;
    }
}

$fp = fopen("../player/queue.json","w");
fwrite($fp, json_encode($queue));
fclose($fp);

?>
