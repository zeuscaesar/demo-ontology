<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="OWL,Demography,Ontology" />
<meta name="description" content="This is Demography Ontology, a project developed at the Computer Science and Telecomunication department of the University of Catania." />
<meta name="author" content="Luciano De Franco, Giuseppe Alessandro, Carlo Leonardi"/>
<meta name="copyright" content="Luciano De Franco, Giuseppe Alessandro, Carlo Leonardi"/>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Demography Ontology - Home Page</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="js-code/js-help.js"></script>
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
			
			<div class="post" id="post">
				<h2 class="title"><a href="#">Simple Search</a></h2>
                                    <p class="meta"></p>
				
					<p>This page allows you to query the SESAME repository to get information about population living in a given year in a given geographical area (a specific municipality, or a province, or the whole Italian territory), according to the selected sex and marital status.</p>
                                        <p>After having filled the form on the left side of the page, by clicking the "Start Query" button a graphic and a table appear: they show the result of user's query. The graphic shows the total amount of people which forms the population partitioned by age. The table shows the amount of people which forms the population partitioned by age, sex and marital status.</p>
				
				
			</div>
			
		</div>
		<!-- end #content -->
		<div id="sidebar">
			<ul>
				
				<li>
					<h2>Functions</h2>
					<ul>
						<li><a href="#" onclick="setDiv(1)">Simple Search</a></li>
						<li><a href="#" onclick="setDiv(2)">Geo Search</a></li>
						<li><a href="#" onclick="setDiv(3)">Growth</a></li>
						<li><a href="#" onclick="setDiv(4)">Free Query</a></li>
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
