var xmlHttp;
var infowindow;
var map;
var markersArray = [];

function loadProv(str) {
   xmlHttp = GetXmlHttpObject();
   if (xmlHttp==null) {
      alert ("Browser does not support HTTP Request");
      return;
   }
   var url = "geoprovloader.php";
   url = url+"?year="+str;
   url = url+"&sid="+Math.random();
   xmlHttp.onreadystatechange = yearChanged;
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}

function loadTowns(str) {
   xmlHttp = GetXmlHttpObject();
   if (xmlHttp==null) {
      alert ("Browser does not support HTTP Request");
      return;
   }
   var url = "geotownloader.php";
   var year = document.forms['frm'].elements['year'].options[document.forms['frm'].elements['year'].options.selectedIndex].value;
   url = url+"?prov="+str+"&year="+year;
   url = url+"&sid="+Math.random();
   xmlHttp.onreadystatechange = stateChanged;
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}

function stateChanged() {
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
        document.getElementById("town").innerHTML = xmlHttp.responseText;
   }
}

function yearChanged() {
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
        document.getElementById("prov").innerHTML = xmlHttp.responseText;
    }
}

function GetXmlHttpObject() {
   var xmlHttp = null;
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

function showMap() {
    var year = document.forms['frm'].elements['year'].options[document.forms['frm'].elements['year'].options.selectedIndex].value;
    var prov = document.forms['frm'].elements['prov'].options[document.forms['frm'].elements['prov'].options.selectedIndex].value;
    var town = document.forms['frm'].elements['town'].options[document.forms['frm'].elements['town'].options.selectedIndex].value;

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp==null) {
        alert ("Browser does not support HTTP Request");
        return;
   }
   var url = "geoquery.php";
   url = url+"?year="+year+"&prov="+prov+"&town="+town;
   xmlHttp.onreadystatechange=changeMapOK;
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
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

function changeMapOK() {
    var prov = document.forms['frm'].elements['prov'].options[document.forms['frm'].elements['prov'].options.selectedIndex].value;
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
        var results = xmlHttp.responseText.split('|');
        var municipalities_data = new Array();
        clearOverlays();
        geocoder.geocode({
            'address': prov+', IT',
            'partialmatch': true},
            geocodeResult);
        for (var i=0; i<results.length-1; i++) {
            var pos = i;
            municipalities_data[i] = results[i].split('#');
            var name = municipalities_data[pos][0];
            var lat = parseFloat(municipalities_data[i][1].split(',')[1]);
            var lng = parseFloat(municipalities_data[i][1].split(',')[0]);
            var latlng = new google.maps.LatLng(lat,lng);
            var info = "";
            info = infobuild(municipalities_data[i][2]);
            createMarker(name,latlng, info);
        }
    }
}

function infobuild(pop_string) {

    //definisco una variabile info_string di tipo stringa che conterrà l'informazione
    //da visualizzare nel fumetto sulla mappa
    var info_string="";

    //salvo nell'array components le varie componenti della popolazione, ancora sotto forma di stringa
    var components = new Array();
    components = pop_string.split(':');

    //creo un array people e lo riempio con le componenti della popolazione sotto forma di array di interi
    var people = new Array();
    for (i=0; i<components.length; i++)
        people[i] = components[i].split(',');

    //creo e inizializzo array sum per tenere conto del numero totale di persone
    //per ogni componente della popolazione
    var sum = new Array();
    for (i=0; i<people.length; i++) {
        sum[i] = 0;
        for (j=0; j<people[i].length; j++) {
            sum[i] += parseInt(people[i][j])
        }
    }

    info_string += tablebuild(sum);
    return info_string;

}

function geocodeResult(results, status) {
    if (status == 'OK' && results.length > 0) {
        map.fitBounds(results[0].geometry.viewport);
        map.setZoom(8);
    }
    else
        alert("Geocode was not successful for the following reason: " + status);
}

function createMarker(name, latlng, info) {
    var marker = new google.maps.Marker({position:latlng, map:map});
    markersArray.push(marker);
    google.maps.event.addListener(marker, "click", function() {
        if (infowindow)
            infowindow.close();
        infowindow = new google.maps.InfoWindow({content: "<div class='municipality'>"+name+"</div>"+info});
        infowindow.open(map, marker);
        });
    return marker;
}

function tablebuild(sum_array) {

    var table = "<table id='result' class='geoquerytable'>";
    var total_female = sum_array[0]+sum_array[1]+sum_array[2]+sum_array[3];
    var total_male = sum_array[4]+sum_array[5]+sum_array[6]+sum_array[7];
    var total = total_female+total_male;
    table += "<tr class='sex'><th style='background-color:white;border:0px'></th><th class='female'>Female</th><th class='male'>Male</th><th class='bothsex'>Total</th></tr>";
    table += "<tr><th class='divorced'>Divorced</th><td class='female'>"+sum_array[0]+"</td><td class='male'>"+sum_array[4]+"</td><td class='bothsex'>"+(parseInt(sum_array[0])+parseInt(sum_array[4]))+"</td></tr>";
    table += "<tr><th class='married'>Married</th><td class='female'>"+sum_array[1]+"</td><td class='male'>"+sum_array[5]+"</td><td class='bothsex'>"+(parseInt(sum_array[1])+parseInt(sum_array[5]))+"</td></tr>";
    table += "<tr><th class='unmarried'>Unmarried</th><td class='female'>"+sum_array[2]+"</td><td class='male'>"+sum_array[6]+"</td><td class='bothsex'>"+(parseInt(sum_array[2])+parseInt(sum_array[6]))+"</td></tr>";
    table += "<tr><th class='widowed'>Widowed</th><td class='female'>"+sum_array[3]+"</td><td class='male'>"+sum_array[7]+"</td><td class='bothsex'>"+(parseInt(sum_array[3])+parseInt(sum_array[7]))+"</td></tr>";
    table += "<tr><th class='allmaritalstatus'>All</th><td class='female' id='totalf'>"+total_female+"</td><td class='male' id='totalm'>"+total_male+"</td><td class='bothsex' id='total'>"+total+"</td></tr>";
    table += "</table>";

    return table;
}