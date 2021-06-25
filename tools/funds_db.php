<?php

require 'connection_db.php';

//Prendre l'id de la startup
$id_startup = $_POST['id_startup'];

//S'il n'y a pas d'id de startup
if($id_startup=="none")
{
    //Prendre la view general de tous les fonds
    $query = 'SELECT * FROM view_display_funds';
}
//S'il y a un id de startup
else
{
    //Prendre la view general, mais chercher seulement les données de la startup
    $query = 'SELECT * FROM view_display_funds WHERE fk_startup = "'.$id_startup.'"';
}

//Chercher les données dans la base de données
$funds_db= $db ->query($query);
$funds = $funds_db ->fetchAll();
foreach ($funds as $fund)
{
    //Faire un tableau avec les données nécessaires pour le graphique
    $output[] = array 
    (
        'id_funding' => $fund['id_funding'],
        'amount'=> $fund['amount'],
        'investment_date' => $fund['investment_date'],
        'investors' => $fund['investors'],
        'stage_of_investment' => $fund['stage_of_investment'],
        'type_of_investment' => $fund['type_of_investment'],
        'startup' => $fund['company'],
    );

}
//Enovyer les données de l'array
echo json_encode($output);

?>