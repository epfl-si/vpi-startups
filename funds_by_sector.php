<?php

require 'tools/hide_header.php';


//Camembert des fonds par secteur
echo "
<script type='text/javascript'>

google.charts.load('current', {packages: ['corechart', 'bar']});    
google.charts.setOnLoadCallback(funds_by_sectors);

//Fonction pour récupérer les données nécessaires pour le camembert
function funds_by_sectors()
{
    $.ajax
    ({
        url:'/tools/funds_by_sectors.php',
        method:'POST',
        dataType:'JSON',
        success:function(data)
        {
            //Passer les données récupérées dans la fonction de construction et affichage du camembert
            drawChart_funds_by_sectors(data);
        }
    });
}

//Traiter les données de manière a les mettre dans les bonnes colonnes
function drawChart_funds_by_sectors(chart_data)
{
    var jsonData = chart_data;
    var data = new google.visualization.DataTable();

    //Ajouter des colonnes au camembert
    data.addColumn('string', 'sectors');
    data.addColumn('number', 'amount');

    //Boucle pour récupérer chaque donnée
    $.each(jsonData, function(i, jsonData)
    {
        var sectors = jsonData.sectors;
        var amount = parseFloat($.trim(jsonData.amount));
        data.addRows([[sectors, amount]]);
    });

    //Donner des options supplémentaires au camembert
    var options = 
    {
        title:'Funds by Sectors',
        sliceVisibilityThreshold:0.005,
        is3D: true,
        pieSliceTextStyle: {
            fontSize:'10',
        },
    };

    //Permet de dire que le graphique est un camembert et qu'il sera placer dans la div
    var chart = new google.visualization.PieChart(document.getElementById('chart_pie_funds_by_sectors'));
    chart.draw(data, options);
}
</script>

<!-- Partie HTML pour placer le grahpique -->
<div class='container-fluid'>
    <div id='chart_pie_funds_by_sectors' class='mx-auto' style='width:1000px;height:500px;'></div>
</div>
";
require 'footer.php';

?>