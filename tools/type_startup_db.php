<?php

require 'connection_db.php';

//Chercher les données dans la base de données
$type_startup_db= $db ->query('SELECT * FROM type_startup');
$type_startups = $type_startup_db ->fetchAll();
foreach ($type_startups as $type_startup)
{
    //Faire un tableau avec les données nécessaires pour le graphique
    $output[] = array 
    (
        'id_type_startup' => $type_startup['id_type_startup'],
        'type_startup'=> $type_startup['type_startup'],
    );

}
//Enovyer les données de l'array
echo json_encode($output);

?>