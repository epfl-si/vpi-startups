<?php

//Récupérer les champs et les données de la page de modifications des personnes
$before_changes = $_SESSION['startup_data'];
$after_changes = $_POST;
$action = security_text($_POST['action']);

//Initialiser une variable à false pour contrôler l'update
$updated = false;

//Boucle pour changer l'id des personnes par leurs noms
for ($x=1;$x<=3;$x++)
{
    //Si la variable n'est pas vide
    if($after_changes["person$x"] != '')
    {
        //Requête pour obtenir le nom des personnes
        $person_name = $db -> query('SELECT name FROM person WHERE id_person = "'.$after_changes["person$x"].'"');
        $name = $person_name -> fetch();
        $after_changes["person$x"] = $name['name'];
    }
}

//Boucle pour changer l'id des fonctions des personnes par leurs noms de fonction
for ($x=1;$x<=3;$x++)
{
    //Si la variable n'est pas vide
    if($after_changes["function_type_of_person$x"] != '')
    {
        //Requête pour obtenir les noms des fonctions
        $function_type_of_person_name = $db -> query('SELECT type_of_person FROM type_of_person WHERE id_type_of_person = "'.$after_changes["function_type_of_person$x"].'"');
        $name_function = $function_type_of_person_name -> fetch();

        $after_changes["function_type_of_person$x"] = $name_function['type_of_person'];
    }
}
//recherche dans la vue des startup les nom des id selectionnées
$LOG = $db -> query('SELECT status,type_startup,sectors,ceo_education_level,country,impact,category FROM view_detail_startup_full WHERE id_startup ='.$param.'');
$LOG_statup = $LOG -> fetch();

//Texte pour les logs
$before = "company : ".$before_changes['company'].", web : ".$before_changes['web'].", founding date : ".$before_changes['founding_date'].", rc : ".$before_changes['rc'].", exit year : ".$before_changes['exit_year'].", EPFL grant : ".$before_changes['epfl_grant'].", awards competitions : ".$before_changes['awards_competitions'].", key words : ".$before_changes['key_words'].", laboratory : ".$before_changes['laboratory'].", short description : ".$before_changes['short_description'].", Company UID : ".$before_changes['company_uid'].", Crunchbase UID : ".$before_changes['crunchbase_uid'].", Unit Path : ".$before_changes['unit_path'].", type of startup : ".$before_changes['type_startup'].", ceo education level : ".$before_changes['ceo_education_level'].", sector : ".$before_changes['sectors'].", category : ".$before_changes['category'].", status : ".$before_changes['status'].", founders country : ".$before_changes['country'].", impact sdg : ".$before_changes['impact'].", faculty schools : ".$before_changes['schools'].", person 1 : ".$before_changes['name1'].", person 2 : ".$before_changes['name2'].", person 3 : ".$before_changes['name3'].", function person 1 : ".$before_changes['type_of_person1'].", function person 2 : ".$before_changes['type_of_person2'].", function person 3 : ".$before_changes['type_of_person3'];
$after = "company : ".$after_changes['company_name'].", web : ".$after_changes['web'].", founding date : ".$after_changes['founding_date'].", rc : ".$after_changes['rc'].", exit year : ".$after_changes['exit_year'].", EPFL grant : ".$after_changes['epfl_grant'].", awards competitions : ".$after_changes['awards_competitions'].", key words : ".$after_changes['key_words'].", laboratory : ".$after_changes['laboratory'].", short description : ".$after_changes['short_description'].", Company UID : ".$after_changes['company_uid'].", Crunchbase UID : ".$after_changes['crunchbase_uid'].", Unit Path : ".$after_changes['unit_path'].", type of startup : ".$LOG_statup["type_startup"].", ceo education level : ".$LOG_statup['ceo_education_level'].", sector : ".$LOG_statup['sectors'].", category : ".$LOG_statup['category'].", status : ".$LOG_statup['status'].", founders country : ".$LOG_statup['country'].", impact sdg : ".$LOG_statup['impact'].", faculty schools : ".implode(";",$after_changes['faculty_schools']).", person 1 : ".$after_changes['person1'].", person 2 : ".$after_changes['person2'].", person 3 : ".$after_changes['person3'].", function person 1 : ".$after_changes['function_type_of_person1'].", function person 2 : ".$after_changes['function_type_of_person2'].", function person 3 : ".$after_changes['function_type_of_person3'];

//Recupérer les données saisies par l'utilisateur
$data = [

    "company_name"=> $_POST['company_name'],
    "web"=> $_POST['web'],
    "founding_date"=> $_POST['founding_date'],
    "rc"=> $_POST['rc'],
    "exit_year"=> $_POST['exit_year'],
    "epfl_grant"=> $_POST['epfl_grant'],
    "awards_competitions"=> $_POST['awards_competitions'],
    "key_words"=> $_POST['key_words'],
    "laboratory"=> $_POST['laboratory'],
    "short_description"=> $_POST['short_description'],
    "company_uid"=> $_POST['company_uid'],
    "crunchbase_uid"=> $_POST['crunchbase_uid'],
    "unit_path"=> $_POST['unit_path'],
];

$type_stratup_Post= $_POST['type_startup_selectBox'];
$ceo_education_level_Post= $_POST['ceo_education_level_selectBox'];
$sector_Post= $_POST['sectors_selectBox'];
$status_Post= $_POST['status_selectBox'];

$categories_id = $db -> query('SELECT id_category FROM category WHERE category = "'.$_POST['category'].'"');
$category_id = $categories_id -> fetch();
$category = $category_id['id_category'];

//Update des champs de la table startup
$sql_update_startup = "UPDATE startup SET company=:company_name, web=:web, founding_date=:founding_date, rc=:rc, exit_year=:exit_year, epfl_grant=:epfl_grant, awards_competitions=:awards_competitions, key_words=:key_words, laboratory=:laboratory, short_description=:short_description, company_uid=:company_uid, crunchbase_uid=:crunchbase_uid, unit_path=:unit_path, fk_type=$type_stratup_Post, fk_ceo_education_level=$ceo_education_level_Post, fk_sectors=$sector_Post, fk_category=$category, fk_status=$status_Post WHERE id_startup=$param";

$stmt = $db->prepare($sql_update_startup);

//Si tout se passe bien
if($stmt->execute($data))
{
    //Il met la variable updated à true pour qu'il affiche le flash message de réussite
    $updated = true;
}
else
{
    //Il met la variable updated à false pour qu'il affiche le flash message d'échoue
    $updated = false;
}

//Update des champs multicritère (Il fait appel aux fonctions qui sont dans le fichier utils.php)
if(startup_faculty_data_has_been_modify())
{
    //Compter le nombre de facultés choisies par l'utilisateur
    $count_faculty_schools = count($_POST['faculty_schools']);
    
    //Supprimer les facultés dans la base de données
    $delete_faculty_schools = $db -> prepare('DELETE FROM startup_faculty_schools WHERE fk_startup = "'.$param.'"');
    $delete_faculty_schools -> execute();

    //Insérer les nouvelles facultés
    for ($x=0; $x<$count_faculty_schools; $x++)
    {
        //Prendre le nom et remplacer par l'id pour faire l'insertion dans la table intermediaire
        $faculty = $_POST['faculty_schools'][$x];
        $id_faculty_schools = $db -> query('SELECT id_faculty_schools FROM faculty_schools WHERE faculty_schools = "'.$faculty.'"');
        $id_faculty_school = $id_faculty_schools -> fetch();
        $faculty_school = $id_faculty_school['id_faculty_schools'];

        $insert_new_faculties_schools =$db -> prepare('INSERT INTO startup_faculty_schools(fk_startup, fk_faculty_schools) VALUES('.$param.','.$faculty_school.')');
        if($insert_new_faculties_schools -> execute())
        {
        }
        else
        {
            $updated = false;
        }
    }
} 

//Update des champs multicritère (Il fait appel aux fonctions qui sont dans le fichier utils.php)
if(startup_country_data_has_been_modify())
{
    
    //Compter le nombre de pays choisies par l'utilisateur
    $count_founders_country = count($_POST['founders_country_selectBox']);

    //Supprimer les pays dans la base de données
    $delete_founders_country = $db -> prepare('DELETE FROM startup_founders_country WHERE fk_startup = "'.$param.'"');
    $delete_founders_country -> execute();

    //Insérer les nouvelles pays 
    for ($x=0; $x<$count_founders_country; $x++)
    {
        //inserer les nouveaux pays qui ne sont pas null
        $country_id = $_POST['founders_country_selectBox'][$x];
        if ($country_id != "NULL"){
            $insert_new_founders_countries =$db -> prepare('INSERT INTO startup_founders_country(fk_startup, fk_founders_country) VALUES('.$param.','.$country_id.')');

            if($insert_new_founders_countries -> execute())
            {
            }
            else
            {
                $updated = false;
            }
        }
    }
}

//Update des champs multicritère (Il fait appel aux fonctions qui sont dans le fichier utils.php)

if(startup_impact_data_has_been_modify())
{
    //Compter le nombre de facultés choisies par l'utilisateur
    $count_impact_sdg = count($_POST['impact_sdg_selectBox']);
    
    //Supprimer les facultés dans la base de données
    $delete_impact_sdg = $db -> prepare('DELETE FROM startup_impact_sdg WHERE fk_startup = "'.$param.'"');
    $delete_impact_sdg -> execute();

    //Insérer les nouvelles facultés
    for ($x=0; $x<$count_impact_sdg; $x++)
    {
        //inserer les nouveaux impact qui ne sont pas null
        $impact_id = $_POST['impact_sdg_selectBox'][$x];
        if ($impact_id != "NULL"){
            $insert_new_impact_sdg =$db -> prepare('INSERT INTO startup_impact_sdg(fk_startup, fk_impact_sdg) VALUES('.$param.','.$impact_id.')');
            if($insert_new_impact_sdg -> execute())
            {
            }
            else
            {
                $updated = false;
            }
        }
       
    }
}

//Update des personnes et leurs fonctions
for ($x = 1; $x <= 3; $x++)
{  
    //Il fait appel aux fonctions qui sont dans le fichier utils.php
    if(startup_person_data_has_been_modify($x) || startup_type_of_person_data_has_been_modify($x))
    {
        //Si l'utilisateur a décidé de supprimer la personne et sa fonction
        if($_POST["person$x"]=="delete"&&$_POST["function_type_of_person$x"]=="delete")
        {   
            //Il la supprime de la base de données
            $delete_startup_person = $db -> prepare('DELETE FROM startup_person WHERE fk_person ="'.$_SESSION['startup_data']["id_person$x"].'"');
            $delete_startup_person -> execute();
        }
        else
        {
            //S'il n'y avait pas de personne ou de fonction pour la personne et l'utilisateur a choisi de mettre une personne ou fonction
            if(($_SESSION['startup_data']["id_person$x"] == ""&& $_POST["person$x"] != "") && ($_SESSION['startup_data']["id_type_of_person$x"] == ""&& $_POST["function_type_of_person$x"] != ""))
            {
                //Il insére dans la base de données
                $add_new_startup_person = $db -> prepare('INSERT INTO startup_person(fk_startup,fk_person,fk_type_of_person) VALUES ("'.$param.'","'.$_POST["person$x"].'","'.$_POST["function_type_of_person$x"].'")');
                if($add_new_startup_person -> execute())
                {
                }
                else
                {
                    $updated = false;
                }
            }
            //Si les champs ne sont pas vides, faire l'update de la table startup person
            else
            {
                $modify_startup_person = $db -> prepare('UPDATE startup_person SET fk_startup="'.$param.'", fk_person="'.$_POST["person$x"].'",fk_type_of_person="'.$_POST["function_type_of_person$x"].'" WHERE id_startup_person="'.$_SESSION['startup_data']["id_startup_person$x"].'"');
                if($modify_startup_person -> execute())
                {
                }
                else
                {
                    $updated = false;
                }
            }
            
        }
    }
}

//Flash message pour dire à l'utilisateur que la startup a été changé
if($updated){
    $_SESSION['flash_message']['message'] = $_POST['company_name']." was changed";
    $_SESSION['flash_message']['type'] = "success";

    //Ajouter les logs 
    add_logs($_SESSION['uniqueid'],$before,$after,$action);
} 

//Flash message d'échoue
else {
    $_SESSION['flash_message']['message'] = "An unexpected error occured";
    $_SESSION['flash_message']['type'] = "danger";
}

//Rediriger l'utilisateur vers la même page pour qu'îl puisse voir le flash message
header("Location: /$controller/$method/$param");

?>