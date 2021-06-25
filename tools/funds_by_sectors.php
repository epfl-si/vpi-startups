<?php

require 'connection_db.php';


//Prendre les données des fonds par sectors grace à la view SQL
$count_companies_year = $db ->query('SELECT * FROM view_funds_by_sector');
$count_company_year = $count_companies_year ->fetchAll();
foreach ($count_company_year as $company_year)
{
    //Faire un tableau avec les données nécessaires pour le camembert
    $output[] = array 
    (
        'sectors'=> $company_year['sectors'],
        'amount' => $company_year['amount'],
    );

}
//Envoyer les données de l'array
echo json_encode($output);


?>