<?php

if($_SESSION['TequilaPHPWrite'] == "TequilaPHPWritetrue")
{
    //Tableau avec les logs du site
    echo "
    <script type='text/javascript'>

    google.charts.load('current', { 'packages': ['table'] });
    google.charts.setOnLoadCallback(logs_table);

    //Fonction pour récupérer les logs dans la base de données
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

    //Fonction pour construire le tableau et mettre les données de la base de données
    function drawChart_logs_table(chart_data)
    {
        var jsonData = chart_data;
        var data = new google.visualization.DataTable();
        
        //Colonnes du tableau
        data.addColumn('string', 'sciper_number');
        data.addColumn('string', 'date');
        data.addColumn('string', 'before');
        data.addColumn('string', 'after');
        data.addColumn('string', 'action');

        //Ajouter les données aux colonnes
        $.each(jsonData, function(i, jsonData)
        {
            var sciper_number = jsonData.sciper_number;
            var date = jsonData.date;
            var after = jsonData.after;
            var before = jsonData.before;
            var action = jsonData.action;
            
            //Definir l'ordre des données pour qu'il match avec les noms de colonnes
            data.addRows([[sciper_number,date,before,after,action]]);
        });

        //Titre du tableau
        var options = 
        {
            title:'Logs',
        };
        
        //Dire que c'est un google chart du type tableau et le mettre dans la bonne div
        var table = new google.visualization.Table(document.getElementById('chart_logs_table'));

        //Construire le tableau et ne pas afficher l'id à chaque ligne
        table.draw(data, {showRowNumber: false});
    }

    
    </script>

    <!-- Partie HTML pour placer les google charts -->
    <div class='container'>
        <div id='chart_logs_table' class='mx-auto'></div>
    </div>
    ";
}

//Si l'utilisateur n'a pas le droit, il affiche un flash message d'avertissement
else
{
    $_SESSION['flash_message'] = array();
    $_SESSION['flash_message']['message'] = "You don't have enough rights to access this page";
    $_SESSION['flash_message']['type'] = "warning";
    header('Location: /');
}




?>