function grafico(data)
{
    for(i = 0; i < data.length; i++)
    {
        //document.write(data.length);
        //document.write("<span class='G' style='width: " + data[i] + "px;'>");
        //document.write("&nbsp;");
        //document.write("</span>");
        var h=data[i];
        var w=2.5;
        document.write("<img src='blank.gif' alt='"+h+"' class='barra2' style='height: " + h + "px; width: " + w + "px;'></img>");


        
        //document.write("<span class='barra' style='height: " + data[i] + "px;'>");
    }
}
