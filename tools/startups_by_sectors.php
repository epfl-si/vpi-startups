<?php

require 'connection_db.php';

$startups_by_sectors = $db ->query('SELECT sectors, count(company) AS "company" From startup INNER JOIN sectors ON sectors.id_sectors=startup.fk_sectors GROUP BY sectors ORDER BY sectors ASC');
$startups_by_sector = $startups_by_sectors ->fetchAll();
foreach ($startups_by_sector as $startup_by_sector)
{
    $output[] = array 
    (
        'sectors'=> $startup_by_sector['sectors'],
        'company' => $startup_by_sector['company'],
    );

}
echo json_encode($output);


?>