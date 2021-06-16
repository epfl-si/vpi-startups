<?php

require 'connection_db.php';

//Chercher les données du nombre de startups par secteur avec une vue SQL
$funds_db= $db ->query('SELECT * FROM funding');
$funds = $funds_db ->fetchAll();
foreach ($funds as $fund)
{
    $stages_of_investment_db= $db ->query('SELECT * FROM stage_of_investment WHERE id_stage_of_investment = "'.$fund['fk_stage_of_investment'].'"');
    $stage = $stages_of_investment_db ->fetch();

    $types_of_investment_db= $db ->query('SELECT * FROM type_of_investment WHERE id_type_of_investment = "'.$fund['fk_type_of_investment'].'"');
    $type = $types_of_investment_db ->fetch();

    $startups_db= $db ->query('SELECT * FROM startup WHERE id_startup = "'.$fund['fk_startup'].'"');
    $startup = $startups_db ->fetch();

    //Faire un tableau avec les données nécessaires pour le graphique
    $output[] = array 
    (
        'id_funding' => $fund['id_funding'],
        'amount'=> $fund['amount'],
        'investment_date' => $fund['investment_date'],
        'investors' => $fund['investors'],
        'stage_of_investment' => $stage['stage_of_investment'],
        'type_of_investment' => $type['type_of_investment'],
        'startup' => $startup['company'],
    );

}
//Encoder l'output pour pouvoir prendre les données dans le graphique
echo json_encode($output);

?>