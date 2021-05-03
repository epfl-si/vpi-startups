<?php

require 'connection_db.php';
//Fonction pour empêcher les attaques XSS et injections SQL
function security_text($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$sciper_number = security_text($_POST['sciper_number']);
$date = security_text($_POST['date']);
$before = security_text($_POST['before']);
$after = security_text($_POST['after']);

$insert_logs_data = $db -> prepare('INSERT INTO logs(sciper_number,date_logs,after_logs,before_logs) VALUES ("'.$sciper_number.'","'.$date.'","'.$after.'","'.$before.'")');
$insert_logs_data -> execute();



?>