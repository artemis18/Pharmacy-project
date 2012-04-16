function saveTrueFalseQuestion(Qtext, Qtrue){
var xmlhttp;
if(Qtrue.checked) { $Qtrue = true; } else { $Qtrue = false; }
//validation here
if(Qtext == null || Qtext == ""){
alert("Enter question text");
return;
} 
//end validation
if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else {// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}

xmlhttp.onreadystatechange=function(){
if (xmlhttp.readyState==4 && xmlhttp.status==200) {
alert("question saved");
}
//alert(xmlhttp.responseText);
}

//var $question = document.getElementById('question').value;
//var $true = document.getElementById('true').value;
var queryString = "?question=" + Qtext + "&true=" + $Qtrue ;
xmlhttp.open("GET", "saveTrueFalseQuestion.php" + queryString, true);
xml