<?php
	$question;
	$answer;
	$ansFeedback = "";
	$numOptions = "";
	$ansNumbring;
	$ansOrientation;
	if(array_key_exists('submitAll',$_POST)){
		$question = $_POST['questionText'];
		$answer = $_POST['answer'];
		$ansFeedback = $_POST['ansFeedback'];
		$numOptions = $_POST['numOptions'];
		$ansNumbring = $_POST['ansNumbring'];
		$ansOrientation = $_POST['ansOrientation'];
	}
	
	if($question == ""){
		echo("Please enter a question.");
	}
	elseif($answer == ""){
		echo("Please enter an answer.");
	}
	elseif($ansFeedback == ""){
		echo("Please enter an answer feeedback.");
	}
	else{
		echo $question;
		echo "<br/>";
		echo $answer;
		echo $ansFeedback;
		echo "<br/>";
		for($i=2;$i<=$numOptions;$i++) {
			$option = "Option".$i;
			$feedback = "Feedback".$i;
			echo $_POST["$option"];
			echo $_POST["$feedback"];
			echo "</br>";	
		}
		echo $ansNumbring;
		echo "<br/>";
		echo $ansOrientation;
	}
	echo '<br/><input type="button" value="Go Back" onclick="history.go(-1)"><br/>';
?>