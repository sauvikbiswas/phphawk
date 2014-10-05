<?php

function bb2html($text)
{
  $bbcode = array("<", ">",
                "[list]", "[*]", "[/list]", 
                "[img]", "[/img]", 
                "[b]", "[/b]", 
                "[u]", "[/u]", 
                "[i]", "[/i]",
                '[color="', "[/color]",
                "[size=\"", "[/size]",
                '[url="', "[/url]",
                "[mail=\"", "[/mail]",
                "[code]", "[/code]",
                "[quote]", "[/quote]",
                '"]');
  $htmlcode = array("&lt;", "&gt;",
                "<ul>", "<li>", "</ul>", 
                "<img src=\"", "\">", 
                "<b>", "</b>", 
                "<u>", "</u>", 
                "<i>", "</i>",
                "<span style=\"color:", "</span>",
                "<span style=\"font-size:", "</span>",
                '<a href="', "</a>",
                "<a href=\"mailto:", "</a>",
                "<code>", "</code>",
                "<div style=\"background:lightgray; border:1px;\">", "</div>",
                '">');
  $newtext = str_replace($bbcode, $htmlcode, $text);
  $newtext = nl2br($newtext);//second pass
  return $newtext;
}

/* Determine IP (search for a better traceroute code) */

function getIP() {
$ip;

if (getenv("HTTP_CLIENT_IP")) $ip = getenv("HTTP_CLIENT_IP");
else if(getenv("HTTP_X_FORWARDED_FOR")) $ip = getenv("HTTP_X_FORWARDED_FOR");
else if(getenv("REMOTE_ADDR")) $ip = getenv("REMOTE_ADDR");
else $ip = "UNKNOWN";

//$iparray = explode(', ', $ip);
return $ip;
}

function getglobalIP() {
$ip;

if (getenv("HTTP_CLIENT_IP")) $ip = getenv("HTTP_CLIENT_IP");
else $ip = "0.0.0.0";
//$iparray = explode(', ', $ip);
return $ip;
}

/* Display an html code */

function display_html($path, $htmlfile, $host, $imagepath)
{
  $ipath = $host.$imagepath;
  $htmlfile = trim($htmlfile);
  $htmlhandle = fopen($path.$htmlfile, "r");
  if($htmlhandle)
  {
	  $contents = fread($htmlhandle, filesize($path.$htmlfile));
	  $contents = str_ireplace('src="', 'src="'.$ipath, $contents);
	  $contents = str_ireplace('src="'.$ipath.'http://', 'src="http://', $contents);
	  $contents = str_ireplace('src="'.$ipath.'www.', 'src="http://www.', $contents);
	  echo($contents);
	  fclose($htmlhandle);
  }
  return;
}

/* Check if a string is a link or not */

function isUrl($url)
{
	$prod = 1;
	$pos = strpos($url, '.');
	if ($pos !== false) $prod *= 2;
	$pos = strpos($url, 'www');
	if ($pos !== false) $prod *= 3;
	$pos = strpos($url, 'http://');
	if ($pos !== false) $prod *= 5;

	if (($prod == 1)||($prod == 2))	return false;
	else return true;
}

/* Check if a string is an email or not */

function isEmail($email) {
    return preg_match('|^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{2,})+$|i', $email);
}


?>