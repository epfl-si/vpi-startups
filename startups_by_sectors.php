<?php

require 'tools/hide_header.php';

///Graphique avec le nombre de startups par secteur
echo "
<script type='text/javascript'>

google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(startups_by_sectors);

//Prendre les données de la base de données
function startups_by_sectors()
{
    $.ajax
    ({
        url:'/tools/startups_by_sectors.php',
        method:'POST',
        dataType:'JSON',
        success:function(data)
        {
            drawChart_startups_by_sectors(data);
        }
    });
}

//Mettre les données dans les colonnes
function drawChart_startups_by_sectors(chart_data)
{

    var jsonData = chart_data;
    var data = new google.visualization.DataTable();

    //Initialiser les colonnes
    data.addColumn('string', 'sectors');
    data.addColumn('number', 'company');


    //Prendre les données de la base de données et les mettre dans les colonnes
    $.each(jsonData, function(i, jsonData)
    {
        var sectors = jsonData.sectors;
        var company = parseFloat($.trim(jsonData.company));


        data.addRows([[sectors, company]]);
    });

    //Donner quelques options supplémentaires au graphique
    var options = 
    {
        title:'Startups by Sectors',
        sliceVisibilityThreshold:0.005,
        is3D: true,
        pieSliceTextStyle: 
        {
            fontSize:'10',
        },

    };

    //Dire que c'est un graphique du type camembert et le mettre dans la div
    var chart = new google.visualization.PieChart(document.getElementById('chart_pie_startups_by_sectors'));

    //Construire et afficher le graphique avec les données et les options supplémentaires
    chart.draw(data, options);
}

</script>

<!-- Partie HTML pour placer les google charts -->
<div class='container-fluid'>
    <div id='chart_pie_startups_by_sectors' class='mx-auto' style='width:1000px;height:500px;'></div>
</div>
";
require 'footer.php';

?>
