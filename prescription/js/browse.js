var selectedID;

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

function browse_endorsements(){
    xmlhttp = createXMLHttpRequest();
    
    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            $("#endorsement_display").html("");
            eval("results="+xmlhttp.responseText);
            var html ="";
            html += "<table class=\"data\">";
            html += "<tr><td>Endorsement ID<\/td><td>Drug Name<\/td>";
            html += "<td>Drug Form<\/td><td>Quantity<\/td><td>Dosage<\/td>";
            html += "<td>Instruction<\/td><td>Remove<\/td><\/tr>";
            
            for(i=0;i<results.results.length;i++){
                var end_id = results.results[i].endorsement_id;
                var name = results.results[i].name;
                var form = results.results[i].form;
                var quantity = results.results[i].quantity;
                var dosage = results.results[i].dosage;
                var instruction = results.results[i].instruction;
                
                html += "<tr onmouseover=\"this.className='over';\" onmouseout=\"this.className='out';\">";
                html += "<td>"+end_id+"<\/td><td>"+name+"<\/td>";
                html += "<td>"+form+"<\/td><td>"+quantity+"<\/td>";
                html += "<td>"+dosage+"<\/td><td>"+instruction+"<\/td>";
                html += "<td><a class=\"cross incorrect\" href=\"#\" onclick=\"delete_confirm("+end_id+");\"><div>&#10006;<\/div><\/a><\/td>";
                html += "<\/tr>";
            }
            
            html += "<\/table>";
            
            $("#endorsement_display").append(html);
        }
    }
    var url = "/prescription/ajax/endorsement.php?browse=1";
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}

function hide_prescription(){
    var $dis_div = $("#display_div");
    var $bg = $("#bg");
    var dis_cvs = document.getElementById("display_canvas");
    
    $dis_div.fadeOut("normal",function(){
        $dis_div.css("visibility","hidden");
    });
    dis_cvs.width=dis_cvs.width;
    $bg.css("visibility", "hidden");
}

function display_prescription(canvas,pform){
    var cvs = document.getElementById(canvas);
    var ctx = cvs.getContext("2d");
    var $dis_cvs = $("#display_canvas");
    var dis_ctx = document.getElementById("display_canvas").getContext("2d");
    var $dis_div = $("#display_div");
    var $bg = $("#bg");
    var myWidth = 0, myHeight = 0;
  
    if(typeof(window.innerWidth) == 'number' ) {
        myWidth = window.innerWidth;
        myHeight = window.innerHeight;
    }else if(document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)){
        myWidth = document.documentElement.clientWidth;
        myHeight = document.documentElement.clientHeight;
    }
    
    var posx = (myWidth / 2) - 225;
    var posy = (myHeight / 2) - 300;
  
    var src = cvs.toDataURL('image/png');
    var img = document.createElement('img');
    img.src = src;
    
    $bg.css("visibility", "visible");
    $bg.css("width", myWidth);
    $bg.css("height", myHeight);
    $dis_div.css("visibility", "visible");
    $dis_div.fadeIn("normal");
    $dis_cvs.css("width", "225");
    $dis_cvs.css("height", "300");
    $dis_div.css("left",cvs.offsetLeft);
    $dis_div.css("top", cvs.offsetTop);
    
    $dis_div.animate({left:posx},"1");
    $dis_div.animate({top:posy},"1","",function(){
        $dis_cvs.animate({height:"600px"},"2");
        $dis_cvs.animate({width:"450px"},"2");
    });
    
    draw_pform(document.getElementById("display_canvas"), 1, pform);
}

function browse_prescriptions(){
    xmlhttp = createXMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            eval("results="+xmlhttp.responseText);

            $("#browse_prescription_container").html("");

            for(i=0;i<results.results.length;i++){
                var pform = results.results[i].prescription_form_id;
                var layout = results.results[i].layout_id;
                var patient = results.results[i].patient_id;
                var prescriber = results.results[i].prescriber_id;
                var signature = results.results[i].signature;
                var date = results.results[i].date;
                var time = results.results[i].timestamp;
                var stamp = results.results[i].stamp;
                var ndt = results.results[i].ndt;
                var dob = results.results[i].dob;
                var age = results.results[i].age;
                var nhs = results.results[i].nhsno;
                var numdays = results.results[i].numdaystreatment;
                var wms = results.results[i].watermark;
                var html = "<div class=\"browse_prescription\" style=\"float: left; margin: 5px;\"><div><a class=\"cross incorrect top\" href=\"#\" onclick=\"showElementCenter('test');\"><div>&#10006;<\/div><\/a>&nbsp;&nbsp;<span style=\"color: #000; font-weight: bold;\">Created: <label id=\""+pform+"_time\"><\/label><\/span><\/div><a href=\"#\" onclick=\"display_prescription('canvas_"+pform+"','"+pform+"');\"><canvas id=\"canvas_"+pform+"\" class=\"browse_canvas\" width=\"225\" height=\"300\" ><\/canvas><\/a><\/div>";
                $("#browse_prescription_container").append(html);
                var cv = document.getElementById("canvas_"+pform);
                $("#"+pform+"_time").html(time);
                process(cv, layout, patient, prescriber, null, 0.5, signature, date, stamp, ndt, dob, age, nhs, numdays, wms);
            }
        }
    }
    var url = "/prescription/ajax/pformsearch.php?browse=1";
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}

function delete_confirm(id){
    selectedID = id;
    showElementCenter("deleteconfirm");
}

function deleteEndorsement(){
    xmlhttp = createXMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            hideElementCenter('deleteconfirm');
            alert("Suucessfully deleted endorsement: "+selectedID);
            browse_endorsements();   
        }
    }
    var url = "/prescription/ajax/endorsement.php?del=1&id="+selectedID;
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}