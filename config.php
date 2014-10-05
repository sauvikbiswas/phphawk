<?php
$mastertablefile = "mastertable.txt";
$pass = "pass";
$imagelocation = "global";
$headcolorarray = array('1','48','104'); /* R, G, B */
$headsize = 150;
$headweight = 'normal'; /* Can be 'bold','normal' */
$headfont = 'Impact';
$headcustom = true;
$headtpl = '<div class="posttitle"><%head%></div>';

$striptag = array(
		"html",
		"body",
		"!doctype"
);

$striptagcontent = array(
		"title",
		"head"
);

/* Journal Configuration */
$journal = true; 
$jentriesdefault = 3;
$jheadcolorarray = array('1','48','104');
$jheadsize = 150;
$jheadweight = 'bold'; /* Can be 'bold','normal' */
$jheadfont = 'Impact';
$jcustom = true;
$jheadtpl = '<b><%jhead%></b> ';
$jsubtpl = '<small><i><%jsub%></i></small><br>';
$jbodytpl = '<%jbody%>';

/* Guestbook Configuration */
$guestbook = true;
$gtargetsubdir = '';
$gdatafile = 'guestdata.html';
$gnewlinetobreak = true;
$gdatatpl = '<!-- <%gemail%> / <%gurl%> --><b><font color="red"><%gname%></font></b><br><i><%gdate%></i><br> <%gcomments%><br><br>';
?>