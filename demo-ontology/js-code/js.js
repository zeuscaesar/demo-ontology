var xmlHttp

function loadProv(str) {
   
   xmlHttp=GetXmlHttpObject()
   if (xmlHttp==null) {
      alert ("Browser does not support HTTP Request")
      return
   }
   var url="provloader.php"
   url=url+"?year="+str
   //url=url+"&sid="+Math.random()
   
   xmlHttp.onreadystatechange=yearChanged
   xmlHttp.open("GET",url,true)
   xmlHttp.send(null)
}
function loadtoyear(str) {
   xmlHttp=GetXmlHttpObject()
   if (xmlHttp==null) {
      alert ("Browser does not support HTTP Request")
      return
   }
   var url="yearloader.php"
   url=url+"?year="+str
   //url=url+"&sid="+Math.random()
   xmlHttp.onreadystatechange=toyearChanged
   xmlHttp.open("GET",url,true)
   xmlHttp.send(null)
}
function loadYearByMun(str) {
   xmlHttp=GetXmlHttpObject()
   if (xmlHttp==null) {
      alert ("Browser does not support HTTP Request")
      return
   }
   var url="yearloaderbymun.php"
   url=url+"?mun="+str
   //url=url+"&sid="+Math.random()
   xmlHttp.onreadystatechange=toMunChangedLoadYear
   xmlHttp.open("GET",url,true)
   xmlHttp.send(null)
}

function loadTowns(str) {//non lo utilizziamo
   xmlHttp=GetXmlHttpObject()
   if (xmlHttp==null) {
      alert ("Browser does not support HTTP Request")
      return
   }
   var url="townloader.php"
   var year=document.forms['frm'].elements['year'].options[document.forms['frm'].elements['year'].options.selectedIndex].value;
   url=url+"?prov="+str+"&year="+year
   //url=url+"&sid="+Math.random()
   xmlHttp.onreadystatechange=stateChanged
   xmlHttp.open("GET",url,true)
   xmlHttp.send(null)
}

function loadTownswy(str) {//wy=without years
   xmlHttp=GetXmlHttpObject()
   if (xmlHttp==null) {
      alert ("Browser does not support HTTP Request")
      return
   }
   var url="townloader.php"
   var year="sel"
   //var year=document.forms['frm'].elements['year'].options[document.forms['frm'].elements['year'].options.selectedIndex].value;
   url=url+"?prov="+str+"&year="+year
   //url=url+"&sid="+Math.random()
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

    //ricopio i risultati ottenuti all'interno di una variabile vett,
    //eliminando l'ultimo che in realtà a causa della costruzione della stringa di risposta
    //corrisponde ad una stringa vuota
    var vett = new Array();
    for (i=0; i<data.length-1; i++)
        vett[i] = data[i].split(',');

    //definisco tre variabili tot_istanze_singole, tot_per_eta, totale_popolaz
    //di tipo array che utilizzerò per contenere rispettivamente
    //il totale di persone per ogni categoria di popolazione restituita dalla query,
    //il totale di persone dell'intera popolazione suddivise per età,
    // e il totale di persone dell'intera popolazione
    var tot_istanze_singole = new Array();
    var tot_per_eta = new Array();
    for (i=0; i<=100; i++)
        tot_per_eta[i]=0;
    var totale_popolaz=0;

    //prelevo il massimo tra tutti i valori contenuti nei vari risultati della query
    //e lo salvo nella variabile max, e mentre leggo i valori
    //incremento le variabili tot_istanze_singole, tot_per_eta e totale_popolaz
    var max=1;
    for(i=0; i<vett.length; i++) {
        tot_istanze_singole[i] = 0;
        for (j=0; j<vett[i].length; j++) {
            var q = parseInt(vett[i][j]);
            tot_istanze_singole[i] += q;
            tot_per_eta[j] += q;
            totale_popolaz += q;
            if((q-max)>0)
                max=q;
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
    for(i = 0; i < sum.length; i++) {
        h=sum[i];
        //if(max<h){max=h;}
        w=3;
        output=output+"<img src='blank.gif' alt='"+i+" anni -> "+h+" abitanti' title='"+i+" anni -> "+h+" abitanti' class='barra2' style='height: " + (norm*h) + "px; width: " + w + "px;'/>";
    }

    var year = document.forms['frm'].elements['year'].options[document.forms['frm'].elements['year'].options.selectedIndex].value;
    var town = document.forms['frm'].elements['town'].options[document.forms['frm'].elements['town'].options.selectedIndex].value;
    var sex = document.forms['frm'].elements['sex'].options[document.forms['frm'].elements['sex'].options.selectedIndex].value;
    var Unmarried = document.forms['frm'].elements['Unmarried'].checked;
    var Married = document.forms['frm'].elements['Married'].checked;
    var Widowed = document.forms['frm'].elements['Widowed'].checked;
    var Divorced = document.forms['frm'].elements['Divorced'].checked;
    var prov = document.forms['frm'].elements['prov'].options[document.forms['frm'].elements['prov'].options.selectedIndex].value;

    var table = "<table id='result'><tr>";
    var counter = 0;
    if (!(Divorced||Married||Unmarried||Widowed)) {
        Divorced = true;
        Married = true;
        Unmarried = true;
        Widowed = true;
    }
    if (Divorced)
        counter++;
    if (Married)
        counter++;
    if (Unmarried)
        counter++;
    if (Widowed)
        counter++;

     table+="<th style='background-color:white;border:0px'></th>";
    if(sex!="Both"){
        table += "<th colspan="+counter+">"+sex+"</th>";
        table += "</tr><tr><th>Age</th>";
        if (Divorced)
            table += "<th>Divorced</th>";
        if (Married)
            table += "<th>Married</th>";
        if (Unmarried)
            table += "<th>Unmarried</th>";
        if (Widowed)
            table += "<th>Widowed</th>";
    }
    else {
        table += "<th  colspan="+counter+">Female</th><th colspan="+counter+">Male</th></tr><tr><th>Age</th>";
        if (Divorced)
            table += "<th>Divorced</th>";
        if (Married)
            table += "<th>Married</th>";
        if (Unmarried)
            table += "<th>Unmarried</th>";
        if (Widowed)
            table += "<th>Widowed</th>";
        if (Divorced)
            table += "<th>Divorced</th>";
        if (Married)
            table += "<th>Married</th>";
        if (Unmarried)
            table += "<th>Unmarried</th>";
        if (Widowed)
            table += "<th>Widowed</th>";
    }
    table += "<th>Total</th></tr>";
    var tot_popolazione = 0;
    for (j=0; j<100; j++) {
        table += "<tr>";
        table += "<td>"+j+"</td>";
        for(i=0; i<tot_istanze_singole.length; i++) {
            table += "<td>"+vett[i][j]+"</td>";
        }
        table += "<td>"+tot_per_eta[j]+"</td>";
        table += "</tr>";
    }
    table += "<tr>";
    table += "<td>100+</td>";
    for(i=0; i<vett.length; i++)
        table += "<td>"+vett[i][100]+"</td>";

    table += "<td>"+tot_popolazione+"</td>";
    table += "</tr>";
    table += "<td>TOTAL</td>";
    for (i=0; i<tot_istanze_singole.length; i++)
        table += "<td>"+tot_istanze_singole[i]+"</td>";
    table += "<td>"+totale_popolaz+"</td>";
    table += "</tr></table>";
  
   document.getElementById("pdiv").innerHTML=table;
   document.getElementById("divdata").innerHTML=output;
   }
}
function yearChanged() {
   if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
      document.getElementById("prov").innerHTML=xmlHttp.responseText
    }
}
function toyearChanged() {
   if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
      document.getElementById("toyear").innerHTML=xmlHttp.responseText
    }
}
function toMunChangedLoadYear() {
   if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
      document.getElementById("fromyear").innerHTML=xmlHttp.responseText
      document.getElementById("toyear").innerHTML=xmlHttp.responseText
    }
}
function queryChanged() {
   if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
      document.getElementById("strprova").innerHTML=xmlHttp.responseText
    }
}
function stampdivdata() {//temporaneo
   if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
      document.getElementById("divdata").innerHTML=xmlHttp.responseText
      
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
function growthing(){
    var fromyear=document.forms['frm'].elements['fromyear'].options[document.forms['frm'].elements['fromyear'].options.selectedIndex].value;
    var toyear=document.forms['frm'].elements['toyear'].options[document.forms['frm'].elements['toyear'].options.selectedIndex].value;
    var prov=document.forms['frm'].elements['prov'].options[document.forms['frm'].elements['prov'].options.selectedIndex].value;
    var town=document.forms['frm'].elements['town'].options[document.forms['frm'].elements['town'].options.selectedIndex].value;
    var sex=document.forms['frm'].elements['sex'].options[document.forms['frm'].elements['sex'].options.selectedIndex].value;
    var Unmarried=document.forms['frm'].elements['Unmarried'].checked;
    var Married=document.forms['frm'].elements['Married'].checked;
    var Widowed=document.forms['frm'].elements['Widowed'].checked;
    var Divorced=document.forms['frm'].elements['Divorced'].checked;

      //alert(s2);
    // var table= "<table border='0.5'><tr><td>prima cella</td><td>seconda cella</td></tr><tr><td>terza cella</td><td>quarta cella</td></tr></table>";
    //document.getElementById('titolo').innerHTML=s;
    //document.getElementById('divdata').innerHTML="pippo";
    //document.getElementById('pdiv').innerHTML=table;
    //document.getElementById('number').innerHTML="0      10      20      30      40      50      60      70      80      90      100";

    xmlHttp=GetXmlHttpObject()
   if (xmlHttp==null) {
      alert ("Browser does not support HTTP Request")
      return
   }
   var url="structquerygrowth.php"
   document.getElementById("divdata").innerHTML=xmlHttp.responseText
   url=url+"?fromyear="+fromyear+"&toyear="+toyear+"&prov="+prov+"&town="+town+"&sex="+sex+"&Unmarried="+Unmarried+"&Married="+Married+"&Widowed="+Widowed+"&Divorced="+Divorced;
   //url=url+"&sid="+Math.random()
   xmlHttp.onreadystatechange=divgrowthChanged
   xmlHttp.open("GET",url,true)
   xmlHttp.send(null)
  
}
function query(){
    var area=document.forms['textform'].elements['area'].value;
     xmlHttp=GetXmlHttpObject()
   if (xmlHttp==null) {
      alert ("Browser does not support HTTP Request")
      return
   }
   var url="queryloader.php"
   //url=url+"?area="+area
   url=url+"?area="+escape(area);  //Modified by AGiP
   //url=url+"&sid="+Math.random()
   xmlHttp.onreadystatechange=queryChanged
   xmlHttp.open("GET",url,true)
   xmlHttp.send(null)

    
}

function divgrowthChanged() {
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {

    var fromyear=document.forms['frm'].elements['fromyear'].options[document.forms['frm'].elements['fromyear'].options.selectedIndex].value;
    var toyear=document.forms['frm'].elements['toyear'].options[document.forms['frm'].elements['toyear'].options.selectedIndex].value;
    var prov=document.forms['frm'].elements['prov'].options[document.forms['frm'].elements['prov'].options.selectedIndex].value;
    var town=document.forms['frm'].elements['town'].options[document.forms['frm'].elements['town'].options.selectedIndex].value;
    var sex=document.forms['frm'].elements['sex'].options[document.forms['frm'].elements['sex'].options.selectedIndex].value;
    var Unmarried=document.forms['frm'].elements['Unmarried'].checked;
    var Married=document.forms['frm'].elements['Married'].checked;
    var Widowed=document.forms['frm'].elements['Widowed'].checked;
    var Divorced=document.forms['frm'].elements['Divorced'].checked;

    var output="";
    var indice=150;

    //ricevuta la stringa di risposta contente i risultati della query separati dal carattere "|",
    //la splitto e memorizzo i singoli risultati nella variabile data
    var data = xmlHttp.responseText.split('|');

    //ricopio i risultati ottenuti all'interno di una variabile vett,
    //eliminando l'ultimo che in realtà a causa della costruzione della stringa di risposta
    //corrisponde ad una stringa vuota
    var vett = new Array();
    for (i=0; i<data.length-1; i++)
        vett[i] = data[i].split(',');

    //creo una variabile relativa al numero di anni da graficare
    var years = toyear - fromyear + 1;

    //definisco e inizializzo un array che conterrà la popolazione totale nei vari anni
    var pop_in_the_years = new Array();
    for (i=0; i<years; i++) {
        pop_in_the_years[i]=0;
    }

    //definisco una variabile che mi indica quanti vettori di popolazione mi vengono restituiti per ogni anno
    var vett_number_per_year = vett.length/years;

    //variabile usata per il debug
    var debug = "";

    //riempio l'array della popolazione totale
    for (i=0; i<vett.length; i++) {
        var sum = 0;
        //sommo in numero di abitanti di ogni vettore di popolazione iterando su tutte le età
        //e ne salvo il totale nella variabile sum
        for (j=0; j<vett[i].length; j++) {
            sum += parseInt(vett[i][j]);
        }
        debug += "sum = " + sum + " || i = " + i + "|| i%years = "+ (i%years)+"<br/>";
        //incremento della quantità sum la componente dell'array pop_in_the_years
        //relativa alla popolazione contata
        pop_in_the_years[i%years] += sum;
    }

    //prelevo il massimo tra tutti i valori contenuti nell'array risultante
    var max=1;
    for(i=0; i<pop_in_the_years.length; i++) {
        var q = parseInt(pop_in_the_years[i]);
        if((q-max)>0)
            max=q;
    }

     //calcolo il fattore di normalizzazione
     var norm=indice/max;

     //grafico la popolazione complessiva per anno
    for(i=0; i<pop_in_the_years.length; i++) {
        h=pop_in_the_years[i];
        w=30;
        output=output+"<img src='blank.gif' alt='anno "+(parseInt(fromyear)+parseInt(i))+" -> "+h+" abitanti' title='anno "+(parseInt(fromyear)+parseInt(i))+" -> "+h+" abitanti' class='barra2' style='height: " + (norm*h) + "px; width: " + w + "px;'/>";
    }

//    var table = "<table id='result'><tr>";
//    var counter = 0;
//    if (!(Divorced||Married||Unmarried||Widowed)) {
//        Divorced = true;
//        Married = true;
//        Unmarried = true;
//        Widowed = true;
//    }
//    if (Divorced)
//        counter++;
//    if (Married)
//        counter++;
//    if (Unmarried)
//        counter++;
//    if (Widowed)
//        counter++;
//
//     table+="<th style='background-color:white;border:0px'></th>";
//    if(sex!="Both"){
//        table += "<th colspan="+counter+">"+sex+"</th>";
//        table += "</tr><tr><th>Age</th>";
//        if (Divorced)
//            table += "<th>Divorced</th>";
//        if (Married)
//            table += "<th>Married</th>";
//        if (Unmarried)
//            table += "<th>Unmarried</th>";
//        if (Widowed)
//            table += "<th>Widowed</th>";
//    }
//    else {
//        table += "<th  colspan="+counter+">Female</th><th colspan="+counter+">Male</th></tr><tr><th>Age</th>";
//        if (Divorced)
//            table += "<th>Divorced</th>";
//        if (Married)
//            table += "<th>Married</th>";
//        if (Unmarried)
//            table += "<th>Unmarried</th>";
//        if (Widowed)
//            table += "<th>Widowed</th>";
//        if (Divorced)
//            table += "<th>Divorced</th>";
//        if (Married)
//            table += "<th>Married</th>";
//        if (Unmarried)
//            table += "<th>Unmarried</th>";
//        if (Widowed)
//            table += "<th>Widowed</th>";
//    }
//    table += "<th>Total</th></tr>";
//    var tot_popolazione = 0;
//    for (j=0; j<100; j++) {
//        table += "<tr>";
//        table += "<td>"+j+"</td>";
//        for(i=0; i<tot_istanze_singole.length; i++) {
//            table += "<td>"+vett[i][j]+"</td>";
//        }
//        table += "<td>"+tot_per_eta[j]+"</td>";
//        table += "</tr>";
//    }
//    table += "<tr>";
//    table += "<td>100+</td>";
//    for(i=0; i<vett.length; i++)
//        table += "<td>"+vett[i][100]+"</td>";
//
//    table += "<td>"+tot_popolazione+"</td>";
//    table += "</tr>";
//    table += "<td>TOTAL</td>";
//    for (i=0; i<tot_istanze_singole.length; i++)
//        table += "<td>"+tot_istanze_singole[i]+"</td>";
//    table += "<td>"+totale_popolaz+"</td>";
//    table += "</tr></table>";
//
//   document.getElementById("pdiv").innerHTML=table;
   document.getElementById("divdata").innerHTML=output;
   }
}