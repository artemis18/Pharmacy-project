<?php
$connect = mysql_connect("localhost", "root", "") or die("Couldn't connect!");
mysql_select_db("pharmacy_new") or die("Couldn't find the database!");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<style>
#container{
position: absolute;
overflow: auto;
margin: auto; 
width:600px;
padding: 5px; 
background-color: #EBF0EB;
}

#publishedTests{
position: relative;
float: left;

border-width: 1px;
width: auto;
height: 450px;
overflow: auto;
padding: 5px;
margin: 5px;

}

#unpublishedTests{
position: relative;
float: right;
float: center;
border-width: 1px;
width: auto;
height: 450px;
overflow: auto;
padding: 5px;
margin: 5px;
}

</style>

<head> 
	
	
	<script type="text/javascript" src ="script.js"></script>
	<link rel="stylesheet" type="text/css" href="mystyle.css" />
</head>
<title> Test Manager</title>
<body>


<div class = "banner"></div>
<a class = "heading">Test Manager</a>
<div class = "intro">Welcome to the Test Manager.<br/>
From here you can either create a test
from existing questions, create a new test or remove a test</div>

<div><hr size=1 align="left" color="black"></div>
	
	
<div id="container"> 
<form action = "testScenarioManager.php" style ="float: left;" name="publishedTest" method = "POST">

<div id = "publishedTests">
Published Tests <br/>
<?php
	//This script shows all the tests.
	$result = mysql_query("select * from test where CURRENT_TIMESTAMP <= releaseTime;");
	echo "Select one of the tests to view.";
	echo "<br/>";
	//Creating a multi select option bar and adding scenario names
	echo '<select style="vertical-align: top; width: 200px;" size="15" name="testList" multiple="single">';
	echo "<option value= 'Blank Test' selected = 'selected'> Create a blank test </option>";
	while($row = mysql_fetch_array($result)){
	//Getting the scenarioID
	$testID = $row['testID'];
	$testName = $row['testName'];
	echo "<option value= '$testID'> $testName </option>";
	}
	echo "</select>";
	echo "<br/>";

?>
<br/><input type = "submit" value = "View Test" name = "testSelection" />
</form>
</div>
<div id = "unpublishedTests">
<form action ="testScenarioManager.php" style ="float: right;" name="unpublishedTest" method = "POST" >
Unpublished Tests <br/>
<?php
//This script shows all the tests.
	$result = mysql_query("select * from test where releaseTime is NULL;");
	echo "Select one of the tests to view.";
	echo "<br/>";
	//Creating a multi select option bar and adding scenario names
	echo '<select style="vertical-align: top; width: 200px;" size="15" name="testList" multiple="single">';
	echo "<option value= 'Blank Test' selected = 'selected'> Create a blank test </option>";
	while($row = mysql_fetch_array($result)){
	//Getting the scenarioID
	$testID = $row['testID'];
	$testName = $row['testName'];
	echo "<option value= '$testID'> $testName </option>";
	}
	echo "</select>";
	echo "<br/>";

?>
	<br/><input type = "submit" value = "View Test" name = "testSelection"/> 
	<input type = "submit" value = "Deploy Test" name = "deployTest" disabled = "true"/> 
	<input type = "submit" value = "Remove Test" name = "removeTest" disabled = "true"/>
	</form>	
</div>
</body>
</html>

