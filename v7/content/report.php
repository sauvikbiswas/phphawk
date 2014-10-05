<?php
$ticketid = trim($HTTP_GET_VARS['ticketid']);

if ($ticketid=="") $ticketid='r'.rand(100,999).'t'.time();
echo($ticketid);
?>