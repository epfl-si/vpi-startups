<?php

require 'tools/hide_header.php';


//Graphique avec le nombre de startups créées par année (Le graphique ne contient pas l'année courante)
echo "
<script type='text/javascript'>

google.charts.load('current', {packages: ['corechart', 'bar']});


google.charts.setOnLoadCallback(number_of_startups_by_year);

//Prendre les données de la base de données
function number_of_startups_by_year()
{
    $.ajax
    ({
        url:'/tools/number_of_startups_by_year.php',
        method:'POST',
        dataType:'JSON',
        success:function(data)
        {
            drawChart_number_of_startups_by_year(data);
        }
    });
}

//Mettre les données dans les bonnes colonnes
function drawChart_number_of_startups_by_year(chart_data)
{
    var jsonData = chart_data;
    var data = new google.visualization.DataTable();

    //Ajouter les colonnes
    data.addColumn('string', 'date');
    data.addColumn('number', 'number of startups');

    //Mettre les données dans les colonnées
    $.each(jsonData, function(i, jsonData)
    {
        var founding_date = jsonData.founding_date;
        var number_of_companies = parseFloat($.trim(jsonData.number_of_companies));
        data.addRows([[founding_date, number_of_companies]]);
    });

    //Donner le titre du tableau
    var options = 
    {
        title:'Number of Startups by Year',
    };
    
    //Dire que le graphique est du type lineaire et le mettre dans la div
    var chart = new google.visualization.LineChart(document.getElementById('chart_line_number_of_startups_by_year'));
    chart.draw(data, options);
}

</script>

<!-- Partie HTML pour placer les google charts -->
<div class='container-fluid'>
    <div id='chart_line_number_of_startups_by_year' class='mx-auto' style='width:1000px;height:500px;'></div>
</div>
";
require 'footer.php';

?>
