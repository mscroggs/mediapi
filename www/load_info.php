<?php
$info = Array();
while(!isset($info["play"])){
    $string = file_get_contents("../player/info.json");
    $info = json_decode($string, true);
}

echo $string;

?>
