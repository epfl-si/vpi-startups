<?php

require './classes/class.fund.php';
require './classes/class.startup.php';

if($method=="add")
{
    $fund = new Fund();
    $option_stage_of_investment = $fund->select_option_stage_of_investment();
    $option_type_of_investment = $fund->select_option_type_of_investment();

    $startup = new Startup();
    $option_startup = $startup->select_all_startups();
    $investment_date=date("Y-m-d");
    if(isset($_POST['submit_btn_funds']))
    {
        if($fund->insert_new_funds($_POST))
        {
            $type_of_investment = $fund->get_type_of_investment_by_id_type_of_investment($_POST['fk_type_of_investment']);
            $stage_of_investment = $fund->get_stage_of_investment_by_id_stage_of_investment($_POST['fk_stage_of_investment']);
            $startup_name = $startup->get_startup_by_id_startup($_POST['fk_startup']);

            $after = "amount : ".$_POST['amount'].", investment date : ".$_POST['investment_date'].", investors : ".$_POST['investors'].", stage of investment : ".$stage_of_investment['stage_of_investment'].", type_of_investment : ".$type_of_investment['type_of_investment'].", startup : ".$startup_name['company'];
            $action = "Add new fund";

            add_logs($_SESSION['uniqueid'],"",$after,$action); 

            $_SESSION['flash_message']['message'] = "The fund was added to startup : ".$startup->get_startup_by_id($_POST['fk_startup'])['company'];
            $_SESSION['flash_message']['type'] = "success";
            header('Location: /funds/add');

        }
        
    }
    require_once("./pages/funds/form_funds.html");
}
elseif($method=="modify")
{
    
    $fund = new Fund();
    $get_funds_by_id = $fund->get_funds_by_id($param);
    $amount = $get_funds_by_id['amount'];
    $investment_date = $get_funds_by_id['investment_date'];
    $investors = $get_funds_by_id['investors'];

    $id_stage_of_investment = $fund->get_stage_of_investment_by_id($param);
    $option_stage_of_investment = $fund->select_option_stage_of_investment($id_stage_of_investment['id_stage_of_investment']);

    $id_type_of_investment = $fund->get_type_of_investment_by_id($param);
    $option_type_of_investment = $fund->select_option_type_of_investment($id_type_of_investment['id_type_of_investment']);
   
    $startup = new Startup();
    $get_startup_id = $startup->get_startup_by_id_funding($param);
    $option_startup = $startup->select_all_startups($get_startup_id['id_startup']);
    $get_all_funds_by_id = $fund->get_funds_to_modify($param);

    if(isset($_POST['submit_btn_funds']))
    {
        if(funds_data_has_been_modify($param))
        {
            if($fund->update_funds($_POST, $param))
            {   
                $type_of_investment_before= $fund->get_type_of_investment_by_id_type_of_investment($get_all_funds_by_id['fk_type_of_investment']);
                $stage_of_investment_before= $fund->get_stage_of_investment_by_id_stage_of_investment($get_all_funds_by_id['fk_stage_of_investment']);
                $startup_name_before= $startup->get_startup_by_id_startup($get_all_funds_by_id['fk_startup']);
                
                $type_of_investment_after= $fund->get_type_of_investment_by_id_type_of_investment($_POST['fk_type_of_investment']);
                $stage_of_investment_after= $fund->get_stage_of_investment_by_id_stage_of_investment($_POST['fk_stage_of_investment']);
                $startup_name_after= $startup->get_startup_by_id_startup($_POST['fk_startup']);
    
                $before = "amount : ".$get_all_funds_by_id['amount'].", investment date : ".$get_all_funds_by_id['investment_date'].", investors : ".$get_all_funds_by_id['investors'].", stage of investment : ".$stage_of_investment_before['stage_of_investment'].", type_of_investment : ".$type_of_investment_before['type_of_investment'].", startup : ".$startup_name_before['company'];
                $after = "amount : ".$_POST['amount'].", investment date : ".$_POST['investment_date'].", investors : ".$_POST['investors'].", stage of investment : ".$stage_of_investment_after['stage_of_investment'].", type_of_investment : ".$type_of_investment_after['type_of_investment'].", startup : ".$startup_name_after['company'];
                $action = "Modify fund";
    
                add_logs($_SESSION['uniqueid'],$before,$after,$action);

                $_SESSION['flash_message']['message'] = "The fund was changed to startup : ".$startup_name_after['company'];
                $_SESSION['flash_message']['type'] = "success";
                header("Location: /funds/modify/$param");
            }
        }
    }
    
    require_once("./pages/funds/form_funds.html");

}
else
{
    //Il affiche le menu aux utilisateurs qui ont le droit d'écrire
    if($_SESSION['TequilaPHPWrite'] == "TequilaPHPWritetrue")
    {
        echo "
        <script type='text/javascript'>
        //Recharger l\'API et le piechart package
        google.charts.load('current', {'packages':['table', 'corechart', 'controls']});
        
        //Permet de faire appel à l\'API quand elle est rechargée 
        google.charts.setOnLoadCallback(load_fundsdata);
        
        //Chercher dans la base de données les données nécessaires pour importer dans la fonction de dessin du tableau (Celle-ci est la même que celles au dessous, la seule différence est que cette partie est pour la checkbox qui est cochée par défaut, donc quand il n'y a pas de changement de checkbox)
        function load_fundsdata()
        {
            $.ajax
            ({
                url:'/tools/funds_db.php',
                method:'POST',
                dataType:'JSON',
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
            //Mettre dans une variable les données récupérées
            var jsonData = chart_data;
            //Initialiser la base d\'un google chart
            var data = new google.visualization.DataTable();
            //Initialiser les colonnes pour mettre les données
            data.addColumn('string', 'id_funding');
            data.addColumn('string', 'amount');
            data.addColumn('string', 'investment_date');
            data.addColumn('string', 'investors');
            data.addColumn('string', 'stage_of_investment');
            data.addColumn('string', 'type_of_investment');
            data.addColumn('string', 'startup');
            //Mettre les données dans les colonnes
            $.each(jsonData, function(i, jsonData)
            {
                var id_funding = jsonData.id_funding;
                var amount = jsonData.amount;
                var investment_date = jsonData.investment_date;
                var investors = jsonData.investors;
                var stage_of_investment = jsonData.stage_of_investment;
                var type_of_investment = jsonData.type_of_investment;
                var startup = jsonData.startup;
                data.addRows([[id_funding, amount, investment_date, investors, stage_of_investment, type_of_investment, startup]]);
            });
            
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
            //Dessiner les champs et faire appel aux fonctions des filtres
            dashboard.bind([stringFilter_amount, stringFilter_startup], [table]);
            dashboard.draw(data);
        }
        </script>
        <!-- Partie HTML pour placer les checkboxes, les champs filtres, le tableau et le bouton de téléchargement du fichier CSV -->
        <div class='container'>
            <legend class='font-weight-bold'> Funds </legend>
            <div id='dashboard_div'>
                <div class='row'>
                    <div id='search_amount' class='text-left col-6 my-5 '></div>
                    <div id='search_startup' class='text-right col-6 my-5 '></div>
                    <div id='table' class='col-12 pr-0'></div>
                </div>
            </div>
        </div>";
    }

}
?>