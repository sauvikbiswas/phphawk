<?php

define("_GUESTBOOK_","0.20");

function guestbook($path, $filename, $gtargetsubdir, $striptagcontent, $striptag)
{
	$text = readhtml($path, $filename);
	$text = str_ireplace('<%gname%>', '<input name="name" size="50" type="text">', $text);
	$text = str_ireplace('<%gemail%>', '<input name="email" size="50" type="text">', $text);
	$text = str_ireplace('<%gurl%>', '<input name="guesturl" size="50" type="text">', $text);
	$text = str_ireplace('<%gcomments%>', '<textarea name="comments" cols="40" rows="7" wrap="virtual"></textarea>', $text);
	echo('<form method="post" action="index.php?subdir='.$gtargetsubdir.'">');
	echo($text);
	echo('<input name="submitvar" value="Sign Guestbook" type="submit"></form>');
	return;
}

function guestbook_accept_message($cmtaccept, $gdatafile)
{
	if ($cmtaccept==1) echo('<hr>Guestbook data accepted in file <a href="'.$path.$gdatafile.'" target="view">'.$path.$gdatafile.'</a>. Thank you.<br><br>');
	if ($cmtaccept==-1) echo('<hr>Guestbook data rejected due to incomplete fill. Please re-post.<br><br>');
	if ($cmtaccept==0) echo('<br>');
	return;
}

function guestbook_write($path, $gdatafile, $gnewlinetobreak, $gdatatpl, $POST_VARS)
{
	$cmtaccept=0;
	$name = $POST_VARS['name'];
	$email = $POST_VARS['email'];
	$guesturl = $POST_VARS['guesturl'];
	$comments = $POST_VARS['comments'];
	if(($name!="")&&($comments!=""))
	{
		$datepost = date("l, F j, Y @ H:i:s");
		$outputhandle = fopen($path.$gdatafile,"a");
		if ($outputhandle)
		{
			if ($gnewlinetobreak) $comments = str_ireplace("\n", "<br>&nbsp;&nbsp;&nbsp;", $comments);
			$tplreplace = array ('<%gname%>', '<%gemail%>', '<%gurl%>', '<%gdate%>', '<%gcomments%>');
			$tplreplaceto = array ($name, $email, $guesturl, $datepost, $comments);		
			$outstring = str_ireplace($tplreplace, $tplreplaceto, $gdatatpl);
			fwrite($outputhandle, $outstring);
			fclose($outputhandle);
			$cmtaccept=1;
		}
		else echo('Failed to open '.$gdatafile.'<br>');
	}
	else $cmtaccept=-1;
	return ($cmtaccept);
}
?>