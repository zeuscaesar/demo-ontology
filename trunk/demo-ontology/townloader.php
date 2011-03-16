<?php
$prov=$_GET["prov"];
$year=$_GET["year"];
echo $prov;
echo "<option value='0'>-- All  Town --</option>\n";

include_once ( 'HTTP/Request.php' );
include_once ('query.php');
                $sesame_url = "http://localhost:8080/openrdf-sesame";
                $query = openRDF('
                select distinct ?name
                where{
                ?prov rdf:type DemoOntology:Province.
                ?prov DemoOntology:hasName "'.$prov.'"^^rdfs:Literal.
                ?prov DemoOntology:hasMunicipality ?mun.
                ?mun DemoOntology:hasPopulation ?pop.
                
                ?mun DemoOntology:hasName ?name.
                ');
                if($year!='0'){
                  $query= concatRDF($query,'?pop DemoOntology:livingInTheYear "'.$year.'"^^xsd:int.');
                }
                $query= closeRDF($query);
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