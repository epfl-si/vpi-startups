<?php
//Récupérer les champs et les données de la page de modifications des personnes
$before_changes = $_SESSION['startup_data'];
$after_changes = $_POST;
$action = security_text($_POST['action']);

//implode(";",$_POST['faculty_schools'])

//logs
$before = "company : ".$before_changes['company_name'].", web : ".$before_changes['web'].", founding date : ".$before_changes['founding_date'].", rc : ".$before_changes['rc'].", exit year : ".$before_changes['exit_year'].", EPFL grant : ".$before_changes['epfl_grant'].", awards competitions : ".$before_changes['awards_competitions'].", key words : ".$before_changes['key_words'].", laboratory : ".$before_changes['laboratory'].", short description : ".$before_changes['short_description'].", type of startup : ".$before_changes['type_startup'].", ceo education level : ".$before_changes['ceo_education_level'].", sector : ".$before_changes['sectors'].", category : ".$before_changes['category'].", status : ".$before_changes['status'].", founders country : ".$before_changes['country'].", impact sdg : ".$before_changes['impact'].", faculty schools : ".$before_changes['schools'].", person 1 : ".$before_changes['person1'].", person 2 : ".$before_changes['person2'].", person 3 : ".$before_changes['person3'].", function person 1 : ".$before_changes['type_of_person1'].", function person 2 : ".$before_changes['type_of_person2'].", function person 3 : ".$before_changes['type_of_person3'];
$after = "company : ".$after_changes['company_name'].", web : ".$after_changes['web'].", founding date : ".$after_changes['founding_date'].", rc : ".$after_changes['rc'].", exit year : ".$after_changes['exit_year'].", EPFL grant : ".$after_changes['epfl_grant'].", awards competitions : ".$after_changes['awards_competitions'].", key words : ".$after_changes['key_words'].", laboratory : ".$after_changes['laboratory'].", short description : ".$after_changes['short_description'].", type of startup : ".$after_changes['type_startup'].", ceo education level : ".$after_changes['ceo_education_level'].", sector : ".$after_changes['sectors'].", category : ".$after_changes['category'].", status : ".$after_changes['status'].", founders country : ".$after_changes['founders_country'].", impact sdg : ".$after_changes['impact_sdg'].", faculty schools : ".$after_changes['faculty_schools'].", person 1 : ".$after_changes['person1'].", person 2 : ".$after_changes['person2'].", person 3 : ".$after_changes['person3'].", function person 1 : ".$after_changes['function_type_of_person1'].", function person 2 : ".$after_changes['function_type_of_person2'].", function person 3 : ".$after_changes['function_type_of_person3'];

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
];

//Transformer les données saisies par l'utilisateur par leurs id
$type_startup_id = $db -> query('SELECT id_type_startup FROM type_startup WHERE type_startup = "'.$_POST['type_startup'].'"');
$type_id = $type_startup_id -> fetch();
$type = $type_id['id_type_startup'];

$ceo_education_level_id = $db -> query('SELECT id_ceo_education_level FROM ceo_education_level WHERE ceo_education_level = "'.$_POST['ceo_education_level'].'"');
$ceo_education_id = $ceo_education_level_id -> fetch();
$ceo = $ceo_education_id['id_ceo_education_level'];

$sectors_id = $db -> query('SELECT id_sectors FROM sectors WHERE sectors = "'.$_POST['sectors'].'"');
$sector_id = $sectors_id -> fetch();
$sector = $sector_id['id_sectors'];

$categories_id = $db -> query('SELECT id_category FROM category WHERE category = "'.$_POST['category'].'"');
$category_id = $categories_id -> fetch();
$category = $category_id['id_category'];

$status_id = $db -> query('SELECT id_status FROM status WHERE status = "'.$_POST['status'].'"');
$statut_id = $status_id -> fetch();
$status = $statut_id['id_status'];

//Update des champs de la table startup
$sql_update_startup = "UPDATE startup SET company=:company_name, web=:web, founding_date=:founding_date, rc=:rc, exit_year=:exit_year, epfl_grant=:epfl_grant, awards_competitions=:awards_competitions, key_words=:key_words, laboratory=:laboratory, short_description=:short_description, fk_type=$type, fk_ceo_education_level=$ceo, fk_sectors=$sector, fk_category=$category, fk_status=$status WHERE id_startup=$param";
$stmt = $db->prepare($sql_update_startup);

//Update des champs multicritère
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
        $faculty = $_POST['faculty_schools'][$x];
        $id_faculty_schools = $db -> query('SELECT id_faculty_schools FROM faculty_schools WHERE faculty_schools = "'.$faculty.'"');
        $id_faculty_school = $id_faculty_schools -> fetch();
        $faculty_school = $id_faculty_school['id_faculty_schools'];

        $insert_new_faculties_schools =$db -> prepare('INSERT INTO startup_faculty_schools(fk_startup, fk_faculty_schools) VALUES('.$param.','.$faculty_school.')');
        $insert_new_faculties_schools -> execute();
    }
} 

if(startup_country_data_has_been_modify())
{
    //Compter le nombre de facultés choisies par l'utilisateur
    $count_founders_country = count($_POST['founders_country']);
    
    //Supprimer les facultés dans la base de données
    $delete_founders_country = $db -> prepare('DELETE FROM startup_founders_country WHERE fk_startup = "'.$param.'"');
    $delete_founders_country -> execute();

    //Insérer les nouvelles facultés
    for ($x=0; $x<$count_founders_country; $x++)
    {
        $country = $_POST['founders_country'][$x];
        $id_founders_country = $db -> query('SELECT id_founders_country FROM founders_country WHERE founders_country = "'.$country.'"');
        $id_country = $id_founders_country -> fetch();
        $founders_country = $id_country['id_founders_country'];

        $insert_new_founders_countries =$db -> prepare('INSERT INTO startup_founders_country(fk_startup, fk_founders_country) VALUES('.$param.','.$founders_country.')');
        $insert_new_founders_countries -> execute();
    }
}

if(startup_impact_data_has_been_modify())
{
    //Compter le nombre de facultés choisies par l'utilisateur
    $count_impact_sdg = count($_POST['impact_sdg']);
    
    //Supprimer les facultés dans la base de données
    $delete_impact_sdg = $db -> prepare('DELETE FROM startup_impact_sdg WHERE fk_startup = "'.$param.'"');
    $delete_impact_sdg -> execute();

    //Insérer les nouvelles facultés
    for ($x=0; $x<$count_impact_sdg; $x++)
    {
        $impact = $_POST['impact_sdg'][$x];
        $id_impact_sdg = $db -> query('SELECT id_impact_sdg FROM impact_sdg WHERE impact_sdg = "'.$impact.'"');
        $id_impact = $id_impact_sdg -> fetch();
        $impact_id = $id_impact['id_impact_sdg'];

        $insert_new_impact_sdg =$db -> prepare('INSERT INTO startup_impact_sdg(fk_startup, fk_impact_sdg) VALUES('.$param.','.$impact_id.')');
        $insert_new_impact_sdg -> execute();
    }
}

//Update des personnes et leurs fonctions
for ($x = 1; $x <= 3; $x++)
{  
    if(startup_person_data_has_been_modify($x) || startup_type_of_person_data_has_been_modify($x))
    {
        if($_POST["person$x"]=="delete"&&$_POST["function_type_of_person$x"]=="delete")
        {   
            $delete_startup_person = $db -> prepare('DELETE FROM startup_person WHERE fk_person ="'.$_SESSION['startup_data']["id_person$x"].'"');
            $delete_startup_person -> execute();
        }
        else
        {
            if(($_SESSION['startup_data']["id_person$x"] == ""&& $_POST["person$x"] != "") && ($_SESSION['startup_data']["id_type_of_person$x"] == ""&& $_POST["function_type_of_person$x"] != ""))
            {
                $add_new_startup_person = $db -> prepare('INSERT INTO startup_person(fk_startup,fk_person,fk_type_of_person) VALUES ("'.$param.'","'.$_POST["person$x"].'","'.$_POST["function_type_of_person$x"].'")');
                $add_new_startup_person -> execute();
            }
            //Si les champs ne sont pas vides, faire l'update de la table startup person
            else
            {
                $modify_startup_person = $db -> prepare('UPDATE startup_person SET fk_startup="'.$param.'", fk_person="'.$_POST["person$x"].'",fk_type_of_person="'.$_POST["function_type_of_person$x"].'" WHERE id_startup_person="'.$_SESSION['startup_data']["id_startup_person$x"].'"');
                $modify_startup_person -> execute();
            }
            
        }
    }
}

//Flash message pour dire à l'utilisateur que la startup a été changé
if($stmt->execute($data)){
    $_SESSION['flash_message']['message'] = $_POST['company_name']." was changed";
    $_SESSION['flash_message']['type'] = "success";

    //add_logs($_POST['company_name'],$after,$after,$action);
} else {
    $_SESSION['flash_message']['message'] = "An unexpected error occured";
    $_SESSION['flash_message']['type'] = "danger";
}

header("Location: /$controller/$method/$param");

?>