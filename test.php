<html>
<body>
	<form action = "testScenarioManager.php" method = "POST">
	<?php
	
	$connect = mysql_connect("localhost", "root", "") or die("Couldn't connect!");
	mysql_select_db("pharmacy_new") or die("Couldn't find the database!");
	
	//Code to allow the user to select the test type.
	$selectTest = "";
	$selected = "";
	$testName = "";
	$add = "";	
	//This script shows all the tests.
	$result = mysql_query("select * from test;");
	echo "Select one of the tests to view.";
	echo "<br/>";
	//Creating a multi select option bar and adding scenario names
		echo '<select style="vertical-align: top; width: 200px;" size="5" name="testList" multiple="single">';
		echo "<option value= 'No Test Selected' selected = 'selected'> Select a test </option>";
		while($row = mysql_fetch_array($result)){
			//Getting the scenarioID
			$testID = $row['testID'];
			$testName = $row['testName'];
			echo "<option value= '$testID'> $testName </option>";
			}
			echo "</select>";
			echo "<br/>";
		
?>
	<input type = "submit" value = "View Test" name = "testSelection"/>
	</form>
</body>
</html>



