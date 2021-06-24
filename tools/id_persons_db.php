<?php

require 'connection_db.php';

//Prendre le nom de la personne qui a été cliqué par l'utilisateur
$str = $_POST['str'];

//Mettre dans un tableau l'id de la personne cliquée
$id_persons = $db ->query('SELECT id_person FROM person WHERE name = "'.$str.'"');
$id_person = $id_persons ->fetch();

$output[] = array 
(
    'id_person'=> $id_person['id_person'],
);

//Envoyer l'id
echo json_encode($output);


?>