<?php
$offset=$HTTP_GET_VARS['offset'];
if ($offset=='') $offset=0;
$blog='darkprojectnews';
$x=fetch_blogfeed($blog,'blogger');
$flag=0;
if ($offset>=5)
{
	echo('<small>&nbsp;&nbsp;&nbsp;<a href="#news" onclick="inloadx(\'subdir=content&page=news.php&type=p&offset=');
	echo $offset-5;
	echo('\',\'content\');">&lt;&lt; Previous 5 Entries</a></small>');
	$flag=1;
}
if (count($x)>$offset+6)
{
	echo('<small>&nbsp;&nbsp;&nbsp;<a href="#news" onclick="inloadx(\'subdir=content&page=news.php&type=p&offset=');
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
	echo('<div class="posttitle">'.$item['title'].'</div><div class="postpubdate">'.$item['pubdate'].'</div><div class="postdescription">'.$item['description'].'</div>');
	echo('<div class="postlink"><small>&nbsp;&nbsp;&nbsp;<a href="'.$item['permalink'].'" target="_blank">Permalink</a> | ');
	$y=fetch_blogcomments($blog,$item['postid']);
	echo('<a href="https://www.blogger.com/comment.g?blogID='.$item['blogid'].'&postID='.$item['postid'].'" target="_blank">'.count($y).' comments</a></small></div>');

}
if ($offset>=5)
{
	echo('<small>&nbsp;&nbsp;&nbsp;<a href="#news" onclick="inloadx(\'subdir=content&page=news.php&type=p&offset=');
	echo $offset-5;
	echo('\',\'content\');">&lt;&lt; Previous 5 Entries</a></small>');
	$flag=1;
}
if (count($x)>$offset+6)
{
	echo('<small>&nbsp;&nbsp;&nbsp;<a href="#news" onclick="inloadx(\'subdir=content&page=news.php&type=p&offset=');
	echo $offset+5;
	echo('\',\'content\');">Next 5 Entries &gt;&gt;</a></small>');
	$flag=1;
}
?>