<?php
    $year=$_GET["year"];
    $prov=$_GET["prov"];
    $town=$_GET["town"];
//    $town=str_replace(" ", "%20", $town);
//    $prov=str_replace(" ", "%20", $prov);
    $union=false;
    include_once ( 'HTTP/Request.php' );
    include_once ('query.php');
    $sesame_url = "http://localhost:8080/openrdf-sesame";
    if ($town=='0') {
        $query=openRDF('
            select ?townName ?coordinates ?pop ?numbers
            where {
            ?province DemoOntology:hasName "'.$prov.'"^^rdfs:Literal.
            ?province DemoOntology:hasMunicipality ?municipality.
            ?municipality DemoOntology:hasName ?townName.
            ?municipality DemoOntology:isLocated ?coordinates.
            ?municipality DemoOntology:hasPopulation ?pop.
            ?pop DemoOntology:numbers ?numbers.
            ?pop DemoOntology:livingInTheYear "'.$year.'"^^xsd:int.
        ');
    }
    else {
        $query=openRDF('
            select ?coordinates ?pop ?numbers
            where {
            ?province DemoOntology:hasName "'.$prov.'"^^rdfs:Literal.
            ?province DemoOntology:hasMunicipality ?municipality.
            ?municipality DemoOntology:hasName "'.$town.'"^^rdfs:Literal.
            ?municipality DemoOntology:isLocated ?coordinates.
            ?municipality DemoOntology:hasPopulation ?pop.
            ?pop DemoOntology:numbers ?numbers.
            ?pop DemoOntology:livingInTheYear "'.$year.'"^^xsd:int.
        ');
    }
    $query=closeRDF($query);
    $requestString = $sesame_url.'/repositories/demography'.$query;
    $req =& new HTTP_Request($requestString);
    $req->setMethod(HTTP_REQUEST_METHOD_GET);
    $req->addHeader("Accept", "application/sparql-results+xml, */*;q=0.5");
    $req->sendRequest();
    $response_code = $req->getResponseCode();
    if($response_code!=200)
        echo "Error code ".$response_code." Query:".$query;
    else {
        $response_body = $req->getResponseBody();
        $xml=simplexml_load_string($response_body);
        $dom = dom_import_simplexml($xml);
        $value = "";
        $towns = array();
        $towns_and_coord = array();
        $towns_and_coord_and_data = array();
        if ($town=='0') {
            //itero su tutti i risultati restituiti dalla query
            foreach ($dom->getElementsByTagName('result') as $result) {
                foreach ($result->getElementsByTagName('binding') as $binding) {
                    if ($binding->getAttribute('name')=='townName')
                        foreach ($binding->getElementsByTagName('literal') as $literal)
                            $townName = $literal->nodeValue;
                    if ($binding->getAttribute('name')=='coordinates')
                        foreach ($binding->getElementsByTagName('literal') as $literal)
                            $coord = $literal->nodeValue;
                    if ($binding->getAttribute('name')=='numbers')
                        foreach ($binding->getElementsByTagName('literal') as $literal)
                            $num = $literal->nodeValue;
                }
                if (!in_array($townName, $towns)) {
                    $towns[] = $townName;
                    $towns_and_coord[] = $townName."#".$coord;
                    $towns_and_coord_and_data[] = $townName."#".$coord."#".$num;
                }
                else
                    $towns_and_coord_and_data[array_search($townName, $towns)] = $towns_and_coord_and_data[array_search($townName, $towns)].":".$num;
            }
            foreach ($towns_and_coord_and_data as $t)
                echo $t."|";
        }
        else {
            //itero su tutti i risultati restituiti dalla query
            foreach ($dom->getElementsByTagName('result') as $result) {
                foreach ($result->getElementsByTagName('binding') as $binding) {
                    if ($binding->getAttribute('name')=='coordinates')
                        foreach ($binding->getElementsByTagName('literal') as $literal)
                            $coord = $literal->nodeValue;
                    if ($binding->getAttribute('name')=='numbers')
                        foreach ($binding->getElementsByTagName('literal') as $literal)
                            $num = $literal->nodeValue;
                }
                if (!in_array($town, $towns)) {
                    $towns[] = $town;
                    $towns_and_coord[] = $town."#".$coord;
                    $towns_and_coord_and_data[] = $town."#".$coord."#".$num;
                }
                else
                    $towns_and_coord_and_data[array_search($town, $towns)] = $towns_and_coord_and_data[array_search($town, $towns)].":".$num;
            }
            foreach ($towns_and_coord_and_data as $t)
                echo $t."|";
        }
    }

?>