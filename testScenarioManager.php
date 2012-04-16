<?php
	$connect = mysql_connect("localhost", "root", "") or die("Couldn't connect!");
	mysql_select_db("pharmacy_new") or die("Couldn't find the database!");

	session_start();
	$currentTest;
	if(array_key_exists('testSelection',$_POST) && array_key_exists('testList',$_POST)){
		$currentTest = $_POST['testList'];
		$_SESSION['testList'] = $currentTest;
	}		
?>

<!DOCTYPE "html"><html>
<?php
	$currentTest = $_SESSION['testList'];
	$testNameQuery = mysql_query("select * from test where testID = '$currentTest'");
	$row = mysql_fetch_array($testNameQuery);
	$testName = $row['testName'];
	$testDescription = $row['description'];
?>
    <head>
	<?php
        echo "<title>$testName</title>";
	?>
	
	<script type="text/javascript">
	function close_window() {
		if (confirm("Any unsaved data wil be lost. Close this test?")) {
		close();
		}
	}
	
	function create_test(){
		if (confirm("Any unsaved data wil be lost. Create new test?")) {
		
		}
	}
	</script>
    </head>
	

<h1>Test Modification</h1>



<body onload = "window.open('',_self','')">
	<table border = "0" style="background-color: #EBF0EB">
	<tr>
	
	<?php
		echo "<td colspan = '2' align = left'><h3>You are currently working on '$testName'";
	?>
	</td>
	<td align = "right">
	<form action="testScenarioManager.php" method="POST" onsubmit="close_window()" id = "frm">
	<input type = "submit" name = "exitTest" value = "Quit and Exit"/>
	<input type = "button" name = "generalHelp" value = "Help!" disabled = "true"/>
	</form>
	
	<form action = "testScenarioManager.php" method = "POST" >
	</td></tr>
	
	<?php 
		echo "<tr><td colspan = '3'><label>Test Name<input type = 'text' value = '$testName' size ='97' name = 'testName' id = 'test'/></label></td></tr>";
		echo "<tr><td colspan = '3'><label>Test Description<input type = 'text' value = '$testDescription' name = 'testDescription' id = 'description' size = '92'/></label>"; 
	?>
	
	</td></tr>
	<tr><td colspan = '3'>
	<p align = "center">
	<input type = "submit" name = "createTest" value = "Create New Test" onclick = "create_test()"/>
	<input type = "submit" name = "saveTest" value = "Save Test"/>
	<input type = "submit" name = "saveExitTest" value = "Save and Exit"/>
	
	</td></tr>
	
	<tr><td colspan = "2"><h3><br/>Add or Remove Scenarios</h3></td>
	<td align = "right"><input type = "button" name = "scenarioHelp" value = "Help!" disabled = "true"/></td></tr>

	<tr></td></tr>

	<td><b>Published Scenarios<br/></b>
	<?php
		//This script retrieves all the scenarios from the table 
		$result = mysql_query("select distinct scenario.scenarioName, scenario.ScenarioID from scenario, scenario_collection where scenario.ScenarioID = scenario_collection.ScenarioID AND scenario.Published = 'yes';");
		//Creating a multi select option bar and adding scenario names
			echo '<select style="vertical-align: top; width: 200px;" size="10" name="pastScenarios" multiple="single">';
			while($row = mysql_fetch_array($result)){
				//Getting the scenarioID
				$scenario = $row['scenarioName'];
				$scenarioID = $row['ScenarioID'];
				echo "<option value= '$scenarioID'> $scenario </option>";
			}
			echo "</select>";
		?>
	
	<p align = "center"><input type = "submit" name = "addFromPast" value ="Add"/>
						<input type = "button" name = "removeFromPast" value ="Remove" disabled = "true"/></p>
	</td>
	<td><b>Unpublished Scenarios</b><br/>	
		<?php
		//This script retrieves all the scenarios from the table 
		$result = mysql_query("select scenarioName, ScenarioID from scenario where Published ='no';");

		//Creating a multi select option bar and adding scenario names
			echo '<select style="vertical-align: top; width: 200px;" size="10" name="unPubScenarios" multiple="single">';
			while($row = mysql_fetch_array($result)) {
				//Getting the scenarioID
				$scenario = $row['scenarioName'];
				$scenarioID = $row['ScenarioID'];
				echo "<option value= '$scenarioID' > $scenario </option>";
			}
			echo "</select>";
		?>
		<p align = "center"><input type = "submit" name = "addScenario" value ="Add"/>
					   <input type = "submit" name = "removeUnPublished" value ="Remove"/></p>
	
	
	</td>
	<td><b>Scenarios for this Test<br/></b>
	<?php
		//This script retrieves all the scenarios from the table 
		$result = mysql_query("select * from scenario,scenario_collection where scenario_collection.testID = '$currentTest' AND scenario_collection.ScenarioID = scenario.ScenarioID;");
		$numRows = mysql_num_rows($result);

		//Creating a multi select option bar and adding scenario names
			echo '<select style="vertical-align: top; width: 200px;" size="10" name="testScenarios" multiple="single">';
			while($row = mysql_fetch_array($result)) {
				$scenario = $row['scenarioName'];
				$scenarioID = $row['ScenarioID'];
				echo "<option value= '$scenarioID' > $scenario </option>";
				}
			echo "</select>";
		?>
	
	<p align = "center"><input type = "button" name = "modifyScenario" value ="Modify" disabled = "true"/>
						<input type = "submit" name = "removeFromTest" value ="Remove"/></p>
	</td>
	</form>
</table>
<br/>
	<?php
		//Adding an unpublished scenario to the test.
		if(array_key_exists('addScenario',$_POST) && array_key_exists('unPubScenarios',$_POST)){
			$unPublishedScenario = $_POST['unPubScenarios'];
			compareAdd($unPublishedScenario, $currentTest);
		}
		elseif(array_key_exists('addScenario',$_POST)){
			echo "Select an <b>unpublished scenario</b> before clicking the 'Add' button.";
		}

		//Adding a past scenario to the test.
		if(array_key_exists('addFromPast',$_POST) && array_key_exists('pastScenarios',$_POST)){
			$selectedPastScenario = $_POST['pastScenarios'];
			compareAdd($selectedPastScenario, $currentTest);
		}
		elseif(array_key_exists('addFromPast',$_POST)){
			echo "Select a <b>past scenario</b> before clicking the 'Add' button.";
		}

		//Removing a scenario from the current test
		if(array_key_exists('removeFromTest',$_POST) && array_key_exists('testScenarios',$_POST)){
			$selectedTestScenario = $_POST['testScenarios'];
			compareRemove($selectedTestScenario, $currentTest);
		}
		elseif(array_key_exists('removeFromTest',$_POST)){
			echo "Select a scenario from the <b>current test</b> before clicking the 'Remove' button.";
		}


		//Removing an unpublished scenario 
		if(array_key_exists('removeUnPublished',$_POST) && array_key_exists('unPubScenarios',$_POST)){
			$selectedUnPublished = $_POST['unPubScenarios'];
			 mysql_query("delete from scenario where ScenarioID = '$selectedUnPublished'");
			 //Refreshing the page.
			 die ('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=testScenarioManager.php">');
		}
		elseif(array_key_exists('removeUnPublished',$_POST)){
			echo "Select a scenario from the <b>unpublished scenarios</b> before clicking the 'Remove' button.";
		}

		function compareAdd($selectedScenario, $currentTest){
		//Retrieving all the scenarios for this test
			$dbScenarioID = "";
			$thisTestScenarios = mysql_query("select * from scenario_collection where testID = '$currentTest' AND ScenarioID = '$selectedScenario';");
			while($rowTest = mysql_fetch_array($thisTestScenarios)){
				$dbScenarioID = $rowTest['ScenarioID'];
			}
			//Checking if the scenario is already in the database.
			//If it is then show this message.
			if($dbScenarioID){
				echo "Can not add this scenario. It already exists.";
			}
			//If not then remove it.
			else{
				//The queries to add and update the tables.
				$scenarioTable = mysql_query("update scenario set published = 'yes' where ScenarioID = '$selectedScenario';");
				$collectionTable = mysql_query("insert into scenario_collection values('$selectedScenario','$currentTest');");
				//If both queries are successful then the page will be refreshed.
				if($scenarioTable && $collectionTable){
					//Refreshing the page.
					die ('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=testScenarioManager.php">');
				}
			}
		}

		function compareRemove($selectedScenario, $currentTest){
			$dbScenarioID = "";
			//Checking if the scenario exists by retrieving the values
			$thisTestScenarios = mysql_query("select * from scenario_collection where ScenarioID = '$selectedScenario' AND testID = '$currentTest';");
			while($rowTest = mysql_fetch_array($thisTestScenarios)){
					$dbScenarioID = $rowTest['ScenarioID'];
				}
			if($dbScenarioID){
				//Remove the scenario and the test from the linked table
				$removing = mysql_query("delete from scenario_collection where ScenarioID = '$selectedScenario' AND testID = '$currentTest';");

				//If the same scenario is used in any other test then do nothing
				$searchPublished = mysql_query("select * from scenario_collection where ScenarioID = '$selectedScenario'");
				$rowCount = mysql_num_rows($searchPublished);
				if($rowCount){
					//echo "Scenario removed from this test. Note: this scenario is used in another test.";
				}
				//Else set Published = 'no'
				else{
					$setUnPublished = mysql_query("update scenario set Published = 'no' where ScenarioID = '$selectedScenario'");
					//echo "Scenario removed from this test. Note: The scenario is now an unpublished scenario.";
				}
				//Refresh the page
				die ('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=testScenarioManager.php">');
			}
			else{
				echo "Error! The scenario does not exist.";
			}
		}
	
	//Exit the test without saving
	if(array_key_exists('exitTest',$_POST)){
		//Ending the session
		session_destroy();
		//Set current test to nothing
		$currentTest = "";
		die();
	}
	
	//Save the test progress and exit
	if(array_key_exists('saveExitTest',$_POST)){
		//Ending the session.
		$currentTest = "";
		$newName = $_POST['testName'];
		$newDescription = $_POST['testDescription'];
		saveExit($newName, $newDescription);
		//Ending the session
		session_destroy();
		//Set current test to nothing
		$currentTest = "";
		//Refreshing the page
		die ('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=testManager.php">');
	}
	
	//Save the test progress
	if(array_key_exists('saveTest',$_POST)){
		//Receiving the user input
		$newName = $_POST['testName'];
		$newDescription = $_POST['testDescription'];
		//Call the function to save the test
		saveTest($newName, $newDescription);
		//Refresh the page
		die ('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=testScenarioManager.php">');
	}

	if(array_key_exists('createTest',$_POST)){
		//calling the function to create 
		createNewTest();
	}
	
	//function for save and exit
	function saveExit($newName,$newDescription){
		if($newName == "" || $newDescription == ""){
			//Do nothing because there is not any input
		}
		else{
			//if the user has pressed the create test button
			if ($_SESSION['testList'] == ""){
				//$currentTest = "notest";
				//then insert the user input into the database table "test".
				mysql_query("insert into test values ('','$newName','$newDescription', 2, NULL, NULL, NULL,'','');");
			}
			else{
				$currentTest = $_SESSION['testList'];
				//update the table by adding the new values
				//query to update the columns in test table:
				mysql_query("update test set description = '$newDescription', testName = '$newName' where testID = '$currentTest';");
			}
		}
	}
	
	//function for saving the changes
	function saveTest($newName,$newDescription){
		if($newName == "" || $newDescription == ""){
			//Do nothing because there is not any input
		}
		else{
			//if the user has pressed the create test button
			if ($_SESSION['testList'] == ""){
				//$currentTest = "notest";
				//then insert the user input into the database table "test".
				$adding = mysql_query("insert into test values ('','$newName','$newDescription', 2, NULL, NULL, NULL,'','');");
				$testName = $newName;
				$testDescription = $newDescription;	
				//Query to get the id of the recently added data
				$findingID = mysql_query("select testID,testName from test where testName = '$newName'");
				$newID = "";
				while($rowID = mysql_fetch_array($findingID)){
						$newID = $rowID['testID'];
					}
				$_SESSION['testList'] = $newID; 
			}
			else{
				$currentTest = $_SESSION['testList'];
				//update the table by adding the new values
				//query to update the columns in test table:
				mysql_query("update test set description = '$newDescription', testName = '$newName' where testID = '$currentTest';");		
			}
		}
	}
	
	//function for resetting the fields
	function createNewTest(){
		session_destroy();
		session_start();
		$_SESSION['testList'] = "";
		$currentTest = $_SESSION['testList'];
		die ('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=testScenarioManager.php">');		
	}
	?>	
</body>