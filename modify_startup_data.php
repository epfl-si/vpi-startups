<?php

   
//S'il n'appartient pas au groupe TequilaPHPWrite, alors il n'a pas le droit de regarder le contenu de cette page
if($_SESSION['TequilaPHPWrite'] == "TequilaPHPWritetrue")
{   
    //Récupérer le nom de la startup qui est en paramètre dans le site
    $id_startup = $param;

    //Récupérer les données de la startup pour les afficher sur les champs
    $startups_data = $db -> query('SELECT * FROM view_detail_startup_full WHERE id_startup="'.$id_startup.'"');
    $startup_data = $startups_data -> fetch();

    $_SESSION['startup_data'] = $startup_data;
    
    //Fonction pour afficher les listes déroulantes des personnes
    function display_people($number_of_person, $id_startup, $id_person_view, $name_person)
    { 
        require 'tools/connection_db.php';
        echo '<div class="form-group row">
                <label for="person'.$number_of_person.'" class="col-sm-4 col-form-label">Person '.$number_of_person.'</label>
                <div class="col-sm-6">
                    <select class="form-control" class="selectpicker" data-dropup-auto="true" name="person'.$number_of_person.'" id="person'.$number_of_person.'">
                    <option value="delete">Delete person</option>';
                    $selected = false;

                    $all_persons = $db-> query('SELECT id_person, name, firstname FROM person');
                    $all_person = $all_persons -> fetchAll();

                    foreach($all_person as $all)
                    {
                        if($all['id_person'] == $id_person_view)
                        {
                            echo '<option value="'.$id_person_view.'" selected>'.$name_person.'</option>';
                            $selected = true;
                            
                        }
                        else
                        {
                            echo '<option value="'.$all['id_person'].'">'.$all['name'].'</option>';
                        }
                    }

                    if($selected == false)
                    {
                        echo '<option value="" disabled selected>Select person '.$number_of_person.'</option>';
                    }
                    echo '
                    </select>
                </div>
            </div>';
    }

    //Fonction pour afficher les listes déroulantes de la fonction des personnes
    function display_people_function($number_of_function, $id_startup,$id_type_of_person_view, $type_of_person)
    {
        require 'tools/connection_db.php';

        echo '
        <div class="form-group row">
            <label for="function_type_of_person'.$number_of_function.'" class="col-sm-4 col-form-label"> Type of Person Function '.$number_of_function.'</label>
            <div class="col-sm-6">
            <select class="form-control" class="selectpicker" data-dropup-auto="true" name="function_type_of_person'.$number_of_function.'" id="function_type_of_person'.$number_of_function.'">
            <option value="delete">Delete type of function</option>';
            
            $all_type_of_persons = $db-> query('SELECT id_type_of_person, type_of_person FROM type_of_person');
            $all_type_of_person = $all_type_of_persons -> fetchAll();
        
            $selected = false;
            
            foreach($all_type_of_person as $all) 
            {
                if($all['id_type_of_person'] == $id_type_of_person_view)
                {
                    echo '<option value="'.$id_type_of_person_view.'" selected>'.$type_of_person.'</option>';
                    $selected = true;
                    
                }
                else
                {
                    echo '<option value="'.$all['id_type_of_person'].'">'.$all['type_of_person'].'</option>';
                }
            }

            if($selected == false)
            {
                echo '<option value="" disabled selected>Select Type of Person '.$number_of_function.'</option>';
            }
            echo '
            
            </select>
            </div>
        </div>';
    }
    //Formulaire pour ajouter une nouvelle startup
    echo '
    <div class="container">
        <form method="post" id="form_add_new_company" class="form_add_new_company col-12 col-sm-12 col-lg-8 col-xl-8 mx-auto" action="'; echo '/'.$controller.'/'.$method.'/'.$param; echo'">
            <legend class="font-weight-bold my-3"> Modify company</legend>
            <small class="text-danger my-3 row col-12"> * Fields Required </small>
            <input type="hidden" id="action" name="action" value="'.$method." ".$controller.' : '.$startup_data['company'].'"">
            <!-- Champ pour le nom de la startup -->
            <div class="form-group row">
                <label for="company_name" class="col-sm-4 col-form-label">Company name <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="company_name" id="company_name" value="'.$startup_data['company'].'" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,300}" title="Letters and Numbers are accepted. Minimum 2 characters and maximum 300. The special characters accepted are : &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;" required>
                </div>
            </div>
            <!-- Champ pour l\'année de création de la startup -->
            <div class="form-group row">
                <label for="founding_date" class="col-sm-4 col-form-label">Founding Date <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="founding_date" id="founding_date" value="'.$startup_data['founding_date'].'" pattern="[0-9]{4}" title="Only numbers, 4 numbers." required>
                </div>
            </div>
            <!-- Champ pour l\'url de la startup -->
            <div class="form-group row">
                <label for="web" class="col-sm-4 col-form-label">Web</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="web" id="web" value="'.$startup_data['web'].'" pattern="((https://)|(http://)|(www)).*" title="Your url must begin by &quot;www&quot;,&quot;http://&quot; or &quot;https://&quot;.">
                </div>
            </div>
            <!--  -->
            <div class="form-group row">
                <label for="rc" class="col-sm-4 col-form-label">RC</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="rc" id="rc" value="'.$startup_data['rc'].'" pattern="[A-Za-z0-9[\-\.\] ]{2,300}" title="Minimum 2 characters and maximum 300. Special characters allowed are &quot;-.&quot;">
                </div>
            </div>
            <!-- Combobox pour afficher tout les status d\'une startup -->
                <div class="form-group row">
                    <label for="status" class="col-sm-4 col-form-label">Status<small class="text-danger"> *</small> </label>
                    <div class="col-sm-6">
                        <select class="form-control" name="status" id="status" required>';

                            //Récupérer le status de la startup et l'afficher sur la combobox, mais afficher les autres possibilités si l'utilisateur veut changer le status de la startup
                            $status_data_startups = $db-> query('SELECT status FROM status INNER JOIN startup ON status.id_status = startup.fk_status WHERE id_startup = "'.$id_startup.'"');
                            $status_data_startup = $status_data_startups -> fetch();

                            $status_data = $db-> query('SELECT status FROM status');
                            $data_status = $status_data -> fetchAll();
                            foreach ($data_status as $status)
                            {
                                if($status['status'] == $status_data_startup['status'])
                                {
                                    echo '<option value="'.$status_data_startup['status'].'" selected>'.$status_data_startup['status'].'</option>';
                                }
                                else
                                {
                                    echo '<option value="'.$status['status'].'">'.$status['status'].'</option>';
                                }
                            }
                        echo '
                        </select>
                    </div>
                </div>
            <!-- Champ pour l\'année de sortie de la startup -->
            <div class="form-group row">
                <label for="exit_year" class="col-sm-4 col-form-label">Exit year</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="exit_year" value="'.$startup_data['exit_year'].'" id="exit_year" pattern="[0-9]{4}" title="Only numbers, 4 numbers.">
                </div>
            </div>
            <!-- Combobox pour afficher tout les types d\'une startup -->
                <div class="form-group row">
                    <label for="type_startup" class="col-sm-4 col-form-label">Type Startup <small class="text-danger"> *</small> </label>
                    <div class="col-sm-6">
                        <select class="form-control" class="selectpicker" data-dropup-auto="true" name="type_startup" id="type_startup" required>';

                            //Récupérer le type_startup de la startup et l'afficher sur la combobox, mais afficher les autres possibilités si l'utilisateur veut changer le type_startup de la startup
                            $type_startup_data_startups = $db-> query('SELECT type_startup FROM type_startup INNER JOIN startup ON type_startup.id_type_startup = startup.fk_type WHERE id_startup = "'.$id_startup.'"');
                            $type_startup_data_startup = $type_startup_data_startups -> fetch();

                            $type_startup_data = $db-> query('SELECT type_startup FROM type_startup');
                            $data_type_startup = $type_startup_data -> fetchAll();
                            foreach ($data_type_startup as $type_startup)
                            {
                                if($type_startup['type_startup'] == $type_startup_data_startup['type_startup'])
                                {
                                    echo '<option value="'.$type_startup_data_startup['type_startup'].'" selected>'.$type_startup_data_startup['type_startup'].'</option>';
                                }
                                else
                                {
                                    echo '<option value="'.$type_startup['type_startup'].'">'.$type_startup['type_startup'].'</option>';
                                }
                            }
                        echo '
                        </select>
                    </div>
                </div>
            <!-- Champ pour la categorie de la startup -->
            <div class="form-group row">
                <label for="category" class="col-sm-4 col-form-label">Category <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                <select class="form-control" class="selectpicker" data-dropup-auto="true" name="category" id="category" required>';

                    $category_data_startups = $db-> query('SELECT category FROM category INNER JOIN startup ON category.id_category = startup.fk_category WHERE id_startup = "'.$id_startup.'"');
                    $category_data_startup = $category_data_startups -> fetch();

                    $category_data = $db-> query('SELECT category FROM category');
                    $data_category = $category_data -> fetchAll();
                    foreach ($data_category as $category)
                    {
                        if($category['category'] == $category_data_startup['category'])
                        {
                            echo '<option value="'.$category_data_startup['category'].'" selected>'.$category_data_startup['category'].'</option>';
                        }
                        else
                        {
                            echo '<option value="'.$category['category'].'">'.$category['category'].'</option>';
                        }
                    }
                echo '
                </select>
                </div>
            </div>
            <!-- Champ pour l\'epfl grant de la startup -->
            <div class="form-group row">
                <label for="epfl_grant" class="col-sm-4 col-form-label">EPFL Grant</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" name="epfl_grant" id="epfl_grant" value="'.$startup_data['epfl_grant'].'" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,100}" title="Minimum 2 characters and maximum 100. Special characters allowed are &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                </div>
            </div>
            <!-- Champ pour le awards competitions de la startup -->
            <div class="form-group row">
                <label for="awards_competitions" class="col-sm-4 col-form-label">Awards / Competitions</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" name="awards_competitions" id="awards_competitions" value="'.$startup_data['awards_competitions'].'" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,300}" title="Minimum 2 characters and maximum 300. Special characters allowed are &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                </div>
            </div>
            
            <!-- Combobox pour afficher tous les sectors d\'une startup -->
            <div class="form-group row">
                <label for="sectors" class="col-sm-4 col-form-label">Sectors <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                <select class="form-control" class="selectpicker" data-dropup-auto="true" name="sectors" id="sectors" required>';

                    $sectors_data_startups = $db-> query('SELECT sectors FROM sectors INNER JOIN startup ON sectors.id_sectors = startup.fk_sectors WHERE id_startup = "'.$id_startup.'"');
                    $sectors_data_startup = $sectors_data_startups -> fetch();

                    $sectors_data = $db-> query('SELECT sectors FROM sectors');
                    $data_sectors = $sectors_data -> fetchAll();
                    foreach ($data_sectors as $sectors)
                    {
                        if($sectors['sectors'] == $sectors_data_startup['sectors'])
                        {
                            echo '<option value="'.$sectors_data_startup['sectors'].'" selected>'.$sectors_data_startup['sectors'].'</option>';
                        }
                        else
                        {
                            echo '<option value="'.$sectors['sectors'].'">'.$sectors['sectors'].'</option>';
                        }
                    }
                echo '
                </select>
                </div>
            </div>
            <!-- Champ pour les keys words de la startup -->
            <div class="form-group row">
                <label for="key_words" class="col-sm-4 col-form-label">Key words</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" name="key_words" id="key_words" value="'.$startup_data['key_words'].'" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,500}" title="Minimum 2 characters and maximum 500. Special characters allowed are &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                </div>
            </div>
            <!-- Champ pour le laboratoire de la startup -->
            <div class="form-group row">
                <label for="laboratory" class="col-sm-4 col-form-label">Laboratory</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" name="laboratory" id="laboratory" value="'.$startup_data['laboratory'].'" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,500}" title="Minimum 2 characters and maximum 500. Special characters allowed are &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                </div>
            </div>
            <!-- Champ pour la description de la startup -->
            <div class="form-group row">
                <label for="short_description" class="col-sm-4 col-form-label">Short Description</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" name="short_description" id="short_description" value="'.$startup_data['short_description'].'" pattern="[A-Za-z0-9[\(-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,500}" title="Letters and Numbers are accepted. Minimum 2 characters and maximum 500. The special characters accepted are : &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                </div>
            </div>
            <!-- Champ pour le niveau d\'études du CEO de la startup -->
            <div class="form-group row">
                <label for="ceo_education_level" class="col-sm-4 col-form-label">CEO Education Level <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                <select class="form-control" class="selectpicker" data-dropup-auto="true" name="ceo_education_level" id="ceo_education_level" required>';

                    $ceo_education_level_data_startups = $db-> query('SELECT ceo_education_level FROM ceo_education_level INNER JOIN startup ON ceo_education_level.id_ceo_education_level = startup.fk_ceo_education_level WHERE id_startup = "'.$id_startup.'"');
                    $ceo_education_level_data_startup = $ceo_education_level_data_startups -> fetch();

                    $ceo_education_level_data = $db-> query('SELECT ceo_education_level FROM ceo_education_level');
                    $data_ceo_education_level = $ceo_education_level_data -> fetchAll();
                    foreach ($data_ceo_education_level as $ceo_education_level)
                    {
                        if($ceo_education_level['ceo_education_level'] == $ceo_education_level_data_startup['ceo_education_level'])
                        {
                            echo '<option value="'.$ceo_education_level_data_startup['ceo_education_level'].'" selected>'.$ceo_education_level_data_startup['ceo_education_level'].'</option>';
                        }
                        else
                        {
                            echo '<option value="'.$ceo_education_level['ceo_education_level'].'">'.$ceo_education_level['ceo_education_level'].'</option>';
                        }
                    }
                echo '
                </select>
                </div>
            </div>
            <!-- Champ pour le pays d\'origine des fondateurs de la startup -->
            <div class="form-group row">
                <label for="founders_country" class="col-sm-4 col-form-label">Founders country <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                <select class="form-control" class="selectpicker" data-dropup-auto="true" name="founders_country[]" id="founders_country" multiple="multiple" required>';

                $founders_country_data_startups = $db-> query('SELECT founders_country FROM founders_country INNER JOIN startup_founders_country ON founders_country.id_founders_country = startup_founders_country.fk_founders_country WHERE fk_startup = "'.$id_startup.'"');
                $selected_countries_startup = $founders_country_data_startups -> fetchAll();
                
                
                $founders_country_data = $db-> query('SELECT founders_country FROM founders_country');
                $all_countries_startup = $founders_country_data -> fetchAll();
                
                foreach ($all_countries_startup as $all_countries)
                {
                    $selected = false;
                    foreach ($selected_countries_startup as $selected_countries)
                    {
                        if($selected_countries['founders_country'] == $all_countries['founders_country'])
                        {
                            $selected = true;
                        }                               
                    }
                    if($selected)
                    {
                        echo '<option value="'.$all_countries['founders_country'].'" selected>'.$all_countries['founders_country'].'</option>';
                    }
                    else
                    {
                        echo '<option value="'.$all_countries['founders_country'].'">'.$all_countries['founders_country'].'</option>';
                    }
                }
                    
                echo '
                </select>
                </div>
            </div>
            <!-- Champ pour la faculté ou département où appartient la startup-->
            <div class="form-group row">
                <label for="faculty_schools" class="col-sm-4 col-form-label">Faculty / Schools <small class="text-danger"> *</small></label>
                <div class="col-sm-6">
                    <select class="form-control" class="selectpicker" data-dropup-auto="true" name="faculty_schools[]" id="faculty_schools" multiple="multiple" required>';
                        $faculty_schools_data_startups = $db-> query('SELECT faculty_schools FROM faculty_schools INNER JOIN startup_faculty_schools ON faculty_schools.id_faculty_schools = startup_faculty_schools.fk_faculty_schools WHERE fk_startup = "'.$id_startup.'"');
                        $selected_faculty_schools_startup = $faculty_schools_data_startups -> fetchAll();
                        
                        
                        $faculty_schools_data = $db-> query('SELECT faculty_schools FROM faculty_schools');
                        $all_faculty_schools_startup = $faculty_schools_data -> fetchAll();
                        
                        foreach ($all_faculty_schools_startup as $all_faculty_schools)
                        {
                            $startup_all_faculty_schools = "";
                            $selected = false;
                            foreach ($selected_faculty_schools_startup as $selected_faculty_schools)
                            {
                                if($selected_faculty_schools['faculty_schools'] == $all_faculty_schools['faculty_schools'])
                                {
                                    $selected = true;
                                }                               
                            }
                            if($selected)
                            {
                                echo '<option value="'.$all_faculty_schools['faculty_schools'].'" selected>'.$all_faculty_schools['faculty_schools'].'</option>';
                            }
                            else
                            {
                                echo '<option value="'.$all_faculty_schools['faculty_schools'].'">'.$all_faculty_schools['faculty_schools'].'</option>';
                            }
                        }
                    echo '
                    </select>
                </div>
            </div>
            <!-- Champ pour l\'impact de la startup -->
            <div class="form-group row">
                <label for="impact_sdg" class="col-sm-4 col-form-label">Impact <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                <select class="form-control" class="selectpicker" data-dropup-auto="true" name="impact_sdg[]" id="impact_sdg" multiple="multiple" required>';
                    $impact_sdg_data_startups = $db-> query('SELECT impact_sdg FROM impact_sdg INNER JOIN startup_impact_sdg ON impact_sdg.id_impact_sdg = startup_impact_sdg.fk_impact_sdg WHERE fk_startup = "'.$id_startup.'"');
                    $selected_impact_sdg_startup = $impact_sdg_data_startups -> fetchAll();
                    
                    
                    $impact_sdg_data = $db-> query('SELECT impact_sdg FROM impact_sdg');
                    $all_impact_sdg_startup = $impact_sdg_data -> fetchAll();
                    
                    foreach ($all_impact_sdg_startup as $all_impact_sdg)
                    {
                        $selected = false;
                        foreach ($selected_impact_sdg_startup as $selected_impact_sdg)
                        {
                            if($selected_impact_sdg['impact_sdg'] == $all_impact_sdg['impact_sdg'])
                            {
                                $selected = true;
                            }                               
                        }
                        if($selected)
                        {
                            echo '<option value="'.$all_impact_sdg['impact_sdg'].'" selected>'.$all_impact_sdg['impact_sdg'].'</option>';
                        }
                        else
                        {
                            echo '<option value="'.$all_impact_sdg['impact_sdg'].'">'.$all_impact_sdg['impact_sdg'].'</option>';
                        }
                    }
                echo '
                </select>
                </div>
            </div>';

            for ($x = 1; $x <= 3; $x++) 
            {
                display_people($x,$id_startup, $_SESSION['startup_data']["id_person$x"], $_SESSION['startup_data']["name$x"] );
                display_people_function($x, $id_startup, $_SESSION['startup_data']["id_type_of_person$x"], $_SESSION['startup_data']["type_of_person$x"]);
            }

            echo '
            <!-- Champ pour une description de la startup-->
            <button class="btn btn-outline-secondary my-5" id="submit_modify_company" name="submit_modify_company" type="submit">Submit</button>
        </form>';
        require 'pages/funds/funds_table.php';

        funds_table($id_startup = $param);
        require 'tools/disconnection_db.php';
        require 'footer.php';
    echo '</div>';
}
elseif($_SESSION['TequilaPHPRead'] == "TequilaPHPReadtrue")
{
    $_SESSION['flash_message'] = array();
    $_SESSION['flash_message']['message'] = "You don't have enough rights to access this page";
    $_SESSION['flash_message']['type'] = "warning";
    header('Location: /');
}



?>