<?php

/*function str_ireplace($search,$replace,$subject) {
    $token = '^[[term^]';
    $haystack = strtolower($subject);
    $needle = strtolower($search);
    while (($pos=strpos($haystack,$needle))!==FALSE)  {
      $c++;
      $subject = substr_replace($subject,$token,$pos,strlen($search));
      $haystack = substr_replace($haystack,$token,$pos,strlen($search));
    }
    while (($pos=strpos($subject,$token))!==FALSE)  {
      $subject = substr_replace($subject,$replace,$pos,strlen($token));
    }
   return $subject;
}*/

/*function stripos($haystack, $needle){
    return strpos($haystack, stristr( $haystack, $needle ));
}*/

/* Reads HTML into a text variable */
function readhtml($path,$htmlfile)
{
  $htmlfile = trim($htmlfile);
  $htmlhandle = fopen($path.$htmlfile, "r");
  if($htmlhandle)
  {
	  $contents = fread($htmlhandle, filesize($path.$htmlfile));
	  fclose($htmlhandle);
  }
  return ($contents);
}

/* Strips the text of tags but not the content */
function striptag($text, $tagarray)
{
	foreach ($tagarray as $tag)
	{
		$starttag = "<".$tag;
		$endtag = "</".$tag.">";

		$startpos = stripos($text, $starttag);
		if ($startpos === false)
		{
		}
		else
		{
			$endpos = stripos($text, ">", $startpos+1);
			$endpos = $endpos + 1;
			$pretext = substr($text,0,$startpos);
			$posttext = substr($text, $endpos);
			$text = $pretext.$posttext;
		}
		$text = str_ireplace($endtag, "", $text);
	}
	$text = trim($text);

	return ($text);
}

/* Strips the text of tags as well as inside contents */
function striptagcontent($text, $tagarray)
{	
	foreach ($tagarray as $tag)
	{
		$starttag = "<".$tag;
		$endtag = "/".$tag.">";

		$startpos = stripos($text, $starttag);
		if ($startpos === false)
		{
		}
		else
		{
			$endpos = stripos($text, $endtag, $startpos+1);
			$endpos = $endpos + strlen($endtag);

			$pretext = substr($text,0,$startpos);
			$posttext = substr($text, $endpos);
			$text = $pretext.$posttext;
		}
	}

	$text = trim($text);
	return ($text);
}

/* Displays an HTML */
function displayhtml($path,$htmlfile,$striptagcontent,$striptag)
{
  $htmlfile = trim($htmlfile);
  $htmlhandle = fopen($path.$htmlfile, "r");
  if($htmlhandle)
  {
	  $contents = fread($htmlhandle, filesize($path.$htmlfile));
	  if (!defined("IMGGLOBAL")) $contents = str_ireplace('src="', 'src="'.$path, $contents);
	  $contents = str_ireplace('src="'.$path.'http://', 'src="http://', $contents);
	  $contents = str_ireplace('src="'.$path.'www.', 'src="http://www.', $contents);
	  $contents = striptagcontent($contents,$striptagcontent);
	  $contents = striptag($contents,$striptag);
	  echo($contents);
	  fclose($htmlhandle);
  }
  return;
}
?>