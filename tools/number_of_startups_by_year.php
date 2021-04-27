<?php

require 'connection_db.php';

//Chercher les données du nombre de startups par secteur avec une vue SQL
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
//Encoder l'output pour pouvoir prendre les données dans le graphique
echo json_encode($output);


?>