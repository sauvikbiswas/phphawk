<?php
if (count($HTTP_GET_VARS)==0) $HTTP_GET_VARS=$_GET;
if (count($HTTP_POST_VARS)==0) $HTTP_POST_VARS=$_POST;
$path = $HTTP_GET_VARS['subdir'];
$forceparsefile = $HTTP_GET_VARS['parse'];
$solopagefile = $HTTP_GET_VARS['page'];
$solopagetype = $HTTP_GET_VARS['type'];
$submitvar = $HTTP_POST_VARS['submitvar'];
$password = $HTTP_POST_VARS['password'];
$passwordc = $HTTP_COOKIE_VARS['passwordc'];
$imagename = $HTTP_GET_VARS['imagename'];
$imagetitle = $HTTP_GET_VARS['imagetitle'];

if ($password != "") 
{
  setcookie("passwordc", $password, time()+1800);
  $passwordc = $password;
}

/* Include defaults */

include("parsingtools.php");
include("config.php");
include("feedgrabber.php");
include("mysql_connect.php");
include("mysql_al.php");
include("libtools.php");

if (($journal) && (is_readable("ext_journal.php"))) include("ext_journal.php");
if (($guestbook) && (is_readable("ext_guestbook.php"))) include("ext_guestbook.php");
if ($imagelocation=="global") define("IMGGLOBAL","ON");

if (defined("_JOURNAL_")) 
{
	$jstart = $HTTP_GET_VARS['jstart'];
	$jentries = $HTTP_GET_VARS['jentries'];
}

function includephp($path,$phpfile,$HTTP_GET_VARS,$HTTP_POST_VARS)
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
	   echo('<img src="spacer.bmp" height=450 width='.$spacerextension.'>');
   }
   else
   {
	   echo('<img src="'.$filename.'" width=600>');
	   //echo('<img src="spacer.bmp" width="1" height="450"><br>');
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
			echo('<img src="spacer.bmp" height=150 width='.$spacerextension.'>');
			echo('<a href="index.php?subdir='.$modpath.'&imagename='.$path.$imgname.'&imagetitle='.$imgtitle.'"><img src="'.$path.$imgname.'" height=150 border=0></a>');
			echo('<img src="spacer.bmp" height=150 width='.$spacerextension.'>');
		}
		else 
		{
			echo('<a href="index.php?subdir='.$modpath.'&imagename='.$path.$imgname.'&imagetitle='.$imgtitle.'"><img src="'.$path.$imgname.'" width=200  border=0></a>');
		}
		$count = $count+1;
		if (($count%3) == 0) echo('<img src="spacer.bmp" width="2" height="150"><br>');
		else echo('&nbsp;&nbsp;');
	}
  }
  if ($count != 0)
  {
	  if (($count%3)!=0) echo('<img src="spacer.bmp" width="2" height="150"><br>');
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


if (is_readable("header.php")) include("header.php");

if ($path!="") $path=$path."/";
if($forceparsefile!="") $mastertable = $path.$forceparsefile;
else $mastertable = $path.$mastertablefile;

if (defined("_JOURNAL_")) 
{
	if ($jstart=="") $jstart=1;
	if ($jentries=="") $jentries=$jentriesdefault;
}

$cmtaccept=0;
if (defined("_GUESTBOOK_"))
{
	if($submitvar=="Sign Guestbook")
	{
		$cmtaccept = guestbook_write($path, $gdatafile, $gnewlinetobreak, $gdatatpl, $HTTP_POST_VARS);
	}
}

$readable = is_readable($mastertable);
if ($readable) $handle = fopen($mastertable,"r");
if (((!$handle)||(!$readable))&&($solopagefile==""))
{
  echo ($mastertable.' not found. ');
  die('Page loader killed.');
}

if ($solopagefile!="") {
	if ($solopagetype=="p") includephp($path,$solopagefile,$HTTP_GET_VARS,$HTTP_POST_VARS);
	else displayhtml($path,$solopagefile,$striptagcontent,$striptag);
}
else {
while (!feof($handle))
{
  $get = fgets($handle);
  $cmdarray = explode(" ",$get,2);
  $parser = $cmdarray[0];
  $parsedstring = $cmdarray[1];

  switch($parser)
  {
    case "m" :
      displayhtml($path,$parsedstring,$striptagcontent,$striptag);
      break;
	case "p" :
      includephp($path,$parsedstring,$HTTP_GET_VARS,$HTTP_POST_VARS);
      break;
    case "h" :
	  if($headcustom)
	  {
		  echo(str_ireplace('<%head%>', $parsedstring, $headtpl));
	  }
	  else
	  {
		  $color = implode(",", $headcolorarray);
		  echo('<div style="font-family:'.$headfont.'; font-size:'.$headsize.'%; font-weight: '.$headweight.'; color: rgb('.$color.');">'.$parsedstring.'</div><br>');
	  }
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
	  if (defined("_JOURNAL_")) 
	  {
		journal($path, $parsedstring, $jstart, $jentries, $jheadcolorarray, $jheadsize, $jheadweight, $jheadfont, $jcustom, $jheadtpl, $jsubtpl, $jbodytpl, $striptagcontent, $striptag);
	  }
	  else
	  {
		  echo("<br>[!] You do not have the journal extension installed properly<br>");
	  }
	  break;
	case "g" :
	  if (defined("_GUESTBOOK_")) 
	  {
		guestbook($path, $parsedstring, $gtargetsubdir, $striptagcontent, $striptag);
	  }
	  else
	  {
		  echo("<br>[!] You do not have the guestbook extension installed properly<br>");
	  }
  }
}
fclose($handle);
}

if (defined("_GUESTBOOK_")) guestbook_accept_message($cmtaccept, $gdatafile);

if (is_readable("footer.php")) include("footer.php");


?>
