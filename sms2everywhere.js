var strText;
var val2;
function textcounter() {
var mesnum=1;
var encodingtype = document.getElementsByName('sms2everywhere_encodingtype');
var val = document.getElementById("sms2everywhere_message").value;
var lines = val.split("\r\n|\r|\n");  
var len=val.length+lines.length-1;
document.getElementById("remLen1").value=len;
if (encodingtype[1].checked==true) {
if(len > 70){while(len > 67){len=len-67;mesnum=mesnum+1;}}
}
else if (encodingtype[0].checked==true) {
if(len > 160){while(len > 153){len=len-153;mesnum=mesnum+1;}}
}
document.getElementById("remLen2").value=mesnum;
}
var page_id;
function init_sms(page_id){
if(page_id == 1){textcounter();}
}