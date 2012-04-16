<?php
$db = mysql_connect("localhost", "root", "") or die("Couldn't connect!");
mysql_select_db("pharmacy_new") or die("Couldn't find the database!");
$question = $_REQUEST['question'];
$true = $_REQUEST['true'];
$query = 'INSERT INTO question_true_false VALUES ( "" ,' .'"' . $question . '"'. ','. $true . ');';
mysql_query($query) or die(mysql_error()); 
?>