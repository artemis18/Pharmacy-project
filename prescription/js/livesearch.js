var aj = "";

/**
 * Used in the endorsement creation form, when a search term is typed
 * in the search field, the string is passed on to the php file that
 * searches depending on the form of the drug required. This data is 
 * then passed back here in JSON format and displayed in the correct
 * places.
 */
function loadSearch(){
    var loading = document.getElementById("divloader").style;
    var str = document.getElementById("query").value;
    var livesearch = document.getElementById("livesearch");
    var form = document.getElementById("form");
    var formvalue = form.value;
    
    //Display the "loading..." image
    loading.visibility = 'visible';
    xmlhttp = createXMLHttpRequest();
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            //create the object results with all data
            eval("results="+xmlhttp.responseText);
            
            document.getElementById("num_results").innerHTML=results.num_results;
            //Only 100 results are shown. This is only displayed if more than 100 results are displayed
            if(results.num_results > 100){
                document.getElementById("extra_result").innerHTML = "Only displaying 100 results from ~. Please refine your search criteria.";
            }
            
            //Reset the form select fields
            form.innerHTML = "";
            
            //Create a new option element for all forms
            var all = document.createElement("option");
            all.text = "All";
            all.value = "all";
            try{form.add(all,null);}
            catch(ex){form.add(all);}
            
            //Create all of the forms of drugs received from the php query
            var forms = results.forms;
            
            for(i=0;i<forms.length;i++){
                var opt = document.createElement("option");
                opt.text = forms[i].name;
                opt.value = forms[i].name;
                if(forms[i].selected == "true"){
                    opt.selected = "1";
                }
                try{form.add(opt,null);}
                catch(ex){form.add(opt);}
            }
            
            //Reset the live search results
            livesearch.innerHTML = "";
            //Create all the results in the form of option elements
            var drugs = results.results;
            for(i=0;i<drugs.length;i++){
                var opt = document.createElement("option");
                opt.text = drugs[i].name;
                opt.value = drugs[i].id;
                try{livesearch.add(opt,null);}
                catch(ex){livesearch.add(opt);}
            }
            loading.visibility = 'hidden';
        }
      }
      
    xmlhttp.open("GET","/prescription/ajax/drugsearch.php?q="+str+"&f="+formvalue,true);
    xmlhttp.send();
}

function displayDrug(id){
    var drug_name = document.getElementById("drug_name");
    var drug_form = document.getElementById("drug_form");
    xmlhttp = createXMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            //alert(xmlhttp.responseText);
            
            eval("drug="+xmlhttp.responseText);
            drug_name.innerHTML=drug.drug.name;
            drug_form.innerHTML=drug.drug.form;
        }
    }
    xmlhttp.open("GET","/prescription/ajax/drugsearch.php?id="+id,true);
    xmlhttp.send();
}

/**
 * Function to convert string representation of boolean into booleans.
 * returns the boolean, or false if anything else
 */
function checkBool(string){
    if(string == "true"){
        return true;
    }
    return false;
}

/**
 * 
 */
function loadEndorsements(str){
    xmlhttp = createXMLHttpRequest();

    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
        document.getElementById("liveendorsements").innerHTML=xmlhttp.responseText;
        }
      }
    xmlhttp.open("GET","/prescription/ajax/endorsementsearch.php?q="+str,true);
    xmlhttp.send();
}

function endorsementDetails(id){
    xmlhttp = createXMLHttpRequest();

    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var response = xmlhttp.responseText.split(";");
            document.getElementById("end_drug").innerHTML = " " + response[0];
            document.getElementById("end_quantity").innerHTML = " " + response[1];
            document.getElementById("end_dosage").innerHTML = " " + response[2];
        }
      }
    xmlhttp.open("GET","/prescription/ajax/endorsementsearch.php?s=loaddetails&q="+id,true);
    xmlhttp.send();
}

function livePatient(query){
    xmlhttp = createXMLHttpRequest();

    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
        document.getElementById("livepatients").innerHTML=xmlhttp.responseText;
        }
      }
    xmlhttp.open("GET","/prescription/ajax/patientsearch.php?q="+query,true);
    xmlhttp.send();
}

function displayPatient(id){
    xmlhttp = createXMLHttpRequest();

    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var result = xmlhttp.responseText.split(",");
            
            document.getElementById("patient_id").innerHTML = result[0];
            document.getElementById("patient_name").innerHTML = result[3] + " " + result[2] + ", " + result[1];
            document.getElementById("patient_gender").innerHTML = result[4];
            document.getElementById("patient_road").innerHTML = result[5];
            document.getElementById("patient_city").innerHTML = result[6];
            document.getElementById("patient_postcode").innerHTML = result[7];
            document.getElementById("patient_telephone").innerHTML = result[8];
        }
      }
    xmlhttp.open("GET","/prescription/ajax/patientsearch.php?id="+id,true);
    xmlhttp.send();
}

function livePrescriber(query){
    xmlhttp = createXMLHttpRequest();

    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
        document.getElementById("liveprescriber").innerHTML=xmlhttp.responseText;
        }
      }
    xmlhttp.open("GET","/prescription/ajax/prescribersearch.php?q="+query,true);
    xmlhttp.send();
}

function displayPrescriber(id){
    xmlhttp = createXMLHttpRequest();

    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var result = xmlhttp.responseText.split(",");
            
            document.getElementById("prescriber_id").innerHTML = result[0];
            document.getElementById("prescriber_name").innerHTML = result[3] + " " + result[2] + ", " + result[1];
            document.getElementById("prescriber_road").innerHTML = result[4];
            document.getElementById("prescriber_city").innerHTML = result[5];
            document.getElementById("prescriber_postcode").innerHTML = result[6];
        }
      }
    xmlhttp.open("GET","/prescription/ajax/prescribersearch.php?id="+id,true);
    xmlhttp.send();
}

function liveLayouts(query){
    xmlhttp = createXMLHttpRequest();

    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
        document.getElementById("livelayouts").innerHTML=xmlhttp.responseText;
        }
      }
    xmlhttp.open("GET","/prescription/ajax/layoutsearch.php?q="+query,true);
    xmlhttp.send();
}

function displayLayout(id){
    xmlhttp = createXMLHttpRequest();

    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var result = xmlhttp.responseText.split(",");

            document.getElementById("layout_id").innerHTML = result[0];
            document.getElementById("layout_name").innerHTML = result[1];
            var canvas = document.getElementById("layout_preview");
            display_layout(canvas,0.5,result[0]);
        }
      }
    xmlhttp.open("GET","/prescription/ajax/layoutsearch.php?id="+id,true);
    xmlhttp.send();
}

function livepformsearch(){
    
    var query = document.getElementById("prescriptionsearch").value;
    var field = document.getElementById("select_field").value;
    var sortby = document.getElementById("sortby_date").checked;
    
    xmlhttp = createXMLHttpRequest();

    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var result = xmlhttp.responseText.split(";");
            document.getElementById("num_results").innerHTML = "Found " + result[0] + " result(s)";
            document.getElementById("livepform").innerHTML=result[1];
        }
      }
    xmlhttp.open("GET","/prescription/ajax/pformsearch.php?q="+query+"&field="+field+"&sortby="+sortby,true);
    xmlhttp.send();
}

function pformdisplay(id){
    xmlhttp = createXMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
      if (xmlhttp.readyState==4 && xmlhttp.status==200){
            eval("aj="+xmlhttp.responseText);
            var pf = aj.PrescriptionForm;
            var pt = aj.Patient;
            var pr = aj.Prescriber;
            var pl = aj.PrescriptionLayout;
            var end = aj.Endorsements;
            var endorsements = "";
            for(i=0;i<end.length;i++){
                if(i==0){
                    endorsements = end[i];
                }
                else{
                    endorsements += ","+ end[i];
                }
                selected[i+1]=end[i];
            }
            var canvas = document.getElementById("ps_view_c");
            process(canvas,pl,pt,pr,endorsements,1,pf.signature,pf.date,pf.stamp,pf.ndt,pf.dob,pf.age,pf.nhsno,pf.numdays,pf.watermark);
        }
    }
    xmlhttp.open("GET","/prescription/ajax/pformsearch.php?id="+id,true);
    xmlhttp.send();
}

function submitSelection(){
    document.getElementById("patient").style.color = '#000';
    document.getElementById("prescriber").style.color = '#000';
    document.getElementById("layout").style.color = '#000';
    document.getElementById("patient").value = aj.Patient;
    document.getElementById("prescriber").value = aj.Prescriber;
    document.getElementById("layout").value = aj.PrescriptionLayout;
    document.getElementById("num_days").value = aj.PrescriptionForm.numdays;
    document.getElementById("show_signature").checked = checkBool(aj.PrescriptionForm.signature);
    document.getElementById("show_stamp").checked = checkBool(aj.PrescriptionForm.stamp);
    document.getElementById("show_date").checked = checkBool(aj.PrescriptionForm.date);
    document.getElementById("show_age").checked = checkBool(aj.PrescriptionForm.age);
    document.getElementById("show_dob").checked = checkBool(aj.PrescriptionForm.dob);
    document.getElementById("show_nhs").checked = checkBool(aj.PrescriptionForm.nhsno);
    document.getElementById("show_ndt").checked = checkBool(aj.PrescriptionForm.ndt);
    var wmk = aj.PrescriptionForm.watermark;
    var watermark = document.getElementsByName("watermark");
    if(wmk=="nhs"){
        watermark[0].checked = true;
    }
    else if(wmk=="pcd"){
        watermark[1].checked = true;
    }
    else{
        watermark[0].checked = true;
    }
    
    submitEndorsements();
    drawCanvas();
    hideElementCenter("select_prescription");
    document.getElementById("selectedid").value = aj.PrescriptionForm.id;
    document.getElementById("selected_id").innerHTML = "Correct Prescription ID: " + aj.PrescriptionForm.id;
}

function userSearch(query){
    xmlhttp = createXMLHttpRequest();

    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            //var result = xmlhttp.responseText.split(";");
            document.getElementById("users").innerHTML = xmlhttp.responseText;
        }
      }
    xmlhttp.open("GET","/prescription/ajax/usersearch.php?q="+query,true);
    xmlhttp.send();
}

function createXMLHttpRequest(){
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      return xmlhttp;
}
