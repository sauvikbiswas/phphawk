<?php
function fetch_twitter(){
    /* cURL parse*/
    $ch = curl_init('http://twitter.com/statuses/user_timeline/26724195.rss');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $xml = curl_exec($ch);
    curl_close($ch);
    $xml_data = $xml;
    $parser = xml_parser_create(); 
    xml_parse_into_struct($parser, $xml_data, &$assoc_arr, &$idx_arr); 
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
    $i = 1;
    $flag = 0;
    foreach($assoc_arr as $key => $element) { 
         if (($element['tag']=='ITEM')&&($element['level']=='3')&&($element['type']=='open')) $flag = 1;
         if (($element['tag']=='ITEM')&&($element['level']=='3')&&($element['type']=='close')) {
              $flag = 0;
              $i++;
         }
         if (($flag==0)&&($element['tag']==TITLE)) $items[0]['title'] = $element['value'];
         if ($flag==1) {
              if ($element['tag']=='GUID') {
                   $guid = $element['value'];
                   $pos = strpos($guid, 'post-');
                   if ($pos===false) $postid = $guid;
                   else {
                      $postid = substr($guid, $pos + 5);
                      $pos1 = strpos($guid, 'blog-');
                      $items[$i]['blogid'] = substr($guid, $pos1 + 5, $pos-$pos1-6);
                   }
                   $items[$i]['postid'] = $postid;
              }
              if($element['tag']=='PUBDATE') $items[$i]['pubdate'] = $element['value'];
              if($element['tag']=='DC:DATE') $items[$i]['pubdate'] = $element['value'];
              if($element['tag']=='TITLE') $items[$i]['title'] = $element['value'];
              if($element['tag']=='DESCRIPTION') $items[$i]['description'] = $element['value'];
              if($element['tag']=='CONTENT:ENCODED') {
                   $content = $element['value'];
                   $feedburnerpos = strpos($content,'<div class="feedflare">');
                   if ($feedburnerpos===false) $items[$i]['description'] = $content;
                   else $items[$i]['description'] = substr($content,0,$feedburnerpos);
                   $wordpresspos = strpos($content,'<a rel="nofollow" href="');
                   if ($wordpresspos===false) $items[$i]['description'] = $content;
                   else $items[$i]['description'] = substr($content,0,$wordpresspos).'</div>';
              }
              if($element['tag']=='LINK') $items[$i]['permalink'] = $element['value'];
              if($element['tag']=='FEEDBURNER:ORIGLINK') $items[$i]['permalink'] = $element['value'];
              if(($element['tag']=='DESCRIPTION')&&($type=='picasa')) {
                   $content = $items[$i]['description'];
                   $picasapos = strpos($content,'</td>');
                   if ($picasapos===false) $items[$i]['description'] = $content;
                   else $items[$i]['description'] = substr($content,strlen('<table><tr><td style="padding: 0 5px">'),$picasapos-strlen('<table><tr><td style="padding: 0 5px">'));
              }

         }
    } 

    return $items; 
}

function fetch_listeners(){
    /* cURL parse*/
    $ch = curl_init("http://ws.audioscrobbler.com/2.0/?method=artist.gettopfans&artist=dark+project&api_key=f9d7d49161418480253e675889af7080");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $xml = curl_exec($ch);
    curl_close($ch);
 
    $xml_data = $xml;
    $parser = xml_parser_create(); 
    xml_parse_into_struct($parser, $xml_data, &$assoc_arr, &$idx_arr); 
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
    $root_tag = $assoc_arr[0]['tag']; 
    $base_tag = strtolower($assoc_arr[1]['tag']); 
    $i = 0; 
    foreach($assoc_arr as $key => $element){ 
         if (($element['tag']=='USER')&&($element['type']=='open')) $flag = 1;
         if (($element['tag']=='USER')&&($element['type']=='close')) {
              $flag = 0;
              $i++;
         }
	if($element['tag']=='NAME') $items[$i]['username'] = $element['value'];
	if(($element['tag']=='IMAGE')&&($element['attributes']['SIZE']=='medium')) $items[$i]['image'] = $element['value'];
	if($element['tag']=='URL') $items[$i]['url'] = $element['value'];
	if($element['tag']=='WEIGHT') $items[$i]['weight'] = $element['value'];
    } 
    return $items; 
} 

function fetch_tags(){
    /* cURL parse*/
    $ch = curl_init("http://ws.audioscrobbler.com/1.0/artist/Dark+Project/toptags.xml");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $xml = curl_exec($ch);
    curl_close($ch);
 
    $xml_data = $xml;
    $parser = xml_parser_create(); 
    xml_parse_into_struct($parser, $xml_data, &$assoc_arr, &$idx_arr); 
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
    $root_tag = $assoc_arr[0]['tag']; 
    $base_tag = strtolower($assoc_arr[1]['tag']); 
    $i = 0; 
    foreach($assoc_arr as $key => $element){ 
        if($element['tag'] != $root_tag){ 
            if(!preg_match('/^\s+$/', $element['value'])){ 
                $tag = strtolower($element['tag']); 
                if(($tag!=$root_tag)&&($tag!=$base_tag)) $items[$i][$tag] = $element['value']; 
                if($tag == $base_tag){ 
                    $i++; 
                } 
            } 
        } 
    } 

    return $items; 
} 

function fetch_toptracks(){
    /* cURL parse*/
    $ch = curl_init("http://ws.audioscrobbler.com/1.0/artist/Dark+Project/toptracks.xml");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $xml = curl_exec($ch);
    curl_close($ch);
 
    $xml_data = $xml;
    $parser = xml_parser_create(); 
    xml_parse_into_struct($parser, $xml_data, &$assoc_arr, &$idx_arr); 
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
    $root_tag = $assoc_arr[0]['tag']; 
    $base_tag = strtolower($assoc_arr[1]['tag']); 
    $i = 0; 
    foreach($assoc_arr as $key => $element){ 
        if($element['tag'] != $root_tag){ 
            if(!preg_match('/^\s+$/', $element['value'])){ 
                $tag = strtolower($element['tag']); 
                if(($tag!=$root_tag)&&($tag!=$base_tag)) $items[$i][$tag] = $element['value']; 
                if($tag == $base_tag){ 
                    $i++; 
                } 
            } 
        } 
    } 

    return $items; 
} 

function fetch_recent($user){
    /* cURL parse*/
    $url = 'http://ws.audioscrobbler.com/1.0/user/'.$user.'/recenttracks.xml';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $xml = curl_exec($ch);
    curl_close($ch);
 
    $xml_data = $xml;
    $parser = xml_parser_create(); 
    xml_parse_into_struct($parser, $xml_data, &$assoc_arr, &$idx_arr); 
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
    $root_tag = $assoc_arr[0]['tag']; 
    $base_tag = strtolower($assoc_arr[1]['tag']); 
    $i = 0; 
    foreach($assoc_arr as $key => $element){ 
        if($element['tag'] != $root_tag){ 
            if(!preg_match('/^\s+$/', $element['value'])){ 
                $tag = strtolower($element['tag']); 
                if(($tag!=$root_tag)&&($tag!=$base_tag)) $items[$i][$tag] = $element['value']; 
                if($tag == $base_tag){ 
                    $i++; 
                } 
            } 
        } 
    } 

    return $items; 
} 

function fetch_blogfeed($blog,$type){
    /* cURL parse*/
    if (strpos(strtolower($blog),'http://')===false) $blogurl = 'http://'.$blog;
    else $blogurl = $blog;
    if ($type=='blogger') $blogurl = 'http://'.$blog.'.blogspot.com/feeds/posts/default?alt=rss';
    if ($type=='lj') $blogurl = 'http://'.$blog.'.livejournal.com/data/rss';
    if ($type=='wp') $blogurl = 'http://'.$blog.'.wordpress.com/feed/';
    if ($type=='flickr') $blogurl = 'http://api.flickr.com/services/feeds/photos_public.gne?id='.$blog.'&lang=en-us&format=rss_200';
    if ($type=='picasa') $blogurl = 'http://picasaweb.google.com/data/feed/base/user/'.$blog.'?alt=rss&kind=photo&hl=en_US';
    $ch = curl_init($blogurl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $xml = curl_exec($ch);
    curl_close($ch);
    $xml_data = $xml;
    $parser = xml_parser_create(); 
    xml_parse_into_struct($parser, $xml_data, &$assoc_arr, &$idx_arr); 
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
    $i = 1;
    $flag = 0;
    foreach($assoc_arr as $key => $element) { 
         if (($element['tag']=='ITEM')&&($element['level']=='3')&&($element['type']=='open')) $flag = 1;
         if (($element['tag']=='ITEM')&&($element['level']=='3')&&($element['type']=='close')) {
              $flag = 0;
              $i++;
         }
         if (($flag==0)&&($element['tag']==TITLE)) $items[0]['title'] = $element['value'];
         if ($flag==1) {
              if ($element['tag']=='GUID') {
                   $guid = $element['value'];
                   $pos = strpos($guid, 'post-');
                   if ($pos===false) $postid = $guid;
                   else {
                      $postid = substr($guid, $pos + 5);
                      $pos1 = strpos($guid, 'blog-');
                      $items[$i]['blogid'] = substr($guid, $pos1 + 5, $pos-$pos1-6);
                   }
                   $items[$i]['postid'] = $postid;
              }
              if($element['tag']=='PUBDATE') $items[$i]['pubdate'] = $element['value'];
              if($element['tag']=='DC:DATE') $items[$i]['pubdate'] = $element['value'];
              if($element['tag']=='TITLE') $items[$i]['title'] = $element['value'];
              if($element['tag']=='DESCRIPTION') $items[$i]['description'] = $element['value'];
              if($element['tag']=='CONTENT:ENCODED') {
                   $content = $element['value'];
                   $feedburnerpos = strpos($content,'<div class="feedflare">');
                   if ($feedburnerpos===false) $items[$i]['description'] = $content;
                   else $items[$i]['description'] = substr($content,0,$feedburnerpos);
                   $wordpresspos = strpos($content,'<a rel="nofollow" href="');
                   if ($wordpresspos===false) $items[$i]['description'] = $content;
                   else $items[$i]['description'] = substr($content,0,$wordpresspos).'</div>';
              }
              if($element['tag']=='LINK') $items[$i]['permalink'] = $element['value'];
              if($element['tag']=='FEEDBURNER:ORIGLINK') $items[$i]['permalink'] = $element['value'];
              if(($element['tag']=='DESCRIPTION')&&($type=='picasa')) {
                   $content = $items[$i]['description'];
                   $picasapos = strpos($content,'</td>');
                   if ($picasapos===false) $items[$i]['description'] = $content;
                   else $items[$i]['description'] = substr($content,strlen('<table><tr><td style="padding: 0 5px">'),$picasapos-strlen('<table><tr><td style="padding: 0 5px">'));
              }

         }
    } 

    return $items; 
}

function fetch_blogcomments($blog,$postid){
    /* cURL parse*/
    $blogurl = 'http://'.$blog.'.blogspot.com/feeds/'.$postid.'/comments/default?alt=rss';
    $ch = curl_init($blogurl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $xml = curl_exec($ch);
    curl_close($ch);
    $xml_data = $xml;
    $parser = xml_parser_create(); 
    xml_parse_into_struct($parser, $xml_data, &$assoc_arr, &$idx_arr); 
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
    $i = 0; 
    $flag = 0;
    foreach($assoc_arr as $key => $element) { 
         if (($element['tag']=='ITEM')&&($element['level']=='3')&&($element['type']=='open')) $flag = 1;
         if (($element['tag']=='ITEM')&&($element['level']=='3')&&($element['type']=='close')) {
              $flag = 0;
              $i++;
         }
         if ($flag==1) {
              if($element['tag']=='GUID') {
                   $guid = $element['value'];
                   $pos = strpos($guid, 'post-');
                   $postid = substr($guid, $pos + 5);
                   $items[$i]['postid'] = $postid;
              }
              if($element['tag']=='PUBDATE') $items[$i]['pubdate'] = $element['value'];
              if($element['tag']=='TITLE') $items[$i]['title'] = $element['value'];
              if($element['tag']=='DESCRIPTION') $items[$i]['description'] = $element['value'];
              if($element['tag']=='LINK') $items[$i]['permalink'] = $element['value'];
         }
    } 

    return $items;
}

function fetch_video($user){
    /* cURL parse*/
    $ch = curl_init('http://gdata.youtube.com/feeds/api/users/'.$user.'/uploads?orderby=updated');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $xml = curl_exec($ch);
    curl_close($ch);

    $xml_data = $xml;
    $parser = xml_parser_create(); 
    xml_parse_into_struct($parser, $xml_data, &$assoc_arr, &$idx_arr); 
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
    $i = 0; 
    $flag = 0;
    foreach($assoc_arr as $key => $element) { 
         if (($element['tag']=='MEDIA:GROUP')&&($element['level']=='3')&&($element['type']=='open')) $flag = 1;
         if (($element['tag']=='MEDIA:GROUP')&&($element['level']=='3')&&($element['type']=='close')) {
              $flag = 0;
              $i++;
         }
         if ($flag==1) {
              if($element['tag']=='MEDIA:PLAYER') {
                   $guid = $element['attributes']['URL'];
                   $pos = strpos($guid, 'v=');
                   $postid = substr($guid, $pos + 2);
                   $items[$i]['postid'] = $postid;
              }
              if($element['tag']=='PUBDATE') $items[$i]['pubdate'] = $element['value'];
              if($element['tag']=='MEDIA:TITLE') $items[$i]['title'] = $element['value'];
              if($element['tag']=='MEDIA:DESCRIPTION') $items[$i]['description'] = $element['value'];
              if($element['tag']=='MEDIA:THUMBNAIL') $items[$i]['thumbnail'] = $element['attributes']['URL'];
              if($element['tag']=='MEDIA:PLAYER') $items[$i]['permalink'] = $element['attributes']['URL'];
         }
    } 

    return $items;
}
?>