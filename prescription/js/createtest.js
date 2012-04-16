var selected = new Array();

function moveAccross(){
    var pform = document.getElementById("livepform");
    var selectedforms = document.getElementById("selectedform");
    if(pform.value.length > 0){
        if(selectedforms.length > 0){
            for(i=0;i<selectedforms.length;i++){
                if(pform.value == selectedforms[i].value){
                    alert("Already exists on selected list!");
                    return;
                }
            }
        }
        var opt = document.createElement("option");
        opt.text = pform[pform.selectedIndex].text;
        opt.className = pform[pform.selectedIndex].className;
        opt.value = pform.value;
        try{
            selectedforms.add(opt,null);
        }
        catch(ex){
            selectedforms.add(opt); 
        }
    }
    else{
        alert("You have not selected any Prescription Forms!");
    }
}

function bringBack(){
    var selectedforms = document.getElementById("selectedform");
    for(i=selectedforms.length-1;i>=0;i--){
        if(selectedforms[i].selected){
            selectedforms.remove(i);
        }
    }
}

function ttt(){
    var selectedforms = document.getElementById("selectedform");
    for(i=0;i<selectedforms.length;i++){
        selectedforms[i].selected = "1";
    }
    return true;
}