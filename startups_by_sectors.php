<?php

require 'tools/hide_header.php';

//Graphique
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

//Mettre les données dans les bonnes colonnes
function drawChart_startups_by_sectors(chart_data)
{

    var jsonData = chart_data;


    var data = new google.visualization.DataTable();


    data.addColumn('string', 'sectors');
    data.addColumn('number', 'company');


    $.each(jsonData, function(i, jsonData)
    {
        var sectors = jsonData.sectors;


        var company = parseFloat($.trim(jsonData.company));


        data.addRows([[sectors, company]]);
    });


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


    var chart = new google.visualization.PieChart(document.getElementById('chart_pie_startups_by_sectors'));


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
