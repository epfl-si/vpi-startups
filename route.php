<?php

//Ignorer les erreurs NOTICE
error_reporting(E_ALL & ~E_NOTICE);

//Ouvrir une session PHP
session_start();

//Mettre dans une liste, les paramètres de l'URL (1 = controller | 2 = method | 3 = param (id))
list($controller, $method, $param) = array_pad(explode('/', $_GET['url']),3,null);

//Importer le fichier utils
require 'tools/utils.php';

//Conditions qui permettent de vérifier si l'utilisateur a soumis le formulaire et evite de charger à nouveau le header du site
if ($controller === 'person' && $method === 'modify' && is_numeric($param) && isset($_POST['name']) && !empty($_POST['name'])) 
{
}
elseif ($controller === 'startup' && $method === 'modify' && is_numeric($param) && isset($_POST['company_name']) && !empty($_POST['company_name'])) 
{
}
elseif ($controller === 'person' && $method === 'add' && isset($_POST['name']) && !empty($_POST['name'])) 
{
}
elseif ($controller === 'startup' && $method === 'add' && isset($_POST['company_name']) && !empty($_POST['company_name'])) 
{
}
elseif ($controller === 'import' && isset($_POST['import']) && !empty($_FILES['fileToUpload']['name'])) 
{
}
elseif ($controller === 'funds' && $method === 'add' && isset($_POST['amount']) && !empty($_POST['amount']))
{
}
elseif ($controller === 'funds' && $method === 'modify' && is_numeric($param) && isset($_POST['amount']) && isset($_POST['amount'])) 
{
}
elseif ($controller === 'type_startup' && $method === 'add' && isset($_POST['add_new_type_startup']) && !empty($_POST['add_new_type_startup']))
{
}
elseif ($controller === 'type_startup' && $method === 'modify' && is_numeric($param) && isset($_POST['modify_type_startup']) && !empty($_POST['modify_type_startup'])) 
{
}
elseif ($controller === 'type_of_person' && $method === 'add' && isset($_POST['add_new_type_of_person']) && !empty($_POST['add_new_type_of_person']))
{
}
elseif ($controller === 'type_of_person' && $method === 'modify' && is_numeric($param) && isset($_POST['modify_type_of_person']) && !empty($_POST['modify_type_of_person'])) 
{
}
elseif ($controller === 'type_of_investment' && $method === 'add' && isset($_POST['add_new_type_of_investment']) && !empty($_POST['add_new_type_of_investment']))
{
}
elseif ($controller === 'type_of_investment' && $method === 'modify' && is_numeric($param) && isset($_POST['modify_type_of_investment']) && !empty($_POST['modify_type_of_investment'])) 
{
}
elseif ($controller === 'status' && $method === 'add' && isset($_POST['add_new_status']) && !empty($_POST['add_new_status']))
{
}
elseif ($controller === 'status' && $method === 'modify' && is_numeric($param) && isset($_POST['modify_status']) && !empty($_POST['modify_status'])) 
{
}
elseif ($controller === 'sectors' && $method === 'add' && isset($_POST['add_new_sectors']) && !empty($_POST['add_new_sectors']))
{
}
elseif ($controller === 'sectors' && $method === 'modify' && is_numeric($param) && isset($_POST['modify_sectors']) && !empty($_POST['modify_sectors'])) 
{
}
elseif ($controller === 'stage_of_investment' && $method === 'add' && isset($_POST['add_new_stage_of_investment']) && !empty($_POST['add_new_stage_of_investment']))
{
}
elseif ($controller === 'stage_of_investment' && $method === 'modify' && is_numeric($param) && isset($_POST['modify_stage_of_investment']) && !empty($_POST['modify_stage_of_investment'])) 
{
}
elseif ($controller === 'impact_sdg' && $method === 'add' && isset($_POST['add_new_impact_sdg']) && !empty($_POST['add_new_impact_sdg']))
{
}
elseif ($controller === 'impact_sdg' && $method === 'modify' && is_numeric($param) && isset($_POST['modify_impact_sdg']) && !empty($_POST['modify_impact_sdg'])) 
{
}
elseif ($controller === 'impact_sdg' && $method === 'add' && isset($_POST['add_new_impact_sdg']) && !empty($_POST['add_new_impact_sdg']))
{
}
elseif ($controller === 'founders_country' && $method === 'modify' && is_numeric($param) && isset($_POST['modify_founders_country']) && !empty($_POST['modify_founders_country'])) 
{
}
elseif ($controller === 'founders_country' && $method === 'add' && isset($_POST['add_new_founders_country']) && !empty($_POST['add_new_founders_country']))
{
}
elseif ($controller === 'faculty_schools' && $method === 'modify' && is_numeric($param) && isset($_POST['modify_faculty_schools']) && !empty($_POST['modify_faculty_schools'])) 
{
}
elseif ($controller === 'faculty_schools' && $method === 'add' && isset($_POST['add_new_faculty_schools']) && !empty($_POST['add_new_faculty_schools']))
{
}
elseif ($controller === 'ceo_education_level' && $method === 'modify' && is_numeric($param) && isset($_POST['modify_ceo_education_level']) && !empty($_POST['modify_ceo_education_level'])) 
{
}
elseif ($controller === 'ceo_education_level' && $method === 'modify' && is_numeric($param) && isset($_POST['modify_ceo_education_level']) && !empty($_POST['modify_ceo_education_level'])) 
{
}
elseif ($controller === 'category' && $method === 'modify' && is_numeric($param) && isset($_POST['modify_category']) && !empty($_POST['modify_category'])) 
{
}
elseif ($controller === 'category' && $method === 'modify' && is_numeric($param) && isset($_POST['modify_category']) && !empty($_POST['modify_category'])) 
{
}
elseif ($controller === 'funds' && $method === "export") 
{
}

//Conditions pour faire disparaitre le header des graphiques
elseif($controller === 'charts' && $method === "startups_by_sectors" && $_GET['header'] === "false")
{
    include_once('./startups_by_sectors.php');
}
elseif($controller === 'charts' && $method === "funds_by_sector" && $_GET['header'] === "false")
{
    include_once('./funds_by_sector.php');
}
elseif($controller === 'charts' && $method === "number_of_startups_by_year" && $_GET['header'] === "false")
{
    include_once('./number_of_startups_by_year.php');
}
elseif ($controller === 'logout') 
{
}
else 
{
    //Importer le header
    require_once 'header.php';
}

//Importer le fichier de connexion à la db et de logs
require 'tools/connection_db.php';
require 'tools/logs_function.php';

//Route pour persons.php
if ($controller === 'persons') 
{
    include_once('./persons.php');
}

//Route pour index.php
if ($controller === '') 
{
    include_once('./index.php');
}

//Route pour les exportation des fonds
if($controller === "funds" && $method==="export")
{
    include_once('./pages/funds/export_funds_to_csv.php');
}

//Route pour funds.php 
if ($controller === 'funds') 
{
    include_once('./pages/funds/funds.php');
}

//Route pour type_startup.php 
if ($controller === 'type_startup') 
{
    include_once('./pages/intermediate_tables/intermediate_data.php');
}

//Route pour type_of_person.php 
if ($controller === 'type_of_person') 
{
    include_once('./pages/intermediate_tables/intermediate_data.php');
}

//Route pour sectors.php 
if ($controller === 'sectors') 
{
    include_once('./pages/intermediate_tables/intermediate_data.php');
}

//Route pour status.php 
if ($controller === 'status') 
{
    include_once('./pages/intermediate_tables/intermediate_data.php');
}

//Route pour stage_of_investment.php 
if ($controller === 'stage_of_investment') 
{
    include_once('./pages/intermediate_tables/intermediate_data.php');
}

//Route pour type_of_investment.php 
if ($controller === 'type_of_investment') 
{
    include_once('./pages/intermediate_tables/intermediate_data.php');
}

//Route pour impact_sdg.php 
if ($controller === 'impact_sdg') 
{
    include_once('./pages/intermediate_tables/intermediate_data.php');
}

//Route pour founders_country.php 
if ($controller === 'founders_country') 
{
    include_once('./pages/intermediate_tables/intermediate_data.php');
}

//Route pour faculty_schools.php 
if ($controller === 'faculty_schools') 
{
    include_once('./pages/intermediate_tables/intermediate_data.php');
}

//Route pour category.php 
if ($controller === 'category') 
{
    include_once('./pages/intermediate_tables/intermediate_data.php');
}

//Route pour ceo_education_level.php 
if ($controller === 'ceo_education_level') 
{
    include_once('./pages/intermediate_tables/intermediate_data.php');
}

//Route pour login.php 
if ($controller === 'login') 
{
    include_once('./login.php');
}

//Route pour logout.php
if ($controller === 'logout') 
{
    include_once('./logout.php');
}

//Route pour funds_by_sector.php
if ($controller === 'charts' && $method === 'funds_by_sector') 
{
    include_once('./funds_by_sector.php');
}

//Route pour startups_by_sectors.php
if ($controller === 'charts' && $method === 'startups_by_sectors') 
{
    include_once('./startups_by_sectors.php');
}

//Route pour number_of_startups_by_year.php
if ($controller === 'charts' && $method === 'number_of_startups_by_year') 
{
    include_once('./number_of_startups_by_year.php');
}

//Route pour logs_page.php
if ($controller === 'logs') 
{
    include_once('./logs_page.php');
}

//Route pour persons.php
if ($controller === 'person' && $method === 'modify' && is_numeric($param)) 
{
    if(isset($_POST['name']) && !empty($_POST['name'])) 
    {
        //Fonction qui est dans utils.php, permet de vérifier si les données ont été changées
        if(data_has_been_modify($param))
        {
            require 'tools/write_person_changes_to_db.php';
        }
    }
    else 
    {
        include_once('./modify_person_data.php');
    }
}


//Route pour modify_startup_data.php
if ($controller === 'startup' && $method === 'modify' && is_numeric($param)) 
{
    if(isset($_POST['company_name']) && !empty($_POST['company_name'])) 
    {
        //Fonction qui est dans utils.php, permet de vérifier si les données ont été changées
        if(startup_data_has_been_modify($param))
        {
            require './tools/write_startup_changes_to_db.php';
        }
    }
    else 
    {
        include_once('./modify_startup_data.php');
    }
}

//Route pour import.php
if ($controller === 'import') 
{
    if(isset($_POST['import']) && !empty($_FILES['fileToUpload']['name'])) 
    {
        require './tools/import_to_db.php';
    }
    else
    {
        include_once('./import_from_csv.php');
    }
}

//Route pour add_startup.php
if ($controller === 'startup' && $method === 'add') 
{
    if(isset($_POST['company_name']) && !empty($_POST['company_name'])) 
    {
        require './tools/add_new_company_db.php';
    }
    else
    {
        include_once('./add_new_company.php');
    }
}

//Route pour add_person.php
if ($controller === 'person' && $method === 'add') 
{
    if(isset($_POST['name']) && !empty($_POST['name'])) 
    {
        require './tools/add_new_person_db.php';
    }
    else
    {
        include_once('./add_new_person.php');
    }
}

?>