<?php
$connect = @mysql_connect("localhost", "darkproj_site", "Hav3faith") or die("Could not connect to the database.");
if ($connect) $dbconfirm = mysql_select_db("darkproj_site");
if (!$dbconfirm) die("Problems connecting to database. (Possibly) Database not found.");
?>