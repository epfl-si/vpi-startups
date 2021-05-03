<?php

require 'connection_db.php';

//Chercher les données du nombre de startups par secteur avec une vue SQL
$logs_db= $db ->query('SELECT * FROM logs');
$logs = $logs_db ->fetchAll();
foreach ($logs as $log)
{
    //Faire un tableau avec les données nécessaires pour le graphique
    $output[] = array 
    (
        'sciper_number'=> $log['sciper_number'],
        'date' => $log['date_logs'],
        'after' => $log['after_changes'],
        'before' => $log['before_changes'],
        'action' => $log['action'],
    );

}
//Encoder l'output pour pouvoir prendre les données dans le graphique
echo json_encode($output);


?>