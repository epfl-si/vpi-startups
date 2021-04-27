<?php

require 'connection_db.php';

//Chercher les données du nombre de startups par secteur avec une vue SQL
$startups_by_sectors = $db ->query('SELECT * FROM view_startups_by_sector');
$startups_by_sector = $startups_by_sectors ->fetchAll();
foreach ($startups_by_sector as $startup_by_sector)
{
    //Faire un tableau avec les données nécessaires pour le camembert
    $output[] = array 
    (
        'sectors'=> $startup_by_sector['sectors'],
        'company' => $startup_by_sector['company'],
    );

}

//Encoder l'output pour pouvoir prendre les données dans le camembert
echo json_encode($output);


?>