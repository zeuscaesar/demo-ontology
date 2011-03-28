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
<title>Demography Ontology - Free Query</title>
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
				
                                <form name="textform"  action="query()">
                                <div align="center">
                                Edit your query<br/>
                                
                                <textarea cols="70" rows="15" name="area" wrap="soft">
PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>
PREFIX xsd:<http://www.w3.org/2001/XMLSchema#>
PREFIX owl:<http://www.w3.org/2002/07/owl#>
PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX DemoOntology:<http://demo-ontology.googlecode.com/svn/trunk/demo-ontology/DemoOntology.owl#>
select ?y
where {
?x rdf:type DemoOntology:Municipality.
?x DemoOntology:hasName ?y.
}
                                </textarea>
                                <br/>
                                <br/>
                                </div>
                                </form>
                                <div align="center">
                                <button id="try" onClick="query()"> Start Query </button>
                                </div>
                                <div id ="divdata" >
                                </div>
                                <p id='strprova'></p>
			</div>
			
		</div>
		<!-- end #content -->
		<div id="sidebar">
			<ul>
                            <li>
				<h2>Help</h2>
					<p>Edit the query and click <em>Start Query</em> button.</p>
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