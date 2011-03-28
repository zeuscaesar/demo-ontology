
var simplesearch="<h3  class=\"title\">Simple Search</h3><p class=\"meta\"></p><p>This page allows you to query the SESAME repository to get information about population living in a given year in a given geographical area (a specific municipality, or a province, or the whole Italian territory), according to the selected sex and marital status.</p><p>After having filled the form on the left side of the page, by clicking the \"Start Query\" button a graphic and a table appear: they show the result of user's query. The graphic shows the total amount of people which forms the population partitioned by age. The table shows the amount of people which forms the population partitioned by age, sex and marital status.</p>";
var geosearch="<h3  class=\"title\">Geo Search</h3><p class=\"meta\"></p><p>This page allows you to query the SESAME repository to get information about population living in a given year in a given province or municipality, showing it on a Google Map</p>After having filled the form on the left side of the page, by clicking the \"Show\" button the map shows the selected province with a markerplace located on the selected municipality. By clicking it, a window containing a summary of the municipal demographic information appears.</p>";
var growth="<h3  class=\"title\">Growth Search</h3><p class=\"meta\"></p>This page allows you to query the SESAME repository to get information about the growth of the population in a given municipality in a given period of time.<p>After having filled the form on the left side of the page, a graphic appears showing the total amount of population living in each year in the selected period.</p>";
var freequery="<h3  class=\"title\">Free Query</h3><p class=\"meta\"></p>This  page allows you to query the SESAME repository in a direct way by editing yourself the query.<p>After having edited the query and having clicked the \"Start Query\" button, the result of your submission is shown in a table.</p>";

function setDiv(i) {
        //alert("ciao");
        
        if(i==1)
            document.getElementById("post").innerHTML=simplesearch;
        if(i==2)
            document.getElementById("post").innerHTML=geosearch;
        if(i==3)
            document.getElementById("post").innerHTML=growth;
        if(i==4)
            document.getElementById("post").innerHTML=freequery;
    }


