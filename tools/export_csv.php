<?php

require 'connection_db.php';

//Mettre la date d'aujourd'hui dans le nom du fichier csv
$today = date("d-m-Y");

//Ouvrir un fichier pour mettre les données de la base de données
$file = fopen("../csv_imported/csv_".$today.".csv", "w+");

//Donner le nom du fichier avec la date courante et le nom du chemin où se trouve le fichier
$filename = "csv_".$today.".csv";
$filepath = "../csv_imported/csv_".$today.".csv";


//Prendre les données de startup de la base de données 
$startup = $db->prepare("SELECT * FROM startup INNER JOIN startup_person ON startup.id_startup = startup_person.fk_startup INNER JOIN person ON startup_person.fk_person = person.id_person");
$startup->execute();

//Supprimer le code HTML du fichier csv
ob_end_clean();

//Mettre l'en-tête dans le fichier csv
$header_csv = array("company","founding_date","web","rc","exit_year","epfl_grant","awards_competitions","key_words","laboratory","short_description","name", "firstname", "person_function", "email", "prof_as_founder", "gender", "type_of_person", "type","ceo_education_level","sectors", "amount","investment_date","investors","stage_of_investment","type_of_investment","category", "status","founders_country", "faculty_schools", "impact_sdg");
try 
{
    fputcsv($file, $header_csv);
}
catch  (Exception $e) 
{
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}

//Mettre les données dans le fichier csv
while ($row = $startup->fetch(PDO::FETCH_NAMED)) 
{
    //Mettre les données de la base de données dans le fichier CSV
    $id_startup = $db ->query('SELECT id_startup FROM startup');
    $startup_id = $id_startup->fetch();

    $fk_status = $db ->query('SELECT status FROM status WHERE id_status ="'.$row['fk_status'].'"');
    $status = $fk_status->fetch();

    $fk_type_startup = $db ->query('SELECT type_startup FROM type_startup WHERE id_type_startup ="'.$row['fk_type'].'"');
    $type_startup = $fk_type_startup->fetch();

    $fk_sectors = $db ->query('SELECT sectors FROM sectors WHERE id_sectors ="'.$row['fk_sectors'].'"');
    $sectors = $fk_sectors->fetch();

    $fk_category = $db ->query('SELECT category FROM category WHERE id_category ="'.$row['fk_category'].'"');
    $category = $fk_category->fetch();

    $fk_ceo_education_level = $db ->query('SELECT ceo_education_level FROM ceo_education_level WHERE id_ceo_education_level ="'.$row['fk_ceo_education_level'].'"');
    $ceo_education_level = $fk_ceo_education_level->fetch();

    $fk_funding = $db ->query('SELECT amount,investment_date,investors,fk_stage_of_investment, fk_type_of_investment FROM funding WHERE id_funding ="'.$row['fk_funding'].'"');
    $funding = $fk_funding->fetch();

    $fk_stage_of_investment= $db ->query('SELECT stage_of_investment FROM stage_of_investment WHERE id_stage_of_investment ="'.$funding['fk_stage_of_investment'].'"');
    $stage_of_investment = $fk_stage_of_investment->fetch();

    $fk_type_of_investment= $db ->query('SELECT type_of_investment FROM type_of_investment WHERE id_type_of_investment ="'.$funding['fk_type_of_investment'].'"');
    $type_of_investment = $fk_type_of_investment->fetch();

    $fk_person= $db ->query('SELECT name,firstname,person_function,email,prof_as_founder,gender,fk_type_of_person FROM person INNER JOIN startup_person ON person.id_person = startup_person.fk_person');
    $person = $fk_person->fetch();

    $fk_type_of_person= $db ->query('SELECT type_of_person FROM type_of_person WHERE id_type_of_person="'.$person['fk_type_of_person'].'"');
    $type_of_person = $fk_type_of_person->fetch();

    $founders_countries= $db ->query('SELECT GROUP_CONCAT(founders_country) AS country FROM startup INNER JOIN startup_founders_country ON startup.id_startup = startup_founders_country.fk_startup INNER JOIN founders_country ON founders_country.id_founders_country = startup_founders_country.fk_founders_country GROUP BY company');
    $founders_country = $founders_countries->fetch();

    $impacts_sdg= $db ->query('SELECT GROUP_CONCAT(impact_sdg) AS impact FROM startup INNER JOIN startup_impact_sdg ON startup.id_startup = startup_impact_sdg.fk_startup INNER JOIN impact_sdg ON impact_sdg.id_impact_sdg = startup_impact_sdg.fk_impact_sdg GROUP BY company');
    $impact_sdg = $impacts_sdg->fetch();

    $faculties_schools= $db ->query('SELECT GROUP_CONCAT(faculty_schools) AS schools FROM startup INNER JOIN startup_faculty_schools ON startup.id_startup = startup_faculty_schools.fk_startup INNER JOIN faculty_schools ON faculty_schools.id_faculty_schools = startup_faculty_schools.fk_faculty_schools GROUP BY company');
    $faculty_schools = $faculties_schools->fetch();


    //Mettre le contenu de la base de données dans un array pour ensuite le mettre dans le fichier de téléchargement
    $text = array($row['company'], $row['founding_date'], $row['web'], $row['rc'], $row['exit_year'], $row['epfl_grant'], $row['awards_competitions'], $row['key_words'], $row['laboratory'], $row['short_description'],$person['name'],$person['firstname'], $person['person_function'], $person['email'], $person['prof_as_founder'],$type_of_person['type_of_person'],$type_startup['type_startup'],  $ceo_education_level['ceo_education_level'],  $sectors['sectors'],  $funding['amount'], $funding['investment_date'], $funding['investors'], $stage_of_investment['stage_of_investment'],$type_of_investment['type_of_investment'],$category['category'], $status['status'], $founders_country['country'], $faculty_schools['schools'], $impact_sdg['impact']);
    $text_replace = str_replace('"', '', $text);
    
    try 
    {
        fputcsv($file,$text_replace,",");
    }
    catch  (Exception $e) 
    {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }
}


//Dire que le fichier est un csv et mettre les accents de français
header('Content-type: text/csv; charset=UTF-8');

//Donner le nom au fichier
header("Content-Disposition: attachment; filename=".$filename);

//Mettre le contenu du fichier dans le fichier de téléchargement
readfile($filepath);

//Fermer le fichier créé
fclose($file);

//Supprimer le fichier créé du serveur
unlink($filepath);

require 'disconnection_db.php';


?>