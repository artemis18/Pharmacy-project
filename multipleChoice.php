<html>
<head>
<title>Multiple Choice</title>
	<script type="text/javascript">
	function options()
	{	
		var i = 0;
		for(i = 0; i<5; i++){
		//create radio buttons
		var area = document.getElementById("questionArea");
		var radio = document.createElement("input");
		radio.type = "radio";
		radio.name = "options";
		//Creating labels
		var optionLabel = document.createTextNode("Option");
		var feedbackLabel = document.createTextNode("Feedback");
		//Creating text boxes
		var optionTextBox = document.createElement("input");
		optionTextBox.type = "text";
		optionTextBox.name = "option"+i;
		var feedbackTextBox = document.createElement("input"); 
		feedbackTextBox.type = "text";
		feedbackTextBox.name = "feedback"+i;	
		//Adding a line break
		var lineBreak = document.createElement("br");
		//Appending the elements to the web document
		area.appendChild(radio);
		area.appendChild(optionLabel);
		area.appendChild(optionTextBox);
		area.appendChild(feedbackLabel);
		area.appendChild(feedbackTextBox);
		area.appendChild(lineBreak);
		}
	}
	</script>
</head>

<h2>Multiple Choice Question</h2>
<?php
	
?>
	<body onload = "window.open('', '_self', '')">

	
	
	<table border = '0' style="background-color: #EBF0EB">
	<tr><td colspan = "5">
		<form action = 'multipleChoice.php' method = 'POST'>
			<b>Possible Number of Options:</b><select name = 'numOptions'>
			<?php
			for($i=2;$i<=5;$i++) {
				echo "<option value=\"$i\">$i</option>\n";
			}
			?>
			</select>
			<input type = 'submit' value = 'GO' name = 'submit'/>
		</form>
	</td>
	</tr>
	
		<form action = "questionSummary.php" method = "POST">
		<tr>
		<td colspan = "2" align = "center"><b>Type the Question</b><br/><textarea rows = "5" columns = "15" name = "questionText"></textarea></td>
		<td></td>
		<td><b>Select Answer Numbring</b><br/><br/>
		<b>Select Answer Orientation</b>
		</td>
		<td>
		<p align = "center">
			<select name = "ansNumbring">
			<option value = "numbers">1, 2, 3</option>
			<option value = "abcCaps">A, B, C</option>
			<option value = "abcSmall">a) ,b), c)</option>
			<option value = "roman">I, II, III</option>
			</select></p>
		<p align = "center">
			<select name = "ansOrientation">
			<option value = "horizontal">Horizontal</option>
			<option value = "vertical">Vertical</option>
			</select></p>
		</td>
		</tr>
		
		<tr><td><br/></td></tr>

		<tr><td colspan = "5" id = "questionArea">
		
			<?php
			$numOptions = "";
			
			if(array_key_exists('submit',$_POST)){
				$numOptions = $_POST['numOptions'];
				echo "<input type = 'hidden' value = '$numOptions' name = 'numOptions'/>";
				echo "
				Answer
				<input type = 'text' name = 'answer'/>
				Feedback
				<input type = 'text' name = 'ansFeedback'/>
				<br/>
				";
			}
			
				for($i=2;$i<=$numOptions;$i++) {
					$option = 'Option'.$i;
					echo $option;
					echo "<input type = 'text' name = '$option'/>";
					$feedback = 'Feedback'.$i;
					echo $feedback;
					echo "<input type = 'text' name = '$feedback'/>";
					echo '<br/>';
					
				}
			?>
		</td>
			
		</tr>
		<tr><td colspan = "5">
		<p align = "center">
			<input type = "button" name = "cancel" value ="Cancel" onclick = "window.close()"/>
			<input type = "reset" name = "reset" value ="Reset"/>
			<input type = "submit" name = "submitAll" value ="Submit"/>
		</p>
		</td></tr>
		</form>
		
		</tr>
		</table>	
	</body>
</html>
