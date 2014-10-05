<?php

function linkify($status_text)
{
  // linkify URLs
  $status_text = preg_replace(
    '/(https?:\/\/\S+)/',
    '<a target="_blank" href="\1">\1</a>',
    $status_text
  );

  // linkify twitter users
  $status_text = preg_replace(
    '/(^|\s)@(\w+)/',
    '\1@<a target="_blank" href="http://twitter.com/\2">\2</a>',
    $status_text
  );

  // linkify tags
  $status_text = preg_replace(
    '/(^|\s)#(\w+)/',
    '\1#<a target="_blank" href="http://search.twitter.com/search?q=%23\2">\2</a>',
    $status_text
  );

  return $status_text;
}


$x=fetch_twitter();
{
	$item = $x[1];
	echo('<span style="font-size:80%;"><i>'.substr($item['pubdate'],0,-5).'</i></span><br>');
	echo('<span style="font-size:100%;">'.linkify(substr($item['description'],17)).'</span>');
}
?>	