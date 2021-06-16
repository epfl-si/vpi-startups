<?php


session_start();

list($controller, $method, $param) = array_pad(explode('/', $_GET['url']),3,null);

//pour persons.php
require 'tools/utils.php';
if ($controller === 'person' && $method === 'modify' && is_numeric($param) && isset($_POST['name']) && !empty($_POST['name'])) {
}
elseif ($controller === 'startup' && $method === 'modify' && is_numeric($param) && isset($_POST['company_name']) && !empty($_POST['company_name'])) {
}
elseif ($controller === 'person' && $method === 'add' && isset($_POST['sciper_number']) && !empty($_POST['sciper_number'])) {
}
elseif ($controller === 'startup' && $method === 'add' && isset($_POST['company_name']) && !empty($_POST['company_name'])) {
}
elseif ($controller === 'import' && isset($_POST['import']) && !empty($_FILES['fileToUpload']['name'])) {
}
elseif ($controller === 'funds' && $method === 'add' && isset($_POST['amount']) && isset($_POST['amount'])) {
}
elseif ($controller === 'funds' && $method === 'modify' && is_numeric($param) && isset($_POST['amount']) && isset($_POST['amount'])) {
}
elseif ($controller === 'logout') {
}
else {
   require_once 'header.php';
}

require 'tools/connection_db.php';
require 'tools/logs_function.php';

// Pour add_new_person.php
// localhost:8888/add_new_person.php → localhost:8888/person/add
if ($controller === 'person' && $method === 'add') {
    include_once('./add_new_person.php');
}

//pour persons.php
if ($controller === 'persons') {
    include_once('./persons.php');
}

//pour index.php
if ($controller === '') {
    include_once('./index.php');
}

//funds 
if ($controller === 'funds') {
    include_once('./pages/funds/funds.php');
}

//Login 
if ($controller === 'login') {
    include_once('./login.php');
}

//Logout
if ($controller === 'logout') {
    include_once('./logout.php');
}

//pour funds_by_sector.php
if ($controller === 'charts' && $method === 'funds_by_sector') {
    include_once('./funds_by_sector.php');
}
elseif($controller === 'charts' && $method === 'funds_by_sector?header=false')
{
    include_once('./hide_header.php');
    include_once('./funds_by_sector.php');
}

//pour number_of_startups_by_year.php
if ($controller === 'charts' && $method === 'number_of_startups_by_year') {
    include_once('./number_of_startups_by_year.php');
}
elseif($controller === 'charts' && $method === 'number_of_startups_by_year?header=false')
{
    include_once('./hide_header.php');
    include_once('./number_of_startups_by_year.php');
}

//pour startups_by_sectors.php
if ($controller === 'charts' && $method === 'startups_by_sectors') {
    include_once('./startups_by_sectors.php');
}
elseif($controller === 'charts' && $method === 'startups_by_sectors?header=false')
{
    include_once('./hide_header.php');
    include_once('./startups_by_sectors.php');
}

//funds
if ($controller === 'funds') {
    include_once('./pages/funds/funds.php');
}

//pour logs_page.php
if ($controller === 'logs') {
    include_once('./logs_page.php');
}

//pour persons.php
if ($controller === 'person' && $method === 'modify' && is_numeric($param)) {
    if(isset($_POST['name']) && !empty($_POST['name'])) 
    {
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


//pour modify_startup_data.php
if ($controller === 'startup' && $method === 'modify' && is_numeric($param)) 
{
    if(isset($_POST['company_name']) && !empty($_POST['company_name'])) 
    {
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

//pour import.php
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

//pour add_person.php
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

require_once 'footer.php';
?>