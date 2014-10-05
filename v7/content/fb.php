<?php
$offset=$HTTP_GET_VARS['offset'];
if ($offset=='') $offset=0;
$blog='108262605719';
$x=fetch_facebook_wall($blog, '');
$flag=0;
if ($offset>=5)
{
	echo('<small>&nbsp;&nbsp;&nbsp;<a href="#fb" onclick="inloadx(\'subdir=content&page=fb.php&type=p&offset=');
	echo $offset-5;
	echo('\',\'content\');">&lt;&lt; Previous 5 Entries</a></small>');
	$flag=1;
}
if (count($x)>$offset+6)
{
	echo('<small>&nbsp;&nbsp;&nbsp;<a href="#fb" onclick="inloadx(\'subdir=content&page=fb.php&type=p&offset=');
	echo $offset+5;
	echo('\',\'content\');">Next 5 Entries &gt;&gt;</a></small>');
	$flag=1;
}
if($flag==1) echo('<br><br>');
if (count($x)>$offset+6) $max=$offset+6;
else $max=count($x);
for($itemno=$offset+1;$itemno<$max;$itemno++)
{
	$item = $x[$itemno];
	$desc = str_replace(array('href="/', 'https://www.facebook.com/l.php?u=','%3A','%2F','%3F','%3D'), array('href="http://facebook.com/','',':','/','?','='), $item['description']);
	echo('<div class="postdescription">'.$desc.'</div>');
	echo('<div class="postlink"><small>&nbsp;&nbsp;&nbsp;'.$item['pubdate'].'&nbsp;&nbsp;&nbsp;<a href="'.$item['permalink'].'" target="_blank">Permalink</a>');
	echo('<hr></small></div>');
}
if ($offset>=5)
{
	echo('<small>&nbsp;&nbsp;&nbsp;<a href="#fb" onclick="inloadx(\'subdir=content&page=fb.php&type=p&offset=');
	echo $offset-5;
	echo('\',\'content\');">&lt;&lt; Previous 5 Entries</a></small>');
	$flag=1;
}
if (count($x)>$offset+6)
{
	echo('<small>&nbsp;&nbsp;&nbsp;<a href="#fb" onclick="inloadx(\'subdir=content&page=fb.php&type=p&offset=');
	echo $offset+5;
	echo('\',\'content\');">Next 5 Entries &gt;&gt;</a></small>');
	$flag=1;
}
?>