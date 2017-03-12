<?php

function firstbit($str){
if(strlen($str)<=17){return $str;} else {
$ret="";
for($i=0;$i<min(14,strlen($str));$i++){
$ret.=$str[$i];
}
$ret.="...";
return $ret;
}
}

$stat=file_get_contents('/home/pi/player/b');
$x=file_get_contents('/home/pi/player/queue');
$x=explode("
",$x);

$f=file("/home/pi/player/db");
for($i=0;$i<count($f);$i++){
$f[$i]=explode("#|#",$f[$i]);
}

if($stat=='on'){
$y=file_get_contents('/home/pi/player/ne');
$y=Array($y);
if($x[0]!=""){
$y=array_merge($y,$x);
}
} else {$y=$x;}
if($y[0]!=""){
for($j=0;$j<count($y);$j++){
$i=$y[$j];
echo("<tr class='r".($j%7)."'><td>".firstbit($f[$i][2])."</td></tr>");
}
}


?>
