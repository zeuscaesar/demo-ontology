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
     //ricevuta la stringa di risposta contente i risultati della query separati dal carattere "|",
     //la splitto e memorizzo i singoli risultati nella variabile var data
     var data = xmlHttp.responseText.split('|');

     //ricopio i risultati ottenuti all'interno di una variabile var vett,
     //eliminando l'ultimo che in realtà a causa della costruzione della stringa di risposta
     //corrisponde ad una stringa vuota
     var vett = new Array();
     var sosv=new Array();//sum on single vector
     for (i=0; i<data.length-1; i++)
         vett[i] = data[i].split(',');
     //prelevo il massimo tra tutti i valori contenuti nei vari risultati della query
     //e lo salvo nella variabile var max
     var max=1;
     for(i=0; i<vett.length; i++)
        {
        sosv[i]=0;
        for (j=0; j<vett[i].length; j++)
            {
            var q=parseInt(vett[i][j]);
            sosv[i]+=q;
            if((q-max)>0){max=q;}
            }
        }

     //calcolo il fattore di normalizzazione
     var norm=indice/max;

     //calcolo la somma della popolazione per anno di età
     var sum = new Array();
     for (j=0; j<vett[0].length; j++)
         {
         sum[j]=0;
         for (i=0; i< vett.length; i++)
            sum[j]+=parseInt(vett[i][j]);
         }

     //se il risultato della query comprende più categorie di popolazione,
     //grafico prima le singole categorie
     if (vett.length>1)
         for(i = 0; i < vett.length; i++)
              {
              for(j = 0; j < vett[i].length; j++)
                {
                var h=vett[i][j];
                //if(max<h){max=h;}
                var w=3;
                output=output+"<img src='blank.gif' alt='"+j+" anni -> "+h+" abitanti' title='"+j+" anni -> "+h+" abitanti' class='barra2' style='height: " + (norm*h) + "px; width: " + w + "px;'/>";
                }
              output += "<br/><hr/ class='graphseparator' style='border:dotted;size=1'<br/>";
              }

     //grafico la totalità della popolazione
     for(i = 0; i < sum.length; i++)
            {
            h=sum[i];
            //if(max<h){max=h;}
            w=3;
            output=output+"<img src='blank.gif' alt='"+i+" anni -> "+h+" abitanti' title='"+i+" anni -> "+h+" abitanti' class='barra2' style='height: " + (norm*h) + "px; width: " + w + "px;'/>";
            }
    var year=document.forms['frm'].elements['year'].options[document.forms['frm'].elements['year'].options.selectedIndex].value;
    var town=document.forms['frm'].elements['town'].options[document.forms['frm'].elements['town'].options.selectedIndex].value;
    var sex=document.forms['frm'].elements['sex'].options[document.forms['frm'].elements['sex'].options.selectedIndex].value;
    var Unmarried=document.forms['frm'].elements['Unmarried'].checked;
    var Married=document.forms['frm'].elements['Married'].checked;
    var Widowed=document.forms['frm'].elements['Widowed'].checked;
    var Divorced=document.forms['frm'].elements['Divorced'].checked;
    var prov=document.forms['frm'].elements['prov'].options[document.forms['frm'].elements['prov'].options.selectedIndex].value;
    var stringsosv="";

    var table= "<table id="+"result><tr>";
    var counter=0;
    if(Divorced){counter++;}
    if(Married){counter++;}
    if(Unmarried){counter++;}
    if(Widowed){counter++;}
    
     table+="<th  colspan='1'  style='background-color:white;border: 0px'></th>";
    if(sex!="Both"){
        table+="<th  colspan="+(counter)+">"+sex+"</th></tr><tr><th>Age</th>"
        if(Divorced){table+="<th>Divorced"+"</th>";}
        if(Married){table+="<th>Married"+"</th>";}
        if(Unmarried){table+="<th>Unmarried"+"</th>";}
        if(Widowed){table+="<th>Widowed"+"</th>";}
    }
    else{
        table+="<th  colspan="+counter+">Female</th><th  colspan="+counter+">Male</th></tr><tr>";
        if(Divorced){table+="<th>Divorced"+"</th>";}
        if(Married){table+="<th>Married"+"</th>";}
        if(Unmarried){table+="<th>Unmarried"+"</th>";}
        if(Widowed){table+="<th>Widowed"+"</th>";}
        if(Divorced){table+="<th>Divorced"+"</th>";}
        if(Married){table+="<th>Married"+"</th>";}
        if(Unmarried){table+="<th>Unmarried"+"</th>";}
        if(Widowed){table+="<th>Widowed"+"</th>";}
    }
    table+="<th>Total</th></tr><tr>";
     var maxv=0;
     for(i=0;i<sosv.length;i++){
            maxv+=sosv[i];
            table+="<td>"+sosv[i]+"</td>";
    }
    table+="<td>"+maxv+"</td>";
    table+="</tr></table>";

//<tr><td>prima cella</td><td>seconda cella</td></tr><tr><td>terza cella</td><td>quarta cella</td></tr></table>";
  
      document.getElementById("pdiv").innerHTML=table;
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
    //document.getElementById('pdiv').innerHTML=table;
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


