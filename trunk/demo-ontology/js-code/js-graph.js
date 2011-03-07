function grafico(data)
{
    for(i = 0; i < data.length; i++)
    {
     
        var h=data[i];
        var w=3;
        document.write("<img src='blank.gif' alt='"+i+" anni -> "+h+" abitanti' title='"+i+" anni -> "+h+" abitanti' class='barra2' style='height: " + h + "px; width: " + w + "px;'/>");


        

    }
}
