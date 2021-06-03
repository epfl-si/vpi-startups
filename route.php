<?php


session_start();

//echo "<pre>"; var_dump($_SESSION); echo "</pre>";

//var_dump($_GET['url']);

list($controller, $method, $param) = explode('/', $_GET['url']);

//var_dump($controller);
//var_dump($method);
//var_dump($param);
//pour persons.php
require 'tools/utils.php';
if ($controller === 'person' && $method === 'modify' && is_numeric($param) && isset($_POST['name']) && !empty($_POST['name'])) {

}else {
   require 'header.php';
}
//require 'header.php';
require 'tools/connection_db.php';
require 'tools/logs_function.php';

// Pour add_new_person.php
// localhost:8888/add_new_person.php → localhost:8888/person/add
if ($controller === 'person' && $method === 'add') {
    include_once('./add_new_person.php');
}

//pour add_new_company.php
if ($controller === 'startup' && $method === 'add') {
    include_once('./add_new_company.php');
}

//pour index.php
if ($controller === '') {
    include_once('./index.php');
}

//pour funds_by_sector.php
if ($controller === 'charts' && $method === 'funds_by_sector') {
    include_once('./funds_by_sector.php');
}

//pour number_of_startups_by_year.php
if ($controller === 'charts' && $method === 'number_of_startups_by_year') {
    include_once('./number_of_startups_by_year.php');
}

//pour startups_by_sectors.php
if ($controller === 'charts' && $method === 'startups_by_sectors') {
    include_once('./startups_by_sectors.php');
}

//pour import_from_csv.php
if ($controller === 'import') {
    include_once('./import_from_csv.php');
}

//pour logs_page.php
if ($controller === 'logs') {
    include_once('./logs_page.php');
}

//pour persons.php
if ($controller === 'person') {
    if ($method === 'modify' && is_numeric($param)) {
        if(isset($_POST['name']) && !empty($_POST['name'])) {
            if(data_has_been_modify($param)){
                require 'tools/write_changes_to_db.php';
            }
        }else {
            include_once('./modify_person_data.php');
        }

    }
    else {
        include_once('./persons.php');
    }
}

//pour modify_startup_data.php
if ($controller === 'startup' && $method === 'modify' && is_numeric($param)) {
    
        if(isset($_POST['company']) && !empty($_POST['company'])) {
            if(startup_data_has_been_modify($param)){
                require 'tools/write_startup_changes_to_db.php';
            }
        }else {
            include_once('./modify_startup_data.php');
        }
}

?>