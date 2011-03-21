<?php

function openRDF($query){
    $pre="?queryLn=SPARQL&query=";
    $prefix='
PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>
PREFIX xsd:<http://www.w3.org/2001/XMLSchema#>
PREFIX owl:<http://www.w3.org/2002/07/owl#>
PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX DemoOntology:<http://demo-ontology.googlecode.com/svn/trunk/demo-ontology/DemoOntology.owl#>';
    $prefix=str_replace(" ", "%20", $prefix);
    $prefix=str_replace("\n","%0A", $prefix);
    $prefix=str_replace("#", "%23", $prefix);
    $query=str_replace(" ", "%20", $query);
    $query=str_replace("?", "%3F", $query);
    $query=str_replace("\n","%0A", $query);
    return "?".$pre.$prefix.$query;
}
function concatRDF($query,$concat){
    $concat=str_replace(" ", "%20", $concat);
    $concat=str_replace("?", "%3F", $concat);
    $concat=str_replace("\n","%0A", $concat);
    return $query.$concat;
}
function closeRDF($query){
    return $query=$query.'}';
}
function writeRDF($query){
    $pre="?queryLn=SPARQL&query=";
//    $prefix='
//PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>
//PREFIX xsd:<http://www.w3.org/2001/XMLSchema#>
//PREFIX owl:<http://www.w3.org/2002/07/owl#>
//PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>
//PREFIX DemoOntology:<http://demo-ontology.googlecode.com/svn/trunk/demo-ontology/DemoOntology.owl#>';
//    $prefix=str_replace(" ", "%20", $prefix);
//    $prefix=str_replace("\n","%0A", $prefix);
//    $prefix=str_replace("#", "%23", $prefix);
    $query=str_replace("#", "%23", $query);
    $query=str_replace(" ", "%20", $query);
    $query=str_replace("?", "%3F", $query);
    $query=str_replace("\n","%0A", $query);
    return "?".$pre.$query;
}
function reverseSymbol($query){
    $query=str_replace("%23","#",  $query);
    $query=str_replace( "%20"," ", $query);
    $query=str_replace( "%3F","?", $query);
    $query=str_replace("%0A","\n", $query);
    return $query;
}
?>