<?php

//Fonction qui contient l'affichage du tableau
function intermediate_table($filename_queries_db, $type_data)
{
    //Remplacer les underscore par des espaces pour le titre du tableau
    $option_title = str_replace ( "_", " ", $type_data);

?>

  <script type='text/javascript'>
 
  //Recharger l\'API et les packages
  google.charts.load('current', {'packages':['table', 'corechart', 'controls', 'gauge'], 'language': 'en'});
  
  //Permet de faire appel à l\'API quand elle est rechargée 
  google.charts.setOnLoadCallback(load_data);
  
  //Fonction qui va chercher les données  dans la base de données
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
            //Envoyer le type de table intermediaire (Ex: Si dans l'url, il y a type_startup, il va envoyer ce controller pour faire la requête SQL)
            controller : type_data,
        },
        //Si tout se passe bien avec le résultat final, alors il passe à success et écrire les données dans le tableau
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

 
  //Fonction pour traiter les données reçues de la base de données et pour construire le tableau
  function drawChart_data(chart_data, type_data = "<?= $type_data; ?>")
  {   

    //Fonction qui permet de mettre les données dans le tableau et de le construire de manière automatique avec le controller qui est dans l'url
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
           
            //Initialiser des variables avec les noms des champs dans JSON pour la récupération des données
            var data_id = `id_${type_data}`;
            var type_datas = `${type_data}`;

            //Récupérer les données qui ont été envoyés au format JSON avec les bons noms des champs
            var id_data = jsonData[data_id];
            var data_type= jsonData[type_datas];

            //Mette les données dans les colonnes correspondantes
            data.addRows([[id_data, data_type]]);
        });

        //Initialiser un champ de recherche 
        var dashboard = new google.visualization.Dashboard
        (
            document.getElementById('dashboard_div')
        );

        //Champ pour trier par nom
        var stringFilter_name = new google.visualization.ControlWrapper
        ({
            //C'est un filtre de texte
            controlType: 'StringFilter',

            //Le filtre est placé dans la div search_name
            containerId: 'search_name',

            //Quelques ooptions supplementaires pour le filtre, comme par exemple, il n'est pas sensible à la case
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

        //Permet de masqué la première colonne qui contient les id de la table intermediaire
        table.setView({'columns': [1]}); 
        
        //Permet d'ajouter un evenement pour que quand l\'utilisateur clique sur une ligne, l'utilisateur soit redirigé vers la page de modification
        google.visualization.events.addListener(table, 'ready', function() 
        {
            var container = document.getElementById(table.getContainerId());
            Array.prototype.forEach.call(container.getElementsByTagName('TD'), function(cell) 
            {
            //Il ajoute un evenement à chaque cellule du tableau
            cell.addEventListener('click', selectCell);
            });
            
            //Fonction qui permet de prendre la cellule que l'utilisateur a cliqué et de lui rediriger vers la bonne page
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
    
        //Faire appel à la fonction de construction et mise en place des données du tableau
        display_data_to_table(chart_data, type_data = "<?= $type_data; ?>")
        
    }
    </script>
    <div class='container'>
        <!-- Titre du tableau -->
        <legend class="font-weight-bold my-3"> <?= $option_title; ?> </legend>
        <div id='dashboard_div'>
          <div class='row'>
              <!-- Filtre -->
              <div id='search_name' class='text-left col-4 mt-2 mb-5'></div>
              <!-- Tableau -->
              <div id='table' class='col-12 pr-0 mb-5'></div>
          </div>
      </div>
    </div>
  <?php
}

?>