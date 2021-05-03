<?php

//Obtenir la fonction pour sécurisé les données envoyées par les formulaires
require '../header.php';

//Ouvrir la connexion à la base de données pour ajouter la nouvelle startup
require 'connection_db.php';

require 'logs_function.php';

//Mettre dans variables toutes les valeurs récupérées de la page add_new_company.php
$company_name = security_text($_POST['company_name']);
$founding_date = security_text($_POST['founding_date']);
$web = security_text($_POST['web']);
$rc = security_text($_POST['rc']);
$status = security_text($_POST['status']);
$exit_year = security_text($_POST['exit_year']);
$type_startup = security_text($_POST['type_startup']);
$category = security_text($_POST['category']);
$epfl_grant = security_text($_POST['epfl_grant']);
$awards_competition = security_text($_POST['awards_competition']);
$impact_sdg = security_text(implode(',', $_POST['impact_sdg']));
$sector = security_text($_POST['sector']);
$key_words = security_text($_POST['key_words']);
$ceo_education_level = security_text($_POST['ceo_education_level']);
$founders_country = security_text(implode(',', $_POST['founders_country']));
$faculty_schools = security_text(implode(',', $_POST['faculty_schools']));
$short_description = security_text($_POST['short_description']);
$person1 = security_text($_POST['person1']);
$person2 = security_text($_POST['person2']);
$person3 = security_text($_POST['person3']);
$function_person1 = security_text($_POST['function_person1']);
$function_person2 = security_text($_POST['function_person2']);
$function_person3 = security_text($_POST['function_person3']);
$impact_sdg_after_explode = explode (",", $impact_sdg);
$faculty_schools_after_explode = explode (",", $faculty_schools);
$founders_country_after_explode = explode (",", $founders_country);

//Initialiser une variable à false pour capturer les erreurs
$error_add_new_people = "false";

//Récupérer l'id du status que l'utilisateur a saisi pour écrire dans la table startup
$status_id = $db-> query('SELECT id_status FROM status WHERE status ="'.$status.'"');
$id_status = $status_id -> fetch();

//Récupérer l'id du type que l'utilisateur a saisi pour écrire dans la table startup
$type_startup_id = $db-> query('SELECT id_type_startup FROM type_startup WHERE type_startup ="'.$type_startup.'"');
$id_type_startup = $type_startup_id -> fetch();

//Récupérer l'id du sector que l'utilisateur a saisi pour écrire dans la table startup
$sectors_id = $db-> query('SELECT id_sectors FROM sectors WHERE sectors ="'.$sector.'"');
$id_sectors = $sectors_id -> fetch();

//Récupérer l'id du sector que l'utilisateur a saisi pour écrire dans la table startup
$ceo_education_level_id = $db-> query('SELECT id_ceo_education_level FROM ceo_education_level WHERE ceo_education_level ="'.$ceo_education_level.'"');
$id_ceo_education_level = $ceo_education_level_id -> fetch();

//Récupérer l'id du sector que l'utilisateur a saisi pour écrire dans la table startup
$category_id = $db-> query('SELECT id_category FROM category WHERE category ="'.$category.'"');
$id_category = $category_id -> fetch();

//Insertion des données dans la table startup
$add_new_startup = $db -> prepare('INSERT INTO startup(company,web,founding_date,rc,exit_year,epfl_grant,awards_competitions,key_words,laboratory,short_description,fk_type,fk_ceo_education_level,fk_sectors,fk_category,fk_status) VALUES("'.$company_name.'","'.$web.'","'.$founding_date.'","'.$rc.'","'.$exit_year.'","'.$epfl_grant.'","'.$awards_competition.'","'.$key_words.'","'.$laboratory.'","'.$short_description.'","'.$id_type_startup['id_type_startup'].'","'.$id_ceo_education_level['id_ceo_education_level'].'","'.$id_sectors['id_sectors'].'","'.$id_category['id_category'].'","'.$id_status['id_status'].'")');
$add_new_startup -> execute();

$startup_id = $db->lastInsertId();


//Ecrire les données dans la table logs pour dire que l'utilisateur à fait un ajout d'une nouvelle startup
$before = "";
$after = "Startup : ".$company_name.", Founding Date : ".$founding_date.", Web : ".$web.", Rc : ".$rc.", Status : ".$status.", Exit Year : ".$exit_year.", Type of Startup : ".$type_startup.", Category : ".$category.", EPFL Grant : ".$epfl_grant.", Awards Competition : ".$awards_competition.", Impact sdg : ".$impact_sdg.", Sector : ".$sector.", Key Words : ".$key_words.", CEO Education Level : ".$ceo_education_level.", Founders Country : ".$founders_country.", Faculty Schools : ".$faculty_schools.", Short Description : ".$short_description.", Person 1 : ".$person1.", Person Function 1 : ".$function_person1.", Person 2 : ".$person2.", Person Function 2 : ".$function_person2.", Person 3 : ".$person3.", Person Function 3 : ".$function_person3;
$action="Add new startup";

add_logs($sciper_number,$before,$after,$action);

//Traitement des champs multicritère
foreach ($impact_sdg_after_explode as $key => $val) 
{   
    //Récupérer l'id du status que l'utilisateur a saisi pour écrire dans la table startup
    $impact_sdg_id = $db-> query('SELECT id_impact_sdg FROM impact_sdg WHERE impact_sdg ="'.$val.'"');
    $id_impact_sdg = $impact_sdg_id -> fetch();

    $add_new_startup_impact_sdg = $db -> prepare('INSERT INTO startup_impact_sdg(fk_startup,fk_impact_sdg) VALUES("'.$startup_id.'","'.$id_impact_sdg['id_impact_sdg'].'")');
    $add_new_startup_impact_sdg -> execute(); 
}

foreach ($founders_country_after_explode as $key => $val) 
{   
    //Récupérer l'id du status que l'utilisateur a saisi pour écrire dans la table startup
    $founders_country_id = $db-> query('SELECT id_founders_country FROM founders_country WHERE founders_country ="'.$val.'"');
    $id_founders_country = $founders_country_id -> fetch();

    $add_new_startup_founders_country = $db -> prepare('INSERT INTO startup_founders_country(fk_startup,fk_founders_country) VALUES("'.$startup_id.'","'.$id_founders_country['id_founders_country'].'")');
    $add_new_startup_founders_country -> execute(); 
}

foreach ($faculty_schools_after_explode as $key => $val) 
{   
    //Récupérer l'id du status que l'utilisateur a saisi pour écrire dans la table startup
    $faculty_schools_id = $db-> query('SELECT id_faculty_schools FROM faculty_schools WHERE faculty_schools ="'.$val.'"');
    $id_faculty_schools = $faculty_schools_id -> fetch();

    $add_new_startup_faculty_schools = $db -> prepare('INSERT INTO startup_faculty_schools(fk_startup,fk_faculty_schools) VALUES("'.$startup_id.'","'.$id_faculty_schools['id_faculty_schools'].'")');
    $add_new_startup_faculty_schools -> execute(); 
}
for ($x = 1; $x <= 3; $x++) 
{
        
    
    echo $x.' '.${'person'.$x} .'<br>';

    if(${'person'.$x} != "" && ${'function_person'.$x} == "")
    {
       echo "erreur : ".${'person'.$x}." n'a pas de fonction";
       $error_add_new_people = "true";
       
    }
}
if($error_add_new_people == "false")
{
    for ($x = 1; $x <= 3; $x++) {

        //Récupérer l'id de la personne que l'utilisateur a saisi pour écrire dans la table startup
        $person_id = $db-> query('SELECT id_person FROM person WHERE name ="'.${'person'.$x}.'"');
        $id_person = $person_id -> fetch();

        //Récupérer l'id du type de personne que l'utilisateur a saisi pour écrire dans la table startup
        $type_of_person_id = $db-> query('SELECT id_type_of_person FROM type_of_person WHERE type_of_person ="'.${'function_person'.$x}.'"');
        $id_type_of_person = $type_of_person_id -> fetch();

        if($id_person != "" && $id_type_of_person != "")
        {
            $add_new_startup_person = $db -> prepare('INSERT INTO startup_person(fk_startup,fk_person,fk_type_of_person) VALUES("'.$startup_id.'","'.$id_person['id_person'].'","'.$id_type_of_person['id_type_of_person'].'")');
            $add_new_startup_person -> execute();
        } 

    }
}
?>