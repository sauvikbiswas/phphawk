<?php
$id = $HTTP_GET_VARS['songid'];

$id_db = array(
	'duality'=>'url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F59496970',
	'magic'=>'url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F16409056%3Fsecret_token%3Ds-9C4RC',
	'totl'=>'url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F18058586',
	'soc'=>'url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F18063994',
	'otasl'=>'url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F18071950',
	'drenched20'=>'url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F16555619'
);

$name_db = array(
	'duality'=>'Duality',
	'magic'=>'Magic',
	'totl'=>'Tale Of The Liars',
	'soc'=>'Streak Of Coldness',
	'otasl'=>'(An Ode To A) Silent Lover',
	'drenched20'=>'Drenched 2.0'
);

$cover_db = array(
	'duality'=>'images/duality_small.jpg',
	'magic'=>'images/magic.jpg',
	'totl'=>'images/magic.jpg',
	'soc'=>'images/LE_small.jpg',
	'otasl'=>'images/LE_small.jpg',
	'drenched20'=>'images/Chaos_small.jpg'
);

echo('<img src="'.$cover_db[$id].'" align="left" width="65" style="margin-left:15px; margin-bottom:15px; margin-right:15px; border:1px #c0e4ff solid"> <i>Now Playing :</i><br>
<big><big><big><b>'.$name_db[$id].'</b></big></big></big>');
echo('<center><object height="81" width="95%"> <param name="movie" value="http://player.soundcloud.com/player.swf?'.$id_db[$id].'&amp;show_comments=true&amp;auto_play=true&amp;color=0d5891"></param> <param name="allowscriptaccess" value="always"></param> <embed allowscriptaccess="always" height="81" src="http://player.soundcloud.com/player.swf?'.$id_db[$id].'&amp;show_comments=true&amp;auto_play=true&amp;color=0d5891" type="application/x-shockwave-flash" width="95%"></embed> </object></center>');
			
?>