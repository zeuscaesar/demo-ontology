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
if($prov!='0'){
    if($town!='0' && $year!='0'){
        $query=openRDF(
                'select distinct ?num
                where{
                ?mun rdf:type DemoOntology:Municipality.
                ?mun DemoOntology:hasName "'.$town.'"^^rdfs:Literal.
                ?mun DemoOntology:hasPopulation ?pop.
                ?pop DemoOntology:livingInTheYear "'.$year.'"^^rdfs:Literal.
                ?pop DemoOntology:numbers ?num.');
     }
     if($town!='0' && $year=='0'){   
        $query=openRDF(
                'select distinct ?num
                where{
                ?mun rdf:type DemoOntology:Municipality.
                ?mun DemoOntology:hasName "'.$town.'"^^rdfs:Literal.
                ?mun DemoOntology:hasPopulation ?pop.
                ?pop DemoOntology:numbers ?num.');
     }

     else{
                $query=openRDF(
                'select distinct ?num
                where{
                ?prov rdf:type DemoOntology:Province.
                ?prov DemoOntology:hasMunicipality ?mun.
                ?mun DemoOntology:hasName "'.$town.'"^^rdfs:Literal.
                ?mun DemoOntology:hasPopulation ?pop.
                ?pop DemoOntology:livingInTheYear "'.$year.'"^^rdfs:Literal.
                ?pop DemoOntology:numbers ?num.');
     }
}
if($prov=='0'){
    if($year=='0'){
    $query=openRDF(
                'select distinct ?num
                where{
                ?prov rdf:type DemoOntology:Province.
                ?prov DemoOntology:hasMunicipality ?mun.
                ?mun rdf:type DemoOntology:Municipality.
                ?mun DemoOntology:hasPopulation ?pop.
                ?pop DemoOntology:numbers ?num.');}
    if($year!='0'){
    $query=openRDF(
                'select distinct ?num
                where{
                ?prov rdf:type DemoOntology:Province.
                ?prov DemoOntology:hasMunicipality ?mun.
                ?mun rdf:type DemoOntology:Municipality.
                ?mun DemoOntology:hasPopulation ?pop.
                ?pop DemoOntology:livingInTheYear "'.$year.'"^^rdfs:Literal.
                ?pop DemoOntology:numbers ?num.');}

    }


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
    if($Unmarried==on || $Unmarried==ON){
        $union=true;
        $query=concatRDF($query,'
            {?pop DemoOntology:hasMaritalStatus "Unmarried"^^rdfs:Literal}
            ');
    }
    if($Married==on || $Married==ON){
        if($union==true){
         $query=concatRDF($query,'UNION'); 
        }
        else{$union=true;}
        $query=concatRDF($query,'
            {?pop DemoOntology:hasMaritalStatus "Married"^^rdfs:Literal}
            ');
    }
    if($Divorced==on || $Divorced==ON){
        if($union==true){
         $query=concatRDF($query,'UNION');
        }
        else{$union=true;}
        $query=concatRDF($query,'
            {?pop DemoOntology:hasMaritalStatus "Divorced"^^rdfs:Literal}
            ');
    }
    if($Widowed==on || $Widowed==ON){
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
                //echo '<div>'.$value.'</div>';
                echo $value;
//                echo "<script type=\"text/javascript\">\n";
//                echo "var data=new Array(105,89,83,92,93,85,75,78,65,75,81,86,80,74,95,82,81,107,96,103,114,94,108,100,93,91,94,103,63,49,77,48,53,52,39,52,41,39,38,33,32,27,31,30,24,20,18,18,16,21,12,14,17,17,12,12,12,12,13,8,8,10,8,5,9,13,7,7,5,10,7,6,8,6,8,5,11,6,7,5,7,5,3,6,2,7,4,5,3,3,1,0,1,0,1,0,0,0,1,0,10);\n";
//                echo "grafico(data);\n";
//                echo "alert(\"accura\");\n";
//                echo "</script>\n";
               
                    }
                }
//echo '<div>'.$year.'  '.$prov.' '.$town.' '.$sex.' Married:'.$Married.' Unmarried:'.$Unmarried.' Divorced:'.$Divorced.' Widowed:'.$Widowed.'</div>'

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
