<?php
include('mysql_connect.php');
$query="select * from counter where pass='12345'";
$x=mysql_query($query) or die(mysql_error());
$infest=mysql_num_rows($x);
if ($infest==0) echo('x');

$result=mysql_fetch_array($x);
$counter=$result['counter'];
$counter++;
echo $counter;
$query="UPDATE counter SET counter='".$counter."' WHERE pass='12345' LIMIT 1";
$x=mysql_query($query) or die(mysql_error());
?>
