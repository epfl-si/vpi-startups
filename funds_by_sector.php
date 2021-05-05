<?php

require 'header.php';
require 'tools/hide_header.php';

//Si l'utilisateur est connecté à Tequila
if(isset($_SESSION['user']))
{
    //Script Javascript pour faire le graphique
    echo "
    <script type='text/javascript'>

    google.charts.load('current', {packages: ['corechart', 'bar']});    
    google.charts.setOnLoadCallback(funds_by_sectors);

    //Aller chercher les données concernants le graphique
    function funds_by_sectors()
    {
        $.ajax
        ({
            url:'tools/funds_by_sectors.php',
            method:'POST',
            dataType:'JSON',
            success:function(data)
            {
                drawChart_funds_by_sectors(data);
            }
        });
    }

    //Traiter les données de manière a les mettre dans les bonnes colonnes
    function drawChart_funds_by_sectors(chart_data)
    {
        var jsonData = chart_data;
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'sectors');
        data.addColumn('number', 'amount');
        $.each(jsonData, function(i, jsonData)
        {
            var sectors = jsonData.sectors;
            var amount = parseFloat($.trim(jsonData.amount));
            data.addRows([[sectors, amount]]);
        });
        var options = 
        {
            title:'Funds by Sectors',
            sliceVisibilityThreshold:0.005,
            is3D: true,
            pieSliceTextStyle: {
                fontSize:'10',
            },
        };
        var chart = new google.visualization.PieChart(document.getElementById('chart_pie_funds_by_sectors'));
        chart.draw(data, options);
    }
    </script>

    <!-- Partie HTML pour placer les google charts -->
    <div class='container-fluid'>
        <div id='chart_pie_funds_by_sectors' class='mx-auto' style='width:1000px;height:500px;'></div>
    </div>
    ";
    require 'footer.php';
}
//Si l'utilisateur n'est pas connecté
else
{
    echo "
    <script>
        window.location.replace('login.php');
    </script>
    ";
}
?>