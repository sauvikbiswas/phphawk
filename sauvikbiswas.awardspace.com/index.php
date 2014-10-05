<?php
$path = $HTTP_GET_VARS['subdir'];
$name = $HTTP_POST_VARS['name'];
$email = $HTTP_POST_VARS['email'];
$guesturl = $HTTP_POST_VARS['guesturl'];
$comments = $HTTP_POST_VARS['comments'];
$datepost = $HTTP_POST_VARS['$datepost'];
$submitvar = $HTTP_POST_VARS['submitvar'];
$password = $HTTP_POST_VARS['password'];
$passwordc = $HTTP_COOKIE_VARS['passwordc'];
$imagename = $HTTP_GET_VARS['imagename'];
$imagetitle = $HTTP_GET_VARS['imagetitle'];
$jstart = $HTTP_GET_VARS['jstart'];
$jentries = $HTTP_GET_VARS['jentries'];

if ($password != "") 
{
  setcookie("passwordc", $password, time()+1800);
  $passwordc = $password;
}

include("config.php");

function displayhtml($path,$htmlfile)
{
  $htmlfile = trim($htmlfile);
  $htmlhandle = fopen($path.$htmlfile, "r");
  if($htmlhandle)
  {
	  $contents = fread($htmlhandle, filesize($path.$htmlfile));
	  echo($contents);
	  fclose($htmlhandle);
  }
  return;
}

function includephp($path,$phpfile)
{
  $phpfile = trim($phpfile);
  include($path.$phpfile);
  return;
}

function displayimage($filename, $title)
{
   $size = getimagesize($filename);
   $width = $size[0];
   $height = $size[1];
   $calcheight = ($height/$width)*600;
   $calcwidth = ($width/$height)*450;
   if ($calcheight > 450) 
   {
	   $spacerextension = intval((600-$calcwidth));
	   echo('<img src="'.$filename.'" height=450>');
	   echo('<img src="spacer.jpg" height=450 width='.$spacerextension.'>');
   }
   else
   {
	   echo('<img src="'.$filename.'" width=600>');
	   //echo('<img src="spacer.jpg" width="1" height="450"><br>');
   }
   echo('<br><br><div style="font-weight: bold;">'.stripslashes($title).'</div>Original Size: '.$width.' x '.$height.'<br><hr><br>');
return;
}

function imagelist($path,$filename,$iname,$ititle)
{
  $filename = trim($filename);
  $imagefile = $path.$filename;
  $ihandle = fopen($imagefile,"r");
  $modpath = substr($path,0,-1);
  $count = 0;
  if($iname!="") displayimage($iname, $ititle);
  while(!feof($ihandle))
  {
	$imgtitle = fgets($ihandle);
	$imgname = fgets($ihandle);
	$imgname = trim($imgname);
	if ($imgname!="")
	{
		if(($count==0)&&($iname=="")) displayimage($path.$imgname, $imgtitle);
		$size = getimagesize($path.$imgname);
		$width = $size[0];
		$height = $size[1];
		$calcheight = ($height/$width)*200;
		$calcwidth = ($width/$height)*150;
		if ($calcheight > 150) 
		{
			$spacerextension = intval((200-$calcwidth)/2);
			echo('<img src="spacer.jpg" height=150 width='.$spacerextension.'>');
			echo('<a href="index.php?subdir='.$modpath.'&imagename='.$path.$imgname.'&imagetitle='.$imgtitle.'"><img src="'.$path.$imgname.'" height=150 border=0></a>');
			echo('<img src="spacer.jpg" height=150 width='.$spacerextension.'>');
		}
		else 
		{
			echo('<a href="index.php?subdir='.$modpath.'&imagename='.$path.$imgname.'&imagetitle='.$imgtitle.'"><img src="'.$path.$imgname.'" width=200  border=0></a>');
		}
		$count = $count+1;
		if (($count%3) == 0) echo('<img src="spacer.jpg" width="2" height="150"><br>');
		else echo('&nbsp;&nbsp;');
	}
  }
  if ($count != 0)
  {
	  if (($count%3)!=0) echo('<img src="spacer.jpg" width="2" height="150"><br>');
  }
  else echo('No image found in gallery');
  echo('<br>');
  fclose($ihandle);
  return;
}

function linklist($path,$filename)
{
  $filename = trim($filename);
  $linkfile = $path.$filename;
  $ihandle = fopen($linkfile,"r");
  $modpath = substr($path,0,-1);
  $count = 0;
  while(!feof($ihandle))
  {
	$linktitle = fgets($ihandle);
	$linkname = fgets($ihandle);
	$linkdesc = fgets($ihandle);
	$linkname = trim($linkname);
	if ($linkname!="")
	{
		echo('<li><b>'.$linktitle.' </b> [ <small><a href="'.$linkname.'" target="_blank">'.$linkname.'</a></small> ] <b>: </b>'.$linkdesc.'<br></li>');
		$count = $count+1;
	}
  }
  if ($count == 0) echo('No links found in linklist');
  echo('<br>');
  fclose($ihandle);
  return;
}

function validate($path,$parsedstring,$passwordc,$password,$pass)
{
  if ($passwordc != $pass)
  {
	  if ($password != "")
	  {
		  echo('<br>The password you entered was wrong<br><br>');
	  }
	  echo('<form method=post action="index.php?subdir='.substr($path,0,-1).'"><input type=password name=password><input type=submit name=Retrive value=Retrive></form>');
  }
  else displayhtml($path,$parsedstring);
  return;
}

function journal($path,$filename,$jstart,$jentries)
{
  $dispflag=0;
  $filename = trim($filename);
  $journalfile = $path.$filename;
  $jhandle = fopen($journalfile,"r");
  $modpath = substr($path,0,-1);
  $count = 0;
  while(!feof($jhandle))
  {
	$jtitle = fgets($jhandle);
	$jfile = fgets($jhandle);
	$jmod = fgets($jhandle);
	$jtitle = trim($jtitle);
	if ($jfile!="")
	{
		if(($count>=($jstart-1))&&($count<=($jstart+$jentries-2)))
		{
			echo('<b>'.$jtitle.'</b><br>');
			echo('<small><i>'.$jmod.'</i></small><br>');
			displayhtml($path,$jfile);
			echo('<br>');
			echo('<hr>');
		}
		$count = $count+1;
		if($count>($jstart+$jentries-1))
		{
			if($dispflag==0) 
			{
				echo('<b>Journal entries made before the displayed entries :</b><br>');
				$dispflag=1;
			}
			echo('<a href="index.php?subdir='.$modpath.'&jstart='.$count.'&jentries='.$jentries.'">'.$jtitle.'</a><small> '.$jmod.'</small><br>');
		}
	}
  }
  if ($count == 0) 
  {
	  echo('No journal entries found in list');
	  return;
  }
  echo('<br>');
  fclose($jhandle);

  $dispflag=0;
  $jhandle = fopen($journalfile,"r");
  $count = 0;
  while(!feof($jhandle))
  {
	$jtitle = fgets($jhandle);
	$jfile = fgets($jhandle);
	$jmod = fgets($jhandle);
	$jtitle = trim($jtitle);
	if ($jfile!="")
	{
		$count = $count+1;
		if($count<($jstart))
		{
			if($dispflag==0) 
			{
				echo('<b>Journal entries made after the displayed entries :</b><br>');
				$dispflag=1;
			}
			echo('<a href="index.php?subdir='.$modpath.'&jstart='.$count.'&jentries='.$jentries.'">'.$jtitle.'</a><small> '.$jmod.'</small><br>');
		}
	}
  }
  echo('<br>');
  fclose($jhandle);

  return;
}

include("header.php");

if ($path!="") $path=$path."/";
$mastertable = $path."mastertable.txt";

if ($jstart=="") $jstart=1;
if ($jentries=="") $jentries=$jentriesdefault;

$cmtaccept=0;
if($submitvar=="Sign Guestbook")
{
  if(($name!="")&&($comments!=""))
  {
	$datepost = date("l, F j, Y @ H:i:s");
	$outputhandle = fopen($path."guestdata.html","a");
	$comments = str_replace("\n", "<br>&nbsp;&nbsp;&nbsp;", $comments);
	$outstring = '<!--  '.$email.' / '.$guesturl.'  --><b><font color="red">'.$name.' </font></b><br><i>'.$datepost.'</i><br>&nbsp;&nbsp;&nbsp;'.$comments."<br><br>\n\n\n";
	fwrite($outputhandle, $outstring);
	fclose($outputhandle);
	$cmtaccept=1;
  }
  else $cmtaccept=-1; 
}

$handle = fopen($mastertable,"r");
if(!$handle)
{
  echo ($mastertable.' not found. ');
  die('Page loader killed.');
}
while (!feof($handle))
{
  $get = fgets($handle);
  $parser = substr($get, 0, 1);
  $parsedstring = substr($get, 2);

  switch($parser)
  {
    case "m" :
      displayhtml($path,$parsedstring);
      break;
	case "p" :
      includephp($path,$parsedstring);
      break;
    case "h" :
	  $color = implode(",", $headcolorarray);
      echo('<div style="font-family:'.$headfont.'; font-size:'.$headsize.'%; font-weight: '.$headweight.'; color: rgb('.$color.');">
      '.$parsedstring.'</div><br>');
      break;
    case "l" :
      echo('<hr>');
      break;
    case "t" :
      echo('<normal>'.$parsedstring.'</normal><br><br>');
      break;
    case "i" :
      imagelist($path,$parsedstring,$imagename,$imagetitle);
      break;
	case "k" :
	  linklist($path,$parsedstring);
	  break;
	case "w" :
	  validate($path,$parsedstring,$passwordc,$password,$pass);
	  break;
	case "j" :
	  journal($path,$parsedstring,$jstart,$jentries);
  }
}

if ($cmtaccept==1) echo('<hr>Guestbook data accepted in file <a href="'.$path.'guestdata.html" target="view">'.$path.'guestdata.html</a>. Thank you.<br><br>');
if ($cmtaccept==-1) echo('<hr>Guestbook data rejected due to incomplete fill. Please re-post.<br><br>');
if ($cmtaccept==0) echo('<br>');
include("footer.php");

fclose($handle)
?>
