<?php
$queue = NULL;
while(is_null($queue)){
    $string = file_get_contents("../player/queue.json");
    $queue = json_decode($string, true);
}

// song
if(isset($_GET['song'])){
    $queue[] = $_GET['song']/1;
    $song = json_decode(file_get_contents("../player/db/full/".$_GET['song'].".json"),true);
    echo("<i>".$song[1]."</i> by ".$song[2]);
}
// list
if(isset($_GET['list'])){
    $lsp = explode(",",$_GET['list']);
    foreach($lsp as $s){
        $queue[] = $s/1;
    }
    $song = json_decode(file_get_contents("../player/db/full/".$lsp[0].".json"),true);
    echo("<b><i>".$song[3]."</i></b> by ".$song[2]);
}

$fp = fopen("../player/queue.json","w");
fwrite($fp, json_encode($queue));
fclose($fp);


?>
