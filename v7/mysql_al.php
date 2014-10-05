<?php

/* Schema Execution */

function execute_schema($filename)
{
	$query_list = @fread(@fopen($filename, 'r'), @filesize($filename));
	$query_list = explode(';',$query_list);
	foreach ($query_list as $query)
	{
		$query = trim($query);
		if ($query != '')
		{
			$sqlexec = mysql_query($query) or die(mysql_error());
		}
	}
	return;
}

/* All functions related to Webring go here */

/* Save a ring description */

function webring_insert($ring_name, $ring_url, $ring_img_url, $ring_submitter, $ring_email, $ring_text)
{
	$query = "INSERT INTO webring (ring_name, ring_url, ring_img_url, ring_submitter, ring_email, ring_text) values ('$ring_name', '$ring_url', '$ring_img_url', '$ring_submitter', '$ring_email', '$ring_text')";
	$sqlexec = mysql_query($query) or die(mysql_error());
	if ($sqlexec) return(0);
	else return(1);
}

/* Update a ring description to display */

function webring_display($ring_id)
{
	$query = "UPDATE webring SET display_status='1' WHERE ring_id='$ring_id'";
	$sqlexec = mysql_query($query) or die(mysql_error());
	if ($sqlexec) return(0);
	else return(1);
}

/* Send the webring list in an array */

function webring_fetch()
{
	$query = "SELECT * FROM webring WHERE display_status='1' ORDER BY ring_id";
	$sqlexec = mysql_query($query) or die(mysql_error());
	$i = 0;
	if(mysql_num_rows($sqlexec) > 0) 
	{
		while($readrow = mysql_fetch_array($sqlexec))
		{
			$i++;
			$ring[$i]['name'] = $readrow['ring_name'];
			$ring[$i]['url'] = $readrow['ring_url'];
			$ring[$i]['img_url'] = $readrow['ring_img_url'];
			$ring[$i]['text'] = $readrow['ring_text'];
		}
	}
	return $ring;
}

function pending_webring_fetch()
{
	$query = "SELECT * FROM webring WHERE display_status='0' ORDER BY ring_id";
	$sqlexec = mysql_query($query) or die(mysql_error());
	$i = 0;
	if(mysql_num_rows($sqlexec) > 0) 
	{
		while($readrow = mysql_fetch_array($sqlexec))
		{
			$i++;
			$ring[$i]['id'] = $readrow['ring_id'];
			$ring[$i]['name'] = $readrow['ring_name'];
			$ring[$i]['url'] = $readrow['ring_url'];
			$ring[$i]['img_url'] = $readrow['ring_img_url'];
			$ring[$i]['text'] = $readrow['ring_text'];
		}
	}
	return $ring;
}

function purge_webring()
{
	$query = "DELETE FROM webring WHERE display_status='0'";
	$sqlexec = mysql_query($query) or die(mysql_error());
	return;
}

/* Return Banlist */

function get_banlist()
{
	$query = "SELECT * FROM banlist";
	$sqlexec = mysql_query($query) or die(mysql_error());
	if(mysql_num_rows($sqlexec) > 0) 
	{
		$i = 0;
		while($readrow = mysql_fetch_array($sqlexec))
		{
			$i++;
			$banlist[$i] = $readrow;
		}
	}
	return $banlist;
}

/* Guestbook insertion */

function insert_guestbook($ip, $name, $email, $url, $comments)
{
	$post_time = time();
	$query="INSERT into guestbook_entries (poster_ip, post_time, poster_name, poster_email, poster_url, post_text) values ('$ip', '$post_time', '$name', '$email', '$url', '$comments')";
	$sqlexec=mysql_query($query) or die(mysql_error());
	if($sqlexec) return(1);
	else return(0);
}

/* Guestbook retrieval */

function get_guestbook($offset, $number)
{
	$query = "SELECT * from guestbook_entries order by post_id DESC";
	$sqlexec = mysql_query($query) or die(mysql_error());
	
	for($h=0;$h<$offset;$h++)
	{
		$result=mysql_fetch_array($sqlexec);
	}

	$i=0;
	while(($result=mysql_fetch_array($sqlexec))&&($i<$number))
	{
		$i++;
		$guestbookdata[$i] = $result;
	}
	return $guestbookdata;
}

/* How many entries? */

function guestbook_entries()
{
	$query = "SELECT * from guestbook_entries";
	$sqlexec = mysql_query($query) or die(mysql_error());
	$infest = mysql_num_rows($sqlexec);
	return $infest;
}

/* Old Guestbook retrieval */

function get_old_guestbook($offset, $number)
{
	$query = "SELECT * from guestbook_old order by daid DESC";
	$sqlexec = mysql_query($query) or die(mysql_error());
	
	for($h=0;$h<$offset;$h++)
	{
		$result=mysql_fetch_array($sqlexec);
	}

	$i=0;
	while(($result=mysql_fetch_array($sqlexec))&&($i<$number))
	{
		$i++;
		$guestbookdata[$i] = $result;
	}
	return $guestbookdata;
}

/* How many entries? */

function old_guestbook_entries()
{
	$query = "SELECT * from guestbook_old";
	$sqlexec = mysql_query($query) or die(mysql_error());
	$infest = mysql_num_rows($sqlexec);
	return $infest;
}

function delete_guestbook_entry($postid)
{
	$query = "DELETE FROM guestbook_entries WHERE post_id='$postid'";
	$sqlexec = mysql_query($query) or die(mysql_error());
	return;
}

function insert_news($heading, $body)
{
	$news_time = time();
	$query="INSERT into news (news_time, news_subject, news_text) values ('$news_time', '$heading', '$body')";
	$sqlexec=mysql_query($query) or die(mysql_error());
	if($sqlexec) return(1);
	else return(0);
}

function news_fetch()
{
	$query = "SELECT * FROM news WHERE archive_status='0' ORDER BY news_id DESC";
	$sqlexec = mysql_query($query) or die(mysql_error());
	$i = 0;
	if(mysql_num_rows($sqlexec) > 0) 
	{
		while($readrow = mysql_fetch_array($sqlexec))
		{
			$i++;
			$news[$i]['id'] = $readrow['news_id'];
			$news[$i]['time'] = $readrow['news_time'];
			$news[$i]['heading'] = $readrow['news_subject'];
			$news[$i]['body'] = $readrow['news_text'];
		}
	}
	return $news;
}

function archive_news_fetch()
{
	$query = "SELECT * FROM news WHERE archive_status='1' ORDER BY news_id DESC";
	$sqlexec = mysql_query($query) or die(mysql_error());
	$i = 0;
	if(mysql_num_rows($sqlexec) > 0) 
	{
		while($readrow = mysql_fetch_array($sqlexec))
		{
			$i++;
			$news[$i]['time'] = $readrow['news_time'];
			$news[$i]['heading'] = $readrow['news_subject'];
			$news[$i]['body'] = $readrow['news_text'];
		}
	}
	return $news;
}

function archive_news($news_id)
{
	$query = "UPDATE news SET archive_status='1' WHERE news_id='$news_id'";
	$sqlexec = mysql_query($query) or die(mysql_error());
	if ($sqlexec) return(0);
	else return(1);
}

function insert_mailinglist($ip, $email)
{
	$query="INSERT into mailinglist (mailer_ip, mailer_email) values ('$ip', '$email')";
	$sqlexec=mysql_query($query) or die(mysql_error());
	if($sqlexec) return(1);
	else return(0);
}

function is_email_in_mailinglist($email)
{
	$query = "SELECT * from mailinglist WHERE mailer_email='$email'";
	$sqlexec = mysql_query($query) or die(mysql_error());
	$infest = mysql_num_rows($sqlexec);
	return $infest;
}

function fetch_mailinglist()
{
	$query = "SELECT * FROM mailinglist";
	$sqlexec = mysql_query($query) or die(mysql_error());
	$i = 0;
	if(mysql_num_rows($sqlexec) > 0) 
	{
		while($readrow = mysql_fetch_array($sqlexec))
		{
			$i++;
			$list[$i] = $readrow['mailer_email'];
		}
	}
	return $list;
}

function fetch_bookinglist()
{
	$query = "SELECT * FROM booking";
	$sqlexec = mysql_query($query) or die(mysql_error());
	$i = 0;
	if(mysql_num_rows($sqlexec) > 0) 
	{
		while($readrow = mysql_fetch_array($sqlexec))
		{
			$i++;
			$list[$i] = $readrow;
		}
	}
	return $list;
}

function insert_bookinglist($name, $copies, $email, $address, $city, $state, $pin, $code)
{
	$datebooked=time();
	$query="INSERT into booking (name, copies, email, address, city, state, pin, code, status, datebooked, dateprocessed) values ('$name', '$copies', '$email', '$address', '$city', '$state', '$pin', '$code', '0', '$datebooked', '0')";
	$sqlexec=mysql_query($query) or die(mysql_error());
	if($sqlexec) return(1);
	else return(0);
}

function process_booking($bookingid)
{
	$dateprocessed=time();
	$query = "UPDATE booking SET dateprocessed='$dateprocessed' , status='1' WHERE bookingid='$bookingid'";
	$sqlexec = mysql_query($query) or die(mysql_error());
	if ($sqlexec) return(0);
	else return(1);
}

function unprocess_booking($bookingid)
{
	$dateprocessed=time();
	$query = "UPDATE booking SET dateprocessed='0' , status='0' WHERE bookingid='$bookingid'";
	$sqlexec = mysql_query($query) or die(mysql_error());
	if ($sqlexec) return(0);
	else return(1);
}

function cancel_booking($bookingid)
{
	$dateprocessed=time();
	$query = "UPDATE booking SET dateprocessed='$dateprocessed' , status='9' WHERE bookingid='$bookingid'";
	$sqlexec = mysql_query($query) or die(mysql_error());
	if ($sqlexec) return(0);
	else return(1);
}

function insert_usedcode($code)
{
	$query="INSERT into usedcodes (code) values ('$code')";
	$sqlexec=mysql_query($query) or die(mysql_error());
	if($sqlexec) return(1);
	else return(0);
}

function is_code_in_codes($code)
{
	$query = "SELECT * from codes WHERE code='$code'";
	$sqlexec = mysql_query($query) or die(mysql_error());
	$infest = mysql_num_rows($sqlexec);
	return $infest;
}

function is_code_in_usedcodes($code)
{
	$query = "SELECT * from usedcodes WHERE code='$code'";
	$sqlexec = mysql_query($query) or die(mysql_error());
	$infest = mysql_num_rows($sqlexec);
	return $infest;
}

function insert_banlist($type, $term)
{
	$query="INSERT into banlist (field, value) values ('$type', '$term')";
	$sqlexec=mysql_query($query) or die(mysql_error());
	if($sqlexec) return(1);
	else return(0);
}

function getZone($ip)
{
	$ipx = explode('.',$ip);
	$ipno = ($ipx[0]*256*256*256)+($ipx[1]*256*256)+($ipx[2]*256)+$ipx[3];
	$query = "SELECT * from iprange WHERE ipstart<'$ipno' AND ipend>'$ipno'";
	$sqlexec=mysql_query($query) or die(mysql_error());
	if($readrow = mysql_fetch_array($sqlexec)) $zone = $readrow['iso'];
	else $zone='GEN';
	return($zone);

}
?>	