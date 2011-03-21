<?php
    $area=$_GET["area"];

    include_once ( 'HTTP/Request.php' );
    include_once ('query.php');
    $sesame_url = "http://localhost:8080/openrdf-sesame";
    $query=writeRDF($area);
    $requestString = $sesame_url.'/repositories/demography'.$query;
    $req =& new HTTP_Request($requestString);
    $req->setMethod(HTTP_REQUEST_METHOD_GET);
                $req->addHeader("Accept", "application/sparql-results+xml, */*;q=0.5");
    $req->sendRequest();
    $response_code = $req->getResponseCode();
    if($response_code!=200) {
        echo "Errore di codice ".$response_code."<br/>";
        if ($response_code==400)
        echo "Verifica che la query sottomessa sia stata formulata correttamente";
    }
    else {
        $response_body = $req->getResponseBody();
        $xml=simplexml_load_string($response_body);
        $dom = dom_import_simplexml($xml);
        $theader = "";
        $tbody = "";
        $variables = array();
        $theader = $theader."<tr class='headerqueryresult'>";
        foreach ($dom->getElementsByTagName('variable') as $variable) {
            $varName = $variable->getAttribute('name');
            $theader = $theader."<th class='queryvariablename'>".$varName."</th>";
            $variables[] = $varName;
        }
        $theader = $theader."</tr>";

        //itero su ogni tupla restituita dalla query
        foreach ($dom->getElementsByTagName('result') as $result) {
            //per ogni tupla trovata, creo una nuova riga della tabella
            $tbody = $tbody."<tr class='queryresult'>";
            //itero su ogni elemento dell'array contenente le variabili richiesta nella query
            foreach ($variables as $var) {
                //creo una variabile booleana che mi indica se ho trovato o meno la variabile nella tupla
                $found = false;
                //per ogni variabile richiesta letta, cerco nella tupla il relativo binding
                foreach ($result->getElementsByTagName('binding') as $binding) {
                    if ($binding->getAttribute('name')==$var) {
                        //se trovo il binding, setto a true la variabile booleana & inserisco il valore nella tabella
                        $found = true;
                        foreach ($binding->getElementsByTagName('literal') as $literal) {
                            $tbody = $tbody."<td class='queryvariablevalue'>".$literal->nodeValue."</td>";
                        }
                        foreach ($binding->getElementsByTagName('uri') as $uri) {
                            $tbody = $tbody."<td class='queryvariablevalue'>&lt;".$uri->nodeValue."&gt;</td>";
                        }
                    }
                }
                //se alla fine dell'iterazione tra i binding il valore booleano è ancora false,
                //allora la variabile cercata non era presente nella tupla
                //e in tal caso inserisco in tabella un posto vuoto.
                if ($found == false)
                    $tbody = $tbody."<td></td>";
                }
                //chiudo la riga
                $tbody = $tbody."</tr>";
            }
        //stampo la tabella
        echo "<table class='queryresults'>".$theader.$tbody."</table>";
    }
////////////////////////////////////////////////////////////////////////////////
//        $theader = "";
//        $tbody = "";
//        $variables = array();
//        $theader = $theader."<tr class='headerrow'>";
//        foreach ($xml->head->children() as $variable) {
//            foreach ($variable->attributes() as $key => $value)
//                if ($key == "name") {
//                    $variables[] = $value;
//                    $theader = $theader."<th class='headercell'>".$value."</th>";
//                }
//        }
//        $theader = $theader."</tr>";
//        foreach ($xml->results->result as $item){
//            //
//            //
//            $tbody = $tbody."<tr class='bodyrow'>";
//            $bindings = $item->children();
//            for ($i=0; $i<count($variables); $i++)
//                foreach ($bindings as $binding) {
//                    if ($binding->hasAttribute('name')) //MESSA PER DEBUG
//                    if ($binding->getAttributeNode('name')==$variables[i]) {
//                        $node = $binding->children();
//                        $nodeName = $node->getName();
//                        if ($nodeName == "uri") {
//                            //SI TRATTA DI UN NODO DI TIPO uri
//                            $tbody = $tbody."<td>".$node."</td>";
//                            echo "||".$nodeName."->".$node."||";
//                        }
//                        else
//                            if ($nodeName == "literal") {
//                                //SI TRATTA DI UN NODO DI TIPO uri
//                                $tbody = $tbody."<td>".$node."</td>";
//                                echo "||".$nodeName."->".$node."||";
//                            }
//                            else {
//                                //SI TRATTA DI UN NODO DI TIPO uri
//                                $tbody = $tbody."<td>".$node."</td>";
//                                echo "||".$nodeName."->".$node."||";
//                            }
//                    }
//                }
//            $tbody = $tbody."</tr>";
//        }
//        echo "<table>".$theader.$tbody."</table>";
//    }
//
//
//            //
//            //
////            $tbody = $tbody."<tr class='bodyrow'>";
////            foreach ($item->binding as $binding)
////                foreach ($binding->children() as $node) {
////                    $nodeName = $node->getName();
////                    if ($nodeName == "uri") {
////                        //SI TRATTA DI UN NODO DI TIPO uri
////                        $tbody = $tbody."<td>".$node."</td>";
////                        echo "||".$nodeName."->".$node."||";
////                    }
////                    else
////                        if ($nodeName == "literal") {
////                            //SI TRATTA DI UN NODO DI TIPO literal
////                            $tbody = $tbody."<td>".$node."</td>";
////                            echo "||".$nodeName."->".$node."||";
////                        }
////                        else {
////                            $tbody = $tbody."<td>".$node."</td>";
////                            echo $nodeName;
////
////                        }
////                }
////                $tbody = $tbody."</tr>";
////        }
////        echo "<table>".$theader.$tbody."</table>";
////    }

?> 