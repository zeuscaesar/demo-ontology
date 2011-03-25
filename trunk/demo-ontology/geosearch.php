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
				<h2 class="title"><a href="#">Demography Ontology </a></h2>

                                <p id="pdiv" class="meta" >Posted by <a href="#">Someone</a> on March 10, 2008
					&nbsp;&bull;&nbsp; <a href="#" class="comments">Comments (64)</a> &nbsp;&bull;&nbsp; <a href="#" class="permalink">Full article</a></p>
                                            <div id="map_canvas" style="width:100%; height:400px; margin-top:3em;"></div>
                                 <p id='number'></p>
			</div>
		</div>
		<!-- end #content -->
		<div id="sidebar">
			<ul>
				<li>
                                    <label id="lb">
                                        <form name="frm" method="post"> <!--action='submit.php'>-->

                                        <span>Year: </span><select name="year" id="year" class="select" onChange="loadProv(this.value)">
                                                <?php
                                                    include_once ('HTTP/Request.php');
                                                    include_once ('query.php');
                                                    $sesame_url = "http://localhost:8080/openrdf-sesame";
                                                    $year_query ='?queryLn=SPARQL&query=PREFIX%20DemoOntology:<http://demo-ontology.googlecode.com/svn/trunk/demo-ontology/DemoOntology.owl%23>%0Aselect%20distinct%20%3Fx%0Awhere{%0A%3Fy%20DemoOntology:livingInTheYear%20%3Fx%0A}ORDER%20BY%20%3Fx';
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
                                                        //$address = new SimpleXMLElement($year_responseBody);
                                                        foreach($year_xml->results->result as $year_item) {
                                                           $year_value=$year_item->binding->literal;
                                                           echo '<option value="'.$year_value.'">'.$year_value.'</option>';
                                                        }
                                                        $selected_year = $year_xml->results->result->binding->literal;
                                                    }

                                                    echo "</select><br/>";
                                                    echo '<span>Province: </span><select name="prov" class="select" id="prov" onChange="loadTowns(this.value)">';
                                                    $prov_query = openRDF('
                                                        select distinct ?name
                                                        where{
                                                        ?prov rdf:type DemoOntology:Province.
                                                        ?prov DemoOntology:hasName ?name.
                                                    ');
                                                    $prov_query = closeRDF($prov_query);
                                                    $prov_requestString = $sesame_url.'/repositories/demography'.$prov_query;
                                                    $prov_req =& new HTTP_Request($prov_requestString);
                                                    $prov_req->setMethod(HTTP_REQUEST_METHOD_GET);
                                                    $prov_req->addHeader("Accept", "application/sparql-results+xml, */*;q=0.5");
                                                    $prov_req->sendRequest();
                                                    $prov_responseCode = $prov_req->getResponseCode();
                                                    if($prov_responseCode!=200)
                                                        //echo "Errore di codice ".$prov_responseCode;
                                                        echo '<option value="Errore">Errore</option>';
                                                    else {
                                                        $prov_responseBody = $prov_req->getResponseBody();
                                                        $prov_xml=simplexml_load_string($prov_responseBody);
                                                        //echo $response_body;
                                                        foreach($prov_xml->results->result as $prov_item){
                                                            $prov_value=$prov_item->binding->literal;
                                                            echo '<option value="'.$prov_value.'">'.$prov_value.'</option>';
                                                        }
                                                        $selected_prov = $prov_xml->results->result->binding->literal;
                                                    }

                                                    echo "</select><br/>";
                                                    echo '<span>Municipality: </span><select name="town" class="select" id="town">';

                                                echo "<option value='0'>--    All    --</option>\n";

                                                    $query2 = openRDF('
                                                        select distinct ?townname
                                                        where{
                                                        ?prov rdf:type DemoOntology:Province.
                                                        ?prov DemoOntology:hasName "'.$selected_prov.'"^^rdfs:Literal.
                                                        ?prov DemoOntology:hasMunicipality ?mun.
                                                        ?mun DemoOntology:hasPopulation ?pop.
                                                        ?mun DemoOntology:hasName ?townname.
                                                    ');
                                                    $query2 = closeRDF($query2);
                                                    $requestString2 = $sesame_url.'/repositories/demography'.$query2;
                                                    $req2 =& new HTTP_Request($requestString2);
                                                    $req2->setMethod(HTTP_REQUEST_METHOD_GET);
                                                    $req2->addHeader("Accept", "application/sparql-results+xml, */*;q=0.5");
                                                    $req2->sendRequest();
                                                    $response_code2 = $req2->getResponseCode();
                                                    if($response_code2!=200)
                                                        echo "Errore di codice ".$response_code2;
                                                    else {
                                                        $response_body2 = $req2->getResponseBody();
                                                        $xml2=simplexml_load_string($response_body2);
                                                        foreach($xml2->results->result as $item){
                                                            $value2=$item->binding->literal;
                                                            echo '<option value="'.$value2.'">'.$value2.'</option>';
                                                        }
                                                    }
                                            ?>
                                          </select><br/>
                                        </form>
                                        <button id="try" onClick="showMap()"> Start Query </button>
                                    </label>
					<h2>Aliquam tempus</h2>
					<p>Mauris vitae nisl nec metus placerat perdiet est. Phasellus dapibus semper urna ornare, orci in consectetuer hendrerit.</p>
				</li>
				<li>
					<h2>Categories</h2>
					<ul>
						<li><a href="#">Uncategorized</a> (3) </li>
						<li><a href="#">Lorem Ipsum</a> (42) </li>
						<li><a href="#">Urna Congue Rutrum</a> (28) </li>
						<li><a href="#">Augue Praesent</a> (55) </li>
						<li><a href="#">Vivamus Fermentum</a> (13) </li>
					</ul>
				</li>
				<li>
					<h2>Blogroll</h2>
					<ul>
						<li><a href="#">Uncategorized</a> (3) </li>
						<li><a href="#">Lorem Ipsum</a> (42) </li>
						<li><a href="#">Urna Congue Rutrum</a> (28) </li>
						<li><a href="#">Augue Praesent</a> (55) </li>
						<li><a href="#">Vivamus Fermentum</a> (13) </li>
					</ul>
				</li>
				<li>
					<h2>Archives</h2>
					<ul>
						<li><a href="#">December 2007</a>&nbsp;(29)</li>
						<li><a href="#">November 2007</a>&nbsp;(30)</li>
						<li><a href="#">October 2007</a>&nbsp;(31)</li>
						<li><a href="#">September 2007</a>&nbsp;(30)</li>
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