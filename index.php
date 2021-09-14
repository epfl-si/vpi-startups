<?php


    //Tableau qui affiche quelques données des startups
    ?>

    <script type='text/javascript'>

        //Recharger l\'API et le piechart package
        google.charts.load('current', {'packages':['table', 'corechart', 'controls']});
        
        //Permet de faire appel à l\'API quand elle est rechargée 
        google.charts.setOnLoadCallback(load_companies_data);
        
        
        
        function convert_and_copy_to_clipboard(data){
            
            navigator.clipboard.writeText(buildTable(data))
            .then(() => {
              console.log("Success !");
              alert("Wordpress table successfully copied!")
            })
            .catch(err => {
              console.log('Something went wrong', err);
            });
        }
        
        // Créer une Table HTML à partit des données de la DB
        function buildTable(data){
            var prefix = `<!-- wp:epfl/table-filter {"largeDisplay":true,"tableHeaderOptions":"header,sort"} -->\n<!-- wp:table {"className":"is-style-stripes"} -->\n<figure class="wp-block-table is-style-stripes">\n`;
            var suffix = `</figure>\n<!-- /wp:table -->\n<!-- /wp:epfl/table-filter -->`
            var headers = ["Company Name", "Founding Date", "Status", "Category", "Sectors", "Laboratory", "Faculty/Schools"]
            
            var strTable = prefix;
            strTable += '<Table>';
            for (var singleRow = 0; singleRow < data.length; singleRow++) {
                if (singleRow === 0) {
                    strTable += '<thead>';
                    strTable += '<tr>';
                } else {
                    
                    strTable += '<tr>';
                }
                
                var rowCells = data[singleRow];
                if(singleRow === 0){
                    for(var rowCell = 0; rowCell < headers.length; rowCell++){
                        strTable += '<th>';
                        strTable += headers[rowCell];
                        strTable += '</th>';
                    }
                }
                else {
                    let i = 0;
                    for (let [key, value] of Object.entries(rowCells)) {
                        if(value === null){
                            value = "";
                        }
                        strTable += '<td>';
                        strTable += value;
                        strTable += '</td>';
                    }
                }
                
                if (singleRow === 0) {
                    strTable += '</tr>';
                    strTable += '</thead>';
                    strTable += '<tbody>';
                } else {
                    strTable += '</tr>';
                }
            }
            strTable += '</tbody>';
            strTable += '</Table>';
            strTable += suffix;
            return strTable
            
            function isNotEmpty(row) {
                return row !== "";
            }
        }
        
        //Fonction pour récupérer les données nécessaires pour le tableau dans la base de données 
        function load_to_clipboard_companies_data()
        {
            $.ajax
            ({
                url:'/tools/companies_list_index_db.php',
                method:'POST',
                dataType:'JSON',

                //Si tout se passe bien avec le résultat final du fichier 'companies_list_index_db.php' alors il passe à success et écrire les données dans le tableau
                success:function(data)
                {
                    convert_and_copy_to_clipboard(data);
                },
                //En revanche, s'il y a eu problème ou s'il n'y a aucune donnée, il ne met rien sur le tableau
                error:function (data) 
                {
                    convert_and_copy_to_clipboard();
                }
            });
        }
        
        //Fonction pour récupérer les données nécessaires pour le tableau dans la base de données 
        function load_companies_data()
        {
            $.ajax
            ({
                url:'/tools/companies_list_index_db.php',
                method:'POST',
                dataType:'JSON',

                //Si tout se passe bien avec le résultat final du fichier 'companies_list_index_db.php' alors il passe à success et écrire les données dans le tableau
                success:function(data)
                {
                    drawChart_companies_data(data);
                },
                //En revanche, s'il y a eu problème ou s'il n'y a aucune donnée, il ne met rien sur le tableau
                error:function (data) 
                {
                    drawChart_companies_data();
                }
            });
        }
        
        //Mettre les données dans le tableau et le construire
        function drawChart_companies_data(chart_data)
        {
            //Mettre dans une variable les données récupérées
            var jsonData = chart_data;

            //Initialiser la base d\'un google chart
            var data = new google.visualization.DataTable();

            //Initialiser les colonnes pour mettre les données
            data.addColumn('string', 'Company Name');
            data.addColumn('string', 'Founding Date');
            data.addColumn('string', 'Status');
            data.addColumn('string', 'Category');
            data.addColumn('string', 'Sectors');
            data.addColumn('string', 'Laboratoy');
            data.addColumn('string', 'Faculty/Schools');

            //Mettre les données dans les colonnes
            $.each(jsonData, function(i, jsonData)
            {
                var company = jsonData.company;
                var founding_date = jsonData.founding_date;
                var category = jsonData.category;
                var laboratory = jsonData.laboratory;
                var status = jsonData.status;
                var sectors = jsonData.sectors;
                var schools = jsonData.schools;

                //Initialiser les colonnes du tableau
                data.addRows([[company, founding_date, status, category, sectors, laboratory, schools]]);
            });
            
            //Initialiser les deux champs de recherche d\'une entreprise ou d\'une unité 
            var dashboard = new google.visualization.Dashboard
            (
                document.getElementById('dashboard_div')
            );

            //Permet de spécifier plus en détail le filtre dans les 2 champs. (Dans ce cas le filtre n'est pas sensible à la case et le match peut être fait avec des minuscules ou majuscules)
            var stringFilter = new google.visualization.ControlWrapper
            ({
                controlType: 'StringFilter',
                containerId: 'search_company',
                options: 
                {
                    ui: 
                    {
                        label: '',
                        placeholder : 'Search Company',
                    }, 
                    matchType: 'any',
                    caseSensitive : 'false',
                    filterColumnLabel: 'Company Name',
                }
            });

            //Ajouter les champ de filtrage par statuts avec quelques options
            var CategoryFilter_status = new google.visualization.ControlWrapper
            ({
                'controlType': 'CategoryFilter',
                'containerId': 'status_dropdown_menu',
                'options': 
                {
                    ui: 
                    {
                        label: '',
                        placeholder : 'status',
                        selectedValuesLayout : 'below',
                        'caption': 'All Status',
                        allowTyping: false,
                        allowMultiple: true,
                    }, 
                    'filterColumnLabel': 'Status',

                }
            });

            //Ajouter le champ de filtrage par secteur avec quelques options
            var CategoryFilter_sectors = new google.visualization.ControlWrapper
            ({
                'controlType': 'CategoryFilter',
                'containerId': 'sectors_dropdown_menu',
                'options': 
                {
                    ui: 
                    {
                        label: '',
                        placeholder : 'sectors',
                        selectedValuesLayout : 'below',
                        'caption': 'All Sectors',
                        allowTyping: false,
                        allowMultiple: true,
                    }, 
                    'filterColumnLabel': 'Sectors',

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
                }
            });

            //Permet d'ajouter un evenement pour que quand l\'utilisateur clique sur une ligne, le script cherche le nom de la startup et redirige l'utilisateur vers la page de details de cette startup
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
                    if(id_cell == 0 || id_cell == 1 || id_cell == 2 || id_cell == 3 || id_cell == 4 || id_cell == 5)
                    {
                        //Récupérer le nom de startup cliqué
                        var str = tableDataView.getFormattedValue(selectedRow, 0);

                        //Chercher l'id de la startup dans la base de données
                        $.ajax
                        ({  
                            //Chemin vers la page qui contient les requêtes SQL
                            url:'/tools/id_company_db.php',
                            method:'POST',
                            dataType:'JSON',
                            data: 
                            {
                                str : str,
                            },
                            //Si tout est bien, il redirige l'utilisateur vers la page de la startup
                            success:function(data)
                            {
                                //Récupérer l'id de la startup dans la base de données
                                var id_startup = data[0].id_startup;
                                
                                //Mettre l'id comme paramètre dans l'url
                                window.location.replace('/startup/modify/'+id_startup);
                            },

                            //Si non, un pop-up d'avertissement est affiché
                            error:function()
                            {
                                alert('Something went wrong, please try again.');
                            }
                        });
                    } 
                }
            
            });

            //Partie pour télécharger un export de la table startup au format CSV
            $('.csv-button').on('click', function () 
            {
                window.location.replace('tools/export_csv.php');
            });
            
            $('.html-button').on('click', async function ()
            {
                load_to_clipboard_companies_data()
            });

            //Dessiner les champs et faire appel aux fonctions des filtres
            dashboard.bind([stringFilter, CategoryFilter_status, CategoryFilter_sectors], [table]);
            dashboard.draw(data);
        }
    </script>

    <!-- Partie HTML pour placer les checkboxes, les champs filtres, le tableau et le bouton de téléchargement du fichier CSV -->
    <div class='container'>
        <h5 class='font-weight-bold'> Homepage: Companies List </h5>
        <div id='dashboard_div'>
            <div class='row'>
                <div id='search_company' class='text-left col-3 my-5 '></div>
                <div id='status_dropdown_menu' class='text-center col-2 my-5 '></div>
                <div id='sectors_dropdown_menu' class='text-center col-2 my-5 '></div>
                <button id='button-csv' class='csv-button btn btn-outline-secondary col-2 my-5 ml-auto'>Download to CSV file</button>
                <button id='button-html' class='html-button btn btn-outline-secondary col-2 my-5 ml-auto'>Copy WP block</button>
                <div id='table' class='col-12 pr-0 mb-5'></div>
            </div>
        </div>
    </div>
    <?php

    require 'footer.php';


?>
