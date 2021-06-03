<?php

//Récupérer les champs et les données de la page de modifications des personnes
$before_changes = $_SESSION['startup_data'];
$after_changes = $_POST;
$action = security_text($_POST['action']);

$before = "company : ".$before_changes['company'].", web : ".$before_changes['web'].", founding date : ".$before_changes['founding_date'].", rc : ".$before_changes['rc'].", exit year : ".$before_changes['exit_year'].", EPFL grant : ".$before_changes['epfl_grant'].", awards competitions : ".$before_changes['awards_competitions'].", key words : ".$before_changes['key_words'].", laboratory : ".$before_changes['laboratory'].", short description : ".$before_changes['short_description']", type of startup : ".$before_changes['type_startup'].", ceo education level : ".$before_changes['ceo_education_level'].", sector : ".$before_changes['sectors'].", category : ".$before_changes['category'].", status : ".$before_changes['status'].", founders country : ".$before_changes['founders_country'].", impact sdg : ".$before_changes['impact_sdg'].", faculty schools : ".$before_changes['faculty_schools'].", person 1 : ".$before_changes['person1'].", person 2 : ".$before_changes['person2'].", person 3 : ".$before_changes['person3'].", function person 1 : ".$before_changes['function_type_of_person1'].", function person 2 : ".$before_changes['function_type_of_person2'].", function person 3 : ".$before_changes['function_type_of_person3'];
$after = "company : ".$after_changes['company'].", web : ".$after_changes['web'].", founding date : ".$after_changes['founding_date'].", rc : ".$after_changes['rc'].", exit year : ".$after_changes['exit_year'].", EPFL grant : ".$after_changes['epfl_grant'].", awards competitions : ".$after_changes['awards_competitions'].", key words : ".$after_changes['key_words'].", laboratory : ".$after_changes['laboratory'].", short description : ".$after_changes['short_description']", type of startup : ".$after_changes['type_startup'].", ceo education level : ".$after_changes['ceo_education_level'].", sector : ".$after_changes['sectors'].", category : ".$after_changes['category'].", status : ".$after_changes['status'].", founders country : ".$after_changes['founders_country'].", impact sdg : ".$after_changes['impact_sdg'].", faculty schools : ".$after_changes['faculty_schools'].", person 1 : ".$after_changes['person1'].", person 2 : ".$after_changes['person2'].", person 3 : ".$after_changes['person3'].", function person 1 : ".$after_changes['function_type_of_person1'].", function person 2 : ".$after_changes['function_type_of_person2'].", function person 3 : ".$after_changes['function_type_of_person3'];


$data = [

    "company"=> $_POST['company'],
    "web"=> $_POST['web'],
    "founding_date"=> $_POST['founding_date'],
    "rc"=> $_POST['rc'],
    "exit_year"=> $_POST['exit_year'],
    "epfl_grant"=> $_POST['epfl_grant'],
    "awards_competitions"=> $_POST['awards_competitions'],
    "key_words"=> $_POST['key_words'],
    "laboratory"=> $_POST['laboratory'],
    "short_description"=> $_POST['short_description'],
    "type_startup"=> $_POST['type_startup'],
    "ceo_education_level"=> $_POST['ceo_education_level'],
    "sectors"=> $_POST['sectors'],
    "category"=> $_POST['category'],
    "impact_sdg"=> $_POST['impact_sdg'],
    "founders_country"=> $_POST['founders_country'],
    "person1"=> $_POST['person1'],
    "person2"=> $_POST['person2'],
    "person3"=> $_POST['person3'],
    "function_type_of_person1"=> $_POST['function_type_of_person1'],
    "function_type_of_person2"=> $_POST['function_type_of_person2'],
    "function_type_of_person3"=> $_POST['function_type_of_person3'],
    
];
$type_startup_id = $db -> query('SELECT id_type_startup FROM type_startup WHERE type_startup = "'.$_POST['type_startup'].'"');
$type_id = $type_startup_id -> fetch();

$ceo_education_level_id = $db -> query('SELECT id_ceo_education_level FROM ceo_education_level WHERE ceo_education_level = "'.$_POST['ceo_education_level'].'"');
$ceo_education_id = $ceo_education_level_id -> fetch();

$sectors_id = $db -> query('SELECT id_sectors FROM sectors WHERE sectors = "'.$_POST['sectors'].'"');
$sector_id = $sectors_id -> fetch();

$categories_id = $db -> query('SELECT id_category FROM category WHERE category = "'.$_POST['category'].'"');
$category_id = $categories_id -> fetch();

$status_id = $db -> query('SELECT id_status FROM status WHERE status = "'.$_POST['status'].'"');
$statut_id = $status_id -> fetch();

$sql_update_startup = "UPDATE startup SET company=:company, web=:web, founding_date=:founding_date, rc=:rc, exit_year=:exit_year, epfl_grant=:epfl_grant, awards_competitions=:awards_competitions, key_words=:key_words, laboratory=:laboratory, short_description=:short_description, fk_type=$type_id['id_type_startup'], fk_ceo_education_level=$ceo_education_id['id_ceo_education_level'], fk_sectors=$sector_id['id_sectors'], fk_category=$category_id['id_category], fk_status=$statut_id['id_status'] WHERE id_startup=$param";
$stmt = $db->prepare($sql_update_startup);

$sql_update_startup = "UPDATE startup SET company=:company, web=:web, founding_date=:founding_date, rc=:rc, exit_year=:exit_year, epfl_grant=:epfl_grant, awards_competitions=:awards_competitions, key_words=:key_words, laboratory=:laboratory, short_description=:short_description, fk_type=$type_id['id_type_startup'], fk_ceo_education_level=$ceo_education_id['id_ceo_education_level'], fk_sectors=$sector_id['id_sectors'], fk_category=$category_id['id_category], fk_status=$statut_id['id_status'] WHERE id_startup=$param";
$stmt = $db->prepare($sql_update_startup);

if($stmt->execute($data)){
    $_SESSION['flash_message']['message'] = $_POST['company']." was changed";
    $_SESSION['flash_message']['type'] = "success";

    add_logs($_POST['company'],$after,$after,$action);
} else {
    $_SESSION['flash_message']['message'] = "An unexpected error occured";
    $_SESSION['flash_message']['type'] = "danger";
}
header("Location: /$controller/$method/$param");

?>