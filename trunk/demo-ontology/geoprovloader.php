<?php

    $year = $_GET["year"];
    include_once('HTTP/Request.php');
    include_once('query.php');
    $sesame_url = "http://localhost:8080/openrdf-sesame";
    $query=openRDF('
        select distinct ?name
        where{
        ?prov rdf:type DemoOntology:Province.
        ?prov DemoOntology:hasMunicipality ?mun.
        ?mun DemoOntology:hasPopulation ?pop.
        ?pop DemoOntology:livingInTheYear "'.$year.'"^^xsd:int.
        ?prov DemoOntology:hasName ?name.
    ');
    $query = closeRDF($query);
    echo $query;
    $requestString = $sesame_url.'/repositories/demography'.$query;
    $req =& new HTTP_Request($requestString);
    $req->setMethod(HTTP_REQUEST_METHOD_GET);
    $req->addHeader("Accept", "application/sparql-results+xml, */*;q=0.5");
    $req->sendRequest();
    $responseCode = $req->getResponseCode();
    if ($responseCode!=200)
    echo "Errore di codice ".$responseCode;
    else {
        $responseBody = $req->getResponseBody();
        $xml=simplexml_load_string($responseBody);
        foreach($xml->results->result as $item){
            $value=$item->binding->literal;
            echo "<option value='".$value."'>".$value."</option>\n";
    }
}

?> 