var selected = new Array();
selected[1] = null;
selected[2] = null;
selected[3] = null;
selected[4] = null;
selected[5] = null;

function displaySelected(){

    var xmlhttp;
    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else{// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            //var div = document.getElementById("endorsement_" + i);
            var response = xmlhttp.responseText.split(";");
            
            var end1 = "<b>Drug:&nbsp;</b>" + response[0] + "<br/><b>Quantity:&nbsp;</b>" + response [1] + "<br/><b>Dosage:&nbsp;</b>" + response[2] + "<br/>";
            var end2 = "<b>Drug:&nbsp;</b>" + response[3] + "<br/><b>Quantity:&nbsp;</b>" + response [4] + "<br/><b>Dosage:&nbsp;</b>" + response[5] + "<br/>";
            var end3 = "<b>Drug:&nbsp;</b>" + response[6] + "<br/><b>Quantity:&nbsp;</b>" + response [7] + "<br/><b>Dosage:&nbsp;</b>" + response[8] + "<br/>";
            var end4 = "<b>Drug:&nbsp;</b>" + response[9] + "<br/><b>Quantity:&nbsp;</b>" + response [10] + "<br/><b>Dosage:&nbsp;</b>" + response[11] + "<br/>";
            var end5 = "<b>Drug:&nbsp;</b>" + response[12] + "<br/><b>Quantity:&nbsp;</b>" + response [13] + "<br/><b>Dosage:&nbsp;</b>" + response[14] + "<br/>";
            
            document.getElementById("endorsement_1").innerHTML = end1;
            document.getElementById("endorsement_2").innerHTML = end2;
            document.getElementById("endorsement_3").innerHTML = end3;
            document.getElementById("endorsement_4").innerHTML = end4;
            document.getElementById("endorsement_5").innerHTML = end5;  
        }
    }
    xmlhttp.open("GET","/prescription/ajax/endorsement.php?id=" + selected,true);
    xmlhttp.send();
}

function addSelected(endorsement_id){
    if(endorsement_id.length > 0){
        if(selected[1] == null){
            selected[1] = endorsement_id;
        }
        else if(selected[2] == null){
            selected[2] = endorsement_id;
        }
        else if(selected[3] == null){
            selected[3] = endorsement_id;
        }
        else if(selected[4] == null){
            selected[4] = endorsement_id;
        }
        else if(selected[5] == null){
            selected[5] = endorsement_id;
        }
        else{
            alert("You have selected the maximum number of endorsements");
        }
    }
    else{
        alert("Please select an endorsement.");
    }
    
    displaySelected();
}

function removeSelected(selected_id){
    selected[selected_id] = null;
    displaySelected();
}

function submitEndorsements(){
    var xmlhttp;
    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else{// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            //var div = document.getElementById("endorsement_" + i);
            var response = xmlhttp.responseText.split(";");
            var endorsements = "";
            if(selected[1] != null){
                endorsements += "<option selected value=\"" + selected[1] + "\">" + response[0] + "-" + response [1] + "-" + response[2] + "</option>";
            }
            if(selected[2] != null){
                endorsements +="<option selected value=\"" + selected[2] + "\">" + response[3] + "-" + response [4] + "-" + response[5] + "</option>";
            }
            if(selected[3] != null){
                endorsements +="<option selected value=\"" + selected[3] + "\">" + response[6] + "-" + response [7] + "-" + response[8] + "</option>";
            }
            if(selected[4] != null){
                endorsements +="<option selected value=\"" + selected[4] + "\">" + response[9] + "-" + response [10] + "-" + response[11] + "</option>";
            }
            if(selected[5] != null){
                endorsements +="<option selected value=\"" + selected[5] + "\">" + response[12] + "-" + response [13] + "-" + response[14] + "</option>";
            }
            
            document.getElementById("endorsements").innerHTML = endorsements;
        }
    }
    xmlhttp.open("GET","/prescription/ajax/endorsement.php?id=" + selected,true);
    xmlhttp.send();
    drawCanvas();
    hideElementCenter("add_endorsements");
}

function submitPatient(){
    document.getElementById("patient").style.color = '#000';
    document.getElementById("patient").value = document.getElementById("patient_id").innerHTML;
    drawCanvas();
    hideElementCenter("add_patient");
}

function submitPrescriber(){
    document.getElementById("prescriber").style.color = '#000';
    document.getElementById("prescriber").value = document.getElementById("prescriber_id").innerHTML;
    drawCanvas();
    hideElementCenter("add_prescriber");
}

function submitLayout(){
    document.getElementById("layout").style.color = '#000';
    document.getElementById("layout").value = document.getElementById("layout_id").innerHTML;
    drawCanvas();
    hideElementCenter("add_layout");
}

function test(){
    alert("hfffff");
    document.forms["prescriptionform"].submit();
}