<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="OWL,Demography,Ontology" />
<meta name="description" content="This is Demography Ontology, a project developed at the Computer Science and Telecomunication department of the University of Catania." />
<meta name="author" content="Luciano De Franco, Giuseppe Alessandro, Carlo Leonardi"/>
<meta name="copyright" content="Luciano De Franco, Giuseppe Alessandro, Carlo Leonardi"/>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<title>Demography Ontology - Growth</title>
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
				<h2 class="title"><a href="#">Demography Ontology </a></h2>
                                
                                <p id="pdiv" class="meta" >Posted by <a href="#">Someone</a> on March 10, 2008
					&nbsp;&bull;&nbsp; <a href="#" class="comments">Comments (64)</a> &nbsp;&bull;&nbsp; <a href="#" class="permalink">Full article</a></p>
				<div id ="divdata" >
                                  
                                </div>
                                 <p id='number'></p>
			</div>
			<div class="post">
				<h2 class="title"><a href="#">Lorem ipsum sed aliquam</a></h2>
				<p class="meta">Posted by <a href="#">Someone</a> on March 8, 2008
					&nbsp;&bull;&nbsp; <a href="#" class="comments">Comments (64)</a> &nbsp;&bull;&nbsp; <a href="#" class="permalink">Full article</a></p>
				<div class="entry">
					<p>Sed lacus. Donec lectus. Nullam pretium nibh ut turpis. Nam bibendum. In nulla tortor, elementum vel, tempor at, varius non, purus. Mauris vitae nisl nec metus placerat consectetuer. Donec ipsum. Proin imperdiet est. Phasellus <a href="#">dapibus semper urna</a>. Pellentesque ornare, orci in consectetuer hendrerit, urna elit eleifend nunc, ut consectetuer nisl felis ac diam. Etiam non felis. Donec ut ante. In id eros. Suspendisse lacus turpis, cursus egestas at sem. Phasellus pellentesque. Mauris quam enim, molestie in, rhoncus ut, lobortis a, est.</p>
					<p>Praesent ac lectus. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Vivamus augue. Fusce eget tellus ultrices ligula volutpat adipiscing. Aenean ligula lectus, vehicula in, dictum a, fermentum nec, felis. Nunc ac turpis in leo posuere imperdiet.</p>
				</div>
			</div>
			<div class="post">
				<h2 class="title"><a href="#">Phasellus pellentesque turpis </a></h2>
				<p class="meta">Posted by <a href="#">Someone</a> on March 8, 2008
					&nbsp;&bull;&nbsp; <a href="#" class="comments">Comments (64)</a> &nbsp;&bull;&nbsp; <a href="#" class="permalink">Full article</a></p>
				<div class="entry">
					<p>Sed lacus. Donec lectus. Nullam pretium nibh ut turpis. Nam bibendum. In nulla tortor, elementum vel, tempor at, varius non, purus. Mauris vitae nisl nec metus placerat consectetuer. Donec ipsum. Proin imperdiet est. Pellentesque ornare, orci in consectetuer hendrerit, urna elit eleifend nunc, ut consectetuer nisl felis ac diam. Etiam non felis. Donec ut ante. In id eros. Suspendisse lacus turpis, cursus egestas at sem. Phasellus pellentesque. Mauris quam enim molestie  rhoncus lobortis a, est.</p>
				</div>
			</div>
		</div>
		<!-- end #content -->
		<div id="sidebar">
			<ul>
				<li>
                                    <label id="lb">
                                        <form name="frm" method="post"> <!--action='submit.php'>-->
                                        
                                        <span>Province: </span><select name="prov" class="select" id="prov" onChange="loadTownswy(this.value)">
                                           <option value="0">--    All    --</option>
                                           <?php
                                                    include_once ( 'HTTP/Request.php' );
                                                    include_once ('query.php');
                                                    $sesame_url = "http://localhost:8080/openrdf-sesame";
                                                    $query='select distinct ?x where{?y rdf:type DemoOntology:Province. ?y DemoOntology:hasName ?x.}ORDER by ?x';
                                                    $query=openRDF($query);
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
                                                        echo '<option value="'.$value.'">'.$value.'</option>';
                                                        }
                                                       }
                                                   ?>
                                        </select><br/>
                                        <span>Municipality: </span><select name="town" class="select" id="town" onChange="loadYearByMun(this.value)" >
                                                <option value="0">--  All Town --</option>
                                          </select><br/>
                                        <span>Sex: </span><select name="sex" class="select" id="sex">

                                                <option value="Both">Both</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                          </select><br/>
                                        <span>From Year: </span><select name="fromyear" id="fromyear" class="select" onChange="loadtoyear(this.value)">
                                                <option value="sel">-- Selection --</option>


                                          </select><br/>
                                        <span>To Year: </span><select name="toyear" id="toyear" class="select">
                                                <option value="sel">-- Selection --</option>

                                          </select><br/>
                                        <span>Marital Status: </span><br/>
                                        <input  type="checkbox" name="Unmarried" id="Unmarried">Unmarried</input>    <input  type="checkbox" name="Married" id="Married">Married</input><br/>
                                        <input  type="checkbox" name="Divorced" id="Divorced">Divorced</input>     <input  type="checkbox" name="Widowed" id="Widowed">Widowed</input><br/>

                                        </form>
                                        <button id="try" onClick="divgrowthChanged()"> Start Query </button>
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