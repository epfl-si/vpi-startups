<?php

require 'connection_db.php';

//Mettre la date d'aujourd'hui dans le nom du fichier csv
$today = date("d-m-Y");

//Ouvrir un fichier pour mettre les données de la base de données
$file = fopen("../csv_imported/csv_".$today.".csv", "w+");

//Donner le nom du fichier avec la date courante et le nom du chemin où se trouve le fichier
$filename = "csv_".$today.".csv";
$filepath = "../csv_imported/csv_".$today.".csv";

//Supprimer le code HTML du fichier csv
ob_end_clean();

//Mettre l'en-tête dans le fichier csv
$header_csv = array("company","founding_date","web","rc","exit_year","epfl_grant","awards_competitions","key_words","laboratory","short_description", "type_startup","ceo_education_level","sectors","category", "status","founders_country", "faculty_schools", "impact_sdg");
try 
{
    fputcsv($file, $header_csv);
}
catch  (Exception $e) 
{
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}

//Prendre les données de startup de la base de données à partir d'une vue SQL
$startups = $db->query("SELECT * FROM view_detail_startup_full");
$startup = $startups->fetchAll();
foreach ($startup as $row)
{
    //Mettre le contenu de la base de données dans un array pour ensuite le mettre dans le fichier de téléchargement
    $text = array($row['company'], $row['founding_date'], $row['web'], $row['rc'], $row['exit_year'], $row['epfl_grant'], $row['awards_competitions'], $row['key_words'], $row['laboratory'], $row['short_description'],$row['type_startup'],  $row['ceo_education_level'],  $row['sectors'],$row['category'], $row['status'], $row['country'], $row['schools'], $row['impact']);
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