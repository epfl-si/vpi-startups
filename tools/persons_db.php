<?php

require 'connection_db.php';

//Chercher les données du nombre de startups par secteur avec une vue SQL
$person_db= $db ->query('SELECT * FROM person');
$persons = $person_db ->fetchAll();
foreach ($persons as $person)
{
    //Faire un tableau avec les données nécessaires pour le graphique
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
//Encoder l'output pour pouvoir prendre les données dans le graphique
echo json_encode($output);


?>