function createNew(){
    if(document.getElementById("selectyes").checked){
        document.forms[0].selectnew.disabled = true;
    }
    else{
        document.forms[0].selectnew.disabled = false;
    }
}

function hideElementCenter(id){
    document.getElementById(id).style.visibility = 'hidden';   
    document.getElementById("bg").style.visibility = 'hidden';
}

function showElementCenter(id){
  var myWidth = 0, myHeight = 0;
  
  if( typeof( window.innerWidth ) == 'number' ) {
    //Non-IE
    myWidth = window.innerWidth;
    myHeight = window.innerHeight;
  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    //IE 6+ in 'standards compliant mode'
    myWidth = document.documentElement.clientWidth;
    myHeight = document.documentElement.clientHeight;
  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    //IE 4 compatible
    myWidth = document.body.clientWidth;
    myHeight = document.body.clientHeight;
  }
    var posX = (myWidth / 2) - (document.getElementById(id).offsetWidth / 2);
    var posY = (myHeight / 2) - (document.getElementById(id).offsetHeight / 2); 
    var blackDiv = document.getElementById("bg");
    
    blackDiv.style.width = myWidth;
    blackDiv.style.height = myHeight;
    blackDiv.style.visibility = 'visible';
    
    document.getElementById(id).style.visibility = 'visible';
    document.getElementById(id).style.left = posX;
    document.getElementById(id).style.top = posY;
}
