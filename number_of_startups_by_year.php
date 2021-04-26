<?php

require 'header.php';

if(isset($_SESSION['user']))
{
    echo "
    <script type='text/javascript'>

    google.charts.load('current', {packages: ['corechart', 'bar']});


    google.charts.setOnLoadCallback(number_of_startups_by_year);
    google.charts.setOnLoadCallback(funds_by_sectors);


    function number_of_startups_by_year()
    {
        $.ajax
        ({
            url:'tools/number_of_startups_by_year.php',
            method:'POST',
            dataType:'JSON',
            success:function(data)
            {
                drawChart_number_of_startups_by_year(data);
            }
        });
    }

    function drawChart_number_of_startups_by_year(chart_data)
    {
        var jsonData = chart_data;
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'unit');
        data.addColumn('number', 'Download');
        $.each(jsonData, function(i, jsonData)
        {
            var founding_date = jsonData.founding_date;
            var number_of_companies = parseFloat($.trim(jsonData.number_of_companies));
            data.addRows([[founding_date, number_of_companies]]);
        });
        var options = 
        {
            title:'Number of Startups by Year',
            sliceVisibilityThreshold:0.005,
            is3D: true,
            pieSliceTextStyle: 
            {
                fontSize:'10',
            },
        };
        
        var chart = new google.visualization.PieChart(document.getElementById('chart_pie_number_of_startups_by_year'));
        chart.draw(data, options);
    }

    </script>

    <!-- Partie HTML pour placer les google charts -->
    <div class='container-fluid'>
        <div id='chart_pie_number_of_startups_by_year' class='mx-auto' style='width:1000px;height:500px;'></div>
    </div>
    ";
    require 'footer.php';
}
else
{
    echo "
    <script>
        window.location.replace('login.php');
    </script>
    ";
}
?>
