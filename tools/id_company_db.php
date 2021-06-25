<?php

require 'connection_db.php';

//Prendre la startup qui a été cliqué par l'utilisateur
$str = $_POST['str'];

//Mettre dans un tableau l'id de la personne cliquée
$id_startups = $db ->query('SELECT id_startup FROM startup WHERE company = "'.$str.'"');
$id_startup = $id_startups ->fetch();

$output[] = array 
(
    'id_startup'=> $id_startup['id_startup'],
);

//Envoyer l'id
echo json_encode($output);


?>