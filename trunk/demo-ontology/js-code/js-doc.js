var title="<h3  class=\"title\">A Demography Ontology made of OWL with Protégé, published by Sesame and available through a web front-end made in PHP, XHTM and JavaScript.</h3><p class=\"meta\"></p>";
var abst="<p><strong>Abstract.</strong> This project implements an ontology that represents the population of each municipality belonging to each province in a given year. For each municipality in a given year is stored the amount of population by sex, age and marital status. The ontology was written in OWL using Protégé and manual editing and was published with the Sesame framework. We have therefore been developed (using PHP, XHTML and JavaScript) a web front-end able to query the ontology. The front-end allows you to perform a simple search based on key descriptive fields (simple search), a search based on location using Google map (geo search), a vision of the time evolution of the population (growth) and a free search using the language SPARQL (free search).</p>";
var keywords="<p><strong>Keywords:</strong> Demography, Ontology, OWL, RDF, Protégé, Sesame, PHP.</p>"
var intro="<h4>Introduction</h4><p>The Semantic Web is a mesh of information linked up in such a way as to be easily processable by machines, on a global scale. You can think of it as being an efficient way of representing data on the World Wide Web, or as a globally linked database.</p><p>The Semantic Web is not about links between web pages. The Semantic Web describes the relationships between things (like A is a part of B and Y is a member of Z) and the properties of things (like size, weight, age, and price).</p><p>The Semantic Web is generally built on syntaxes which use URIs to represent data, usually in triples based structures: i.e. many triples of URI data that can be held in databases, or interchanged on the World Wide Web using a set of particular syntaxes developed especially for the task. These syntaxes are called \"Resource Description Framework\" syntaxes.</p><p>Therefore the RDF is a language for describing information and resources on the web. Putting information into RDF files, makes it possible for computer programs (\"web spiders\") to search, discover, pick up, collect, analyze and process information from the web. For example if information about music, cars, tickets, etc. were stored in RDF files, intelligent web applications could collect information from many different sources, combine information, and present it to users in a meaningful way.</p><p>It has taken years to put the pieces together that comprise the Semantic Web, including the standardization of RDF, the W3C release of the Web Ontology Language (OWL), and standardization on SPARQL, which adds querying capabilities to RDF. So with standards and languages in place, we can see Semantic Web technologies being used by early adopters.</p><p>Semantic Web technologies are popular in areas such as research and life sciences where they can help researchers by aggregating data on different medicines and illnesses that have multiple names in different parts of the world. On the Web, Twine is offering a knowledge networking application which has been built with Semantic Web technologies. The Joost online television service also uses Semantic technology on the back-end: here Semantic technology is used to help Joost users to understand the relationships between pieces of content, enabling them to find the types of content they want most. Oracle offers a Semantic Web view of its Oracle Technology Network, called the OTN Semantic Web to name a few of those companies who are implementing Semantic Web technologies.</p><p>About our project, we created an ontology which describes the demographies of Italian municipalities. For each municipality in a given year, the amount of population partitioned by sex, age and marital status is stored in a database.</p>";
var ontology="";
var frontend="";

function setDiv(i) {
        //alert("ciao");
        document.getElementById("title").innerHTML=title;
        if(i==1)
            document.getElementById("doc").innerHTML=abst;
        if(i==2)
            document.getElementById("doc").innerHTML=keywords;
        if(i==3)
            document.getElementById("doc").innerHTML=intro;
        if(i==4)
            document.getElementById("doc").innerHTML=ontology;
        if(i==5)
            document.getElementById("doc").innerHTML=frontend;
    }


