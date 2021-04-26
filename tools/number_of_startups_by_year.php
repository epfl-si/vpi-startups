<?php

require 'connection_db.php';

$count_companies_year = $db ->query('SELECT founding_date, Count(company) AS "number_of_companies" FROM startup GROUP BY founding_date ORDER BY founding_date ASC');
$count_company_year = $count_companies_year ->fetchAll();
foreach ($count_company_year as $company_year)
{
    $output[] = array 
    (
        'number_of_companies'=> $company_year['number_of_companies'],
        'founding_date' => $company_year['founding_date'],
    );

}
echo json_encode($output);


?>