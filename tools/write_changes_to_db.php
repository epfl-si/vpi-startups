<?php

//Ouvrir la connexion à la base de données pour ajouter la nouvelle startup
require 'connection_db.php';
require 'logs_function.php';

//Fonction pour empêcher les attaques XSS et injections SQL
function security_text($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//Récupérer les champs et les données de la page de modifications des personnes
$sciper = security_text($_POST['sciper']);
$get = security_text($_POST['get']);
$name_field = security_text($_POST['name_field']);
$before_changes = security_text($_POST['before_changes']);
$after_changes = security_text($_POST['after_changes']);
$action = security_text($_POST['action']);

$before = $name_field." : ".$before_changes;
$after = $name_field." : ".$after_changes;

//Faire un update du champ changé avec la nouvelle valeur pour l'id de personne    
$update_changes = $db -> prepare('UPDATE person SET '.$name_field.' = "'.$after_changes.'" WHERE id_person ="'.$get.'" ');
$update_changes -> execute();

add_logs($sciper,$before,$after,$action);
?>