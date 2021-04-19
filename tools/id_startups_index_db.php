<?php

require 'connection_db.php';

function security_text($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$str = security_text($_POST['str']);

//Mettre dans un tableau l'id de la startup cliquée
$id_startups = $db ->query('SELECT id_startup FROM startup WHERE company = "'.$str.'"');
$id_startup = $id_startups ->fetch();
/*foreach ($id_startup as $id)
{
    //Mettre dans un tableau les données récupérées de la base de données
    $output[] = array 
    (
        'id_startup'=> $id['id_startup'],
    );

}*/
$output[] = array 
    (
        'id_startup'=> $id_startup['id_startup'],
    );
//$id_startup = $id_startup['id_startup'];
echo json_encode($output);


?>