<?php
$name = trim($HTTP_GET_VARS['name']);
$email = trim($HTTP_GET_VARS['email']);
$url = trim($HTTP_GET_VARS['url']);
$comments = trim($HTTP_GET_VARS['comments']);
$submit = $HTTP_GET_VARS['submit'];

$ip = getIP();
$banlist = get_banlist();

if($submit=="Sign the Guestbook")
{
	foreach ($banlist as $ban)
	{
		if($ban['field']=='ip')
		{
			$pos = strpos(strtolower($ip), $ban['value']);
			if ($pos === false) 
			{
				echo ('');
			}
			else 
			{
				$submit = "InvalidIP";
				echo ('Dear <b>'.$name.'</b>,<br> Your Comment was discarded. Spamming is <u>strictly</u> prohibited.<br>');
			}
		}
		if($ban['field']=='email')
		{
			$pos = strpos(strtolower($email), $ban['value']);
			if ($pos === false) 
			{
				echo ('');
			}
			else 
			{
				$submit = "Invalid";
				echo ('Dear <b>'.$name.'</b>,<br> Your Comment was discarded. Spamming is <u>strictly</u> banned. If spamming persists the ISP may be banned, too.<br>');
			}

		}
		if($ban['field']=='word')
		{
			$pos1 = strpos(strtolower(' '.$comments.' '), ' '.$ban['value']);
			$pos2 = strpos(strtolower(' '.$comments.' '), $ban['value'].' ');
			if (($pos1 === false) && ($pos2 === false))
			{
				echo ('');
			}
			else
			{
				$submit = "Invalid";
				echo ('Dear <b>'.$name.'</b>,<br> Your Comment was discarded. The phrase/word '.$ban['value'].' in this guestbook is <u>strictly</u> banned.<br>');
			}
		}

		if($ban['field']=='term')
		{
			$pos = strpos(strtolower($comments), $ban['value']);
			if ($pos === false)
			{
				echo ('');
			}
			else
			{
				$submit = "Invalid";
				echo ('Dear <b>'.$name.'</b>,<br> Your Comment was discarded. The term '.$ban['value'].' in this guestbook is <u>strictly</u> banned.<br>');
			}
		}

	}
	if(($name=="")||($email=="")||($comments==""))
	{
		$submit = "Invalid";
		echo ('Incomplete entry. Please fill the name, email and comments field.<br>');
	}

}

if($submit=="Invalid")
{
	echo('You may edit and re-enter your text.<br><br>');
}

if($submit=="Sign the Guestbook")
{
	$ret = insert_guestbook($ip, $name, $email, $url, $comments);
	if ($ret==1) echo ('Dear <b>'.$name.'</b>,<br>Thank You for signing the guestbook. You might wish to view the guestbook [<a href="#guestbook" onclick="inloadx(\'subdir=content&page=viewguestbook.php&type=p&offset=0\',\'content\')">Here</a>]');
}
else
{
	echo('<form action="#" id="guestbook" method="post"><span style="font-weight: bold;">Name : </span><input name="name" size="40" type="text" value="'.$name.'"><br><br><span style="font-weight: bold;">Email : </span><input name="email" size="40" type="text" value="'.$email.'"><br><br><span style="font-weight: bold;">URL : </span><input name="url" size="40" type="text" value="'.$url.'"><br><br><br><span style="font-weight: bold;">Comments : </span><br><textarea name="comments" cols="60" rows="7" wrap="virtual">'.$comments.'</textarea><br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <input name="submit" value="Sign the Guestbook" type="hidden"><a onclick="guestbooksubmit();" href="#" style="border: 1px solid rgb(0, 0, 0); padding: 2px; text-decoration: none;">Sign the Guestbook</a></form>');
}
?>