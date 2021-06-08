<?php

require 'connection_db.php';


$str = $_POST['str'];

//Mettre dans un tableau l'id de la personne cliquée
$id_persons = $db ->query('SELECT id_person FROM person WHERE name = "'.$str.'"');
$id_person = $id_persons ->fetch();

$output[] = array 
(
    'id_person'=> $id_person['id_person'],
);

echo json_encode($output);


?>