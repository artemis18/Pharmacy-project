<?php
	#purpose:run an insert query to save questions
	include("db_connect.php");
	$query = "INSERT INTO" . $QuestionType . "VALUES" .  $Qtext . " ; ";
	mysql_query($query);
?>