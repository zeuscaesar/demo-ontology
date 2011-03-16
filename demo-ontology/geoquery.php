<?php
    //$year=$_GET["year"];
    $prov=$_GET["prov"];
    //$town=$_GET["town"];
    //$sex=$_GET["sex"];
    //$Married=$_GET["Married"];
    //$Unmarried=$_GET["Unmarried"];
    //$Divorced=$_GET["Divorced"];
    //$Widowed=$_GET["Widowed"];
    $town=str_replace(" ", "%20", $town);
    $union=false;
    //echo $s;
    include_once ( 'HTTP/Request.php' );
    include_once ('query.php');
    $sesame_url = "http://localhost:8080/openrdf-sesame";
            $query=openRDF(
                'select distinct ?nomeComune ?coordinates
                where {
                ?provincia DemoOntology:hasName "'.$prov.'"^^rdfs:Literal.
                ?provincia DemoOntology:hasMunicipality ?comune.
                ?comune DemoOntology:hasName ?nomeComune.
                ?comune DemoOntology:isLocated ?coordinates.
                ');

    $query=closeRDF($query);

    $requestString = $sesame_url.'/repositories/demography'.$query;
    $req =& new HTTP_Request($requestString);
    $req->setMethod(HTTP_REQUEST_METHOD_GET);
    $req->addHeader("Accept", "application/sparql-results+xml, */*;q=0.5");
    $req->sendRequest();
    $response_code = $req->getResponseCode();
    if($response_code!=200)
        echo "Errore di codice ".$response_code." Query:".$query;
    else {
        $response_body = $req->getResponseBody();
        $xml=simplexml_load_string($response_body);
        $value = "";
        foreach($xml->results->result as $item){
            $value = $item->binding[0]->literal.",".$item->binding[1]->literal;
            echo $value."|";
        }
    }
?>
