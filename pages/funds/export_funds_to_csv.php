<?php

//Mettre la date d'aujourd'hui dans le nom du fichier csv
$today = date("d-m-Y");

//Ouvrir un fichier pour mettre les données de la base de données
$file = fopen("./csv_imported/csv_funds_".$today.".csv", "w+");

//Nom du fichier avec la date courante
$filename = "csv_funds_".$today.".csv";

//Chemin où se trouve le fichier
$filepath = "./csv_imported/csv_funds_".$today.".csv";

//Supprimer le code HTML du fichier csv
ob_end_clean();

//Mettre l'en-tête dans le fichier csv
$header_csv = array("amount","investment_date","investors","stage_of_investment","type_of_investment","startup");
try 
{
    //Mettre l'en-tête dans le fichier csv
    fputcsv($file, $header_csv);
}
catch  (Exception $e) 
{
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}

//Condition qui permet de vérifier s'il y a un id dans l'url
if($param == "")
{
    //Prendre les fonds à partir d'une vue SQL
    $funds = $db->query("SELECT * FROM view_display_funds");
    $fund = $funds->fetchAll();
}
else
{
    //Prendre les fonds à partir d'une vue SQL
    $funds = $db->query("SELECT * FROM view_display_funds WHERE fk_startup='".$param."'");
    $fund = $funds->fetchAll();
}

foreach ($fund as $row)
{
    //Changement du format de date. YYYY-mm-dd vers dd-mm-YYYY
    $date_display = date("d-m-Y", strtotime($row['investment_date']));

    //Prendre les données de la view et les mettre dans un array
    $text = array($row['amount'], $date_display, $row['investors'], $row['stage_of_investment'], $row['type_of_investment'], $row['company']);

    //Remplacer les guillements doubles par des guillements simples dans le contenu de la base de données
    $text_replace = str_replace('"', '', $text);
    
    try 
    {
        //Mettre les données dans le fichier et la , est le séparateur de colonnes
        fputcsv($file,$text_replace,",");
        fgetss($file);
    }
    catch  (Exception $e) 
    {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }
}
 
//Condition qui permet de vérifier s'il y a un id dans l'url
if($param == "")
{
    //Ecrire les données dans la table logs
    $action="Export funds data to CSV file";
}
else
{
    //Ecrire les données dans la table logs pour la startup
    $action="Export funds data to CSV file of startup : ".$row['company'];
}

add_logs($_SESSION['uniqueid'],"","",$action);

//Dire que le fichier est un csv
header('Content-type: text/csv; charset=UTF-8');

//Donner le nom au fichier avec la date du jour et le mettre comme un fichier à télécharger
header("Content-Disposition: attachment; filename=".$filename);

//Mettre le contenu du fichier dans le fichier de téléchargement
readfile($filepath);

//Fermer le fichier créé
fclose($file);

//Supprimer le fichier créé du serveur
unlink($filepath);



?>