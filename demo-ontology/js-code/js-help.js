
var simplesearch="<h3  class=\"title\">Simple Search</h3><p class=\"meta\"></p><p>This function allows you to perform a search based on key descriptive fields.</p><p>Inserire contenuto...</p>";
var geosearch="<h3  class=\"title\">Geo Search</h3><p class=\"meta\"></p><p>Inserire contenuto</p>";
var growth="<h3  class=\"title\">Growth Search</h3><p class=\"meta\"></p><p>Inserire contenuto</p>";
var freequery="<h3  class=\"title\">Free Query</h3><p class=\"meta\"></p><p>Inserire contenuto</p>";

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


