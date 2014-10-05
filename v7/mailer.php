<?php

$to  = $HTTP_GET_VARS['to'];

if ($to!='') {
/*$to  = 'sauvik.biswas@gmail.com';*/
$subject = 'Dark Project Newsletter : Release of two new singles';
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Dark Project <mail.dark.project@gmail.com>' . "\r\n";

$message = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head><body><center><img src="http://darkproject.co.in/ext/M_TOTL_poster.jpg" alt="Please enable the display of images to view this poster. You can visit http://darkproject.co.in to know how you can grab the songs for free." usemap="#green" border="0">
<map name="green">
<area shape="rect" coords="240,136,439,162" href="http://darkproject.co.in" target="_blank">
<area shape="rect" coords="272,671,320,722" href="http://www.facebook.com/darkprojectband" target="_blank">
<area shape="rect" coords="321,671,370,722" href="http://www.twitter.com/darkprojectband" target="_blank">
<area shape="rect" coords="371,671,420,722" href="http://www.last.fm/music/Dark+Project" target="_blank">
<area shape="rect" coords="421,671,472,722" href="http://soundcloud.com/darkproject" target="_blank">
</map></center>
</body>
</html>';

mail($to, $subject, $message, $headers);
sleep(2);
echo ('Mailed to '.$to);
}
else
{
echo ('To not specified. Use this syntax http://darkproject.co.in/mailer.php?to=&lt;email_id&gt;');
}
?>