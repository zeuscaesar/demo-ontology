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
$union=false;
//echo $s;
include_once ( 'HTTP/Request.php' );
include_once ('query.php');
$sesame_url = "http://localhost:8080/openrdf-sesame";
//$query='?queryLn=SPARQL&query=PREFIX%20rdfs:<http://www.w3.org/2000/01/rdf-schema%23>%0APREFIX%20rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns%23>%0APREFIX%20DemoOntology:<http://demo-ontology.googlecode.com/svn/trunk/demo-ontology/DemoOntology.owl%23>%0Aselect%20distinct%20%3Fnum%0Awhere{%0A%3Fmun%20rdf:type%20DemoOntology:Municipality.%0A%3Fname%20DemoOntology:hasName%20"'.$town.'"^^rdfs:Literal.%0A%3Fname%20DemoOntology:hasPopulation%20%3Fpop.%0A%3Fpop%20DemoOntology:livingInTheYear%20"'.$year.'"^^rdfs:Literal.%0A%3Fpop%20DemoOntology:numbers%20%3Fnum.';
$query=openRDF(
            'select distinct ?num
            where{
            ?mun rdf:type DemoOntology:Municipality.
            ?name DemoOntology:hasName "'.$town.'"^^rdfs:Literal.
            ?name DemoOntology:hasPopulation ?pop.
            ?pop DemoOntology:livingInTheYear "'.$year.'"^^rdfs:Literal.
            ?pop DemoOntology:numbers ?num.');
    if($sex==Male){
        $query=concatRDF($query,'
            {?pop DemoOntology:hasSex "Male"^^rdfs:Literal}
            ');
    }
    if($sex==Female){
        $query=concatRDF($query,'
            {?pop DemoOntology:hasSex "Female"^^rdfs:Literal}
            ');
    }
    if($sex==Both){
        $query=concatRDF($query,'
            {?pop DemoOntology:hasSex "Male"^^rdfs:Literal}
            UNION
            {?pop DemoOntology:hasSex "Female"^^rdfs:Literal}
            ');
    }
    if($Unmarried==on){
        $union=true;
        $query=concatRDF($query,'
            {?pop DemoOntology:hasMaritalStatus "Unmarried"^^rdfs:Literal}
            ');
    }
    if($Married==on){
        if($union==true){
         $query=concatRDF($query,'UNION'); 
        }
        else{$union=true;}
        $query=concatRDF($query,'
            {?pop DemoOntology:hasMaritalStatus "Married"^^rdfs:Literal}
            ');
    }
    if($Divorced==on){
        if($union==true){
         $query=concatRDF($query,'UNION');
        }
        else{$union=true;}
        $query=concatRDF($query,'
            {?pop DemoOntology:hasMaritalStatus "Divorced"^^rdfs:Literal}
            ');
    }
    if($Widowed==on){
        if($union==true){
         $query=concatRDF($query,'UNION');
        }
        else{$union=true;}
        $query=concatRDF($query,'
            {?pop DemoOntology:hasMaritalStatus "Widowed"^^rdfs:Literal}
            ');
    }


$query=closeRDF($query);

$requestString = $sesame_url.'/repositories/demography'.$query;
                $req =& new HTTP_Request($requestString);
                //echo $requestString;
                $req->setMethod(HTTP_REQUEST_METHOD_GET);
                $req->addHeader("Accept", "application/sparql-results+xml, */*;q=0.5");
                $req->sendRequest();
                $response_code = $req->getResponseCode();
                if($response_code!=200)
                echo "Errore di codice ".$response_code." Query:".$query;
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
