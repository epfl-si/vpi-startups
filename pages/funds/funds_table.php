<?php

function funds_table($id_startup)
{
echo "
  <script type='text/javascript'>
  
  //Recharger l\'API et le piechart package
  google.charts.load('current', {'packages':['table', 'corechart', 'controls', 'gauge'], 'language': 'en'});
  
  //Permet de faire appel à l\'API quand elle est rechargée 
  google.charts.setOnLoadCallback(load_fundsdata);
  
  
  //Chercher dans la base de données les données nécessaires pour importer dans la fonction de dessin du tableau (Celle-ci est la même que celles au dessous, la seule différence est que cette partie est pour la checkbox qui est cochée par défaut, donc quand il n'y a pas de changement de checkbox)
  function load_fundsdata(id_startup)
  {
    var id_startup = '".$id_startup."';
    $.ajax
    ({
        url:'/tools/funds_db.php',
        method:'POST',
        dataType:'JSON',
        data: 
        {
          id_startup : id_startup,
        },
        //Si tout se passe bien avec le résultat final du fichier 'funds_db.php' alors il passe à success et écrire les données dans le tableau
        success:function(data)
        {
            drawChart_funds_data(data);
        },
        //En revanche, s'il y a eu problème ou s'il n'y a aucune donnée, il ne met rien sur le tableau
        error:function (data) 
        {
            drawChart_funds_data();
        }
    });
  }
  //Mettre les données dans le tableau et le dessiner
  function drawChart_funds_data(chart_data)
  {
      var id_startup = '".$id_startup."';
      var sum_amount = 0;
    
      //Mettre dans une variable les données récupérées
      var jsonData = chart_data;
      //Initialiser la base d\'un google chart
      var data = new google.visualization.DataTable();
      //Initialiser les colonnes pour mettre les données
      data.addColumn('string', 'id_funding');
      data.addColumn('number', 'amount');
      data.addColumn('string', 'investment_date');
      data.addColumn('string', 'investors');
      data.addColumn('string', 'stage_of_investment');
      data.addColumn('string', 'type_of_investment');
      data.addColumn('string', 'startup');
      //Mettre les données dans les colonnes
      $.each(jsonData, function(i, jsonData)
      {
        var id_funding = jsonData.id_funding;
        var amount = parseInt($.trim(jsonData.amount));
        var investment_date = jsonData.investment_date;

        //Convert yyyy-mm-dd to dd-mm-yyyy in displayed table
        var datearray = investment_date.split('-');
        var date_investment = datearray[2] + '-' + datearray[1] + '-' + datearray[0];
    
        //Faire l'addition des fonds
        sum_amount += amount;

        var investors = jsonData.investors;
        var stage_of_investment = jsonData.stage_of_investment;
        var type_of_investment = jsonData.type_of_investment;
        var startup = jsonData.startup;
        data.addRows([[id_funding, amount, date_investment, investors, stage_of_investment, type_of_investment, startup]]);
      });
      

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


      if(id_startup == 'none')
      {
        //Initialiser les deux champs de recherche d\'une entreprise ou d\'une unité 
        var dashboard = new google.visualization.Dashboard
        (
            document.getElementById('dashboard_div')
        );

      
        //Permet de spécifier plus en détail le filtre dans les 2 champs. (Dans ce cas le filtre n'est pas sensible à la case et le match peut être fait avec des minuscules ou majuscules)
        var stringFilter_amount = new google.visualization.ControlWrapper
        ({
            controlType: 'StringFilter',
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

      table.setView({'columns': [1, 2, 3, 4, 5, 6]}); 
      
      //Permet d'ajouter un evenement pour que quand l\'utilisateur clique sur une ligne, le script cherche le nom de l'entreprise et puisse rediriger l'utilisateur vers la page de details
      google.visualization.events.addListener(table, 'ready', function() 
      {
          var container = document.getElementById(table.getContainerId());
          Array.prototype.forEach.call(container.getElementsByTagName('TD'), function(cell) 
          {
          cell.addEventListener('click', selectCell);
          });
      
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

                  //Mettre l'id comme paramètre dans l'url
                  window.location.replace('/funds/modify/'+id_funding);
              } 
          }
      
      });
      
      
      var formatter = new google.visualization.NumberFormat({groupingSymbol:'\'',decimalSymbol:',',fractionDigits:'2'});
      formatter.format(data,1);

      if(id_startup == 'none')
      {
        //Dessiner les champs et faire appel aux fonctions des filtres
        dashboard.bind([stringFilter_amount, stringFilter_startup], [table]);
        dashboard.draw(data);
      }
      else
      { 
        var table = new google.visualization.Table(document.getElementById('table'));
        view = new google.visualization.DataView(data);
        view.hideColumns([0]);
        table.draw(view);
      }
  }
  </script>
  <!-- Partie HTML pour placer les checkboxes, les champs filtres, le tableau et le bouton de téléchargement du fichier CSV -->
  <div class='container'>
      <legend class='font-weight-bold mt-5'> Funds of Startup</legend>
      <div id='dashboard_div'>
          <div class='row'>";
          if($id_startup == "none")
          {
              echo "
              <div id='search_amount' class='text-left col-6 my-5 '></div>
              <div id='search_startup' class='text-right col-6 my-5 '></div>
              <div id='table' class='col-12 pr-0 mb-5'></div>
              <div id='sum_amount' class='col-12 pr-0 mb-5 font-weight-bold'></div>";
          }
          else
          {
            echo "
            <div id='table' class='col-12 pr-0 mb-5 mt-3 mx-auto'></div>
            <div id='sum_amount' class='col-12 pr-0 mb-5 font-weight-bold'></div>
            <a href='/funds/add/$id_startup' class='btn btn-outline-secondary mb-5' role='button' aria-disabled='true'>Add New Fund to Startup</a>";
          }
          echo "
          </div>
      </div>
  </div>";
}

?>