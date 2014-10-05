<html>
<head>
<title>Dark Project : Wallpaper Gallery</title>
</head>
<body bgcolor=white>
<?php
$fn=$HTTP_GET_VARS['fn'];
$dim=$HTTP_GET_VARS['dim'];
$imagepath="images/";
?>
<table width=100%><tr><td>
<br><font style="font-weight: bold; color: rgb(255, 0, 0);" size="+1">Dark Project Wallpaper</font><br>
<small>Dimension : 
<?php
echo($dim);
?>
<br>Right Click on the image and choose 'Set As Background'<br><br></small>
<img src="
<?php
echo($imagepath.$fn);
?>
">
<br>
</td></tr></table>
<P>&nbsp;</P>
<P>&nbsp;</P>
</body></html>