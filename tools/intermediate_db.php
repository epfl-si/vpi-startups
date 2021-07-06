<?php

require 'connection_db.php';

//Récupérer la valeur qui est dans l'url pour l'utiliser dans la requête SQL
$controller = $_POST['controller'];

//Chercher les données dans la base de données
$intermediate_db= $db ->query("SELECT * FROM $controller");
$intermediates = $intermediate_db ->fetchAll();
foreach ($intermediates as $intermediate)
{
    //Faire un tableau avec les données nécessaires pour le graphique
    $output[] = array 
    (
        "id_$controller" => $intermediate["id_$controller"],
        "$controller"=> $intermediate["$controller"],
    );

}
//Enovyer les données de l'array
echo json_encode($output);

?>