var response = "";

function checkCorrect(){
    var signature = document.getElementById("show_signature").checked;
    var stamp = document.getElementById("show_stamp").checked;
    var date = document.getElementById("show_date").checked;
    var ndt = document.getElementById("show_ndt").checked;
    var dob = document.getElementById("show_dob").checked;
    var age = document.getElementById("show_age").checked;
    var nhs = document.getElementById("show_nhs").checked;
    var type = document.getElementsByName("type");
    
    if(!signature){
        type[1].checked = true;
    }
    if(!stamp){
        type[1].checked = true;
    }
    if(!date){
        type[1].checked = true;
    }
    if(!ndt){
        type[1].checked = true;
    }
    if(!dob){
        type[1].checked = true;
    }
    if(!age){
        type[1].checked = true;
    }
    if(!nhs){
        type[1].checked = true;
    }
}

function updateCanvas(scale){
   if(scale == null){
       scale = 1;
   }
   checkCorrect();
    var signature = document.getElementById("show_signature").checked;
    var stamp = document.getElementById("show_stamp").checked;
    var date = document.getElementById("show_date").checked;
    var ndt = document.getElementById("show_ndt").checked;
    var canvas = document.getElementById("liveCanvas");
    var dob = document.getElementById("show_dob").checked;
    var age = document.getElementById("show_age").checked;
    var nhs = document.getElementById("show_nhs").checked;
    var numdays = document.getElementById("num_days").value;
    var wms = document.getElementsByName("watermark");
    var watermark = "none";
    
    for(i=0;i<wms.length;i++){
        if(wms[i].checked){
            watermark = wms[i].value;
        }
    }
    
    draw(canvas, scale, signature, date, stamp, ndt, dob, age, nhs, numdays, watermark);
}

function drawCanvas(scale){
    if(scale == null){
        scale = 1;
    }
    
    var signature = document.getElementById("show_signature").checked;
    var stamp = document.getElementById("show_stamp").checked;
    var date = document.getElementById("show_date").checked;
    var ndt = document.getElementById("show_ndt").checked;
    var layout = document.getElementById("layout").value;
    var patient = document.getElementById("patient").value;
    var prescriber = document.getElementById("prescriber").value;
    var dob = document.getElementById("show_dob").checked;
    var age = document.getElementById("show_age").checked;
    var nhs = document.getElementById("show_nhs").checked;
    var numdays = document.getElementById("num_days").value;
    var wms = document.getElementsByName("watermark");
    
    var watermark = "none";
    
    for(i=0;i<wms.length;i++){
        if(wms[i].checked){
            watermark = wms[i].value;
        }
    }
    
    var endorsements = "";
    var canvas = document.getElementById("liveCanvas");
    var ctx = canvas.getContext("2d");
    canvas.width=canvas.width;
    for(i=1;i<selected.length;i++){
        if(i!=1){
            endorsements += ","+selected[i];
        }
        else{
            endorsements += selected[i];
        }
    }
    if(layout == "Click on Show"){
        ctx.font = Math.round(30*scale)+"pt Calibri"
        ctx.fillStyle = "#000000";
        ctx.fillText("Please select a layout",100,100);
    }
    else{
         process(canvas, layout, patient, prescriber, endorsements, scale, signature, date, stamp, ndt, dob, age, nhs, numdays, watermark);
    }
}

function draw_pform(canvas, scale, pform_id){
    if(canvas == null){return;}
    xmlhttp = createXMLHttpRequest();
    
    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            eval("response="+xmlhttp.responseText);
            process(canvas, response.layout, response.patient, response.prescriber, response.endorsements, 1, response.signature, response.date, response.stamp, response.ndt, response.dob, response.age, response.nhsno, response.numdays, response.watermark)
            $("#p_timestamp").html(response.timestamp);
        }
    }
    var url = "/prescription/ajax/liveview.php?pformid="+pform_id;
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}
function display_layout(canvas,scale,layout){
    if(canvas == null){return;}
    if(layout == null){return;}
    
    process(canvas, layout, null, null, null, scale, null, null, null, null, null, null, null, null, null);
}

function process(canvas, layout, patient, prescriber, endorsements, scale, signature, date, stamp, ndt, dob, age, nhs, numdays, wms){
    if(canvas == null){return;}
    if(layout == null){return;}
    xmlhttp = createXMLHttpRequest();
    
    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            eval("response="+xmlhttp.responseText);
			//alert(response);
            draw(canvas, scale, signature, date, stamp, ndt, dob, age, nhs, numdays, wms);
        }
    }
    var url = "/prescription/ajax/liveview.php?layout="+layout+"&patient="+patient+"&prescriber="+prescriber+"&endorsements="+endorsements;
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}

function draw(canvas, scale, signature, date, stamp, ndt, show_dob, show_age, show_nhs, num_days, wms){

    //Set default values
    if(scale == null){scale = 1;}
    var wm = "none";
    
    if(wms != null){
        wm = wms;
    }
    
    var ctx = canvas.getContext("2d");
    var font = Math.round(10 * scale);
    var layout = response.prescription_layout;
    var placeholders = layout.placeholders;
    var boxes = layout.boxes;
    var laywidth = Math.round(layout.width[0] * scale);
    var layheight = Math.round(layout.height[0] * scale);
    canvas.width = laywidth;
    canvas.height = layheight;
    ctx.fillStyle = "rgb("+layout.bg.red[0]+","+layout.bg.green[0]+","+layout.bg.blue[0]+")";
    ctx.fillRect(0, 0, laywidth, layheight);

    if(wm!="none"){
        var watermark = new Image();
        if(wm=="nhs"){
            watermark.src = "/prescription/images/NHS-logo.png";
        }
        else{
            watermark.src = "/prescription/images/privatecd.png";
        }
        watermark.onload = function(){
        var num = Math.round(layheight/85);
            for(i=0;i<num;i++){
                if((i%2)>0){
                    imgX = (laywidth/2)-Math.round(50*scale);
                    imgY = (i * 75) + Math.round(10*scale);
                    ctx.drawImage(watermark, imgX, imgY, 80, 40);
                }
                else{
                    imgX = (laywidth/4)-Math.round(50*scale);
                    imgX2 = (imgX + (laywidth/2));
                    imgY = (i * 75) + Math.round(10*scale);
                    ctx.drawImage(watermark, imgX, imgY, 80, 40);
                    ctx.drawImage(watermark, imgX2, imgY, 80, 40);
                }
            }
        }
    }

    for(i=0; i<boxes.length; i++){
       box = boxes[i];

       var x = Math.round(box.position.x[0] * scale);
       var y = Math.round(box.position.y[0] * scale);
       var width = Math.round(box.dimension.width[0] * scale);
       var height = Math.round(box.dimension.height[0] * scale);

       if(box.fill.transparent[0] == "false"){
           ctx.fillStyle = "rgb("+box.fill.colour.red[0]+","+box.fill.colour.green[0]+","+box.fill.colour.blue[0]+")";
           ctx.fillRect(x,y,width,height);
       }
       if(box.line.width[0] != "0.0"){
           ctx.lineWidth = 2;
           ctx.strokeStyle = "rgb("+box.line.colour.red[0]+","+box.line.colour.green[0]+","+box.line.colour.blue[0]+")";
           ctx.strokeRect(x,y,width,height);
       }
       if(box.name[0]){
           txtX = parseInt(x) + Math.round(5 * scale);
           txtY = parseInt(y) + Math.round(10 * scale);
           ctx.font = font+"pt Calibri";
           ctx.fillStyle = '#000000';
           ctx.fillText(box.name[0], txtX, txtY);
       }
    }
    if(signature && signature!=null){
        var pr_s_pos = placeholders['prescriber_signature'].split(",");
        var ioffX = Math.round(parseInt(pr_s_pos[0]) * scale) + Math.round(30 * scale);
        var ioffY = Math.round(parseInt(pr_s_pos[1]) * scale) + Math.round(10 * scale);
        var swidth = Math.round(100 * scale);
        var sheight = Math.round(35 * scale);

        var sig = new Image();
        sig.src = "/prescription/images/signature.png";
        sig.onload = function(){
            ctx.drawImage(sig, ioffX, ioffY, swidth, sheight);
        }
    }
    if(ndt && ndt!=null && ndt != "false"){
        var ndt_pos = placeholders['num_days_treatment'].split(",");
        var ndtoffX = Math.round(parseInt(ndt_pos[0]) * scale) + Math.round(5 * scale);
        var ndtoffY = Math.round(parseInt(ndt_pos[1]) * scale) + Math.round(20 * scale);
        
        ctx.font = (font+2)+"pt Calibri";
        ctx.fillStyle = "#000";
        ctx.fillText(num_days, ndtoffX, ndtoffY);
    }
    if(date && date!=null && date != "false"){
        var prd_pos = placeholders['prescription_date'].split(",");
        var dateoffX = Math.round(parseInt(prd_pos[0]) * scale) + Math.round(5 * scale);
        var dateoffY = Math.round(parseInt(prd_pos[1]) * scale) + Math.round(35 * scale);
        var currentTime = new Date()
        var month = currentTime.getMonth() + 1
        var day = currentTime.getDate()
        var year = currentTime.getFullYear()
        var dated = month + "/" + day + "/" + year;

        ctx.font = font+"pt Calibri";
        ctx.fillStyle = "#000";
        ctx.fillText(dated, dateoffX, dateoffY);
    }
    if(stamp){
        
    }
    if(response.patient){
        var pt = response.patient;
        var position = placeholders['patient_details'].split(",");
        var txtX = Math.round(parseInt(position[0]) * scale);
        var txtY = Math.round(parseInt(position[1]) * scale) + Math.round(5*scale);
        var offX = Math.round(10 * scale);

        var name = pt.name;
        var road = pt.road;
        var city = pt.city;
        var postcode = pt.postcode;
        var telephone = pt.telephone;
        var dob = pt.dob;
        var nhsno = pt.nhsno;
        var age = pt.age;

        ctx.font = font+"pt Calibri";
        ctx.fillStyle = "#000";
        ctx.fillText(name, txtX + offX, txtY + (offX * 2));
        ctx.fillText(road, txtX + offX, txtY + (offX * 3));
        ctx.fillText(city, txtX + offX, txtY + (offX * 4));
        ctx.fillText(postcode, txtX + offX, txtY + (offX * 5));
        ctx.fillText(telephone, txtX + offX, txtY + (offX * 6));

        if(show_dob && show_dob != "false"){
            var dob_pos = placeholders['patient_dob'].split(",");
            var dobX = Math.round(parseInt(dob_pos[0])*scale) + offX;
            var dobY = Math.round(parseInt(dob_pos[1])*scale) + (offX * 2.5);
            ctx.fillText(dob, dobX, dobY);
        }
        if(show_age && show_age != "false"){
            var age_pos = placeholders['patient_age'].split(",");
            var ageX = Math.round(parseInt(age_pos[0])*scale)+offX;
            var ageY = Math.round(parseInt(age_pos[1])*scale)+(offX * 2.5);
            ctx.fillText(age, ageX, ageY);
        }
        if(show_nhs && show_nhs != "false"){
            var nhs_pos = placeholders['patient_nhsno'].split(",");
            var nhsX = Math.round(parseInt(nhs_pos[0])*scale) + (offX * 10);
            var nhsY = Math.round(parseInt(nhs_pos[1])*scale) + offX;
            ctx.fillText(nhsno, nhsX, nhsY);
        }
    }
    if(response.prescriber){
        var pr = response.prescriber;
        var position = placeholders['prescriber_details'].split(",");
        var txtX = Math.round(parseInt(position[0]) * scale);
        var txtY = Math.round(parseInt(position[1])*scale) + Math.round(5*scale);
        var offX = Math.round(10 * scale);

        var name = pr.name;
        var road = pr.road;
        var city = pr.city;
        var postcode = pr.postcode;
        var telephone = pr.telephone;

        ctx.font = font+"pt Calibri";
        ctx.fillStyle = "#000";
        ctx.fillText(name, txtX + offX, txtY + (offX * 2));
        ctx.fillText(road, txtX + offX, txtY + (offX * 3));
        ctx.fillText(city, txtX + offX, txtY + (offX * 4));
        ctx.fillText(postcode, txtX + offX, txtY + (offX * 5));
        ctx.fillText(telephone, txtX + offX, txtY + (offX * 6));
    }
    if(response.endorsements){
        var end = response.endorsements;
        var position = placeholders['endorsements'].split(",");
        var txtX = Math.round(parseInt(position[0])*scale) + Math.round(65*scale);
        var txtY = Math.round(parseInt(position[1])*scale);
        var l = 0;
        for(i in end){
            var name = end[i].name;
            var form = end[i].form;
            var quantity = end[i].quantity;
            var dosage = end[i].dosage;
            var instruction = end[i].instruction;

            var offY = (l * (Math.round(40*scale))) + txtY + Math.round(10*scale);

            ctx.font = font+"pt Calibri";
            ctx.fillStyle = "#000";
            ctx.fillText(name + " " + form, txtX + Math.round(25*scale), offY);
            ctx.fillText(dosage + " " + instruction, txtX + Math.round(25*scale), offY + Math.round(11*scale));
            ctx.fillText(quantity, txtX + Math.round(25*scale), offY + Math.round(22*scale));
            l++;
        }
        var offY = (l * (Math.round(40*scale))) + txtY + Math.round(10*scale);
        ctx.font = font+"pt Calibri";
        ctx.fillStyle = "#000";
        ctx.fillText("[No more items on this prescription]", txtX + Math.round(25*scale), offY);
    }
}