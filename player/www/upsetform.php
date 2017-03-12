<?php

$prob=file_get_contents('/home/pi/player/prob');
$filt=file_get_contents('/home/pi/player/filt');
$d=true;
echo("

<a href='javascript:hideSetty()' style='color:#0000FF;text-decoration:none;font-size:10px'>&#x25B3; Shuffle Settings &#x25B3;</a>
<br />
<form onsubmit='return upSet(this)'>
Play <select name='genr' onchange='othertest(this)'>
<option value='xmas'");
if($filt=='xmas'){echo(" selected");$d=false;}
echo(">Christmas</option>
<option value='jazz'");
if($filt=='jazz'){echo(" selected");$d=false;}
echo(">Jazz</option>
<option value='elephant6'");
if($filt=='elephant6'){echo(" selected");$d=false;}
echo(">Elephant 6</option>
<option value='irish'");
if($filt=='irish'){echo(" selected");$d=false;}
echo(">Irish Folk</option>
<option value='balkan'");
if($filt=='balkan'){echo(" selected");$d=false;}
echo(">Balkan Folk</option>
<option value='psc'");
if($filt=='psc'){echo(" selected");$d=false;}
echo(">Purple Stereo</option>
<option value='seenlive'");
if($filt=='seenlive'){echo(" selected");$d=false;}
echo(">I've Seen Live</option>
<option value='hiphop'");
if($filt=='hiphop'){echo(" selected");$d=false;}
echo(">Hip Hop</option>
<option value='work'");
if($filt=='work'){echo(" selected");$d=false;}
echo(">Working Music</option>
<option value='twis'");
if($filt=='twis'){echo(" selected");$d=false;}
echo(">Twilight Struggle</option>

<option value='other'");
if($d){echo(" selected");}
echo(">Other:</option>
</select>
<input name='other' id='oththing' style='display:");
if($d){echo("block' value='".$filt."'");} else {echo("none'");}
echo(" size='15'>
with probability <input name='prob' size=2 value='".$prob."'>
<input type='submit' value='Update'>
</form>

");

?>
