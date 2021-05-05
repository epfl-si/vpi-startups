<?php
require 'header.php';

//Il affiche seulement le menu si l'utilisateur est connecté
if(isset($_SESSION['user']))
{
    //Il affiche le menu aux utilisateurs qui ont le droit d'écrire
    if($_SESSION['TequilaPHPWrite'] == "TequilaPHPWritetrue")
    {
        //Tableau pour afficher les logs 
        echo "
        <script type='text/javascript'>

        google.charts.load('current', { 'packages': ['table'] });


        google.charts.setOnLoadCallback(logs_table);

        //Prendre les logs dans la base de données
        function logs_table()
        {
            $.ajax
            ({
                url:'tools/logs_db_read.php',
                method:'POST',
                dataType:'JSON',
                success:function(data)
                {
                    drawChart_logs_table(data);
                }
            });
        }

        //Ecrire les données dans les colonnes
        function drawChart_logs_table(chart_data)
        {
            var jsonData = chart_data;
            var data = new google.visualization.DataTable();
            
            data.addColumn('string', 'sciper_number');
            data.addColumn('string', 'date');
            data.addColumn('string', 'after');
            data.addColumn('string', 'before');
            data.addColumn('string', 'action');
            $.each(jsonData, function(i, jsonData)
            {
                var sciper_number = jsonData.sciper_number;
                var date = jsonData.date;
                var after = jsonData.after;
                var before = jsonData.before;
                var action = jsonData.action;
                
                data.addRows([[sciper_number,date,before,after,action]]);
            });
            var options = 
            {
                title:'Logs',
            };
            
            var table = new google.visualization.Table(document.getElementById('chart_logs_table'));

            table.draw(data, {showRowNumber: false, width: '100%'});
        }

        
        </script>

        <!-- Partie HTML pour placer les google charts -->
        <div class='container'>
            <div id='chart_logs_table' class='mx-auto'></div>
        </div>
        ";
    }
    //Si l'utilisateur appartient au groupe read
    else
    {
        echo "
        <script>
            alert('You don't have enough rights to access this page.');
            window.location.replace('index.php');
        </script>
        ";
    }
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