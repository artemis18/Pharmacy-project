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
			function saveQuestion($Qtype ,$Qtext ){
				    {//ajax
						var xmlhttp;
			
						if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
						  xmlhttp=new XMLHttpRequest();
						}
						else {// code for IE6, IE5
						  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						}
						
						xmlhttp.onreadystatechange=function(){
						  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
							// action on completion of processing
						  }
						}
						queryString = "?QText = " + $Qtext + "&QType = " + qType;
						xmlhttp.open("GET", "saveQuestion.php" + queryString, true);
						xmlhttp.send(null);
					}
					
			}
			function editQuestion(Qtype){
				switch(Qtype){
				case "Multiple_choice" : alert("Multiple_choice load"); //window.open("test.php");
				break;
				case "True_False" :alert("True_False load"); //window.open("");
				break;
				default: alert("error");
				}
			}
			
			function createform(){
				var selection = document.getElementById("questionType");
				var selectionText = selection[selection.selectedIndex].text;
			
				$form = '<form> ';
				$form += '<label>Question text: <input type = "text" name = "qText"></label>';
				$form += '<label>questionType: <input type = "text" name = "qType" disabled = "true"'; 
				$form += 'value ="';
				$form += selectionText;
				$form += '"';
				$form += '/></label>';
				$form += '<input type = "button" value = "save" onclick = "saveQuestion(qType.value,qText.value)"/>';
				$form += '<input type = "button" value = "edit" onclick = "editQuestion(qType.value)"/>';
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