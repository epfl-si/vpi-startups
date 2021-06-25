<?php

require 'connection_db.php';

//Prendre les données des personnes (table person dans la base de données)
$person_db= $db ->query('SELECT * FROM person');
$persons = $person_db ->fetchAll();
foreach ($persons as $person)
{
    //Faire un tableau avec les données nécessaires
    $output[] = array 
    (
        'name'=> $person['name'],
        'firstname' => $person['firstname'],
        'person_function' => $person['person_function'],
        'email' => $person['email'],
        'prof_as_founder' => $person['prof_as_founder'],
        'gender' => $person['gender'],
        'sciper_number' => $person['sciper_number'],
    );

}
//Envoyer les données
echo json_encode($output);


?>