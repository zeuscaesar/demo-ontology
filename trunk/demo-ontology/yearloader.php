<?php
$year=$_GET["year"];
echo $year;
include_once ( 'HTTP/Request.php' );
include_once ('query.php');
                $sesame_url = "http://localhost:8080/openrdf-sesame";
                //FILTER (x? >='.$year.'
                $query='select distinct ?x where{?y DemoOntology:livingInTheYear ?x. FILTER(?x>='.$year.')}ORDER by ?x';
                $query=openRDF($query);
                //$query=closeRDF($query);
                echo $query;
                $requestString = $sesame_url.'/repositories/demography'.$query;
                $req =& new HTTP_Request($requestString);
                //echo $requestString;
                $req->setMethod(HTTP_REQUEST_METHOD_GET);
                $req->addHeader("Accept", "application/sparql-results+xml, */*;q=0.5");
                $req->sendRequest();
                $response_code = $req->getResponseCode();
                if($response_code!=200){echo "Errore di codice ".$response_code;}
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
                foreach($xml->results->result as $item)
                    {
                    $value=$item->binding->literal;
                    echo '<option value="'.$value.'">'.$value.'</option>';
                    }
                }
?> 