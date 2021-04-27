<?php

require 'header.php';
require 'tools/connection_db.php';

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
                    <input class="form-check-input" type="radio" value="all" name="data_imported" id="identical_data" checked>
                    <label class="form-check-label" for="identical_data">
                        Identical data
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="different" name="data_imported" id="only_different_data">
                    <label class="form-check-label" for="only_different_data">
                        Only different data
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

                        //Lire le fichier importé
                        while(($data = fgetcsv($input, 10000, ",")) !== FALSE)
                        {
                            //Changer l'ordre du fichier importé, en mettant les foreign keys à la fin (dans la base de données, les fks sont à la fin)
                            $order = array(0,1,2,3,4,5,6,7,8,9,10,11,12,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29);
                            
                            //Lire le fichier importé
                            while (($csv = fgetcsv($input, 10000, ",")) !== FALSE) 
                            {
                                //Faire un nouveau tableau avec les données changés pour y mettre les id's des foreign keys
                                $new = array();
                                
                                    //Mettre le résultat du fichier importé dans le nouveau tableau avec les changements de place
                                    $new[] = $csv[$index];                                    
                                    
                                    //Type of person
                                    $types_of_person = $db -> query('SELECT id_type_of_person, type_of_person FROM type_of_person WHERE type_of_person = "'.$csv[16].'"');
                                    $type_of_person = $types_of_person->fetch();
                                    
                                    if($type_of_person['type_of_person'] == '')
                                    {
                                        echo '
                                        <script> 
                                            alert("The type of person that you choose don\'t match with types of person in database"); 
                                        </script>';
                                        exit;
                                    }
                                    else
                                    {
                                        $csv[16] = $type_of_person['id_type_of_person'];
                                    }

                                    //Type of startup
                                    $types_startup = $db -> query('SELECT id_type_startup, type_startup FROM type_startup WHERE type_startup = "'.$csv[17].'"');
                                    $type_startup = $types_startup->fetch();
                                    
                                    if($type_startup['type_startup'] == '')
                                    {
                                        echo '
                                        <script> 
                                            alert("The type of startup that you choose don\'t match with types of startup in database"); 
                                        </script>';
                                        exit;
                                    }
                                    else
                                    {
                                        $csv[17] = $type_startup['id_type_startup'];
                                    }
                                    
                                    //Ceo education level
                                    $ceo_education_levels = $db -> query('SELECT id_ceo_education_level, ceo_education_level FROM ceo_education_level WHERE ceo_education_level = "'.$csv[18].'"');
                                    $ceo_education_level = $ceo_education_levels->fetch();
                                    
                                    if($ceo_education_level['ceo_education_level'] == '')
                                    {
                                        echo '
                                        <script> 
                                            alert("The ceo education level that you choose don\'t match with ceo education level in database"); 
                                        </script>';
                                        exit;
                                    }
                                    else
                                    {
                                        $csv[18] = $ceo_education_level['id_ceo_education_level'];
                                    }
                                    
                                    //sectors
                                    $sectors = $db -> query('SELECT id_sectors, sectors FROM sectors WHERE sectors = "'.$csv[19].'"');
                                    $sector = $sectors->fetch();
                                    
                                    if($sector['sectors'] == '')
                                    {
                                        echo '
                                        <script> 
                                            alert("The sector that you choose don\'t match with sector in database"); 
                                        </script>';
                                    }
                                    else
                                    {
                                        $csv[19] = $sector['id_sectors'];
                                    }
                                   
                                    //stage of investment
                                    $stage_of_investments = $db -> query('SELECT id_stage_of_investment, stage_of_investment FROM stage_of_investment WHERE stage_of_investment = "'.$csv[23].'"');
                                    $stage_of_investment = $stage_of_investments->fetch();

                                    if($stage_of_investment['stage_of_investment'] == '')
                                    {
                                        echo '
                                        <script> 
                                            alert("The stage of investment that you choose don\'t match with stage of investment in database"); 
                                        </script>';
                                        exit;
                                    }
                                    else
                                    {
                                        $csv[23] = $stage_of_investment['id_stage_of_investment'];
                                    } 
                                    
                                    //type of investment
                                    $type_of_investments = $db -> query('SELECT id_type_of_investment, type_of_investment FROM type_of_investment WHERE type_of_investment = "'.$csv[24].'"');
                                    $type_of_investment = $type_of_investments->fetch();
                                    
                                    if($type_of_investment['type_of_investment'] == '')
                                    {
                                        echo '
                                        <script> 
                                            alert("The type of investment that you choose don\'t match with type of investment in database"); 
                                        </script>';
                                        exit;
                                    }
                                    else
                                    {
                                        $csv[24] = $type_of_investment['id_type_of_investment'];
                                    }

                                    //category
                                    $categories = $db -> query('SELECT id_category, category FROM category WHERE category = "'.$csv[25].'"');
                                    $category = $categories->fetch();
                                    
                                    if($category['category'] == '')
                                    {
                                        echo '
                                        <script> 
                                            alert("The category that you choose don\'t match with category in database"); 
                                        </script>';
                                        exit;
                                    }
                                    else
                                    {
                                        $csv[25] = $category['id_category'];
                                    }

                                    //status
                                    $status = $db -> query('SELECT id_status, status FROM status WHERE status = "'.$csv[26].'"');
                                    $statut = $status->fetch();
                                    
                                    if($statut['status'] == '')
                                    {
                                        echo '
                                        <script> 
                                            alert("The status that you choose don\'t match with status in database"); 
                                        </script>';
                                        exit;
                                    }
                                    else
                                    {
                                        $csv[26] = $statut['id_status'];
                                    }

                                    //founders country
                                    $founders_country_explode= explode(';',$csv[27]);

                                    foreach($founders_country_explode as $country)
                                    { 
                                       
                                        $founders_countries = $db -> query('SELECT id_founders_country, founders_country FROM founders_country WHERE founders_country = "'.$country.'"');
                                        $founders_country = $founders_countries->fetch();
                                        
                                        if($founders_country['founders_country'] == '')
                                        {
                                            echo '
                                            <script> 
                                                alert("The founders country that you choose don\'t match with founders country in database"); 
                                            </script>';
                                            exit;
                                        }
                                        else
                                        {
                                            $csv[27] = $founders_country['id_founders_country'];

                                            $import_data_to_db_startups_founders_country = $db -> prepare('INSERT INTO startup_founders_country(fk_startup, fk_founders_country) VALUES (NULL,"'.$csv[27].'")');
                                            $import_data_to_db_startups_founders_country -> execute();
                                        }
                                    }
                                    
                                    //faculty schools
                                    $faculty_schools_explode= explode(';',$csv[28]);

                                    foreach($faculty_schools_explode as $schools)
                                    { 

                                        $faculties_schools = $db -> query('SELECT id_faculty_schools, faculty_schools FROM faculty_schools WHERE faculty_schools = "'.$schools.'"');
                                        $faculty_schools = $faculties_schools->fetch();
                                        
                                        if($faculty_schools['faculty_schools'] == '')
                                        {
                                            echo '
                                            <script> 
                                                alert("The faculty schools that you choose don\'t match with faculty schools in database"); 
                                            </script>';
                                            exit;
                                        }
                                        else
                                        {
                                            $csv[28] = $faculty_schools['id_faculty_schools'];

                                            $import_data_to_db_startups_faculty_schools = $db -> prepare('INSERT INTO startup_faculty_schools(fk_startup, fk_faculty_schools) VALUES (NULL,"'.$csv[28].'")');
                                            $import_data_to_db_startups_faculty_schools -> execute();
                                        }
                                    }

                                    //impact sdg
                                    $impact_sdg_explode= explode(';',$csv[29]);

                                    foreach($impact_sdg_explode as $impact)
                                    { 

                                        $impact_sdgs = $db -> query('SELECT id_impact_sdg, impact_sdg FROM impact_sdg WHERE impact_sdg = "'.$impact.'"');
                                        $impact_sdg = $impact_sdgs->fetch();
                                        
                                        if($impact_sdg['impact_sdg'] == '')
                                        {
                                            echo '
                                            <script> 
                                                alert("The impact that you choose don\'t match with impact in database"); 
                                            </script>';
                                            exit;
                                        }
                                        else
                                        {
                                            $csv[29] = $impact_sdg['id_impact_sdg'];

                                            $import_data_to_db_startups_impact_sdg = $db -> prepare('INSERT INTO startup_impact_sdg(fk_startup, fk_impact_sdg) VALUES (NULL,"'.$csv[29].'")');
                                            $import_data_to_db_startups_impact_sdg -> execute();
                                        }
                                    }
                                    $text = array($csv[0],$csv[1],$csv[2],$csv[3],$csv[4],$csv[5],$csv[6],$csv[7],$csv[8],$csv[9],$csv[10],$csv[11],$csv[12],$csv[13],$csv[14],$csv[15],$csv[16],$csv[17],$csv[18],$csv[19],$csv[20],$csv[21],$csv[22],$csv[23],$csv[24],$csv[25],$csv[26],$csv[27],$csv[28],$csv[29]);
                                    $output_replaced = str_replace('"', '\'', $text);
                                    
                                

                                 //Mettre les changements dans le fichier output
                                fputcsv($output, $output_replaced);
                                
                                if($radio_result == "different")
                                {
                                    //Chercher les startups qui sont déjà dans la base de données
                                    $set_only_non_existants = $db->query('SELECT company FROM startup WHERE company = "'.$csv[0].'"');
                                    $set_only_non_existant = $set_only_non_existants->fetchAll();
                                    foreach($set_only_non_existant as $only_non_existant)
                                    {
                                        //Supprimer du fichier créé ci-dessous les startups qui sont déjà dans la base de données
                                        $rows = file("csv_imported/startups_modified_good_order.csv");

                                        $blacklist = $only_non_existant['company'];

                                        foreach($rows as $key => $row) 
                                        {
                                            if(preg_match("/($blacklist)/", $row)) 
                                            {
                                                unset($rows[$key]); 
                                            }
                                        }
                                        file_put_contents("csv_imported/startups_modified_good_order.csv", $rows);  
                                    }
                                }
                            }
                        }

                        //Ouvrir le fichier modifié pour obtenir les données et les mettre dans la base de données
                        $file_output = fopen("csv_imported/startups_modified_good_order.csv","r");

                        while (($data_import_db = fgetcsv($file_output, 20000, ",")) !== FALSE) 
                        { 
                            //Ecrire dans la base de données, les données du fichier
                            $import_data_to_db_person = $db -> prepare('INSERT INTO person(name,firstname,person_function,email,prof_as_founder,gender,fk_type_of_person) VALUES ("'.$data_import_db[10].'","'.$data_import_db[11].'","'.$data_import_db[12].'","'.$data_import_db[13].'","'.$data_import_db[14].'","'.$data_import_db[15].'","'.$data_import_db[16].'")');
                            $import_data_to_db_person -> execute();

                            $last_id_person = $db->lastInsertId();

                            $import_data_to_db_funding = $db -> prepare('INSERT INTO funding(amount,investment_date,investors,fk_stage_of_investment,fk_type_of_investment) VALUES ("'.$data_import_db[20].'","'.$data_import_db[21].'","'.$data_import_db[22].'","'.$data_import_db[23].'","'.$data_import_db[24].'")');
                            $import_data_to_db_funding -> execute();

                            $last_id_funding = $db->lastInsertId();
                            
                            $import_data_to_db_startups = $db -> prepare('INSERT INTO startup(company,web,founding_date,rc,exit_year,epfl_grant,awards_competitions,key_words,laboratory, short_description, fk_type, fk_ceo_education_level, fk_sectors, fk_funding, fk_category, fk_status) VALUES ("'.$data_import_db[0].'","'.$data_import_db[1].'","'.$data_import_db[2].'","'.$data_import_db[3].'","'.$data_import_db[4].'","'.$data_import_db[5].'","'.$data_import_db[6].'","'.$data_import_db[7].'","'.$data_import_db[8].'","'.$data_import_db[9].'","'.$data_import_db[17].'","'.$data_import_db[18].'","'.$data_import_db[19].'","'.$last_id_funding.'","'.$data_import_db[25].'","'.$data_import_db[26].'")');
                            $import_data_to_db_startups -> execute();

                            $last_id_startup = $db->lastInsertId();

                            $ids_startups_faculty_schools = $db -> query('SELECT id_startup_faculty_schools FROM startup_faculty_schools WHERE fk_startup IS NULL');
                            $id_startups_faculty_schools = $ids_startups_faculty_schools ->fetch();

                            $import_data_to_db_startups_faculty_schools = $db -> prepare('UPDATE startup_faculty_schools SET fk_startup="'.$last_id_startup.'" WHERE id_startup_faculty_schools="'.$id_startups_faculty_schools['id_startup_faculty_schools'].'"');
                            $import_data_to_db_startups_faculty_schools -> execute();

                            $ids_startups_founders_country = $db -> query('SELECT id_startup_founders_country FROM startup_founders_country WHERE fk_startup IS NULL');
                            $id_startups_founders_country = $ids_startups_founders_country-> fetch();

                            $import_data_to_db_startups_founders_country = $db -> prepare('UPDATE startup_founders_country SET fk_startup="'.$last_id_startup.'" WHERE id_startup_founders_country="'.$id_startups_founders_country['id_startup_founders_country'].'"');
                            $import_data_to_db_startups_founders_country -> execute();

                            $ids_startups_impact_sdg = $db -> query('SELECT id_startup_impact_sdg FROM startup_impact_sdg WHERE fk_startup IS NULL');
                            $id_startups_impact_sdg = $ids_startups_impact_sdg -> fetch();

                            $import_data_to_db_startups_impact_sdg = $db -> prepare('UPDATE startup_impact_sdg SET fk_startup="'.$last_id_startup.'" WHERE id_startup_impact_sdg="'.$id_startups_impact_sdg['id_startup_impact_sdg'].'"');
                            $import_data_to_db_startups_impact_sdg -> execute();

                        }
                         
                         //"Fermer" les fichiers ouverts au-dessus
                        fclose($input);
                        fclose($output);
                        fclose($file_output);

                        //Supprimer le fichier qui a été importé par l'utilsateur et le fichier de traitement des données
                        unlink('csv_imported/'.basename(($_FILES["fileToUpload"]["name"])).'');
                        unlink('csv_imported/startups_modified_good_order.csv');

                        //Pop-up d'avertissement pour dire que le fichier a été importé et que les données ont été importées dans la base de donnée
                        echo " 
                        <script>
                        var filename = '".basename($_FILES["fileToUpload"]["name"])."';
                            alert('The file '+filename+' has been uploaded and the data was imported in database.');
                        </script>
                        "; 
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