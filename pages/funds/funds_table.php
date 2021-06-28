<?php


//Fonction qui contient l'affichage du tableau avec les données de la table funding
function funds_table($id_startup)
{
  //Le tableau est fait avec la librairie google charts en javascript et jquery
  echo "
  <script type='text/javascript'>
  
  //Recharger l\'API et les packages
  google.charts.load('current', {'packages':['table', 'corechart', 'controls', 'gauge'], 'language': 'en'});
  
  //Permet de faire appel à l\'API quand elle est rechargée 
  google.charts.setOnLoadCallback(load_fundsdata);
  
  
  //Fonction qui va chercher les données de la table funding dans la base de données
  function load_fundsdata(id_startup)
  {
    //Mettre en variable l'id qui est dans l'url (S'il y en a)
    var id_startup = '".$id_startup."';

    //Methode ajax pour aller chercher les données dans la base de données avec du javascript
    $.ajax
    ({
        //Le fichier PHP qui contient les requêtes SQL nécessaires
        url:'/tools/funds_db.php',

        //Il utilise la methode POST pour envoyer des données
        method:'POST',
        dataType:'JSON',

        //L'id de la startup qui est dans la variable va être envoyer au fichier PHP en POST
        data: 
        {
          id_startup : id_startup,
        },
        //Si tout se passe bien avec le résultat final du fichier 'funds_db.php', alors il passe à success et écrire les données dans le tableau
        success:function(data)
        {
            drawChart_funds_data(data);
        },
        //En revanche, s'il y a eu problème ou s'il n'y a aucune donnée, il ne met rien sur le tableau
        error:function() 
        {
            drawChart_funds_data();
        }
    });
  }
  //Fonction pour traiter les données reçus de la base de données et pour construire le tableau
  function drawChart_funds_data(chart_data)
  {    
      var id_startup = '".$id_startup."';

      //Initialiser la variable sum_amount à 0. Cette variable sera utilise pour afficher l'addition de tous les fonds
      var sum_amount = 0;
    
      //Mettre dans une variable les données récupérées
      var jsonData = chart_data;

      //Initialiser la table
      var data = new google.visualization.DataTable();

      //Initialiser les colonnes de la table pour mettre les données
      data.addColumn('string', 'id_funding');
      data.addColumn('number', 'amount');
      data.addColumn('string', 'investment_date');
      data.addColumn('string', 'investors');
      data.addColumn('string', 'stage_of_investment');
      data.addColumn('string', 'type_of_investment');
      data.addColumn('string', 'startup');
      
      //Boucle pour aller récupérer les données qui sont dans jsonData
      $.each(jsonData, function(i, jsonData)
      {
        var id_funding = jsonData.id_funding;

        //Si la donnée est du type numerique, il faut faire un parse
        var amount = parseInt($.trim(jsonData.amount));
        var investment_date = jsonData.investment_date;

        //Convertir le format de date : yyyy-mm-dd vers dd-mm-yyyy

        //Il séparate chaque bout de la date (le séparateur est le - )
        var datearray = investment_date.split('-');

        //Il change l'ordre de la date grace à la séparation
        var date_investment = datearray[2] + '-' + datearray[1] + '-' + datearray[0];
    
        //Faire l'addition des fonds
        sum_amount += amount;

        var investors = jsonData.investors;
        var stage_of_investment = jsonData.stage_of_investment;
        var type_of_investment = jsonData.type_of_investment;
        var startup = jsonData.startup;

        //Mette les données dans les colonnes correspondantes
        data.addRows([[id_funding, amount, date_investment, investors, stage_of_investment, type_of_investment, startup]]);
      });
      
      //Fonction pour séparer les milliers d'un nombre
      function formatMillier(nombre)
      {
        nombre += '';
        var sep = '\'';
        var reg = /(\d+)(\d{3})/;
        while( reg.test( nombre)) 
        {
          nombre = nombre.replace( reg, '$1' +sep +'$2');
        }
        return nombre;
      }


      //Ecrire dans la div, le total des fonds
      document.getElementById('sum_amount').innerHTML += 'Total : '+formatMillier(sum_amount)+' CHF';

      //Condition qui vérifie s'il y a ou s'il n'y a pas d'id sur l'url
      if(id_startup == 'none')
      {
        //Initialiser les deux champs de recherche d\'une entreprise ou d\'une unité 
        var dashboard = new google.visualization.Dashboard
        (
            document.getElementById('dashboard_div')
        );

        //Permet de spécifier plus en détail le filtre dans les 2 champs. (Dans ce cas le filtre n'est pas sensible à la case et le match peut être fait avec des minuscules ou majuscules)

        //Champ pour trier par fonds
        var stringFilter_amount = new google.visualization.ControlWrapper
        ({
            //C'est un filtre de texte
            controlType: 'StringFilter',

            //Le filtre est placé dans la div search_amount
            containerId: 'search_amount',
            options: 
            {
                ui: 
                {
                    label: '',
                    placeholder : 'Search amount',
                }, 
                matchType: 'any',
                caseSensitive : 'false',
                filterColumnLabel: 'amount',
            }
        });

        //Champ pour trier par startup
        var stringFilter_startup = new google.visualization.ControlWrapper
        ({
            controlType: 'StringFilter',
            containerId: 'search_startup',
            options: 
            {
                ui: 
                {
                    label: '',
                    placeholder : 'Search Startup',
                }, 
                matchType: 'any',
                caseSensitive : 'false',
                filterColumnLabel: 'startup',
            }
        });
      }

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
      table.setView({'columns': [1, 2, 3, 4, 5, 6]}); 
      
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
              if(id_cell == 0 || id_cell == 1 || id_cell == 2 || id_cell == 3 || id_cell == 4 || id_cell == 5 || id_cell == 6)
              {
                  //Récupérer l'id du fond cliqué
                  var id_funding = tableDataView.getFormattedValue(selectedRow, 0);

                  //Rediriger l'utilisateur, en mettant l'id dans l'url
                  window.location.replace('/funds/modify/'+id_funding);
              } 
          }
      
      });
      
      //Partie pour télécharger un export de la table funds au format CSV
      $('#button_export_funds').on('click', function () 
      {
        //window.location.replace('/funds/export');
        window.location.replace('/pages/funds/export_funds_to_csv.php');
      });

      //Permet de transformer les données numeriques du tableau.
      var formatter = new google.visualization.NumberFormat({groupingSymbol:'\'',decimalSymbol:',',fractionDigits:'2'});
      formatter.format(data,1);

      //Condition pour séparer la méthode d'affichage du tableau s'il y a ou s'il n'y a pas d'id sur l'url
      if(id_startup == 'none')
      {
        //Dessiner les champs et faire appel aux fonctions des filtres
        dashboard.bind([stringFilter_amount, stringFilter_startup], [table]);
        dashboard.draw(data);
      }
      else
      { 
        //Dessiner le tableau sans la première colonne qui a été masquée
        var table = new google.visualization.Table(document.getElementById('table'));
        view = new google.visualization.DataView(data);
        view.hideColumns([0]);
        table.draw(view);
      }
  }
  </script>
  <div class='container'>
      <legend class='font-weight-bold mt-5'> Funds of Startup</legend>
      <div id='dashboard_div'>
          <div class='row'>";
          if($id_startup == "none")
          {
              //Div qui contiennent les filtres, le tableau et l'addition des fonds et le bouton pour exporter les funds en csv
              echo "
              <div id='search_amount' class='text-left col-4 my-5 ml-auto'></div>
              <div id='search_startup' class='text-left col-4 my-5'></div>
              <button id='button_export_funds' class='btn btn-outline-secondary col-4 my-5 '>Download Funds to CSV file</button>
              <div id='table' class='col-12 pr-0 mb-5'></div>
              <div id='sum_amount' class='col-12 pr-0 mb-5 font-weight-bold'></div>";
          }
          else
          {
            //Div qui contiennent le tableau, l'addition des fonds et un bouton pour additionner un fond lier à l'id de startup qui est sur l'url
            echo "
            <div id='table' class='col-12 pr-0 mb-5 mt-3 mx-auto'></div>
            <div id='sum_amount' class='col-12 pr-0 mb-5 font-weight-bold'></div>
            <a href='/funds/add/$id_startup' class='btn btn-outline-secondary col-2 mb-5 mr-5' role='button' aria-disabled='true'>Add New Fund to Startup</a>
            <a href='/funds/export/$id_startup' class='btn btn-outline-secondary col-2 mb-5 ml-5' role='button' aria-disabled='true'>Export Startups Funds to CSV</a>";
          }
          echo "
          </div>
      </div>
  </div>";
}

?>