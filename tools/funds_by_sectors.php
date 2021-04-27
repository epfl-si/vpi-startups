<?php

require 'connection_db.php';


//Chercher les données du nombre de startups par secteur avec une vue SQL
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
//Encoder l'output pour pouvoir prendre les données dans le camembert
echo json_encode($output);


?>