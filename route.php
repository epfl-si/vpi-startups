<?php

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
elseif ($controller === 'funds' && $method === "export") 
{
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
elseif($controller === 'charts' && $method === 'funds_by_sector?header=false')
{
    include_once('./hide_header.php');
    include_once('./funds_by_sector.php');
}

//Route pour number_of_startups_by_year.php
if ($controller === 'charts' && $method === 'number_of_startups_by_year') 
{
    include_once('./number_of_startups_by_year.php');
}
elseif($controller === 'charts' && $method === 'number_of_startups_by_year?header=false')
{
    include_once('./hide_header.php');
    include_once('./number_of_startups_by_year.php');
}

//Route pour startups_by_sectors.php
if ($controller === 'charts' && $method === 'startups_by_sectors') 
{
    include_once('./startups_by_sectors.php');
}
elseif($controller === 'charts' && $method === 'startups_by_sectors?header=false')
{
    include_once('./hide_header.php');
    include_once('./startups_by_sectors.php');
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