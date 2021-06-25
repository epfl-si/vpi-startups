<?php

require 'connection_db.php';

//Prendre le nombre de startups créées par année 
$count_companies_year = $db ->query('SELECT * FROM `view_number_of_startups_by_year`');
$count_company_year = $count_companies_year ->fetchAll();
foreach ($count_company_year as $company_year)
{
    //Faire un tableau avec les données nécessaires pour le graphique
    $output[] = array 
    (
        'number_of_companies'=> $company_year['number_of_companies'],
        'founding_date' => $company_year['founding_date'],
    );

}
//Envoyer les données
echo json_encode($output);


?>