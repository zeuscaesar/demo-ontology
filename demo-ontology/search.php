<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="OWL,Demography,Ontology" />
<meta name="description" content="This is Demography Ontology, a project developed at the Computer Science and Telecomunication department of the University of Catania." />
<meta name="author" content="Luciano De Franco, Giuseppe Alessandro, Carlo Leonardi"/>
<meta name="copyright" content="Luciano De Franco, Giuseppe Alessandro, Carlo Leonardi"/>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Demography Ontology - Simple Search</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="js-code/js.js"></script>
<script type="text/javascript" src="js-code/js-graph.js"></script>

</head>
<body>
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
				<h2 class="title"><a href="#">Simple Search </a></h2>
                                
                                <p id="pdiv" class="meta" ></p>
                                <p id='number'></p>
                                <div id ="divdata" >
                                Edit your Simple Query
                                </div>
			</div>
			
			
		</div>
		<!-- end #content -->
		<div id="sidebar">
			<ul>
				<li>
                                    <label id="lb">
                                        <form name="frm" method="post"> <!--action='submit.php'>-->

                                        <span>Year: </span><select name="year" id="year" class="select" onChange="loadProv(this.value)"> <!--alert(this.value)">-->
                                                <?php
                                                    include_once ( 'HTTP/Request.php' );
                                                    include_once ('query.php');
                                                    $sesame_url = "http://localhost:8080/openrdf-sesame";
                                                    $query='select distinct ?x where{?y DemoOntology:livingInTheYear ?x.}ORDER BY ?x';
                                                    $query=openRDF($query);
                                                    //$query ='?queryLn=SPARQL&query=PREFIX%20DemoOntology:<http://demo-ontology.googlecode.com/svn/trunk/demo-ontology/DemoOntology.owl%23>%0Aselect%20distinct%20%3Fx%0Awhere{%0A%3Fy%20DemoOntology:livingInTheYear%20%3Fx%0A}';
                                                    $requestString = $sesame_url.'/repositories/demography'.$query;
                                                    $req =& new HTTP_Request($requestString);
                                                    //echo $requestString;
                                                    $req->setMethod(HTTP_REQUEST_METHOD_GET);
                                                    $req->addHeader("Accept", "application/sparql-results+xml, */*;q=0.5");
                                                    $req->sendRequest();
                                                    $response_code = $req->getResponseCode();
                                                    if($response_code!=200)
                                                            echo "Errore di codice ".$response_code;
                                                    else
                                                        {
                                                        $response_body = $req->getResponseBody();
                                                        //echo "Risposta ricevuta correttamente<br/><br>";
                                                        //echo $response_body."<br/><br/>";
                                                        $xml=simplexml_load_string($response_body);
                                                        $address = new SimpleXMLElement($response_body);
                                                        foreach($xml->results->result as $item){
                                                        $value=$item->binding->literal;
                                                        echo '<option value="'.$value.'">'.$value.'</option>';}
                                                       }
                                                   ?>
                                          </select><br/>
                                        <span>Province: </span><select name="prov" class="select" id="prov" onChange="loadTowns(this.value)">
                                           <option value="0">--  All --</option>
                                        </select><br/>
                                        <span>Municipality: </span><select name="town" class="select" id="town">
                                                <option value="0">--  All --</option>
                                          </select><br/>
                                        <span>Sex: </span><select name="sex" class="select" id="sex">

                                                <option value="Both">Both</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                          </select><br/>
                                        <span>Marital Status: </span><br/>
                                        <input  type="checkbox" checked="true" name="Unmarried" id="Unmarried">Unmarried</input>    <input  type="checkbox" checked="true" name="Married" id="Married">Married</input><br/>
                                        <input  type="checkbox" checked="true" name="Divorced" id="Divorced">Divorced</input>     <input  type="checkbox" checked="true" name="Widowed" id="Widowed">Widowed</input><br/>

                                        </form>
                                        <button id="try" onClick="prova()"> Start Query </button>
                                    </label>
					<h2>Help</h2>
					<p>This page allows you to query the SESAME repository to get information about population living in a given year in a given geographical area (a specific municipality, or a province, or the whole Italian territory), according to the selected sex and marital status. After having filled the form on the left side of the page, by clicking the "Start Query" button a graphic and a table appear: they show the result of user's query. The graphic shows the total amount of people which forms the population partitioned by age. The table shows the amount of people which forms the population partitioned by age, sex and marital status.</p>
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