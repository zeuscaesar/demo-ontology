<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="OWL,Demography,Ontology" />
<meta name="description" content="This is Demography Ontology, a project developed at the Computer Science and Telecomunication department of the University of Catania." />
<meta name="author" content="Luciano De Franco, Giuseppe Alessandro, Carlo Leonardi"/>
<meta name="copyright" content="Luciano De Franco, Giuseppe Alessandro, Carlo Leonardi"/>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Demography Ontology - Geo Search</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="js-code/maps.js"></script>
<script type="text/javascript" src="js-code/util.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
</head>
<body onload="initialize()">
<div id="wrapper">
	<div id="header">
		<div id="logo">
			<h1><a href="#">Demography Ontology</a></h1>
			<p><a href=""></a></p>
		</div>
		<div id="search">
			<form method="get" action="">
				<fieldset>
				<input id="search-text" type="text" name="s" value="Search" size="15" />
				<input type="submit" id="search-submit" value="Search" />
				</fieldset>
			</form>
		</div>
		<!-- end #search -->
	</div>
	<!-- end #header -->
	<div id="menu">
		<ul>
                                <li><a href="index.php">Home</a></li>
                                <li><a href="search.php">Simple Search</a></li>
                                <li><a href="geosearch.php">Geo Search</a></li>
                                <li><a href="growth.php">Growth</a></li>
                                <li><a href="freequery.php">Free Query</a></li>
                                <li><a href="help.php">Help</a></li>
                                <li><a href="about.php">About</a></li>
		</ul>
	</div>
	<!-- end #menu -->
	<div id="page">
		<div id="content">
			<div class="post" >
                                <div id="map_canvas" style="width:100%; height:400px;"></div>
			</div>
		</div>
		<!-- end #content -->
		<div id="sidebar">
			<ul>
                                
				<li>
                                    <ul>
                                        <li></li>
                                        <li>
                                    <label id="lb">
                                        <form name="frm" method="post">

                                        <span>Year: </span><select name="year" id="year" class="select" onChange="loadProv(this.value)">
                                                <?php
                                                    include_once ('HTTP/Request.php');
                                                    include_once ('query.php');
                                                    $sesame_url = "http://localhost:8080/openrdf-sesame";
                                                    $year_query ='?queryLn=SPARQL&query=PREFIX%20DemoOntology:<http://demo-ontology.googlecode.com/svn/trunk/demo-ontology/DemoOntology.owl%23>%0Aselect%20distinct%20%3Fx%0Awhere{%0A%3Fy%20DemoOntology:livingInTheYear%20%3Fx%0A}ORDER%20BY%20DESC(%3Fx)';
                                                    $year_requestString = $sesame_url.'/repositories/demography'.$year_query;
                                                    $year_req =& new HTTP_Request($year_requestString);
                                                    $year_req->setMethod(HTTP_REQUEST_METHOD_GET);
                                                    $year_req->addHeader("Accept", "application/sparql-results+xml, */*;q=0.5");
                                                    $year_req->sendRequest();
                                                    $year_responseCode = $year_req->getResponseCode();
                                                    if($year_responseCode!=200)
                                                       echo "Errore di codice ".$year_responseCode;
                                                    else {
                                                        $year_responseBody = $year_req->getResponseBody();
                                                        $year_xml=simplexml_load_string($year_responseBody);
                                                        foreach($year_xml->results->result as $year_item) {
                                                           $year_value=$year_item->binding->literal;
                                                           echo '<option value="'.$year_value.'">'.$year_value.'</option>';
                                                        }
                                                        $selected_year = $year_xml->results->result->binding->literal;
                                                    }
                                                    echo "</select><br/>";
                                                    echo '<span>Province: </span><select name="prov" class="select" id="prov" onChange="loadTowns(this.value)">';
                                                    $prov_query = openRDF('select distinct ?name where{?prov rdf:type DemoOntology:Province. ?prov DemoOntology:hasName ?name. ?prov DemoOntology:hasMunicipality ?mun. ?mun DemoOntology:hasPopulation ?pop. ?pop DemoOntology:livingInTheYear "'.$selected_year.'"^^xsd:int.');
                                                    $prov_query = closeRDF($prov_query);
                                                    $prov_requestString = $sesame_url.'/repositories/demography'.$prov_query;
                                                    $prov_req =& new HTTP_Request($prov_requestString);
                                                    $prov_req->setMethod(HTTP_REQUEST_METHOD_GET);
                                                    $prov_req->addHeader("Accept", "application/sparql-results+xml, */*;q=0.5");
                                                    $prov_req->sendRequest();
                                                    $prov_responseCode = $prov_req->getResponseCode();
                                                    if($prov_responseCode!=200)
                                                        echo "Errore di codice ".$prov_responseCode;
                                                    else {
                                                        $prov_responseBody = $prov_req->getResponseBody();
                                                        $prov_xml=simplexml_load_string($prov_responseBody);
                                                        foreach($prov_xml->results->result as $prov_item){
                                                            $prov_value=$prov_item->binding->literal;
                                                            echo '<option value="'.$prov_value.'">'.$prov_value.'</option>';
                                                        }
                                                        $selected_prov = $prov_xml->results->result->binding->literal;
                                                    }
                                                    echo "</select><br/>";
                                                    echo '<span>Municipality: </span><select name="town" class="select" id="town">';
                                                    echo "<option value='0'>--    All    --</option>\n";
                                                    $town_query = openRDF('select distinct ?townname where{?prov rdf:type DemoOntology:Province. ?prov DemoOntology:hasName "'.$selected_prov.'"^^rdfs:Literal. ?prov DemoOntology:hasMunicipality ?mun. ?mun DemoOntology:hasPopulation ?pop. ?mun DemoOntology:hasName ?townname.');
                                                    $town_query = closeRDF($town_query);
                                                    $town_requestString = $sesame_url.'/repositories/demography'.$town_query;
                                                    $town_req =& new HTTP_Request($town_requestString);
                                                    $town_req->setMethod(HTTP_REQUEST_METHOD_GET);
                                                    $town_req->addHeader("Accept", "application/sparql-results+xml, */*;q=0.5");
                                                    $town_req->sendRequest();
                                                    $town_responseCode = $town_req->getResponseCode();
                                                    if($town_responseCode!=200)
                                                        echo "Errore di codice ".$town_responseCode;
                                                    else {
                                                        $town_responseBody = $town_req->getResponseBody();
                                                        $town_xml = simplexml_load_string($town_responseBody);
                                                        foreach($town_xml->results->result as $town_item){
                                                            $town_value = $town_item->binding->literal;
                                                            echo '<option value="'.$town_value.'">'.$town_value.'</option>';
                                                        }
                                                    }
                                                ?>
                                          </select><br/>
                                        </form>
                                        <button id="try" onClick="showMap()">Show</button>
                                    </label>
                                    

                                        </li>
                                        <br/>
                                        <li>
					<h2>Help</h2>
                                        <p>Markerplaces for the selected municipalities are shown on a Google map. By clicking them, a window contening a summary of the municipal demographic information appears.</p>
                                        </li>
                                    </ul>
                                </li>
				
			</ul>
		</div>
		<!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	<!-- end #page -->
<div id="footer">
	<p>Copyright (c) 2011 DemographyOntology.com. All rights reserved. Design by <a href="mailto:alexgpeppe84@hotmail.it">GA</a> - <a href="http://lucianodefranco.altervista.org/">LDF</a> - <a href="mailto:carloleonardi83@gmail.com">CL</a>.</p>
</div>
<!-- end #footer -->
</div>
</body>
</html>