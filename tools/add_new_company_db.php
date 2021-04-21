<?php

//Ouvrir la connexion à la base de données pour ajouter la nouvelle startup
require 'connection_db.php';

//Fonction pour empêcher les attaques XSS et injections SQL
function security_text($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//Mettre dans variables toutes les valeurs récupérées de la page add_new_company.php
$company_name = security_text($_POST['company_name']);
$founding_year = security_text($_POST['founding_year']);
$web = security_text($_POST['web']);
$rc = security_text($_POST['rc']);
$status = security_text($_POST['status']);
$exit_year = security_text($_POST['exit_year']);
$type_startup = security_text($_POST['type_startup']);
$category = security_text($_POST['category']);
$epfl_grant = security_text($_POST['epfl_grant']);
$impact_sdg = security_text(implode(',', $_POST['impact_sdg']));
$sector = security_text($_POST['sector']);
$key_words = security_text($_POST['key_words']);
$ceo_education_level = security_text($_POST['ceo_education_level']);
$founders_country = security_text(implode(',', $_POST['founders_country']));
$name = security_text($_POST['name']);
$firstname = security_text($_POST['firstname']);
$function = security_text($_POST['function']);
$email = security_text($_POST['email']);
$prof_as_founder = security_text($_POST['prof_as_founder']);
$gender = security_text($_POST['gender']);
$faculty_schools = security_text(implode(',', $_POST['faculty_schools']));
$laboratory = security_text($_POST['laboratory']);
$prof = security_text($_POST['prof']);
$amount = security_text($_POST['amount']);
$investment_date = security_text($_POST['investment_date']);
$type_of_investment = security_text($_POST['type_of_investment']);
$stage_of_investment = security_text($_POST['stage_of_investment']);
$investors = security_text($_POST['investor']);
$short_description = security_text($_POST['short_description']);

$impact_sdg_after_explode = explode (",", $impact_sdg);
$faculty_schools_after_explode = explode (",", $faculty_schools);
$founders_country_after_explode = explode (",", $founders_country);


/* //Récupérer l'id du status que l'utilisateur a saisi pour écrire dans la table startup
$type_of_investment_id = $db-> query('SELECT id_type_of_investment FROM type_of_investment WHERE type_of_investment ="'.$type_of_investment.'"');
$id_type_of_investment = $type_of_investment_id -> fetch();

//Récupérer l'id du status que l'utilisateur a saisi pour écrire dans la table startup
$stage_of_investment_id = $db-> query('SELECT id_stage_of_investment FROM stage_of_investment WHERE stage_of_investment ="'.$stage_of_investment.'"');
$id_stage_of_investment = $stage_of_investment_id -> fetch();

//Insertion des données dans la table startup
$add_new_funding = $db -> prepare('INSERT INTO funding(amount,investment_date,investors,fk_type_of_investment,fk_stage_of_investment) VALUES("'.$amount.'","'.$investment_date.'","'.$investors.'","'.$id_type_of_investment['id_type_of_investment'].'","'.$id_stage_of_investment['id_stage_of_investment'].'")');
$add_new_funding -> execute();

//Dernier id insérer (funding)
$funding_id = $db->lastInsertId(); */

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
$add_new_startup = $db -> prepare('INSERT INTO startup(company,web,founding_date,rc,exit_year,epfl_grant,awards_competitions,key_words,laboratory,short_description,fk_type,fk_ceo_education_level,fk_sectors,fk_funding,fk_category,fk_status) VALUES("'.$company_name.'","'.$web.'","'.$founding_date.'","'.$rc.'","'.$exit_year.'","'.$epfl_grant.'","'.$awards_competition.'","'.$key_words.'","'.$laboratory.'","'.$short_description.'","'.$id_type_startup['id_type_startup'].'","'.$id_ceo_education_level['id_ceo_education_level'].'","'.$id_sectors['id_sectors'].'","'.$funding_id.'","'.$id_category['id_category'].'","'.$id_status['id_status'].'")');
$add_new_startup -> execute(); 

/* foreach ($impact_sdg_after_explode as $key => $val) 
{   
    //Récupérer l'id du status que l'utilisateur a saisi pour écrire dans la table startup
    $impact_sdg_id = $db-> query('SELECT id_impact_sdg FROM impact_sdg WHERE impact_sdg ="'.$val.'"');
    $id_impact_sdg = $impact_sdg_id -> fetch();

    //Récupérer l'id du status que l'utilisateur a saisi pour écrire dans la table startup
    $startup_id = $db-> query('SELECT id_startup FROM startup WHERE company_name ="'.$company_name.'"');
    $id_startup = $startup_id -> fetch();

    $add_new_startup_impact_sdg = $db -> prepare('INSERT INTO startup_impact_sdg(fk_startup,fk_impact_sdg) VALUES("'.$id_startup['id_startup'].'","'.$id_impact_sdg['id_impact_sdg'].'")');
    $add_new_startup_impact_sdg -> execute(); 
}

foreach ($founders_country_after_explode as $key => $val) 
{   
    //Récupérer l'id du status que l'utilisateur a saisi pour écrire dans la table startup
    $founders_country_id = $db-> query('SELECT id_founders_country FROM founders_country WHERE founders_country ="'.$val.'"');
    $id_founders_country = $founders_country_id -> fetch();

    //Récupérer l'id du status que l'utilisateur a saisi pour écrire dans la table startup
    $startup_id = $db-> query('SELECT id_startup FROM startup WHERE company_name ="'.$company_name.'"');
    $id_startup = $startup_id -> fetch();

    $add_new_startup_founders_country = $db -> prepare('INSERT INTO startup_founders_country(fk_startup,fk_founders_country) VALUES("'.$id_startup['id_startup'].'","'.$id_founders_country['id_founders_country'].'")');
    $add_new_startup_founders_country -> execute(); 
}

foreach ($faculty_schools_after_explode as $key => $val) 
{   
    //Récupérer l'id du status que l'utilisateur a saisi pour écrire dans la table startup
    $faculty_schools_id = $db-> query('SELECT id_faculty_schools FROM faculty_schools WHERE faculty_schools ="'.$val.'"');
    $id_faculty_schools = $faculty_schools_id -> fetch();

    //Récupérer l'id du status que l'utilisateur a saisi pour écrire dans la table startup
    $startup_id = $db-> query('SELECT id_startup FROM startup WHERE company_name ="'.$company_name.'"');
    $id_startup = $startup_id -> fetch();

    $add_new_startup_faculty_schools = $db -> prepare('INSERT INTO startup_faculty_schools(fk_startup,fk_faculty_schools) VALUES("'.$id_startup['id_startup'].'","'.$id_faculty_schools['id_faculty_schools'].'")');
    $add_new_startup_faculty_schools -> execute(); 
}
 */
?>