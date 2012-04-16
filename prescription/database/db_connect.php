<?php

require_once("database.php");

//Connect path to the database
$con = mysql_connect($db_host, $db_username, $db_password);
$db = mysql_select_db($db_database, $con);

//If unable to connect or select database show suitable error messages
if (!$con) die("Was unable to connect to the server");
if (!$db) die("Was unable to connect to the database");
?>
