<?php
$options = Array();
while(!isset($options["play"])){
    $string = file_get_contents("../player/options.json");
    $options = json_decode($string, true);
}

// play
if(isset($_GET['play'])){
    $options["play"] = $_GET['play'];
}
// pause
if(isset($_GET['pause'])){
    if($_GET['pause']=='ON'){
        $options["pause"] = true;
    } else {
        $options["pause"] = false;
    }
}
// shuffle
if(isset($_GET['shuffle'])){
    if($_GET['shuffle']=='ON'){
        $options["shuffle"] = true;
    } else {
        $options["shuffle"] = false;
    }
}
// skip
if(isset($_GET['skip'])){
    if($_GET['skip']=='ON'){
        $options["skip"] = true;
    } else {
        $options["skip"] = false;
    }
}
// filter
if(isset($_GET['filter'])){
    $options["filter"] = $_GET['filter']/1;
}
// prob
if(isset($_GET['prob'])){
    $options["prob"] = $_GET['prob']/1;
}
// radioc
if(isset($_GET['radioc'])){
    $options["radioc"] = $_GET['radioc']/1;
}

$fp = fopen("../player/options.json","w");
fwrite($fp, json_encode($options));
fclose($fp);

?>
