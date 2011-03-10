var xmlHttp

function loadProv(str) {
   xmlHttp=GetXmlHttpObject()
   if (xmlHttp==null) {
      alert ("Browser does not support HTTP Request")
      return
   }
   var url="provloader.php"
   url=url+"?year="+str
   url=url+"&sid="+Math.random()
   xmlHttp.onreadystatechange=yearChanged
   xmlHttp.open("GET",url,true)
   xmlHttp.send(null)
}

function loadTowns(str) {
   xmlHttp=GetXmlHttpObject()
   if (xmlHttp==null) {
      alert ("Browser does not support HTTP Request")
      return
   }
   var url="townloader.php"
   var year=document.forms['frm'].elements['year'].options[document.forms['frm'].elements['year'].options.selectedIndex].value;
   url=url+"?prov="+str+"&year="+year
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
     var output="";
     var indice=150;
     var data=xmlHttp.responseText.split(',');
     var data2=data;
     var max=1;
     
      for(j = 0; j < data2.length; j++)
    {
        var q=data2[j];
        if((q-max)>0){max=q;}
    }
    var norm=indice/max;
     for(i = 0; i < data.length; i++)
    {
        var h=data[i];
        //if(max<h){max=h;}
        var w=3;
        output=output+"<img src='blank.gif' alt='"+i+" anni -> "+h+" abitanti' title='"+i+" anni -> "+h+" abitanti ->max="+max+"' class='barra2' style='height: " + (norm*h) + "px; width: " + w + "px;'/>";
    }

      document.getElementById("divdata").innerHTML=output;
   }
}
function yearChanged() {
   if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
      document.getElementById("prov").innerHTML=xmlHttp.responseText
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
    var year=document.forms['frm'].elements['year'].options[document.forms['frm'].elements['year'].options.selectedIndex].value;
    var prov=document.forms['frm'].elements['prov'].options[document.forms['frm'].elements['prov'].options.selectedIndex].value;
    var town=document.forms['frm'].elements['town'].options[document.forms['frm'].elements['town'].options.selectedIndex].value;
    var sex=document.forms['frm'].elements['sex'].options[document.forms['frm'].elements['sex'].options.selectedIndex].value;
    var Unmarried=document.forms['frm'].elements['Unmarried'].checked;
    var Married=document.forms['frm'].elements['Married'].checked;
    var Widowed=document.forms['frm'].elements['Widowed'].checked;
    var Divorced=document.forms['frm'].elements['Divorced'].checked;

      //alert(s2);
     var table= "<table border='0.5'><tr><td>prima cella</td><td>seconda cella</td></tr><tr><td>terza cella</td><td>quarta cella</td></tr></table>";
    //document.getElementById('titolo').innerHTML=s;
    //document.getElementById('divdata').innerHTML="pippo";
    document.getElementById('pdiv').innerHTML=Unmarried+";"+Married+";"+Widowed+";"+Divorced;
    document.getElementById('number').innerHTML="0      10      20      30      40      50      60      70      80      90      100";

    xmlHttp=GetXmlHttpObject()
   if (xmlHttp==null) {
      alert ("Browser does not support HTTP Request")
      return
   }
   var url="structquery.php"
   document.getElementById("divdata").innerHTML=xmlHttp.responseText
   url=url+"?year="+year+"&prov="+prov+"&town="+town+"&sex="+sex+"&Unmarried="+Unmarried+"&Married="+Married+"&Widowed="+Widowed+"&Divorced="+Divorced;
   //url=url+"&sid="+Math.random()
   xmlHttp.onreadystatechange=divChanged
   xmlHttp.open("GET",url,true)
   xmlHttp.send(null)
}


