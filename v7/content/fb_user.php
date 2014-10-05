<?php
$blog='108262605719';
$x=fetch_facebook_wall($blog, 'user');
$flag=0;
$basedict = array();
for($itemno=0;$itemno<count($x);$itemno++)
{
	$index = substr($x[$itemno]['pubdate'],0,16);
	if (strlen($index) == 16)
	{
		$item = $x[$itemno]['description'];
		if (array_key_exists($index, $basedict) === False) $basedict[$index] = array();
		$basedict[$index][] = $item;
	}
}
foreach($basedict as $pubdate=>$description_array)
{
	echo('<div class="postlink"><small>&nbsp;&nbsp;&nbsp;'.$pubdate.'</small></div>');
	foreach($description_array as $key=>$description)
	{
		echo('<div class="postdescription">'.$description.'</div>');
	}
	echo('<hr>');
}
?>