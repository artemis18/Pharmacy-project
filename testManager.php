<?php
$connect = mysql_connect("localhost", "root", "") or die("Couldn't connect!");
mysql_select_db("pharmacy_new") or die("Couldn't find the database!");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd
">

<html xmlns="http://www.w3.org/1999/xhtml
">
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
<link rel="stylesheet" type="text/css" href="style.css"/>
<title> Test Manager</title>
<script type="text/javascript" src ="script.js"></script>
</head>

<body>
<h1> Test Manager </h1>
<p>Welcome to the Test Manager.<br/>
<b>Instructions: </b>From here you can either create a test
from existing questions, create a new test or remove a test </p>
<div id="container"> 
<form action = "testScenarioManager.php" style ="float: left;" name="publishedTest" method = "POST" target = "_blank">

<div id = "publishedTests">
Published Tests <br/>
<?php
	//This script shows all the tests.
	$result = mysql_query("select * from test where releaseTime is NULL;");
	echo "Select one of the tests to view.";
	echo "<br/>";
	//Creating a multi select option bar and adding scenario names
	echo '<select style="vertical-align: top; width: 200px;" size="15" name="testList" multiple="single">';
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
<br/><input type = "submit" value = "View Test" name = "testSelection" />
</form>
</div>
<div id = "unpublishedTests">
<form action ="testScenarioManager.php" style ="float: right;" name="unpublishedTest" method = "POST" target = "_blank">
Unpublished Tests <br/>
<?php
//This script shows all the tests.
$result = mysql_query("select * from test where releaseTime is NOT NULL;");
echo "Select one of the tests to view.";
echo "<br/>";
//Creating a multi select option bar and adding scenario names
echo '<select style="vertical-align: top; width: 200px;" size="15" name="testList" multiple="single">';
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
<br/><input type = "submit" value = "View Test" name = "testSelection"/> <button onclick="">Deploy Test</button> <button onclick="">Remove Test</button></td>
</form>	
</div>

</body>
</html>

