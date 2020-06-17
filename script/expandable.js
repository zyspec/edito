var ie4 = false;
var display = '[+]';
var hide    = '[-]';

if(document.all) { ie4 = true; }

function getObject(id)
 {
     if (ie4) { return document.all[id]; } else { return document.getElementById(id); }
 }

function toggle(link, divId) {
     var lText = link.innerHTML; var d = getObject(divId);
     if (lText == display) {
      link.innerHTML = hide;
      d.style.display = 'block';
     } else {
      link.innerHTML = display;
      d.style.display = 'none';
     } 
}

function SelectIt(Code){
  if (Code.value=="") {
     alert('There is nothing to copy, dude!')
   }else{
     Code.focus();
     Code.select();
     if (document.getElementById("1")){
        Code.createTextRange().execCommand("Copy");
     }
   }
}