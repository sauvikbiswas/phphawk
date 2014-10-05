<?php
$photoarray = fetch_blogfeed('mail.dark.project','picasa');
	$set = $photoarray[count($photoarray)-1];
	$title = $set['title'];
	$pubdate = $set['pubdate'];
	$description = $set['description'];
$hrefpos = strpos($description,'href="')+6;
$hreflen = strpos($description,'"',$hrefpos)-$hrefpos;
$href = substr($description,$hrefpos,$hreflen);
$imgsrcpos = strpos($description,'src="')+5;
$imgsrclen = strpos($description,'"',$imgsrcpos)-$imgsrcpos;
$photo = substr($description,$imgsrcpos,$imgsrclen);
$photo = str_replace('s288','s640',$photo);
echo('<a name="photoscroll"></a>');
echo('<div id="imgtitle" class="imgposttitle">'.$title.'</div>');
echo('<div id="imgpubdate" class="imgpostpubdate">'.$pubdate.'</div>');
echo('<img id="photo" class="psdisplay" src="'.$photo.'" width="550"><br>
<div class="postlink" id="permalink"><small><a target="_blank" href="'.$href.'">Permalink /Comments</a></small></div>
	<div class="photoscroll">');
for($i=count($photoarray)-1;$i>0;$i--)
{
	$set = $photoarray[$i];
//print_r($set);
	$title = $set['title'];
	$pubdate = $set['pubdate'];
	$description = $set['description'];
$imgsrcpos = strpos($description,'src="')+5;
$imgsrclen = strpos($description,'"',$imgsrcpos)-$imgsrcpos;
$photo = substr($description,$imgsrcpos,$imgsrclen);
$photo = str_replace('s288','s640',$photo);
	$descalt = str_replace(array('src','s288'),array('height="96" src','s128'),$description);
$hrefpos = strpos($descalt,'href="')+6;
$hreflen = strpos($descalt,'"',$hrefpos)-$hrefpos;
$href = substr($descalt,$hrefpos,$hreflen);
$hrefpos2 = strpos($description,'href="')+6;
$hreflen2 = strpos($description,'"',$hrefpos2)-$hrefpos2;
$href2 = substr($description,$hrefpos2,$hreflen2);
$title = addslashes($title);
$rep = '#photoscroll" onclick="swapimg(\''.$photo.'\',\''.$title.'\',\''.$pubdate.'\',\''.$href2.'\');';
$descalt = str_replace($href,$rep,$descalt);
	echo($descalt);
}
