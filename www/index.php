<?php

echo("<html>
<head>
<title>MediaPi</title>
<link rel='stylesheet' type='text/css' href='sty.css'>
<script type='text/javascript'>
loagin=0
function loadPlaying(){

//global loagin
//alert(loagin)
//document.getElementById('loagin').innerHTML=loagin
if(loagin<=0){
var xmlhttp;var xmlhttp2;var xmlhttp3;var xmlhttp4;var xmlhttp4r;var xmlhttp5;
if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();xmlhttp2=new XMLHttpRequest();xmlhttp3=new XMLHttpRequest();xmlhttp4=new XMLHttpRequest();xmlhttp4r=new XMLHttpRequest();xmlhttp5=new XMLHttpRequest();
  } else {// code for IE6, IE5
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');xmlhttp2=new ActiveXObject('Microsoft.XMLHTTP');xmlhttp3=new ActiveXObject('Microsoft.XMLHTTP');xmlhttp4=new ActiveXObject('Microsoft.XMLHTTP');xmlhttp4r=new ActiveXObject('Microsoft.XMLHTTP');xmlhttp5=new ActiveXObject('Microsoft.XMLHTTP');
  }

xmlhttp.onreadystatechange=function(){
  if (xmlhttp.readyState==4 && xmlhttp.status==200){
    document.getElementById('nowpdiv').innerHTML=xmlhttp.responseText;
    loagin--
  }
  }
xmlhttp.open('GET','ajaxque.php',true);
xmlhttp.send();loagin++

xmlhttp2.onreadystatechange=function(){
  if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
    document.getElementById('qtab').innerHTML=xmlhttp2.responseText;
    loagin--
  }
  }
xmlhttp2.open('GET','ajaxque2.php',true);
xmlhttp2.send();loagin++

xmlhttp3.onreadystatechange=function(){
  if (xmlhttp3.readyState==4 && xmlhttp3.status==200){
st=xmlhttp3.responseText
if(st=='off'){
document.getElementById('sh0').style.display='block'
document.getElementById('sh1').style.display='none'
}
if(st=='on'){
document.getElementById('sh0').style.display='none'
document.getElementById('sh1').style.display='block'
}
  loagin--
  }}
xmlhttp3.open('GET','getsh.php',true);
xmlhttp3.send();loagin++

xmlhttp4.onreadystatechange=function(){
  if (xmlhttp4.readyState==4 && xmlhttp4.status==200){
st=xmlhttp4.responseText
if(st=='off'){
document.getElementById('a0').style.display='block'
document.getElementById('a1').style.display='none'
}
if(st=='on'){
document.getElementById('a0').style.display='none'
document.getElementById('a1').style.display='block'
}
  loagin--
  }}
xmlhttp4.open('GET','geta.php',true);
xmlhttp4.send();loagin++

xmlhttp4r.onreadystatechange=function(){
  if (xmlhttp4r.readyState==4 && xmlhttp4r.status==200){
str=xmlhttp4r.responseText
if(str=='off'){
document.getElementById('r0').style.display='block'
document.getElementById('r1').style.display='none'
}
if(str=='on'){
document.getElementById('r0').style.display='none'
document.getElementById('r1').style.display='block'
}
  loagin--
  }}
xmlhttp4r.open('GET','getr.php',true);
xmlhttp4r.send();loagin++

xmlhttp5.onreadystatechange=function(){
  if (xmlhttp5.readyState==4 && xmlhttp5.status==200){
st=xmlhttp5.responseText
if(st=='off'){
document.getElementById('p0').style.display='block'
document.getElementById('p1').style.display='none'
}
if(st=='on'){
document.getElementById('p0').style.display='none'
document.getElementById('p1').style.display='block'
}
  loagin--
  }}
xmlhttp5.open('GET','getp.php',true);
xmlhttp5.send();loagin++
}
}

function addQ(qQ){
var xmlhttp;
if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  } else {// code for IE6, IE5
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }
xmlhttp.onreadystatechange=function(){if(xmlhttp.readyState==4 && xmlhttp.status==200){loagin--}}
xmlhttp.open('GET','que.php?q='+qQ,true);
xmlhttp.send();loagin++

}

function addQA(qQ){
var xmlhttp;
if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  } else {// code for IE6, IE5
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }
xmlhttp.onreadystatechange=function(){if(xmlhttp.readyState==4 && xmlhttp.status==200){loagin--}}
xmlhttp.open('GET','qalb.php?q='+qQ,true);
xmlhttp.send();loagin++
}

function chRad(rR){
var xmlhttp;
if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  } else {// code for IE6, IE5
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }
xmlhttp.onreadystatechange=function(){if(xmlhttp.readyState==4 && xmlhttp.status==200){loagin--}}
xmlhttp.open('GET','chrad.php?q='+rR,true);
xmlhttp.send();loagin++
}

function setSh(st){
var xmlhttp;
if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  } else {// code for IE6, IE5
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }
xmlhttp.onreadystatechange=function(){if(xmlhttp.readyState==4 && xmlhttp.status==200){loagin--}}
xmlhttp.open('GET','shuf.php?s='+st,true);
xmlhttp.send();loagin++
/*if(st==0){
document.getElementById('sh0').style.display='block'
document.getElementById('sh1').style.display='none'
}
if(st==1){
document.getElementById('sh0').style.display='none'
document.getElementById('sh1').style.display='block'
}*/
}

function setA(st){
var xmlhttp;
if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  } else {// code for IE6, IE5
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }
xmlhttp.onreadystatechange=function(){
  if (xmlhttp.readyState==4 && xmlhttp.status==200){
    filt('');
  loagin--
  }
  }
xmlhttp.open('GET','but.php?a='+st,true);
xmlhttp.send();loagin++
/*if(st==0){
document.getElementById('a0').style.display='block'
document.getElementById('a1').style.display='none'
}
if(st==1){
document.getElementById('a0').style.display='none'
document.getElementById('a1').style.display='block'
}*/
}

function setR(st){
var xmlhttp;
if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  } else {// code for IE6, IE5
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }
xmlhttp.onreadystatechange=function(){
  if (xmlhttp.readyState==4 && xmlhttp.status==200){
    filt('');
  loagin--
  }
  }
xmlhttp.open('GET','butr.php?a='+st,true);
xmlhttp.send();loagin++
/*if(st==0){
document.getElementById('a0').style.display='block'
document.getElementById('a1').style.display='none'
}
if(st==1){
document.getElementById('a0').style.display='none'
document.getElementById('a1').style.display='block'
}*/
}

function setP(st){
var xmlhttp;
if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  } else {// code for IE6, IE5
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }
xmlhttp.onreadystatechange=function(){if(xmlhttp.readyState==4 && xmlhttp.status==200){loagin--}}
xmlhttp.open('GET','pau.php?p='+st,true);
xmlhttp.send();loagin++
}

function skiP(){
var xmlhttp;
if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  } else {// code for IE6, IE5
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }
xmlhttp.onreadystatechange=function(){if(xmlhttp.readyState==4 && xmlhttp.status==200){loagin--}}
xmlhttp.open('GET','skip.php',true);
xmlhttp.send();loagin++
}

function filt(txt){
var xmlhttp;
if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  } else {// code for IE6, IE5
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }

xmlhttp.onreadystatechange=function(){
  if (xmlhttp.readyState==4 && xmlhttp.status==200){
    document.getElementById('dbdiv').innerHTML=xmlhttp.responseText;
  loagin--
  }}
xmlhttp.open('GET','ajaxdb.php?s='+txt,true);
xmlhttp.send();loagin++
}
function filt2(txt){
document.getElementById('searchy').value=txt
filt(txt)
}

window.setInterval(loadPlaying,1000)
</script>
</head>
<body>

<div id='nowpdiv' style='position:fixed;margin-top:-26px;margin-left:-200;width:100%;border-bottom:2px solid black;z-index:10;background-color:#FFFFFF;height:25px;'></div>

<div style='position:fixed;margin-top:0px;margin-left:-200px;width:200px;height:100%;background-color:#FFFFFF;border-right:2px solid black;z-index:9'>
");

$a=file_get_contents('/home/pi/player/a');
if($a=='off'){$a1='none';$a0='block';}
else {$a1='block';$a0='none';}

$r=file_get_contents('/home/pi/player/r');
if($r=='off'){$r1='none';$r0='block';}
else {$r1='block';$r0='none';}

echo("
<span id='r0' style='display:".$r0."'>Radio: <a href='javascript:setR(1)' style='color:#FF0000;text-decoration:none'>OFF</a></span>
<span id='r1' style='display:".$r1."'>Radio: <a href='javascript:setR(0)' style='color:#0000FF;text-decoration:none'>ON</a></span>

<span id='a0' style='display:".$a0."'>Music Player: <a href='javascript:setA(1)' style='color:#FF0000;text-decoration:none'>OFF</a></span>
<span id='a1' style='display:".$a1."'>Music Player: <a href='javascript:setA(0)' style='color:#0000FF;text-decoration:none'>ON</a>
<br /><br />
");

$p=file_get_contents('/home/pi/player/p');
if($p=='off'){$p1='none';$p0='block';}
else {$p1='block';$p0='none';}
echo("<span id='p0' style='display:".$p0."'>Pause: <a href='javascript:setP(1)' style='color:#FF0000;text-decoration:none'>OFF</a></span>
<span id='p1' style='display:".$p1."'>Pause: <a href='javascript:setP(0)' style='color:#0000FF;text-decoration:none'>ON</a></span>
<a href='javascript:skiP(0)' style='color:#0000FF;text-decoration:none'>Skip Track</a>
");


$s=file_get_contents('/home/pi/player/s');
if($s=='off'){$sh1='none';$sh0='block';}
else {$sh1='block';$sh0='none';}
echo("<span id='sh0' style='display:".$sh0."'>Shuffle: <a href='javascript:setSh(1)' style='color:#FF0000;text-decoration:none'>OFF</a></span>
<span id='sh1' style='display:".$sh1."'>Shuffle: <a href='javascript:setSh(0)' style='color:#0000FF;text-decoration:none'>ON</a></span>
<span id='setty'>
<a href='javascript:showSetty()' style='color:#0000FF;text-decoration:none;font-size:10px'>&#x25BD; Shuffle Settings &#x25BD;</a>
</span>");/*
<span id='setty000' style='display:none'>
<a href='javascript:hideSetty()' style='color:#0000FF;text-decoration:none;font-size:10px'>&#x25B3; Shuffle Settings &#x25B3;</a>
<br />
<form onsubmit='upSet();return false'>
Play <select name='genr' onchange='othertest(this)'>
<option value='xmas'>Christmas</option>
<option value='jazz'>Jazz</option>
<option value='other'>Other:</option>
</select>
<input name='other' id='oththing' style='display:none' size='15'>
with probability <input name='prob' size=2>
<input type='submit' value='Update'>
</form>
</span>
*/echo("
<form onsubmit='return false'><input size=10 placeholder='Filter' onchange='filt(this.value)' id='searchy'><a href='javascript:filt2(\"\")' style='color:#AA0000;text-decoration:none'>&times;</a></form>

<h3 style='margin-bottom:0;margin-top:5px'>Queue</h3>
<table width='200' id='qtab'></table>
</span>

</div>

<div id='dbdiv'></div>

<script type='text/javascript'>filt('')

function hideSetty(){
document.getElementById(\"setty\").innerHTML=\"<a href='javascript:showSetty()' style='color:#0000FF;text-decoration:none;font-size:10px'>&#x25BD; Shuffle Settings &#x25BD;</a>\"
}
function showSetty(){
var xmlhttp;
if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  } else {// code for IE6, IE5
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }

xmlhttp.onreadystatechange=function(){
  if (xmlhttp.readyState==4 && xmlhttp.status==200){
    document.getElementById('setty').innerHTML=xmlhttp.responseText;
    loagin--
  }}
xmlhttp.open('GET','upsetform.php',true);
xmlhttp.send();loagin++
}
function othertest(ob){
if(ob.value=='other'){
document.getElementById(\"oththing\").style.display=\"block\"
} else {
document.getElementById(\"oththing\").style.display=\"none\"
}
}

function upSet(ob){
var gen
var pr
var go=true
gen=ob.genr.value
if(gen=='other'){gen=ob.other.value;}
pr=ob.prob.value
if(isNaN(pr)){alert(\"Probability must be a number\");go=false;}
else if(pr>1){alert(\"Probability must be less than or equal to 1\");go=false;}
else if(pr<0){alert(\"Probability must be greater than or equal to 0\");go=false;}
else if(gen==''){alert(\"Please enter a filter to use\");go=false;}

if(go){
var xmlhttp;
if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  } else {// code for IE6, IE5
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }
xmlhttp.onreadystatechange=function(){
  if (xmlhttp.readyState==4 && xmlhttp.status==200){
    hideSetty()
    loagin--
  }}
xmlhttp.open('GET','upset.php?p='+pr+'&filt='+gen,true);
xmlhttp.send();loagin++
}
return false;
}

</script>");

//echo("<iframe height=1 width=1 src='que.php' name='que'></iframe><br />");
//echo("<iframe height=370 width=1000 src='db.php' name='lis'></iframe>
//");
/*
$f=file("/home/pi/player/db");
echo("<table width=100%>");
for($i=0;$i<count($f);$i++){
$f[$i]=str_replace(" ","&nbsp;",$f[$i]);
$f[$i]=explode("#|#",$f[$i]);
echo("<tr class='r".($i%7)."'><td>".$f[$i][1]."</td><td><a href='javascript:addQ(".$i.")'>".$f[$i][2]."</a></td><td>".$f[$i][3]."</td><td>".str_replace("
","",$f[$i][4])."</td></tr>");
}
echo("</table>");*/
echo("</body></html>");
?>
