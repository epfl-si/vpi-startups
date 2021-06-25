<?php

require 'connection_db.php';

//Chercher les logs par ordre descendente
$logs_db= $db ->query('SELECT * FROM logs GROUP BY id_logs DESC');
$logs = $logs_db ->fetchAll();
foreach ($logs as $log)
{
    //Faire un tableau avec les données nécessaires pour le tableau
    $output[] = array 
    (
        'sciper_number'=> $log['sciper_number'],
        'date' => $log['date_logs'],
        'after' => $log['after_changes'],
        'before' => $log['before_changes'],
        'action' => $log['action'],
    );

}
//Envoyer les données
echo json_encode($output);


?>