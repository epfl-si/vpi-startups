<?php

require 'connection_db.php';

//Prendre le nombre de startups par secteur
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

//Envoyer les données
echo json_encode($output);


?>