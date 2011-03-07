<?php
$year=$_GET["year"];
$prov=$_GET["prov"];
$town=$_GET["town"];
$sex=$_GET["sex"];
$Married=$_GET["Married"];
$Unmarried=$_GET["Unmarried"];
$Divorced=$_GET["Divorced"];
$Widowed=$_GET["Widowed"];
$town=str_replace(" ", "%20", $town);
//echo $s;
include_once ( 'HTTP/Request.php' );
$sesame_url = "http://localhost:8080/openrdf-sesame";
$query='?queryLn=SPARQL&query=PREFIX%20rdfs:<http://www.w3.org/2000/01/rdf-schema%23>%0APREFIX%20rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns%23>%0APREFIX%20DemoOntology:<http://demo-ontology.googlecode.com/svn/trunk/demo-ontology/DemoOntology.owl%23>%0Aselect%20distinct%20%3Fnum%0Awhere{%0A%3Fmun%20rdf:type%20DemoOntology:Municipality.%0A%3Fname%20DemoOntology:hasName%20"'.$town.'"^^rdfs:Literal.%0A%3Fname%20DemoOntology:hasPopulation%20%3Fpop.%0A%3Fpop%20DemoOntology:livingInTheYear%20"'.$year.'"^^rdfs:Literal.%0A%3Fpop%20DemoOntology:numbers%20%3Fnum.';
if($Widowed=='on'){
    $widowedconcat='{}';
    // $query=$query.''
}
$query=$query.'}';
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
                //echo $response_body."<br/><br/>";
                //echo "Risposta ricevuta correttamente<br/><br>";
                //echo $response_body."<br/><br/>";
                $xml=simplexml_load_string($response_body);
                //echo $response_body;
                //$address = new SimpleXMLElement($response_body);
                foreach($xml->results->result as $item){
                $value=$item->binding->literal;
                echo '<div>'.$value.'</div>';

                }
        }
//echo '<div>'.$year.'  '.$prov.' '.$town.' '.$sex.' Married:'.$Married.' Unmarried:'.$Unmarried.' Divorced:'.$Divorced.' Widowed:'.$Widowed.'</div>'

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
