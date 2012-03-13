<?php
	$connect = mysql_connect("localhost", "root", "") or die("Couldn't connect!");
	mysql_select_db("pharmacy_new") or die("Couldn't find the database!");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml">
	<style>
	#container{
	width:600px;
	padding: 5px;  
	background-color: #EBF0EB;
	}
	
	#publishedTests{
	
	}
	
	#unpublishedTests{
	
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
			<form action = "testManager.php" method = "" style ="float: left;" name="publishedTest" >
				
				<div id = "publishedTests">
						Published Tests
							<?php
							//unpublished tests
							$result = mysql_query("SELECT * FROM test WHERE releaseTime is not NULL;");
							echo '<select style="vertical-align: top;  width: 250px;"  
							size="15" name="unpublishedtest"  multiple="single"></select>';
							while($row = mysql_fetch_array($result)) {
								
								$test = $row['releaseTime'];
								
								echo "<option value= '$test' > $test </option>";
								}
							echo "</select>";
							?>
									<button disabled = "true" onclick="">View</button>
				</form>
				</div>
				<form action ="testManager.php" method ="">
						<?php
						$result = mysql_query("SELECT * FROM test WHERE releaseTime is NULL;");
						echo '<select id="unpublishedtest"  style="vertical-align: top;  width: 250px;"  size="15" name="unpublishedtest" onChange="pformdisplay(this.value);" multiple="multiple">
						</select> ';
						while($row = mysql_fetch_array($result)) {
						
						$test = $row['releaseTime'];
						
						echo "<option value= '$test' > $test </option>";
						}
					echo "</select>";
						?>
						<button onclick="">New Test</button> <button onclick="">Deploy Test</button> <button onclick="">Remove Test</button></td>
				</form>	
		</div>
	
	</body>
</html>



	  
