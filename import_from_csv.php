<?php


//Si l'utilisateur est connecté
if(isset($_SESSION['user']))
{
    //Si l'utilisateur a le droit d'écrire
    if($_SESSION['TequilaPHPWrite'] == "TequilaPHPWritetrue")
    {
        echo '
        <div class="container my-5">
            <h5 class="font-weight-bold my-5 pl-0"> Import from CSV to database </h5>
            <form method="post" id="form_csv_upload" class="form_csv_upload col-12 col-sm-12 col-lg-8 col-xl-8 my-5" enctype="multipart/form-data" action="'; echo security_text($_SERVER["PHP_SELF"]); echo'">
                <div>
                    <!-- input type="file" permet d\'aller chercher sur le disque de l\'utilisateur, le csv qu\'il veut ajouter-->
                    <input type="file" class="form-control-file border" name="fileToUpload" id="fileToUpload">  
                </div>
                <div class="form-check mt-5">
                    <input class="form-check-input" type="radio" value="import_new_overwrite_old" name="data_imported" id="identical_data">
                    <label class="form-check-label" for="identical_data">
                        Import new data and overwrite old data
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="only_new_keep_old" name="data_imported" id="only_different_data" checked>
                    <label class="form-check-label" for="only_different_data">
                        Import only new data and keep old data as is
                    </label>
                </div>
                <div>
                    <button class="btn btn-outline-secondary my-5" id="import" name="import" type="submit">Import</button>
                </div>
            </form>
            <div id="echo_result"></div>
        </div>';

        //Si le bouton import a été cliqué
        if(isset($_POST["import"])) 
        {

            $radio_result = $_POST['data_imported'];
            
            //Initialiser une variable à 1 pour dire que tout va bien avec l'importation du fichier
            $uploadOk = 1;

            //Mettre dans une array, tous les formats de csv accéptés
            $mimes = array('application/vnd.ms-excel','text/csv');

            //Si le mime du fichier est dans l'array
            if(in_array($_FILES['fileToUpload']['type'],$mimes))
            {
                //Donner le répertoire où le csv va être télécharger
                $target_dir = "csv_imported/";

                //Il regarde si la taille du fichier ne dépasse les 500 Mb
                if ($_FILES["fileToUpload"]["size"] > 500000000) 
                {
                    echo "
                    <script>
                        alert('Sorry, your file have more that 500 Mb, it\'s too large.');
                    </script>
                    ";
                
                    $uploadOk = 0;
                }

                //Si une de ces conditions est vraie, alors il n'importe pas le fichier
                if ($uploadOk == 0) 
                {
                    echo "
                    <script>
                        alert('Sorry, the file was not upload.');
                    </script>
                    ";
                }

                //Si tout se passe bien
                else 
                {
                    //Répertoire où va être enregistrer le fichier
                    $uploadfile = $_SERVER['DOCUMENT_ROOT']."/".$target_dir.basename(($_FILES["fileToUpload"]["name"]));
                    
                    //Enregistrer le fichier dans le répertoire
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $uploadfile)) 
                    {
                        //"Ouvrir" le fichier importé, en lui mettant des droits de lire seulement
                        $input = fopen('csv_imported/'.basename(($_FILES["fileToUpload"]["name"])).'', 'r');
                        
                        //"Ouvrir" le fichier qui aura le résultat après traitement du fichier importé, en lui mettant des droits d'écriture seulement 
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
                                if($csv[10] != "")
                                {   
                                    //Type of startup : Vérifier si le type de startup existe dans la base de données
                                    $types_startup = $db -> query('SELECT id_type_startup, type_startup FROM type_startup WHERE type_startup = "'.$csv[10].'"');
                                    $type_startup = $types_startup->fetch();
                                    

                                    if($type_startup['type_startup'] == '')
                                    {
                                    
                                        echo "The type of startup that you choose don't match with types of startup in database for the startup : ".$csv[0]."<br>";
                                        $import_error = "true";
                                    }

                                    //Si le type de startup existe, il le remplace par l'id
                                    else
                                    {
                                        $csv[10] = $type_startup['id_type_startup'];
                                    }
                                }
                                else
                                {
                                    $csv[10] = "NULL";
                                }

                                //Ceo education level
                                if($csv[11] != "")
                                {
                                    
                                    $ceo_education_levels = $db -> query('SELECT id_ceo_education_level, ceo_education_level FROM ceo_education_level WHERE ceo_education_level = "'.$csv[11].'"');
                                    $ceo_education_level = $ceo_education_levels->fetch();
                                    
                                    if($ceo_education_level['ceo_education_level'] == '')
                                    {
                                        echo "The ceo education level that you choose don't match with ceo education level in database for the startup : ".$csv[0]."<br>"; 
                                        $import_error = "true";
                                    }
                                    else
                                    {
                                        $csv[11] = $ceo_education_level['id_ceo_education_level'];
                                    }
                                }
                                else
                                {
                                    $csv[11] = "NULL";
                                }

                                //sectors
                                if($csv[12] != "")
                                {
                                   
                                    $sectors = $db -> query('SELECT id_sectors, sectors FROM sectors WHERE sectors = "'.$csv[12].'"');
                                    $sector = $sectors->fetch();
                                    
                                    if($sector['sectors'] == '')
                                    {
                                        echo "The sector that you choose don't match with sector in database for the startup : ".$csv[0]."<br>"; 
                                        $import_error = "true";
                                    }
                                    else
                                    {
                                        $csv[12] = $sector['id_sectors'];
                                    }
                                }
                                else
                                {
                                    $csv[12] = "NULL";
                                }
                                
                                //category
                                if($csv[13] != "")
                                {
                                    $categories = $db -> query('SELECT id_category, category FROM category WHERE category = "'.$csv[13].'"');
                                    $category = $categories->fetch();
                                    
                                    if($category['category'] == '')
                                    {
                                        echo "The category that you choose don't match with category in database for the startup : ".$csv[0]."<br>";
                                        $import_error = "true";
                                    }
                                    else
                                    {
                                        $csv[13] = $category['id_category'];
                                    }
                                }
                                else
                                {
                                    $csv[13] = "NULL";
                                }
                                

                                //status
                                if($csv[14] != "")
                                {
                                    $status = $db -> query('SELECT id_status, status FROM status WHERE status = "'.$csv[14].'"');
                                    $statut = $status->fetch();
                                    
                                    if($statut['status'] == '')
                                    {
                                        echo "The status that you choose don't match with status in database for the startup : ".$csv[0]."<br>";
                                        $import_error = "true";
                                    }
                                    else
                                    {
                                        $csv[14] = $statut['id_status'];
                                    }
                                }
                                else
                                {
                                    $csv[14] = "NULL";
                                }

                                //founders country
                                if($csv[15] != "")
                                {
                                    $founders_country_explode= explode(';',$csv[15]);
                                    $csv[15] = "";
                                    foreach($founders_country_explode as $country)
                                    { 
                                    
                                        $founders_countries = $db -> query('SELECT id_founders_country, founders_country FROM founders_country WHERE founders_country = "'.$country.'"');
                                        $founders_country = $founders_countries->fetch();
                                        
                                        if($founders_country['founders_country'] == '')
                                        {
                                            echo "The founders country that you choose don't match with founders country in database for the startup : ".$csv[0]."<br>"; 
                                            $import_error = "true";
                                        }
                                        else
                                        {
                                            $csv[15] = $csv[15].$founders_country['id_founders_country'].';';
                                            $id_country = rtrim($csv[15], ";");
                                        }
                                    }
                                }
                                else
                                {
                                    $id_country = "NULL";
                                }
                                
                                //faculty schools
                                if($csv[16] != "")
                                {
                                    $faculty_schools_explode= explode(';',$csv[16]);
                                    $csv[16] = "";
                                    foreach($faculty_schools_explode as $schools)
                                    { 

                                        $faculties_schools = $db -> query('SELECT id_faculty_schools, faculty_schools FROM faculty_schools WHERE faculty_schools = "'.$schools.'"');
                                        $faculty_schools = $faculties_schools->fetch();
                                        
                                        if($faculty_schools['faculty_schools'] == '')
                                        {
                                            echo "The faculty schools that you choose don't match with faculty schools in database for the startup : ".$csv[0]."<br>";
                                            $import_error = "true"; 
                                        }
                                        else
                                        {
                                            $csv[16] = $csv[16].$faculty_schools['id_faculty_schools']. ';';
                                            $id_schools = rtrim($csv[16], ";");
                                        }
                                    }
                                }
                                else
                                {
                                    $id_schools = "NULL";
                                }

                                //impact sdg
                                if($csv[17] != "")
                                {
                                    $impact_sdg_explode= explode(';',$csv[17]);
                                    $csv[17] = "";
                                    foreach($impact_sdg_explode as $impact)
                                    { 
                                        $impact_sdgs = $db -> query('SELECT id_impact_sdg, impact_sdg FROM impact_sdg WHERE impact_sdg = "'.$impact.'"');
                                        $impact_sdg = $impact_sdgs->fetch();
                                        
                                        if($impact_sdg['impact_sdg'] == '')
                                        {
                                            echo "The impact that you choose don't match with impact in database for the startup : ".$csv[0]."<br>";
                                            $import_error = "true";
                                        }
                                        else
                                        {
                                            $csv[17] = $csv[17].$impact_sdg['id_impact_sdg']. ';';
                                            $id_impact = rtrim($csv[17], ";");
                                            
                                        }
                                    }
                                }
                                else
                                {
                                    $id_impact = "NULL";
                                }
                                
                                if($import_error == "false")
                                {
                                    $text = array($csv[0],$csv[1],$csv[2],$csv[3],$csv[4],$csv[5],$csv[6],$csv[7],$csv[8],$csv[9],$csv[10],$csv[11],$csv[12],$csv[13],$csv[14],$id_country,$id_schools,$id_impact);
                                    $output_replaced = str_replace('"', '\'', $text);
                                    
                                    //Mettre les changements dans le fichier output
                                    fputcsv($output, $output_replaced);
                                }
                                else
                                {
                                    exit;
                                }
                            }
                       }

                        //Ouvrir le fichier modifié pour obtenir les données et les mettre dans la base de données
                        $file_output = fopen("csv_imported/startups_modified_good_order.csv","r");
                        
                        //Ecrire que l'utilisateur a fait un import dans la table logs de la base de données
                        $before = "";
                        $after = "";
                        $action="Import data from CSV to database";

                        add_logs($sciper_number,$before,$after,$action);
                        
                        while (($data_import_db = fgetcsv($file_output, 10000, ",")) !== FALSE) 
                        {
                            $add_data = $db->query('SELECT id_startup, company FROM startup WHERE company = "'.$data_import_db[0].'"');
                            $data = $add_data->fetch();
                           
                            //On test si la startup n'existe pas
                            if($data['company'] == '')
                            {
                                $import_data_to_db_startups = $db -> prepare('INSERT INTO startup(company,web,founding_date,rc,exit_year,epfl_grant,awards_competitions,key_words,laboratory, short_description, fk_type, fk_ceo_education_level, fk_sectors, fk_category, fk_status) VALUES ("'.$data_import_db[0].'","'.$data_import_db[1].'","'.$data_import_db[2].'","'.$data_import_db[3].'","'.$data_import_db[4].'","'.$data_import_db[5].'","'.$data_import_db[6].'","'.$data_import_db[7].'","'.$data_import_db[8].'","'.$data_import_db[9].'",'.$data_import_db[10].','.$data_import_db[11].','.$data_import_db[12].','.$data_import_db[13].','.$data_import_db[14].')');
                                $import_data_to_db_startups -> execute();

                                $last_id_startup = $db->lastInsertId();

                                if($data_import_db[15]  != 'NULL')
                                {
                                    $id_founders_country_explode= explode(';',$data_import_db[15]);
                                    foreach ($id_founders_country_explode as $id_founders_country)
                                    {
                                        $import_data_to_db_startups_founders_country = $db -> prepare('INSERT INTO startup_founders_country(fk_startup, fk_founders_country) VALUES ('.$last_id_startup.','.$id_founders_country.')');
                                        $import_data_to_db_startups_founders_country -> execute();

                                    }
                                }
                                if($data_import_db[16]  != 'NULL')
                                {
                                    $id_faculty_schools_explode= explode(';',$data_import_db[16]);
                                    foreach ($id_faculty_schools_explode as $id_faculty_schools)
                                    {
                                        $import_data_to_db_startups_faculty_schools = $db -> prepare('INSERT INTO startup_faculty_schools(fk_startup, fk_faculty_schools) VALUES ('.$last_id_startup.','.$id_faculty_schools.')');
                                        $import_data_to_db_startups_faculty_schools -> execute();

                                    }
                                }
                                
                                if($data_import_db[17] != "NULL")
                                {
                                    $id_impact_sdg_explode= explode(';',$data_import_db[17]);
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

                                    $update_data = $db -> prepare('UPDATE startup SET web = "'.$data_import_db[1].'", founding_date = "'.$data_import_db[2].'", rc="'.$data_import_db[3].'", exit_year="'.$data_import_db[4].'",epfl_grant="'.$data_import_db[5].'",awards_competitions="'.$data_import_db[6].'", key_words="'.$data_import_db[7].'", laboratory="'.$data_import_db[8].'", short_description="'.$data_import_db[9].'", fk_type='.$data_import_db[10].',fk_ceo_education_level='.$data_import_db[11].',fk_sectors='.$data_import_db[12].',fk_category='.$data_import_db[13].',fk_status='.$data_import_db[14].' WHERE id_startup='.$data['id_startup'].'');
                                    $update_data -> execute();

                                    //Supprimer les anciennes valeurs pour cette startup des pays
                                    $delete_data_to_db_startups_founders_country = $db -> prepare('DELETE FROM startup_founders_country WHERE fk_startup='.$data['id_startup'].'');
                                    $delete_data_to_db_startups_founders_country -> execute();

                                    if($data_import_db[15] != 'NULL')
                                    {
                                        //Pour ensuite les remettre avec les nouvelles données
                                        $id_founders_country_explode= explode(';',$data_import_db[15]);
                                        foreach ($id_founders_country_explode as $id_founders_country)
                                        {
                                            
                                            $insert_data_to_db_startups_founders_country = $db -> prepare('INSERT INTO startup_founders_country (fk_startup, fk_founders_country) VALUES ('.$data['id_startup'].', '.$id_founders_country.')');
                                            $insert_data_to_db_startups_founders_country -> execute();

                                        }
                                    }
                                    //Supprimer les anciennes valeurs pour cette startup des schools
                                    $delete_data_to_db_startups_faculty_schools = $db -> prepare('DELETE FROM startup_faculty_schools WHERE fk_startup='.$data['id_startup'].'');
                                    $delete_data_to_db_startups_faculty_schools -> execute();

                                    if($data_import_db[16] != 'NULL')
                                    {
                                        //Pour ensuite les remettre avec les nouvelles données
                                        $id_faculty_schools_explode= explode(';',$data_import_db[16]);
                                        foreach ($id_faculty_schools_explode as $id_faculty_schools)
                                        {
                                            
                                            $import_data_to_db_startups_faculty_schools = $db -> prepare('INSERT INTO startup_faculty_schools(fk_startup, fk_faculty_schools) VALUES ('.$data['id_startup'].','.$id_faculty_schools.')');
                                            $import_data_to_db_startups_faculty_schools -> execute();

                                        }
                                    }
                                    //Supprimer les anciennes valeurs pour cette startup des impacts
                                    $delete_data_to_db_startups_impact_sdg = $db -> prepare('DELETE FROM startup_impact_sdg WHERE fk_startup='.$data['id_startup'].'');
                                    $delete_data_to_db_startups_impact_sdg -> execute();

                                    if($data_import_db[17] != 'NULL')
                                    {
                                        //Pour ensuite les remettre avec les nouvelles données
                                        $id_impact_sdg_explode= explode(';',$data_import_db[17]);
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
                                    echo "La startup ".$data['company'] ." existe déjà <br>";
                                } 
                            }
                        }
                    

                       //Pop-up d'avertissement pour dire que le fichier a été importé et que les données ont été importées dans la base de donnée
                        echo " 
                        <script>
                        var filename = '".basename($_FILES["fileToUpload"]["name"])."';
                            alert('The file '+filename+' has been uploaded and the data was imported in database.');
                        </script>
                        ";

                        //echo 'The file '.$data_import_db[0].' has been uploaded and the data was imported in database.';
                         //"Fermer" les fichiers ouverts au-dessus
                         fclose($input);
                         fclose($output);
                         fclose($file_output);

                         //Supprimer le fichier qui a été importé par l'utilsateur et le fichier de traitement des données
                         unlink('csv_imported/'.basename(($_FILES["fileToUpload"]["name"])).'');
                         unlink('csv_imported/startups_modified_good_order.csv');

                    }
                    
                    //Pop-up d'avertissement s'il y a eu un problème avec l'importation des données 
                    else 
                    {
                        echo "  
                        <script>
                            alert('Sorry, there was an error uploading your file.');
                        </script>
                        ";
                    } 
                    
                } 
            }
            //Si le fichier n'est pas valide 
            else 
            {
                echo "
                <script>
                    alert('Sorry, your file is not valid.');
                </script>
                ";
            }
        }

        require 'tools/disconnection_db.php';
        require 'footer.php';
    }

    //Si l'utilisateur n'a pas le droit d'écrire, un pop-up d'avertissement sera affiché et il sera redirigé vers la page d'accueil
    elseif($_SESSION['TequilaPHPRead'] == "TequilaPHPReadtrue")
    {
        echo "
        <script>
            alert('You don't have enough rights to access this page.');
            window.location.replace('index.php');
        </script>
        ";
    }
}
else
{
    echo "
    <script>
        window.location.replace('login.php');
    </script>
    ";
}

?>
