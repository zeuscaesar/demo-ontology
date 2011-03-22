<?php
    $year=$_GET["year"];
    $prov=$_GET["prov"];
    $town=$_GET["town"];
    $town=str_replace(" ", "%20", $town);
    $prov=str_replace(" ", "%20", $prov);
    $union=false;
    //echo $s;
    include_once ( 'HTTP/Request.php' );
    include_once ('query.php');
    $sesame_url = "http://localhost:8080/openrdf-sesame";
    $query=openRDF('
        select ?nomeComune ?coordinates ?pop ?numbers
        where {
        ?provincia DemoOntology:hasName "'.$prov.'"^^rdfs:Literal.
        ?provincia DemoOntology:hasMunicipality ?comune.
        ?comune DemoOntology:hasName ?nomeComune.
        ?comune DemoOntology:isLocated ?coordinates.
        ?comune DemoOntology:hasPopulation ?pop.
        ?pop DemoOntology:numbers ?numbers.
        ?pop DemoOntology:livingInTheYear "'.$year.'"^^xsd:int.
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
        $towns = array();
        $towns_and_coord = array();
        $towns_and_coord_and_data = array();
        $dom = dom_import_simplexml($xml);
        //itero su tutti i risultati restituiti dalla query
        foreach ($dom->getElementsByTagName('result') as $result) {
            $values = array();
            //per ogni risultato leggo il nome della città
            //e il valore delle coordinate geografiche
            //e li salvo negli array towns e towns_and_coord qualora non ancora presenti
//            foreach ($result->getElementsByTagName('binding') as $binding) {
//                if ($binding->getAttribute('name')=='nomeComune') {
//                    foreach ($binding->getElementsByTagName('literal') as $literal)
//                        $nomeComune = $literal->nodeValue;
//                    foreach ($result->getElementsByTagName('binding') as $binding)
//                        if ($binding->getAttribute('name')=='coordinates');
//                            foreach ($binding->getElementsByTagName('literal') as $literal)
//                                $coord = $literal->nodeValue;
//                    if (!in_array($nomeComune.":".$coord, $towns)) {
//                        $towns[] = $nomeComune;
//                        $towns_and_coord[] = $nomeComune.":".$coord;
//                    }
//                }
//            }
            foreach ($result->getElementsByTagName('binding') as $binding) {
                if ($binding->getAttribute('name')=='nomeComune')
                    foreach ($binding->getElementsByTagName('literal') as $literal)
                        $nomeComune = $literal->nodeValue;
                if ($binding->getAttribute('name')=='coordinates')
                    foreach ($binding->getElementsByTagName('literal') as $literal)
                        $coord = $literal->nodeValue;
                if ($binding->getAttribute('name')=='numbers')
                    foreach ($binding->getElementsByTagName('literal') as $literal)
                        $num = $literal->nodeValue;
            }
            if (!in_array($nomeComune, $towns)) {
                $towns[] = $nomeComune;
                $towns_and_coord[] = $nomeComune."#".$coord;
                $towns_and_coord_and_data[] = $nomeComune."#".$coord."#".$num;
            }
            else
                $towns_and_coord_and_data[array_search($nomeComune, $towns)] = $towns_and_coord_and_data[array_search($nomeComune, $towns)].":".$num;

        }
//        $data_vett = array();
//        foreach ($towns as $town) {
//            $townData="";
//            $count = 0;
//            foreach ($dom->getElementsByTagName('result') as $result) {
//                foreach ($result->getElementsByTagName('binding') as $binding);
//                    if ($binding->getAttribute('name')=='nomeComune') {
//                        if ($binding->firstChild->nodeValue == $town) {
//                            foreach ($result->getElementsByTagName('binding') as $binding)
//                                if ($binding->getAttribute('name')=='num') {
//                                    $num = $binding->firstChild->nodeValue;
//                                    $townData = $townData.":".$num;
//                                    $count++;
//                                    break;
//                                }
//                        }
//                     }
//                if ($count == 8)
//                    break;
//            }
//        $data_vett[array_search($town, $towns)] = $townData;
//        }
//        for ($i=0; $i<$towns->length; $i++)
//            echo $towns_and_coord[i].":".$data_vett."|";

        foreach ($towns_and_coord_and_data as $t)
            echo $t."|";

//////////////Prima versione, solo con nome e coordinate del comune
//        $response_body = $req->getResponseBody();
//        $xml=simplexml_load_string($response_body);
//        $value = "";
//        foreach($xml->results->result as $item){
//            $value = $item->binding[0]->literal.",".$item->binding[1]->literal;
//            echo $value."|";
//        }
    }

?>