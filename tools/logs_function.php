<?php

//Fonction pour ajouter des logs dans la base de données
function add_logs($sciper_number,$before,$after,$action)
{
    require 'connection_db.php';
    $date = new DateTime("now", new DateTimeZone('Europe/Zurich') );
    $date_timezone = $date->format('Y-m-d H:i:s');

    $insert_logs_data = $db -> prepare('INSERT INTO logs(sciper_number,date_logs,before_changes,after_changes,action) VALUES ("'.$sciper_number.'","'.$date_timezone.'","'.$before.'","'.$after.'","'.$action.'")');
    $insert_logs_data -> execute();
}

?>