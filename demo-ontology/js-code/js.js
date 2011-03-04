var xmlHttp

function loadTowns(str) {
   xmlHttp=GetXmlHttpObject()
   if (xmlHttp==null) {
      alert ("Browser does not support HTTP Request")
      return
   }
   var url="townloader.php"

   url=url+"?prov="+str
   url=url+"&sid="+Math.random()
   xmlHttp.onreadystatechange=stateChanged
   xmlHttp.open("GET",url,true)
   xmlHttp.send(null)
}

function stateChanged() {
   if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
      document.getElementById("town").innerHTML=xmlHttp.responseText
   }
}
function divChanged() {
   if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
      document.getElementById("titolo").innerHTML=xmlHttp.responseText
   }
}
function GetXmlHttpObject() {
   var xmlHttp=null;
   try {
      // Firefox, Opera 8.0+, Safari
      xmlHttp=new XMLHttpRequest();
   } catch (e) {
      //Internet Explorer
      try {
         xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      } catch (e) {
         xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
   }
   return xmlHttp;
}
function prova(){
  var s=document.forms['frm'].elements['town'].options[document.forms['frm'].elements['town'].options.selectedIndex].value;
    var s2=document.forms['frm'].elements['sex'].options[document.forms['frm'].elements['sex'].options.selectedIndex].value;
    var Unmarried=document.forms['frm'].elements['Unmarried'].value;
    var Married=document.forms['frm'].elements['Married'].value;
    var Widowed=document.forms['frm'].elements['Widowed'].value;
    var Divorced=document.forms['frm'].elements['Divorced'].value;

      //alert(s2);
    //document.getElementById('titolo').innerHTML=s;
     //document.getElementById('titolo').innerHTML=s2;
    xmlHttp=GetXmlHttpObject()
   if (xmlHttp==null) {
      alert ("Browser does not support HTTP Request")
      return
   }
   var url="structquery.php"

   url=url+"?s="+s+"&s2="+s2+"&Unmarried="+Unmarried+"&Married="+Married+"&Widowed="+Widowed+"&Divorced="+Divorced;
   //url=url+"&sid="+Math.random()
   xmlHttp.onreadystatechange=divChanged
   xmlHttp.open("GET",url,true)
   xmlHttp.send(null)
}


