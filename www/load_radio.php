<table>

<?php

$string = file_get_contents("../player/radio.json");
$radio = json_decode($string, true);
foreach($radio as $i=>$a){
    echo("<tr class='tr".($i%2)."'><td><a href='javascript:send_changes(\"radioc=".$i."\")'>".$a[0]."</a></td></tr>");
}
?>

</table>
