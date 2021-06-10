<?php

require 'connection_db.php';

//Mettre dans variables toutes les valeurs récupérées de la page add_new_company.php
$company_name = security_text($_POST['company_name']);
$founding_date = security_text($_POST['founding_date']);
$web = security_text($_POST['web']);
$rc = security_text($_POST['rc']);
$status = $_POST['status'];
$exit_year = security_text($_POST['exit_year']);
$type_startup = security_text($_POST['type_startup']);
$category = security_text($_POST['category']);
$epfl_grant = security_text($_POST['epfl_grant']);
$key_words = security_text($_POST['key_words']);
$short_description = security_text($_POST['short_description']);
$awards_competition = security_text($_POST['awards_competition']);
$impact_sdg = $_POST['impact_sdg'];
$sector = $_POST['sector'];
$ceo_education_level = $_POST['ceo_education_level'];
$founders_country = $_POST['founders_country'];
$faculty_schools = $_POST['faculty_schools'];
$person1 = $_POST['person1'];
$person2 = $_POST['person2'];
$person3 = $_POST['person3'];
$function_person1 = $_POST['function_person1'];
$function_person2 = $_POST['function_person2'];
$function_person3 = $_POST['function_person3'];


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
$after = "Startup : ".$company_name.", Founding Date : ".$founding_date.", Web : ".$web.", Rc : ".$rc.", Status : ".$status.", Exit Year : ".$exit_year.", Type of Startup : ".$type_startup.", Category : ".$category.", EPFL Grant : ".$epfl_grant.", Awards Competition : ".$awards_competition.", Impact sdg : ".implode(";",$impact_sdg).", Sector : ".$sector.", Key Words : ".$key_words.", CEO Education Level : ".$ceo_education_level.", Founders Country : ".implode(";",$founders_country).", Faculty Schools : ".implode(";",$faculty_schools).", Short Description : ".$short_description.", Person 1 : ".$person1.", Person Function 1 : ".$function_person1.", Person 2 : ".$person2.", Person Function 2 : ".$function_person2.", Person 3 : ".$person3.", Person Function 3 : ".$function_person3;
$action="Add new startup";

add_logs($sciper_number,$before,$after,$action);

//Traitement des champs multicritère 
//Compter le nombre de facultés choisies par l'utilisateur
$count_impact_sdg = count($impact_sdg);

//Insérer les nouvelles facultés
for ($x=0; $x<$count_impact_sdg; $x++)
{
    $impact = $_POST['impact_sdg'][$x];
    $id_impacts_sdg = $db -> query('SELECT id_impact_sdg FROM impact_sdg WHERE impact_sdg = "'.$impact.'"');
    $id_impact_sdg = $id_impacts_sdg -> fetch();
    $impact_sdg = $id_impact_sdg['id_impact_sdg'];

    $add_new_startup_impact_sdg = $db -> prepare('INSERT INTO startup_impact_sdg(fk_startup,fk_impact_sdg) VALUES("'.$startup_id.'","'.$impact_sdg.'")');
    $add_new_startup_impact_sdg -> execute(); 
}

//Compter le nombre de countries choisies par l'utilisateur
$count_founders_country = count($founders_country);

//Insérer les nouvelles facultés
for ($x=0; $x<$count_founders_country; $x++)
{
    $country = $_POST['founders_country'][$x];
    $id_founders_countries = $db -> query('SELECT id_founders_country FROM founders_country WHERE founders_country = "'.$country.'"');
    $id_founders_country = $id_founders_countries -> fetch();
    $founders_country = $id_founders_country['id_founders_country'];

    $add_new_startup_founders_country = $db -> prepare('INSERT INTO startup_founders_country(fk_startup,fk_founders_country) VALUES("'.$startup_id.'","'.$founders_country.'")');
    $add_new_startup_founders_country -> execute(); 
}

//Compter le nombre de countries choisies par l'utilisateur
$count_faculty_schools = count($faculty_schools);

//Insérer les nouvelles facultés
for ($x=0; $x<$count_faculty_schools; $x++)
{
    $faculty = $_POST['faculty_schools'][$x];
    $id_faculties_schools = $db -> query('SELECT id_faculty_schools FROM faculty_schools WHERE faculty_schools = "'.$faculty.'"');
    $id_faculty_schools = $id_faculties_schools -> fetch();
    $faculty_schools = $id_faculty_schools['id_faculty_schools'];

    $add_new_startup_faculty_schools = $db -> prepare('INSERT INTO startup_faculty_schools(fk_startup,fk_faculty_schools) VALUES("'.$startup_id.'","'.$faculty_schools.'")');
    $add_new_startup_faculty_schools -> execute(); 
}

//Fonction pour avertir l'utilisateur si la personne ou la fonction de la personne est erronée
for ($x = 1; $x <= 3; $x++) 
{
    if($_POST["person$x"] != "" && $_POST["function_person$x"] == "")
    {
       echo "erreur : ".$_POST["person$x"]." n'a pas de fonction";
       $error_add_new_people = "true";      
    }
}

//Si tout se passe bien
if($error_add_new_people == "false")
{
    //Insertion des personnes et leurs fonctions
    for ($x = 1; $x <= 3; $x++) {

        //Récupérer l'id de la personne que l'utilisateur a saisi pour écrire dans la table startup
        $person_id = $db-> query('SELECT id_person FROM person WHERE name ="'.$_POST["person$x"].'"');
        $id_person = $person_id -> fetch();

        //Récupérer l'id du type de personne que l'utilisateur a saisi pour écrire dans la table startup
        $type_of_person_id = $db-> query('SELECT id_type_of_person FROM type_of_person WHERE type_of_person ="'.$_POST["function_person$x"].'"');
        $id_type_of_person = $type_of_person_id -> fetch();

        if($id_person != "" && $id_type_of_person != "")
        {
            $add_new_startup_person = $db -> prepare('INSERT INTO startup_person(fk_startup,fk_person,fk_type_of_person) VALUES("'.$startup_id.'","'.$id_person['id_person'].'","'.$id_type_of_person['id_type_of_person'].'")');
            $add_new_startup_person -> execute();
        } 
    }
}
?>