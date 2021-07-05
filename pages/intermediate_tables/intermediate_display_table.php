<?php


//Fonction qui contient l'affichage du tableau avec les données de la table funding
function intermediate_table($filename_queries_db, $type_data)
{
  //Le tableau est fait avec la librairie google charts en javascript et jquery

?>

  <script type='text/javascript'>
 
  //Recharger l\'API et les packages
  google.charts.load('current', {'packages':['table', 'corechart', 'controls', 'gauge'], 'language': 'en'});
  
  //Permet de faire appel à l\'API quand elle est rechargée 
  google.charts.setOnLoadCallback(load_data);
  
  //Fonction qui va chercher les données de la table funding dans la base de données
  function load_data(file_name = "<?= $filename_queries_db; ?>", type_data = "<?= $type_data; ?>")
  {

    //Methode ajax pour aller chercher les données dans la base de données avec du javascript
    $.ajax
    ({
        //Le fichier PHP qui contient les requêtes SQL nécessaires
        url:'/tools/'+file_name,

        //Il utilise la methode POST pour envoyer des données
        method:'POST',
        dataType:'JSON',
        data: 
        {
            //Envoyer le sciper à la page PHP ci-dessus
            controller : type_data,
        },
        //Si tout se passe bien avec le résultat final du fichier 'funds_db.php', alors il passe à success et écrire les données dans le tableau
        success:function(data)
        {

            drawChart_data(data);
        },
        //En revanche, s'il y a eu problème ou s'il n'y a aucune donnée, il ne met rien sur le tableau
        error:function() 
        {
            drawChart_data();
        }
    });
  }

 
  //Fonction pour traiter les données reçus de la base de données et pour construire le tableau
  function drawChart_data(chart_data, type_data = "<?= $type_data; ?>")
  {   

    function display_data_to_table(chart_data, type_data) 
    {
        //Recupérer le type de tableau à afficher (Ex: Tableau avec tous les types de startup)
        //Mettre dans une variable les données récupérées
        var jsonData = chart_data;

        //Initialiser la table
        var data = new google.visualization.DataTable();

        data.addColumn('string', `id_${type_data}`);
        data.addColumn('string', type_data);
        
        //Boucle pour aller récupérer les données qui sont dans jsonData
        $.each(jsonData, function(i, jsonData, type_data = "<?= $type_data; ?>")
        {
            //Récupérer les données de la db
            var data_id = `id_${type_data}`;
            var type_datas = `${type_data}`;

            var id_data = jsonData[data_id];
            var data_type= jsonData[type_datas];

            //Mette les données dans les colonnes correspondantes
            data.addRows([[id_data, data_type]]);
        });

        //Initialiser les deux champs de recherche d\'une entreprise ou d\'une unité 
        var dashboard = new google.visualization.Dashboard
        (
            document.getElementById('dashboard_div')
        );

        //Champ pour trier par fonds
        var stringFilter_name = new google.visualization.ControlWrapper
        ({
            //C'est un filtre de texte
            controlType: 'StringFilter',

            //Le filtre est placé dans la div search_name
            containerId: 'search_name',
            options: 
            {
                ui: 
                {
                    label: '',
                    placeholder : 'Search name',
                }, 
                matchType: 'any',
                caseSensitive : 'false',
                filterColumnLabel: type_data,
            }
        });

        //Quelques options de plus, dans ce cas, il n'affiche pas les id\'s à chaque ligne
        var table = new google.visualization.ChartWrapper
        ({
            chartType: 'Table',
            containerId: 'table',
            options: 
            {
                showRowNumber: false,
                width:'100%',
            },
        });

        //Permet de masqué la premier colonne qui contient les id de la table funding
        table.setView({'columns': [1]}); 
        
        //Permet d'ajouter un evenement pour que quand l\'utilisateur clique sur une ligne, l'utilisateur soit redirigé vers la page de modification du fond
        google.visualization.events.addListener(table, 'ready', function() 
        {
            var container = document.getElementById(table.getContainerId());
            Array.prototype.forEach.call(container.getElementsByTagName('TD'), function(cell) 
            {
            //Il ajoute un evenement à chaque cellule du tableau
            cell.addEventListener('click', selectCell);
            });
            
            //Fonction qui permet de prendre quelle cellule l'utilisateur à cliquer et de lui rediriger vers la bonne page
            function selectCell(sender) 
            {
                //Récupérer le tableau qui est affiché
                var tableDataView = table.getDataTable();

                //Mettre en variable tous les elements de la ligne que l'utilisateur a cliqué
                var cell = sender.target;
                var row = cell.closest('tr');
            
                //Mettre en variable la position de la ligne que l'utilisateur a cliqué
                var selectedRow = row.rowIndex - 1;
                
                //Permet de savoir quelle celulle l'utilisateur a cliqué
                var e = event || window.event;
                var cell_e = e.target;
                var id_cell = cell_e.cellIndex;

                //Cette condition permet rediriger l'utilisateur vers la bonne page suivant la celulle cliquée
                if(id_cell == 0)
                {
                    //Récupérer l'id du fond cliqué
                    var id= tableDataView.getFormattedValue(selectedRow, 0);

                    //Rediriger l'utilisateur, en mettant l'id dans l'url
                    window.location.replace('/'+type_data+'/modify/'+id);
                } 
            }
        
        });

        //Dessiner les champs et faire appel aux fonctions des filtres
        dashboard.bind([stringFilter_name], [table]);
        dashboard.draw(data);
        }
    
        if(type_data == "type_startup")
        {
            display_data_to_table(chart_data, type_data = "<?= $type_data; ?>")
        }
    }
  </script>
  <div class='container'>
      <div id='dashboard_div'>
          <div class='row'>
              <div id='search_name' class='text-left col-4 my-5 ml-auto'></div>
              <div id='table' class='col-12 pr-0 mb-5'></div>
          </div>
      </div>
  </div>
  <?php
}

?>