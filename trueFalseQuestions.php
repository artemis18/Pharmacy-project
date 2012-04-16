<?php

$db = mysql_connect("localhost", "root", "") or die("Couldn't connect!");
mysql_select_db("pharmacy_new") or die("Couldn't find the database!");
?>

<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>True and False Questions</title>
<script type="text/javascript" src="trueFalse.js"></script>
<h1> True and False Questions </h1>
</head>
<body>
<div >
<form action="" name="input" method='GET'>
Question: 
<input type="text" id="question" /> 
True:
<input type ="checkbox" value ="true" id="true_false" name ="true_false" />
<input type="button" Value="AddQuestion" onclick ="saveTrueFalseQuestion(question.value, true_false)" /> <br/>

</form>

</div>
<div id="add_question" >

</div>

</body>
</html>