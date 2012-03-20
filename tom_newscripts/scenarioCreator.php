<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?xml version="1.0" encoding="UTF-8"?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<style>
	#container{
	position:absolute;
	width:760px;
	top:-40px;
	padding:35px;
	}
	#prescriptionForm{
	position:relative;
	float:left;
	border-width:2px;
	border-style:dotted;
	border-color:black;
	width:350px;
	height:350px;
	margin:5px;
	}
	#patientForm{
	position:relative;
	float:right;
	border-width:2px;
	border-style:dotted;
	border-color:black;
	width:350px;
	padding:15px;
	margin:5px;

	}
	#addQuestionForm{
	position: relative;
	float:bottom;
	float:center;
	border-width:2px;
	border-style:dotted;
	border-color:black;
	width:750px;
	overflow:auto;
	}
	#scenarioname{
	border-width:2px;
	border-style:dotted;
	border-color:black;
	padding:15px;
	margin:5px;
	}
	#Qformdiv{
	position: relative;
	border-width:2px;
	border-style:dotted;
	border-color:black;
	width: 715px;
	padding:15px;
	margin-top:5px;
	}
	#questionForm{
	position:relative;
	width: 750px;
	overflow: auto;
	margin:5px;
	}
	</style>
	<head>
		
		<title> Scenario Creator</title>	
		<script type="text/javascript" language="javascript">   
			function createform(){
				$selection = document.getElementById("questionType").selectedIndex;
				$selectionText = document.getElementByID("questionType")[$selection].text;
			
				$form = '<form> ';
				$form += '<label>Question text: <input type = "text" name = "text area"></label>';
				$form += '<label>questionType: <input type = "text" name = "qType" disabled = "true"'; 
				$form += 'value ="';
				$form += $selectionText;
				$form += '"';
				$form += '/></label>';
				$form += '</form>';
			
			return $form;
		}
		function questionCreate() {       
        var createQform = document.createElement("div");
        createQform.id = "Qformdiv";
        createQform.innerHTML = createform(); 
        document.getElementById("questionForm").appendChild(createQform);
		}

</script>		
	</head>
	<body>	

	<div id="container">
		<h1> Scenario Creator</h1>
		<div id = "scenarioname">
			<form>
				<label> scenario name: <input type = "text" name="scenarioName"/> </label><br/>
				<label> select prescription form <br/>
				<textArea name = "prescriptions"> </textarea> </label>
				 <input type = "submit" value = "save" />

			</form>
		</div>
		 <div id= "prescriptionForm" >
			<p>prescription will go here</p>
		 </div>
		 
		 <div id = "patientForm">
			<p>patients details</P>
			 <form>
			 <label> name: <input type = "text" size="46px" name="name"/> </label><br/>
			 <label> age: <input type = "text" size ="48px"name="age"/> </label><br/>
			 <label> address: <input type = "text" size = "43px" name="address"/> </label> <br/>
			 <label> additional details <br/><textarea 
			 rows="10" cols = "40" name = "additional"> </textarea> </label>
			 </form>
		</div>
		 <div id = "questionForm">
		 <!-- something to display question form(s)-->
		 <!-- end questions forms-->
		 </div>
		 <div id= "addQuestionForm">
		 <form name = "addQuestion" method = "post">
			 <label> Select question type: 
				 <select id = "questionType">
				 <option> Multiple_choice</option>
				 <option> True_False</option>
				 </select>
			</label>
			 <input type = "button" value = "add" onclick = "questionCreate()" />
		 </form>
		 </div>
	 </div>
	</body>
</html>