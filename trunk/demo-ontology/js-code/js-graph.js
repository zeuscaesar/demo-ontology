function grafico(data)
{
    for(i = 0; i < data.length; i++)
    {
        //document.write(data.length);
        //document.write("<span class='G' style='width: " + data[i] + "px;'>");
        //document.write("&nbsp;");
        //document.write("</span>");
        var h=data[i];
        var w=2.9;
        document.write("<img src='blank.gif' alt='"+i+" anni -> "+h+" abitanti' title='"+i+" anni -> "+h+" abitanti' class='barra2' style='height: " + h + "px; width: " + w + "px;'/>");


        
        //document.write("<span class='barra' style='height: " + data[i] + "px;'>");
    }
}
