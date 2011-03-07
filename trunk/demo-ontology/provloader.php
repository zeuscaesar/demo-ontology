<?php
$year=$_GET["year"];
echo $year;
echo "<option value='0'>-- Selection --</option>\n";

include_once ( 'HTTP/Request.php' );
                $sesame_url = "http://localhost:8080/openrdf-sesame";
                //$query = "?queryLn=SPARQL&query=PREFIX%20rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns%23>%0APREFIX%20Ontology12989921859012:<http://www.semanticweb.org/ontologies/2011/2/Ontology1298992185901.owl%23>%0ASELECT%20%3Fprovincia%0AWHERE{%3Fx%20rdf:type%20Ontology12989921859012:Province.%3Fx%20Ontology12989921859012:nameIs%20%3Fprovincia.}";
                //$query = '?queryLn=SPARQL&query=PREFIX%20Ontology12989921859012:<http://www.semanticweb.org/ontologies/2011/2/Ontology1298992185901.owl%23>%0APREFIX%20xsd:<http://www.w3.org/2001/XMLSchema%23>%0ASelect%20%3Fy%0Awhere{%0A%3Fx%20Ontology12989921859012:nameIs%20"'.$prov.'"^^xsd:string.%0A%3Fx%20Ontology12989921859012:hasMunicipality%20%3Fz.%0A%3Fz%20Ontology12989921859012:nameIs%20%3Fy.}';
                //$query ='?queryLn=SPARQL&query=PREFIX%20Ontology12989921859012:%3Chttp://www.semanticweb.org/ontologies/2011/2/Ontology1298992185901.owl%23%3E%0APREFIX%20xsd:%3Chttp://www.w3.org/2001/XMLSchema%23%3E%0ASELECT%20%3Fy%0AWHERE{%0A%3Fx%20Ontology12989921859012:nameIs%20%22Catania%22^^xsd:string.%0A%3Fx%20Ontology12989921859012:hasMunicipality%20%3Fy.%0A}&limit=100&infer=true';
                //$query = '?queryLn=SPARQL&query=PREFIX%20rdfs:<http://www.w3.org/2000/01/rdf-schema%23>%0APREFIX%20rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns%23>%0APREFIX%20DemoOntology:<http://demo-ontology.googlecode.com/svn/trunk/demo-ontology/DemoOntology.owl%23>%0Aselect%20%3Fy%0Awhere{%0A%3Fx%20rdf:type%09DemoOntology:Province.%0A%3Fx%20DemoOntology:hasName%09"'.$prov.'"^^rdfs:Literal.%0A%3Fx%20DemoOntology:hasMunicipality%09%3Fz.%0A%3Fz%20DemoOntology:hasName%20%3Fy.%20}';
                //$query ="?queryLn=SPARQL&query=PREFIX%20rdfs:<http://www.w3.org/2000/01/rdf-schema%23>%0APREFIX%20rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns%23>%0APREFIX%20DemoOntology:<http://demo-ontology.googlecode.com/svn/trunk/demo-ontology/DemoOntology.owl%23>%0Aselect%20distinct%20%3Fx%0Awhere%20{%0A%3Fx%20rdf:type%20DemoOntology:Province.%0A%3Fx%20DemoOntology:hasMunicipality%20%3Fz.%0A%3Fz%20DemoOntology:hasPopulation%20%3Fy.%09%0A%3Fy%20DemoOntology:livingInTheYear%09".'"'.$year.'"'."^^rdfs:Literal.%0A}";
                $query ="?queryLn=SPARQL&query=PREFIX%20rdfs:<http://www.w3.org/2000/01/rdf-schema%23>%0APREFIX%20rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns%23>%0APREFIX%20DemoOntology:<http://demo-ontology.googlecode.com/svn/trunk/demo-ontology/DemoOntology.owl%23>%0Aselect%20distinct%20%3Fnome%0Awhere{%0A%3Fx%20rdf:type%20DemoOntology:Province.%0A%3Fx%20DemoOntology:hasMunicipality%20%3Fy.%0A%3Fy%20DemoOntology:hasPopulation%20%3Fz.%0A%3Fz%20DemoOntology:livingInTheYear%20".'"'.$year.'"'."^^rdfs:Literal.%0A%3Fx%20DemoOntology:hasName%20%3Fnome.%0A}";
                echo $query;
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
                echo $response_body."<br/><br/>";
                //echo "Risposta ricevuta correttamente<br/><br>";
                //echo $response_body."<br/><br/>";
                $xml=simplexml_load_string($response_body);
                echo $response_body;
                //$address = new SimpleXMLElement($response_body);
                foreach($xml->results->result as $item){
                $value=$item->binding->literal;
                echo '<option value="'.$value.'">'.$value.'</option>';
                }
}

?> 