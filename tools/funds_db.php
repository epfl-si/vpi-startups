<?php

require 'connection_db.php';

$id_startup = $_POST['id_startup'];

if($id_startup=="none")
{
    $query = 'SELECT * FROM view_display_funds';
}
else
{
    $query = 'SELECT * FROM view_display_funds WHERE fk_startup = "'.$id_startup.'"';
}

//Chercher les données du nombre de startups par secteur avec une vue SQL
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
//Encoder l'output pour pouvoir prendre les données dans le graphique
echo json_encode($output);

?>