<?php

function add_logs($sciper_number,$before,$after,$action)
{
    require 'connection_db.php';
    $date = date("Y-m-d H:i:s");

    $insert_logs_data = $db -> prepare('INSERT INTO logs(sciper_number,date_logs,after_changes,before_changes,action) VALUES ("'.$sciper_number.'","'.$date.'","'.$after.'","'.$before.'","'.$action.'")');
    $insert_logs_data -> execute();
}

?>