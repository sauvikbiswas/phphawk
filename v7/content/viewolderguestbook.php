<div class="pageheader">Guests who Left their Mark (<small>before</small>)</div>
<?php
$offset = $HTTP_GET_VARS['offset'];
if ($offset=="") $offset=0;
if ($offset>=10)
{
	echo('&nbsp;&nbsp;&nbsp;<a href="index.php?subdir=Guestbook&page=viewolderguestbook&type=p&offset=');
	echo $offset-10;
	echo('">&lt;&lt; Previous 10 Entries</a> ');
}
$infest = old_guestbook_entries();
if ($infest>$offset+10)
{
	echo('&nbsp;&nbsp;&nbsp;<a href="index.php?subdir=Guestbook&page=viewolderguestbook&type=p&offset=');
	echo $offset+10;
	echo('"> Next 10 Entries&gt;&gt;</a>');
}
echo('<br><br>');
$guestbookdata = get_old_guestbook($offset, 10);
foreach($guestbookdata as $guestdata)
{
	$name = $guestdata['name'];
	$email = $guestdata['email'];
	$comments = $guestdata['comments'];
	$da = $guestdata['da'];
	echo('<b>'.$name.'</b></font> wrote on '.$da.'<br>');
	echo($comments.'<br>');
	echo('<br>');
}
if ($offset>=10)
{
	echo('&nbsp;&nbsp;&nbsp;<a href="index.php?subdir=Guestbook&page=viewolderguestbook&type=p&offset=');
	echo $offset-10;
	echo('">&lt;&lt; Previous 10 Entries</a> ');
}
$infest = old_guestbook_entries();
if ($infest>$offset+10)
{
	echo('&nbsp;&nbsp;&nbsp;<a href="index.php?subdir=Guestbook&page=viewolderguestbook&type=p&offset=');
	echo $offset+10;
	echo('"> Next 10 Entries&gt;&gt;</a>');
}
?>