<?php
$offset = $HTTP_GET_VARS['offset'];
if ($offset=="") $offset=0;
if ($offset>=10)
{
	echo('<small>&nbsp;&nbsp;&nbsp;<a href="#guestbook" onclick="inloadx(\'subdir=content&page=viewguestbook.php&type=p&offset=');
	echo $offset-10;
	echo('\',\'content\');">&lt;&lt; Previous 10 Entries</a></small>');
}
$infest = guestbook_entries();
if ($infest>$offset+10)
{
	echo('<small>&nbsp;&nbsp;&nbsp;<a href="#guestbook" onclick="inloadx(\'subdir=content&page=viewguestbook.php&type=p&offset=');
	echo $offset+10;
	echo('\',\'content\');">Next 10 Entries &gt;&gt;</a></small>');
}
echo('<br><br>');
$guestbookdata = get_guestbook($offset, 10);
if(count($guestbookdata)>0)
{
foreach($guestbookdata as $guestdata)
{
	$name = $guestdata['poster_name'];
	$email = $guestdata['poster_email'];
	$comments = $guestdata['post_text'];
	$comments = bb2html($comments);
	$da = date("l, F j, Y @ H:i:s", $guestdata['post_time']);
	echo('<b>'.$name.'</b></font> wrote on '.$da.'<br>');
	echo($comments.'<br>');
	echo('<br>');
}
if ($offset>=10)
{
	echo('<small>&nbsp;&nbsp;&nbsp;<a href="#guestbook" onclick="inloadx(\'subdir=content&page=viewguestbook.php&type=p&offset=');
	echo $offset-10;
	echo('\',\'content\');">&lt;&lt; Previous 10 Entries</a></small>');
}
$infest = guestbook_entries();
if ($infest>$offset+10)
{
	echo('<small>&nbsp;&nbsp;&nbsp;<a href="#guestbook" onclick="inloadx(\'subdir=content&page=viewguestbook.php&type=p&offset=');
	echo $offset+10;
	echo('\',\'content\');">Next 10 Entries &gt;&gt;</a></small>');
}
}
else
{
	echo('No entries in the guestbook yet. You can be the first one to do so [:D]<br>');
}
?>