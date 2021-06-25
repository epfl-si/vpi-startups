<?php

//Fonction pour ajouter des logs dans la base de données
function add_logs($sciper_number,$before,$after,$action)
{
    require 'connection_db.php';

    //Date du jour avec la zone time suisse
    $date = new DateTime("now", new DateTimeZone('Europe/Zurich') );

    //Date au format yyyy-mm-dd HH:mmm:ss
    $date_timezone = $date->format('Y-m-d H:i:s');

    //Insérer dans la base de données, les logs avec le numéro de sciper, la date, l'avant, l'après et l'action faite par l'utilisateur
    $insert_logs_data = $db -> prepare('INSERT INTO logs(sciper_number,date_logs,before_changes,after_changes,action) VALUES ("'.$sciper_number.'","'.$date_timezone.'","'.$before.'","'.$after.'","'.$action.'")');
    $insert_logs_data -> execute();
}

?>