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
$time_to_exit = security_text($_POST['time_to_exit']);
$type = security_text($_POST['type']);
$capital = security_text($_POST['capital']);
$investor_platform = security_text($_POST['investor_platform']);
$epfl_grant = security_text($_POST['epfl_grant']);
$prix_hors_epfl = security_text($_POST['prix_hors_epfl']);
$impact = security_text($_POST['impact']);
$sector = security_text($_POST['sector']);
$key_words = security_text($_POST['key_words']);
$ba_ma_phd_epfl = security_text($_POST['ba_ma_phd_epfl']);
$founders_origin = security_text($_POST['founders_origin']);
$founders_country = security_text($_POST['founders_country']);
$name = security_text($_POST['name']);
$firstname = security_text($_POST['firstname']);
$function1 = security_text($_POST['function1']);
$email1 = security_text($_POST['email1']);
$email2 = security_text($_POST['email2']);
$name2 = security_text($_POST['name2']);
$firstname2 = security_text($_POST['firstname2']);
$function2 = security_text($_POST['function2']);
$prof_as_founder = security_text($_POST['prof_as_founder']);
$gender_female_ratio = security_text($_POST['gender_female_ratio']);
$gender_female_number = security_text($_POST['gender_female_number']);
$fac_dpt = security_text($_POST['fac_dpt']);
$laboratory = security_text($_POST['laboratory']);
$prof = security_text($_POST['prof']);
$investment_2020 = security_text($_POST['investment_2020']);
$investor_2020 = security_text($_POST['investor_2020']);
$description = security_text($_POST['description']);
$comments = security_text($_POST['comments']);


//Récupérer l'id du status que l'utilisateur a saisi pour écrire dans la table startup
$status_id = $db-> query('SELECT id_status FROM status WHERE status ="'.$status.'"');
$id_status = $status_id -> fetch();

//Récupérer l'id du type que l'utilisateur a saisi pour écrire dans la table startup
$type_id = $db-> query('SELECT id_type FROM type WHERE type ="'.$type.'"');
$id_type = $type_id -> fetch();

//Récupérer l'id du sector que l'utilisateur a saisi pour écrire dans la table startup
$sectors_id = $db-> query('SELECT id_sectors FROM sectors WHERE sectors ="'.$sector.'"');
$id_sectors = $sectors_id -> fetch();

//Mettre la variable à NULL si le champ est vide pour ne pas avoir d'erreurs dans la requête SQL
if($company_name == '')
{
    $company_name = "NULL";
}

if($founding_year == '')
{
    $founding_year = "NULL";
}

if($web == '')
{
    $web = "NULL";
}

if($rc == '')
{
    $rc = "NULL";
}

if($exit_year == '')
{
    $exit_year = "NULL";
}

if($time_to_exit == '')
{
    $time_to_exit = "NULL";
}

if($capital == '')
{
    $capital = "NULL";
}

if($investor_platform == '')
{
    $investor_platform = "NULL";
}

if($epfl_grant == '')
{
    $epfl_grant = "NULL";
}

if($prix_hors_epfl == '')
{
    $prix_hors_epfl = "NULL";
}

if($impact == '')
{
    $impact = "NULL";
}

if($ba_ma_phd_epfl == '')
{
    $ba_ma_phd_epfl = "NULL";
}

if($founders_origin == '')
{
    $founders_origin = "NULL";
}

if($founders_country == '')
{
    $founders_country = "NULL";
}

if($name == '')
{
    $name = "NULL";
}

if($firstname == '')
{
    $firstname = "NULL";
}

if($function1 == '')
{
    $function1 = "NULL";
}

if($email1 == '')
{
    $email1 = "NULL";
}

if($email2 == '')
{
    $email2 = "NULL";
}

if($name2 == '')
{
    $name2 = "NULL";
}

if($firstname2 == '')
{
    $firstname2 = "NULL";
}

if($function2 == '')
{
    $function2 = "NULL";
}

if($prof_as_founder == '')
{
    $prof_as_founder = "NULL";
}

if($gender_female_ratio == '')
{
    $gender_female_ratio = "NULL";
}

if($gender_female_number == '')
{
    $gender_female_number = "NULL";
}

if($fac_dpt == '')
{
    $fac_dpt = "NULL";
}

if($laboratory == '')
{
    $laboratory = "NULL";
}

if($prof == '')
{
    $prof = "NULL";
}

if($investment_2020 == '')
{
    $investment_2020 = "NULL";
}

if($investor_2020 == '')
{
    $investor_2020 = "NULL";
}

if($description == '')
{
    $description = "NULL";
}

if($comments == '')
{
    $comments = "NULL";
}



//Insertion des données dans la table startup
$add_new_startup = $db -> prepare('INSERT INTO startup(company,founding_year,web,rc,exit_year,time_to_exit,capital,investor_platform,epfl_grant,prix_hors_epfl,impact,key_words,ba_ma_phd_epfl,founders_origin,founders_country,name,firstname,function,email1,email2,name2,firstname2,function2,prof_as_founder,gender_female_ratio,gender_female_number,fac_dpt,laboratory,prof,investment_2020,investor_2020,description,comments,fk_status,fk_type,fk_sectors) VALUES("'.$company_name.'","'.$founding_year.'","'.$web.'","'.$rc.'","'.$exit_year.'","'.$time_to_exit.'","'.$capital.'","'.$investor_platform.'","'.$epfl_grant.'","'.$prix_hors_epfl.'","'.$impact.'","'.$key_words.'","'.$ba_ma_phd_epfl.'","'.$founders_origin.'","'.$founders_country.'","'.$name.'","'.$firstname.'","'.$function1.'","'.$email1.'","'.$email2.'","'.$name2.'","'.$firstname2.'","'.$function2.'","'.$prof_as_founder.'","'.$gender_female_ratio.'","'.$gender_female_number.'","'.$fac_dpt.'","'.$laboratory.'","'.$prof.'","'.$investment_2020.'","'.$investor_2020.'","'.$description.'", "'.$comments.'","'.$id_status['id_status'].'","'.$id_type['id_type'].'","'.$id_sectors['id_sectors'].'")');
$add_new_startup -> execute();


?>