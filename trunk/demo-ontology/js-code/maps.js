var xmlHttp;
var infowindow;
var map;
var markersArray = [];
var debug = "";

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
function showMap(){
//    var year=document.forms['frm'].elements['year'].options[document.forms['frm'].elements['year'].options.selectedIndex].value;
    var prov=document.forms['frm'].elements['prov'].options[document.forms['frm'].elements['prov'].options.selectedIndex].value;
//    var town=document.forms['frm'].elements['town'].options[document.forms['frm'].elements['town'].options.selectedIndex].value;
//    var sex=document.forms['frm'].elements['sex'].options[document.forms['frm'].elements['sex'].options.selectedIndex].value;
//    var Unmarried=document.forms['frm'].elements['Unmarried'].checked;
//    var Married=document.forms['frm'].elements['Married'].checked;
//    var Widowed=document.forms['frm'].elements['Widowed'].checked;
//    var Divorced=document.forms['frm'].elements['Divorced'].checked;

    xmlHttp=GetXmlHttpObject()
    if (xmlHttp==null) {
        alert ("Browser does not support HTTP Request")
        return
   }
   var url="geoquery.php"
   //url=url+"?year="+year+"&prov="+prov+"&town="+town+"&sex="+sex+"&Unmarried="+Unmarried+"&Married="+Married+"&Widowed="+Widowed+"&Divorced="+Divorced;
   url=url+"?prov="+prov+"&town="+town;
   xmlHttp.onreadystatechange=changeMapOK;
   xmlHttp.open("GET",url,true)
   xmlHttp.send(null)
}

function initialize() {
    geocoder = new google.maps.Geocoder();
    var myLatlng = new google.maps.LatLng(41.8954656, 12.4823243);
    var myOptions = {
        zoom: 5,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
}

function clearOverlays() {
    if (markersArray) {
        for (i in markersArray) {
            markersArray[i].setMap(null);
	}
    }
}

function geocode() {
    clearOverlays(); //richiama la funzione per cancellare eventuali precedenti markers
    var ind1 = document.getElementById("comuni").value;
    var ind2 = " ,IT";
    var address = ind1 + ind2; // se cercassimo solo "Roma" potremmo rischiare di trovare una citta' con nome simile, pertanto aggiungo anche ,IT
    geocoder.geocode({
        'address': address,
        'partialmatch': true },
        geocodeResult);
    var link = "generazione_xml.php?comune=";
    downloadUrl(link+ind1, function(data) { // trasmetto a generazione_xml con GET il nome del comune di cui voglio estrarre i markers
        var markers = data.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
            var latlng = new google.maps.LatLng(parseFloat(markers[i].getAttribute("lat")),
            parseFloat(markers[i].getAttribute("lng")));
            var marker = createMarker(markers[i].getAttribute("name"), latlng);
       }
     });
}

function changeMapOK() {
    var prov=document.forms['frm'].elements['prov'].options[document.forms['frm'].elements['prov'].options.selectedIndex].value;
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
        var results = xmlHttp.responseText.split('|');
        var municipalities_and_coord = new Array();
        clearOverlays();
        geocoder.geocode({
            'address': prov+', IT',
            'partialmatch': true },
            geocodeResult);
        for (i=0; i<results.length-1; i++) {
            municipalities_and_coord[i] = results[i].split(',');
            var name = municipalities_and_coord[i][0];
            var lat = parseFloat(municipalities_and_coord[i][2]);
            var lng = parseFloat(municipalities_and_coord[i][1]);
            var latlng = new google.maps.LatLng(lat,lng);
            createMarker(name,latlng);
        }
    }
}

function geocodeResult(results, status) {
    if (status == 'OK' && results.length > 0) {
        map.fitBounds(results[0].geometry.viewport);
        map.setZoom(8);
    }
    else
        alert("Geocode was not successful for the following reason: " + status);
}


function createMarker(name, latlng) {
    var marker = new google.maps.Marker({position:latlng, map:map});
//    debug += "Ho creato il marker di "+name+".<br/>";
    markersArray.push(marker);
//    debug += "Ho inserito il marker di "+name+" nel vettore.<br/>";
    google.maps.event.addListener(marker, "click", function() {
        if (infowindow)
            infowindow.close();
        var content = "<div>PROVA</div>";
        infowindow = new google.maps.InfoWindow({content: name+content});
        infowindow.open(map, marker);
        });
//    debug += "Ho aggiunto un listener al marker di "+name+"; esco dal metodo di creazione del marker.<br/>";
    return marker;
}
