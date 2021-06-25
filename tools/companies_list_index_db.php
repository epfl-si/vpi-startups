<?php

require 'connection_db.php';

//Requête SQL nécessaire pour prendre les données du tableau de la page d'accueil
$companies_data = $db ->query('SELECT company, founding_date, web, rc, status, sectors FROM startup INNER JOIN status ON startup.fk_status = status.id_status INNER JOIN sectors ON sectors.id_sectors = startup.fk_sectors');
$company_data = $companies_data ->fetchAll();
foreach ($company_data as $data_company)
{
    //Mettre dans un array, les données nécessaires pour le tableau de la page d'accueil
    $output[] = array 
    (
        'company'=> $data_company['company'],
        'founding_date' => $data_company['founding_date'],
        'web'=>$data_company['web'],
        'rc'=>$data_company['rc'],
        'status'=>$data_company['status'],
        'sectors'=>$data_company['sectors'],
    );

}
//Envoyer les données de l'array
echo json_encode($output);


?>