<?php

//Prendre le resultat de la radio sur l'importation
$radio_result = $_POST['data_imported'];

//Initialiser un message d'erreur à vide
$error_message = "";

//Initialiser le type de message pour le flash message
$type_message = "warning";

//Initialiser une variable à 1 pour dire que tout va bien avec l'importation du fichier
$uploadOk = 1;

//Mettre dans un array, tous les formats de csv accéptés
$mimes = array('application/vnd.ms-excel','text/csv');

//Si le mime du fichier est dans l'array
if(in_array($_FILES['fileToUpload']['type'],$mimes))
{
    //Donner le répertoire où le csv va être télécharger sur le serveur
    $target_dir = "csv_imported/";

    //Il regarde si la taille du fichier ne dépasse les 50 Mb
    if ($_FILES["fileToUpload"]["size"] > 50000000) 
    {                  
        
        //Flash message si le fichier dépasse les 50 Mb
        $_SESSION['flash_message'] = array();
        $_SESSION['flash_message']['message'] = "Sorry, your file have more that 50 Mb, it's too large. <br>";
        $_SESSION['flash_message']['type'] = "warning";
        header('Location: /'.$controller);
        exit;
    }
    //Si tout se passe bien
    else 
    {
        //Répertoire où va être enregistrer le fichier sur le serveur
        $uploadfile = $_SERVER['DOCUMENT_ROOT']."/".$target_dir.basename(($_FILES["fileToUpload"]["name"]));
        
        //Déplacer le fichier dans le répertoire mentionné ci-dessus
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $uploadfile)) 
        {
            //"Ouvrir" le fichier importé, en lui mettant des droits de lire seulement
            $input = fopen('csv_imported/'.basename(($_FILES["fileToUpload"]["name"])).'', 'r');
            
            //"Ouvrir" le fichier qui aura le résultat après traitement du fichier importé, en lui mettant des droits d'écriture et lecture 
            $output= fopen('csv_imported/startups_modified_good_order.csv', 'a+');

            //Initialiser la variable pour exclure l'en-tête du fichier
            $number_of_lines = 0;
            
            //Initialiser une variable pour vérifier s'il y a des erreurs au moment de l'importation
            $import_error = "false";

            //Lire le fichier importé
            while (($csv = fgetcsv($input, 10000, ",")) !== FALSE) 
            {
                //Augmenter la variable pour ne pas lire l'en-tête 
                $number_of_lines ++;

                //Test pour ne pas traiter la première ligne qui est l'en-tête
                if($number_of_lines != '1')
                {   
                    //Faire un nouveau tableau avec les données changés pour y mettre les id's des foreign keys
                    $new = array();
                
                    //Type startup
                    if($csv[13] != "")
                    {   
                        //Type of startup : Vérifier si le type de startup existe dans la base de données
                        $types_startup = $db -> query('SELECT id_type_startup, type_startup FROM type_startup WHERE type_startup = "'.$csv[13].'"');
                        $type_startup = $types_startup->fetch();
                        
                        //Si le type n'existe pas dans la base de données, il affiche un message d'erreur avec le nom de la startup
                        if($type_startup['type_startup'] == '')
                        {
                            $error_message = $error_message."The type of startup that you choose don't match with types of startup in database for the startup : ".$csv[0]."<br>"; 
                            $import_error = "true";
                        }

                        //Si le type de startup existe, il le remplace par l'id
                        else
                        {
                            $csv[13] = $type_startup['id_type_startup'];
                        }
                    }
                    //Si le type de la startup est vide, il remplace la variable par null pour la base de données
                    else
                    {
                        $csv[13] = "NULL";
                    }

                    //Ceo education level
                    if($csv[14] != "")
                    {
                        //Ceo Education Level : Vérifier si le niveau d'éducation est existant dans la base de données
                        $ceo_education_levels = $db -> query('SELECT id_ceo_education_level, ceo_education_level FROM ceo_education_level WHERE ceo_education_level = "'.$csv[14].'"');
                        $ceo_education_level = $ceo_education_levels->fetch();
                        
                        //S'il n'existe pas, il affiche un message d'erreur
                        if($ceo_education_level['ceo_education_level'] == '')
                        {
                            $error_message = $error_message."The ceo education level that you choose don't match with ceo education level in database for the startup : ".$csv[0]."<br>"; 
                            $import_error = "true";
                        }
                        //S'il existe, il prendre l'id du ceo education level choisi
                        else
                        {
                            $csv[14] = $ceo_education_level['id_ceo_education_level'];
                        }
                    }
                    //Si le ceo education level de la startup est vide, il remplace la variable par null pour la base de données
                    else
                    {
                        $csv[14] = "NULL";
                    }

                    //sectors
                    if($csv[15] != "")
                    {
                        //Sectors : Vérifier si le secteur est existant dans la base de données
                        $sectors = $db -> query('SELECT id_sectors, sectors FROM sectors WHERE sectors = "'.$csv[15].'"');
                        $sector = $sectors->fetch();
                        
                        //S'il n'existe pas, il affiche un message d'erreur
                        if($sector['sectors'] == '')
                        {
                            $error_message = $error_message."The sector that you choose don't match with sector in database for the startup : ".$csv[0]."<br>";
                            $import_error = "true";
                        }
                        //S'il existe, il prendre l'id du secteur choisi
                        else
                        {
                            $csv[15] = $sector['id_sectors'];
                        }
                    }
                    //Si le secteur de la startup est vide, il remplace la variable par null pour la base de données
                    else
                    {
                        $csv[15] = "NULL";
                    }
                    
                    //category
                    if($csv[16] != "")
                    {
                        //Category : Vérifier si la categorie est existante dans la base de données
                        $categories = $db -> query('SELECT id_category, category FROM category WHERE category = "'.$csv[16].'"');
                        $category = $categories->fetch();
                        
                        //Si elle n'existe pas, il affiche un message d'erreur
                        if($category['category'] == '')
                        {
                            $error_message = $error_message."The category that you choose don't match with category in database for the startup : ".$csv[0]."<br>"; 
                            $import_error = "true";
                        }
                        //Si elle existe, il prendre l'id de la categorie choisie
                        else
                        {
                            $csv[16] = $category['id_category'];
                        }
                    }
                    //Si la categorie de la startup est vide, il remplace la variable par null pour la base de données
                    else
                    {
                        $csv[16] = "NULL";
                    }
                    

                    //status
                    if($csv[17] != "")
                    {
                        //Status : Vérifier si le status est existant dans la base de données
                        $status = $db -> query('SELECT id_status, status FROM status WHERE status = "'.$csv[17].'"');
                        $statut = $status->fetch();
                        
                        //S'il n'existe pas, il affiche un message d'erreur
                        if($statut['status'] == '')
                        {
                            $error_message = $error_message."The status that you choose don't match with status in database for the startup : ".$csv[0]."<br>"; 
                            $import_error = "true";
                        }
                        //S'il existe, il prendre l'id du status choisi
                        else
                        {
                            $csv[17] = $statut['id_status'];
                        }
                    }
                    //Si le status de la startup est vide, il remplace la variable par null pour la base de données
                    else
                    {
                        $csv[17] = "NULL";
                    }

                    //founders country
                    if($csv[18] != "")
                    {
                        //Prendre les données multicritère par le séparateur ; et les séparer
                        $founders_country_explode= explode(';',$csv[18]);
                        
                        //Initialiser la variable à vide
                        $csv[18] = "";
                        
                        //Boucle pour vérifier tous les pays choisis
                        foreach($founders_country_explode as $country)
                        { 
                            //Requête pour vérifier si les pays existent dans la base de données
                            $founders_countries = $db -> query('SELECT id_founders_country, founders_country FROM founders_country WHERE founders_country = "'.$country.'"');
                            $founders_country = $founders_countries->fetch();
                            
                            //Si le pays n'existe pas, il affiche un message d'erreur avec le nom de la startup
                            if($founders_country['founders_country'] == '')
                            {
                                $error_message = $error_message."The founders country that you choose don't match with founders country in database for the startup : ".$csv[0]."<br>"; 
                                $import_error = "true";
                            }
                            //Si le pays existe, il les assemble et met de nouveau le séparateur ;
                            else
                            {
                                $csv[18] = $csv[18].$founders_country['id_founders_country'].';';
                                $id_country = rtrim($csv[18], ";");
                            }
                        }
                    }
                    //Si c'est vide, il initialise la variable à null pour les bases de données
                    else
                    {
                        $id_country = "NULL";
                    }
                    
                    //faculty schools
                    if($csv[19] != "")
                    {
                        //Prendre les données multicritère par le séparateur ; et les séparer
                        $faculty_schools_explode= explode(';',$csv[19]);
                        
                        //Initialiser la variable à vide
                        $csv[19] = "";
                        
                        //Boucle pour vérifier toutes les facultés choisies
                        foreach($faculty_schools_explode as $schools)
                        { 
                            //Requête pour vérifier si les facultés existent dans la base de données
                            $faculties_schools = $db -> query('SELECT id_faculty_schools, faculty_schools FROM faculty_schools WHERE faculty_schools = "'.$schools.'"');
                            $faculty_schools = $faculties_schools->fetch();
                            
                            //Si la faculté n'existe pas, il affiche un message d'erreur avec le nom de la startup
                            if($faculty_schools['faculty_schools'] == '')
                            {
                                $error_message = $error_message."The faculty schools that you choose don't match with faculty schools in database for the startup : ".$csv[0]."<br>";
                                $import_error = "true"; 
                            }
                            //Si la faculté existe, il les assemble et met de nouveau le séparateur ;
                            else
                            {
                                $csv[19] = $csv[19].$faculty_schools['id_faculty_schools']. ';';
                                $id_schools = rtrim($csv[19], ";");
                            }
                        }
                    }
                    //Si c'est vide, il initialise la variable à null pour les bases de données
                    else
                    {
                        $id_schools = "NULL";
                    }

                    //impact sdg
                    if($csv[20] != "")
                    {
                        //Prendre les données multicritère par le séparateur ; et les séparer
                        $impact_sdg_explode= explode(';',$csv[20]);

                        //Initialiser la variable à vide
                        $csv[20] = "";

                        //Boucle pour vérifier toutes les impactes choisis
                        foreach($impact_sdg_explode as $impact)
                        { 
                            //Requête pour vérifier si les impacts existent dans la base de données
                            $impact_sdgs = $db -> query('SELECT id_impact_sdg, impact_sdg FROM impact_sdg WHERE impact_sdg = "'.$impact.'"');
                            $impact_sdg = $impact_sdgs->fetch();
                            
                            //Si l'impact n'existe pas, il affiche un message d'erreur avec le nom de la startup
                            if($impact_sdg['impact_sdg'] == '')
                            {
                                $error_message = $error_message."The impact that you choose don't match with impact in database for the startup : ".$csv[0]."<br>";
                                $import_error = "true";
                            }
                            //Si l'impact existe, il les assemble et met de nouveau le séparateur ;
                            else
                            {
                                $csv[20] = $csv[20].$impact_sdg['id_impact_sdg']. ';';
                                $id_impact = rtrim($csv[20], ";");
                                
                            }
                        }
                    }
                    //Si c'est vide, il initialise la variable à null pour les bases de données
                    else
                    {
                        $id_impact = "NULL";
                    }
                    
                    //S'il n'y a pas de problème
                    if($import_error == "false")
                    {
                        //Mettre les données dans un array
                        $text = array($csv[0],$csv[1],$csv[2],$csv[3],$csv[4],$csv[5],$csv[6],$csv[7],$csv[8],$csv[9],$csv[10],$csv[11],$csv[12],$csv[13],$csv[14],$csv[15],$csv[16],$csv[17],$id_country,$id_schools,$id_impact);
                        
                        //Remplacer les guillements doubles par des guillements simples
                        $output_replaced = str_replace('"', '\'', $text);
                        
                        //Mettre les changements dans le fichier output
                        fputcsv($output, $output_replaced);
                    }
                    //S'il y a eu un problème, il affiche le flash message avec le message d'erreur
                    else
                    {
                        $_SESSION['flash_message'] = array();
                        $_SESSION['flash_message']['message'] = $error_message;
                        $_SESSION['flash_message']['type'] = "warning";
                        header('Location: /'.$controller);
                        exit;
                    }
                }
            }

            //
            //Ouvrir le fichier modifié pour obtenir les données et les mettre dans la base de données
            $file_output = fopen("csv_imported/startups_modified_good_order.csv","r");
            
            //Ecrire que l'utilisateur a fait un import dans la table logs de la base de données
            $before = "";
            $after = "";
            $action="Import data from CSV to database";

            add_logs($_SESSION['uniqueid'],$before,$after,$action);
            
            while (($data_import_db = fgetcsv($file_output, 10000, ",")) !== FALSE) 
            {
                $add_data = $db->query('SELECT id_startup, company FROM startup WHERE company = "'.$data_import_db[0].'"');
                $data = $add_data->fetch();
                
                //On test si la startup n'existe pas
                if($data['company'] == '')
                {
                    $import_data_to_db_startups = $db -> prepare('INSERT INTO startup(company,web,founding_date,rc,exit_year,epfl_grant,awards_competitions,key_words,laboratory, short_description, company_uid, crunchbase_uid, unit_path, fk_type, fk_ceo_education_level, fk_sectors, fk_category, fk_status) VALUES ("'.$data_import_db[0].'","'.$data_import_db[1].'","'.$data_import_db[2].'","'.$data_import_db[3].'","'.$data_import_db[4].'","'.$data_import_db[5].'","'.$data_import_db[6].'","'.$data_import_db[7].'","'.$data_import_db[8].'","'.$data_import_db[9].'","'.$data_import_db[10].'","'.$data_import_db[11].'","'.$data_import_db[12].'",'.$data_import_db[13].','.$data_import_db[14].','.$data_import_db[15].','.$data_import_db[16].','.$data_import_db[17].')');
                    $import_data_to_db_startups -> execute();

                    $last_id_startup = $db->lastInsertId();

                    if($data_import_db[18]  != 'NULL')
                    {
                        $id_founders_country_explode= explode(';',$data_import_db[18]);
                        foreach ($id_founders_country_explode as $id_founders_country)
                        {
                            $import_data_to_db_startups_founders_country = $db -> prepare('INSERT INTO startup_founders_country(fk_startup, fk_founders_country) VALUES ('.$last_id_startup.','.$id_founders_country.')');
                            $import_data_to_db_startups_founders_country -> execute();

                        }
                    }
                    if($data_import_db[19]  != 'NULL')
                    {
                        $id_faculty_schools_explode= explode(';',$data_import_db[19]);
                        foreach ($id_faculty_schools_explode as $id_faculty_schools)
                        {
                            $import_data_to_db_startups_faculty_schools = $db -> prepare('INSERT INTO startup_faculty_schools(fk_startup, fk_faculty_schools) VALUES ('.$last_id_startup.','.$id_faculty_schools.')');
                            $import_data_to_db_startups_faculty_schools -> execute();

                        }
                    }
                    
                    if($data_import_db[20] != "NULL")
                    {
                        $id_impact_sdg_explode= explode(';',$data_import_db[20]);
                        foreach ($id_impact_sdg_explode as $id_impact_sdg)
                        {
                            $import_data_to_db_startups_impact_sdg = $db -> prepare('INSERT INTO startup_impact_sdg(fk_startup, fk_impact_sdg) VALUES ('.$last_id_startup.','.$id_impact_sdg.')');
                            $import_data_to_db_startups_impact_sdg -> execute();

                        }
                    }
                }
                //Si la startup existe
                else
                {
                    //Si elle existe et l'utilisateur a choisi de réécrire les données
                    if($radio_result == "import_new_overwrite_old")
                    {

                        $update_data = $db -> prepare('UPDATE startup SET web = "'.$data_import_db[1].'", founding_date = "'.$data_import_db[2].'", rc="'.$data_import_db[3].'", exit_year="'.$data_import_db[4].'",epfl_grant="'.$data_import_db[5].'",awards_competitions="'.$data_import_db[6].'", key_words="'.$data_import_db[7].'", laboratory="'.$data_import_db[8].'", short_description="'.$data_import_db[9].'", company_uid="'.$data_import_db[10].'", crunchbase_uid="'.$data_import_db[11].'", unit_path="'.$data_import_db[12].'",fk_type='.$data_import_db[13].',fk_ceo_education_level='.$data_import_db[14].',fk_sectors='.$data_import_db[15].',fk_category='.$data_import_db[16].',fk_status='.$data_import_db[17].' WHERE id_startup='.$data['id_startup'].'');
                        $update_data -> execute();

                        //Supprimer les anciennes valeurs pour cette startup des pays
                        $delete_data_to_db_startups_founders_country = $db -> prepare('DELETE FROM startup_founders_country WHERE fk_startup='.$data['id_startup'].'');
                        $delete_data_to_db_startups_founders_country -> execute();

                        if($data_import_db[18] != 'NULL')
                        {
                            //Pour ensuite les remettre avec les nouvelles données
                            $id_founders_country_explode= explode(';',$data_import_db[18]);
                            foreach ($id_founders_country_explode as $id_founders_country)
                            {
                                
                                $insert_data_to_db_startups_founders_country = $db -> prepare('INSERT INTO startup_founders_country (fk_startup, fk_founders_country) VALUES ('.$data['id_startup'].', '.$id_founders_country.')');
                                $insert_data_to_db_startups_founders_country -> execute();

                            }
                        }
                        //Supprimer les anciennes valeurs pour cette startup des schools
                        $delete_data_to_db_startups_faculty_schools = $db -> prepare('DELETE FROM startup_faculty_schools WHERE fk_startup='.$data['id_startup'].'');
                        $delete_data_to_db_startups_faculty_schools -> execute();

                        if($data_import_db[19] != 'NULL')
                        {
                            //Pour ensuite les remettre avec les nouvelles données
                            $id_faculty_schools_explode= explode(';',$data_import_db[19]);
                            foreach ($id_faculty_schools_explode as $id_faculty_schools)
                            {
                                
                                $import_data_to_db_startups_faculty_schools = $db -> prepare('INSERT INTO startup_faculty_schools(fk_startup, fk_faculty_schools) VALUES ('.$data['id_startup'].','.$id_faculty_schools.')');
                                $import_data_to_db_startups_faculty_schools -> execute();

                            }
                        }
                        //Supprimer les anciennes valeurs pour cette startup des impacts
                        $delete_data_to_db_startups_impact_sdg = $db -> prepare('DELETE FROM startup_impact_sdg WHERE fk_startup='.$data['id_startup'].'');
                        $delete_data_to_db_startups_impact_sdg -> execute();

                        if($data_import_db[20] != 'NULL')
                        {
                            //Pour ensuite les remettre avec les nouvelles données
                            $id_impact_sdg_explode= explode(';',$data_import_db[20]);
                            foreach ($id_impact_sdg_explode as $id_impact_sdg)
                            {
                                $import_data_to_db_startups_impact_sdg = $db -> prepare('INSERT INTO startup_impact_sdg(fk_startup, fk_impact_sdg) VALUES ('.$data['id_startup'].','.$id_impact_sdg.')');
                                $import_data_to_db_startups_impact_sdg -> execute();

                            }
                        }
                    }
                    //Si l'utilisateur a choisi de ne pas réécrire les données
                    else
                    {
                        $error_message = $error_message."La startup ".$data['company'] ." existe déjà <br>";
                    } 
                }
            }
            
            if($error_message == '')
            {
                $type_message = "success";
                
                //Pop-up d'avertissement pour dire que le fichier a été importé et que les données ont été importées dans la base de donnée
                $error_message = "The file ".basename($_FILES["fileToUpload"]["name"])." has been uploaded and the data was imported in database";
            }
            
        }
        
        //Pop-up d'avertissement s'il y a eu un problème avec l'importation des données 
        else 
        {
            $error_message = "Sorry, something went wrong";
        } 
        
    } 
}
//Si le fichier n'est pas valide 
else 
{
    $error_message = "Sorry, your file is not a csv file";
}

if($type)
$_SESSION['flash_message'] = array();
$_SESSION['flash_message']['message'] = $error_message;
$_SESSION['flash_message']['type'] = $type_message;
header('Location: /'.$controller);

//"Fermer" les fichiers ouverts au-dessus
fclose($input);
fclose($output);
fclose($file_output);

//Supprimer le fichier qui a été importé par l'utilsateur et le fichier de traitement des données
unlink('csv_imported/'.basename(($_FILES["fileToUpload"]["name"])).'');
unlink('csv_imported/startups_modified_good_order.csv');
header('Location: /'.$controller);
            



?>