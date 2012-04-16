<?php
	$db_host = "localhost";
	$db_username = "root";
	$db_password = "root";
	$db_database = "pharmacy_new";

    $con = mysql_connect($db_host, $db_username, $db_password) or die("Couldn't connect!");
    $db = mysql_select_db($db_database, $con)or die("Couldn't find the database!");
?>