<!--
	Author: Purav Upadhyay
	Date: 12/04/2012
	Last Edit: 04/04/2012
	Edited By: Purav Upadhyay
	Purpose of the Script: The purpose of this script allows the user to view, rename and edit a published or unpublished test 
	selected by the user from the Test Manager. The script allows the user to add and remove scenarios to a particular test. 
-->

<?php
	//Connecting to the database.
	$connect = mysql_connect("localhost", "root", "") or die("Couldn't connect!");
	mysql_select_db("pharmacy_new") or die("Couldn't find the database!");
	//Starting the session
	session_start();
	//Declaring a variable to store the current test.
	$currentTest;
	//Saving the session to the currentTest if the 'testSelection' button is pressed and a test is selected from the 'testList'
	if(array_key_exists('testSelection',$_POST) || array_key_exists('testList',$_POST)){
		$currentTest = $_POST['testList'];
		$_SESSION['testList'] = $currentTest;
	}		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<?php
	//Saving the session to the variable after the user presses 'createNewTest' button.
	$currentTest = $_SESSION['testList'];
	//Getting the test name depending on the testID.
	$testNameQuery = mysql_query("select * from test where testID = '$currentTest'");
	$row = mysql_fetch_array($testNameQuery);
	$testName = $row['testName'];
	//Also saving the description
	$testDescription = $row['description'];
?>
    <head>
	<?php
        echo "<title>$testName</title>";
	?>
	
	<script type="text/javascript">
	function close_window() {
		//If the user presses ok, the window will be closed.
		return confirm("Any unsaved data wil be lost. Quit working on this test?");
		
	}
	
	function create_test(){
		//A confirmation for the user before they create a new test.
		return confirm("Any unsaved data wil be lost. Create a new test?"); 
		
	}
	
	function removeScenario(){
		//A confirmation for the user before they delete a scenario from database.
		return confirm("This scenario will be removed from the database. Continue?"); 
		
	}
	
	function help1(){
		myWindow=window.open("","","width=500,height=100");
		myWindow.document.write("<b>To edit</b> test name or description, change the test name or description and<br/> <b>click save test</b> or <b>Save and Exit</b> to exit at the same time.<br/> Create new test by clicking on 'CreateNewTest'");
		
	}
	function help2(){
		myWindow=window.open("","","width=500,height=300");
		myWindow.document.write("This section is about adding or removing a scenario to this test. (the one selected by you from the Test Manager).<br/><br/><b>Published Scenarios</b>: These are the scenarios which already exist in one or more tests.<br/><b>UnPublished Scenarios</b>: These scenarios are not linked to any tests.<br/><b>Scenarios For This Test</b>: These scenarios are linked to this perticular test.<br/><br/>To <b>add</b> a published or unpublished scenario to this test, select one from the list and click add. <br/>To remove a scenario from this test, select one from the list 'Scenarios For This Test' and click <b>Remove</b>.");
	}
	
	function modifyScenario()
	{
		document.myform.action ="scenarioCreator.php";
		document.myform.method ="POST";
		document.myform.target ="_self";
		document.myform.submit();             
	}
	
	</script>
	<link rel="stylesheet" type="text/css" href="mystyle.css" />
    </head>
	


	<body onload = "window.open('', '_self', '')">
	<div class = "banner"></div>
	
	<a class = "heading">Test Modification</a>
	<div class = "intro">
	Welcome to the Test Modifier.
	This page allows you to edit test details and create a new test. <br/>You can also remove, modify and add a new scenario to the test.</div>
	<div><hr size=1 align="left" color="black"></div>
	

	<table border = "0" style="background-color: #EBF0EB">
	<tr>
	
	<?php
		//A label for the user to let them know what test they're working on
		echo "<td colspan = '2' align = left'><h3>You are currently working on '$testName'";
	?>
	</td>
	<td align = "right">
	<!-- This form allows the user to exit the test by calling the javascript function close_window() -->
	<form action="testScenarioManager.php" method="POST" onsubmit="return close_window()" id = "frm">
		<input type = "submit" name = "exitTest" value = "Quit and Exit" />
		<input type = "button" name = "generalHelp" value = "Help!" onclick = "help1()"/>
	</form>
	<!-- This form allows the user to create new test, save the current changes and save and exit the test-->
	<form action = "testScenarioManager.php" method = "POST" onsubmit = "return create_test()">
		<input type = "submit" name = "createTest" value = "Create New Test"/>
	</form>
	
	</td></tr>
	
	
	<form action = "testScenarioManager.php" method = "POST" name = "myform">
	<?php 
		
		echo "<tr><td colspan = '3'><label>Test Name<input type = 'text' value = '$testName' size ='97' name = 'testName' id = 'test'/></label></td></tr>";
		echo "<tr><td colspan = '3'><label>Test Description<input type = 'text' value = '$testDescription' name = 'testDescription' id = 'description' size = '92'/></label>"; 
	?>
	
	</td></tr>
	<tr><td colspan = '3' align = "center">
	
	
	<input type = "submit" name = "saveTest" value = "Save Test"/>
	<input type = "submit" name = "saveExitTest" value = "Save and Exit"/>
	
	</td></tr>
	
	<tr><td colspan = "2"><h3><br/>Add or Remove Scenarios</h3></td>
	<td align = "right"><input type = "button" name = "scenarioHelp" value = "Help!" onclick = "help2()"/></td></tr>

	<tr></td></tr>

	<td><b>Published Scenarios<br/></b>
	<?php
		//This script retrieves all the scenarios from the table to create a list of published scenarios for the user to select from.
		$result = mysql_query("select distinct scenario.scenarioName, scenario.ScenarioID from scenario, scenario_collection where scenario.ScenarioID = scenario_collection.ScenarioID AND scenario.Published = 'yes';");
		//Creating a selection list and adding scenario names
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
		//This script retrieves all the unpublished scenarios from the table 
		$result = mysql_query("select scenarioName, ScenarioID from scenario where Published ='no';");
		
		//Creating a multi select option bar and adding scenario names
			echo '<select style="vertical-align: top; width: 200px;" size="10" name="unPubScenarios" multiple="single">';
			while($row = mysql_fetch_array($result)) {
				//Saving the scenarioID as a value and name as an option text
				$scenario = $row['scenarioName'];
				$scenarioID = $row['ScenarioID'];
				echo "<option value= '$scenarioID' > $scenario </option>";
			}
			echo "</select>";
		?>
		<p align = "center"><input type = "submit" name = "addScenario" value ="Add"/>
		
		<input type = "submit" name = "removeUnPublished" value ="Remove" disabled = "true"/></p>
	</td>
	<td><b>Scenarios for this Test<br/></b>
	<?php
		//This script retrieves all the scenarios which are linked to this perticualr test
		$result = mysql_query("select * from scenario,scenario_collection where scenario_collection.testID = '$currentTest' AND scenario_collection.ScenarioID = scenario.ScenarioID;");
		$count = mysql_num_rows($result);
		//Creating a multi select option bar and adding scenario names
			echo '<select style="vertical-align: top; width: 200px;" size="10" name="testScenarios" multiple="single">';
			while($row = mysql_fetch_array($result)) {
				//Saving the scenarioID as a value and name as an option text
				$scenario = $row['scenarioName'];
				$scenarioID = $row['ScenarioID'];
				echo "<option value= '$scenarioID' > $scenario </option>";
				}
			echo "</select>";
		?>
	
		<p align = "center">
		
		<?php
			if($count == 0){
			echo '<input type = "button" name = "modify" value = "Modify" onclick = "modifyScenario()" disabled = "true"/>';
			echo '<input type = "button" name = "removeFromTest" value ="Remove" disabled = "true"/>';
		}
		else{
			echo '<input type = "button" name = "modify" value = "Modify" onclick = "modifyScenario()"/>';
			echo '<input type = "submit" name = "removeFromTest" value ="Remove" />';

		}
		?>
		</p>
	</form>
	</td>
	
</table>
<br/>
	<?php
		//Adding an unpublished scenario to the test.
		if(array_key_exists('addScenario',$_POST) && array_key_exists('unPubScenarios',$_POST)){
			$unPublishedScenario = $_POST['unPubScenarios'];
			compareAdd($unPublishedScenario, $currentTest);
		}
		//A message for the user if there are not any scenarios selected.
		elseif(array_key_exists('addScenario',$_POST)){
			echo "Select an <b>unpublished scenario</b> before clicking the 'Add' button.";
		}

		//Adding a past scenario to the test.
		if(array_key_exists('addFromPast',$_POST) && array_key_exists('pastScenarios',$_POST)){
			$selectedPastScenario = $_POST['pastScenarios'];
			compareAdd($selectedPastScenario, $currentTest);
		}
		//A message for the user if there are not any scenarios selected.
		elseif(array_key_exists('addFromPast',$_POST)){
			echo "Select a <b>past scenario</b> before clicking the 'Add' button.";
		}

		//Removing a scenario from the current test
		if(array_key_exists('removeFromTest',$_POST) && array_key_exists('testScenarios',$_POST)){
			$selectedTestScenario = $_POST['testScenarios'];
			compareRemove($selectedTestScenario, $currentTest);
		}
		//A message for the user if there are not any scenarios selected.
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
		//A message for the user if there are not any scenarios selected.
		elseif(array_key_exists('removeUnPublished',$_POST)){
			echo "Select a scenario from the <b>unpublished scenarios</b> before clicking the 'Remove' button.";
		}
		
		
		//Checking if the scenario is already in the test and add if not
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
			//If not then add
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
		//Check if the scenario is linked to the test and remove if it is.
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
		die ('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=testManager.php">');
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
				//Saving the new test id to the current session
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
		//Ending this session
		session_destroy();
		//Starting a new session with a blank testID
		session_start();
		$_SESSION['testList'] = "";
		$currentTest = $_SESSION['testList'];
		//Refreshing the page to allow the user to create a new test.
		die ('<META HTTP-EQUIV="Refresh" CONTENT="0;URL=testScenarioManager.php">');		
	}
	?>	
</body>