<?php

require 'connection_db.php';

$count_companies_year = $db ->query('SELECT sectors, SUM(amount) AS "amount" From startup INNER JOIN funding ON funding.id_funding=startup.fk_funding INNER JOIN sectors ON sectors.id_sectors = startup.fk_sectors GROUP BY sectors ORDER BY sectors');
$count_company_year = $count_companies_year ->fetchAll();
foreach ($count_company_year as $company_year)
{
    $output[] = array 
    (
        'sectors'=> $company_year['sectors'],
        'amount' => $company_year['amount'],
    );

}
echo json_encode($output);


?>