<?php

require 'connection_db.php';

//Mettre dans un tableau les données importants d'une startup

$companies_data = $db ->query('SELECT company, founding_year, web, rc, status, sectors FROM startup INNER JOIN status ON startup.fk_status = status.id_status INNER JOIN sectors ON sectors.id_sectors = startup.fk_sectors');
$company_data = $companies_data ->fetchAll();
foreach ($company_data as $data_company)
{
    //Mettre dans un tableau les données récupérées de la base de données
    $output[] = array 
    (
        'company'=> $data_company['company'],
        'founding_year' => $data_company['founding_year'],
        'web'=>$data_company['web'],
        'rc'=>$data_company['rc'],
        'status'=>$data_company['status'],
        'sectors'=>$data_company['sectors'],
    );

}
echo json_encode($output);


?>