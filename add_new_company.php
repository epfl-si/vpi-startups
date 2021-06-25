<?php

require 'tools/connection_db.php';

//S'il n'appartient pas au groupe TequilaPHPWrite, alors il n'a pas le droit de voir le contenu de cette page
if($_SESSION['TequilaPHPWrite'] == "TequilaPHPWritetrue")
{   
    //Fonction pour afficher la liste déroulante des personnes
    function display_people($number_of_person)
    {
        require 'tools/connection_db.php';
        
        echo '
        <!-- Liste déroulante des personnes -->
        <div class="form-group row">
                <label for="person'.$number_of_person.'" class="col-sm-4 col-form-label">Person '.$number_of_person.'</label>
                <div class="col-sm-6">
                    <select class="form-control" class="selectpicker" data-dropup-auto="true" name="person'.$number_of_person.'" id="person'.$number_of_person.'">
                        <option name="NULL" value="" disabled selected>Select person '.$number_of_person.' </option>';
                        $person_data = $db-> query('SELECT name,firstname FROM person');
                        $data_person = $person_data -> fetchAll();
                        foreach ($data_person as $person)
                        {
                            echo '<option value="'.$person['name'].'">'.$person['name'].', '.$person['firstname'].'</option>';
                        }
                    echo '
                    </select>
                </div>
            </div>';
    }

    //Fonction pour afficher la liste déroulante de la fonction des personnes
    function display_people_function($number_of_function)
    {
        require 'tools/connection_db.php';

        echo '
        <!-- Liste déroulante des fonction des personnes -->
        <div class="form-group row">
            <label for="function_person'.$number_of_function.'" class="col-sm-4 col-form-label"> Person Function '.$number_of_function.'</label>
            <div class="col-sm-6">
            <select class="form-control" class="selectpicker" data-dropup-auto="true" name="function_person'.$number_of_function.'" id="function_person'.$number_of_function.'">
                <option name="NULL" value="" disabled selected>Select type of person '.$number_of_function.'</option>';
                $types_of_person_data = $db-> query('SELECT type_of_person FROM type_of_person');
                $type_of_person_data = $types_of_person_data -> fetchAll();
                foreach ($type_of_person_data as $type_of_person)
                {
                    echo '<option value="'.$type_of_person['type_of_person'].'">'.$type_of_person['type_of_person'].'</option>';
                }
            echo '
            </select>
            </div>
        </div>';
    }

    //Formulaire pour ajouter une nouvelle startup
    echo '
    <div class="container">
        <form method="post" id="form_add_new_company" class="form_add_new_company col-12 col-sm-12 col-lg-8 col-xl-8 mx-auto" action="'; echo '/'.$controller.'/'.$method; echo'">
        <legend class="font-weight-bold my-3"> Add new company</legend>
        <small class="text-danger my-3 row col-12"> * Fields Required </small>
            <!-- Champ pour le nom de la startup -->
            <div class="form-group row">
                <label for="company_name" class="col-sm-4 col-form-label">Company name <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="company_name" id="company_name" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,300}" title="Letters and Numbers are accepted. Minimum 2 characters and maximum 300. The special characters accepted are : &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;" required>
                </div>
            </div>
            <!-- Champ pour l\'année de création de la startup -->
            <div class="form-group row">
                <label for="founding_date" class="col-sm-4 col-form-label">Founding Date <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="founding_date" id="founding_date" pattern="[0-9]{4}" title="Only numbers, 4 numbers." required>
                </div>
            </div>
            <!-- Champ pour l\'url de la startup -->
            <div class="form-group row">
                <label for="web" class="col-sm-4 col-form-label">Web</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="web" id="web" pattern="((https://)|(http://)).*" title="Your url must begin by &quot;&quot;http://&quot; or &quot;https://&quot;.">
                </div>
            </div>
            <!-- Champ pour l\'url de la startup -->
            <div class="form-group row">
                <label for="rc" class="col-sm-4 col-form-label">RC</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="rc" id="rc" pattern="[A-Za-z0-9[\-\.\] ]{2,300}" title="Minimum 2 characters and maximum 300. Special characters allowed are &quot;-.&quot;">
                </div>
            </div>
            <!-- Combobox pour afficher tous les status d\'une startup -->
            <div class="form-group row">
                <label for="status" class="col-sm-4 col-form-label">Status <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                    <select class="form-control" name="status" id="status" required>
                    <option name="NULL" value="" disabled selected>Select a status</option>';
                        $status_data = $db-> query('SELECT status FROM status');
                        $data_status = $status_data -> fetchAll();
                        foreach ($data_status as $status)
                        {
                            echo '<option value="'.$status['status'].'">'.$status['status'].'</option>';
                        }
                    echo '
                    </select>
                </div>
            </div>
            <!-- Champ pour l\'année de sortie de la startup -->
            <div class="form-group row">
                <label for="exit_year" class="col-sm-4 col-form-label">Exit year</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="exit_year" id="exit_year" pattern="[0-9]{4}" title="Only numbers, 4 numbers.">
                </div>
            </div>
            <!-- Combobox pour afficher tous les types d\'une startup -->
            <div class="form-group row">
                <label for="type_startup" class="col-sm-4 col-form-label">Type Startup <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                    <select class="form-control" class="selectpicker" data-dropup-auto="true" name="type_startup" id="type_startup" required>
                    <option name="NULL" value="" disabled selected>Select a type of startup</option>';
                        $type_data = $db-> query('SELECT type_startup FROM type_startup');
                        $data_type = $type_data -> fetchAll();
                        foreach ($data_type as $type)
                        {
                            echo '<option value="'.$type['type_startup'].'">'.$type['type_startup'].'</option>';
                        }
                    echo '
                    </select>
                </div>
            </div>
            <!-- Champ pour afficher tous les categories de la startup -->
            <div class="form-group row">
                <label for="category" class="col-sm-4 col-form-label">Category <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                <select class="form-control" class="selectpicker" data-dropup-auto="true" name="category" id="category" required>
                    <option name="NULL" value="" disabled selected>Select a category</option>';
                    $category_data = $db-> query('SELECT category FROM category');
                    $data_category = $category_data -> fetchAll();
                    foreach ($data_category as $category)
                    {
                        echo '<option value="'.$category['category'].'">'.$category['category'].'</option>';
                    }
                echo '
                </select>
                </div>
            </div>
            <!-- Champ pour l\'epfl grant de la startup -->
            <div class="form-group row">
                <label for="epfl_grant" class="col-sm-4 col-form-label">EPFL Grant</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" name="epfl_grant" id="epfl_grant" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,100}" title="Minimum 2 characters and maximum 100. Special characters allowed are &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                </div>
            </div>
            <!-- Champ pour le awards competitions de la startup -->
            <div class="form-group row">
                <label for="awards_competitions" class="col-sm-4 col-form-label">Awards / Competitions</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" name="awards_competitions" id="awards_competitions" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,300}" title="Minimum 2 characters and maximum 300. Special characters allowed are &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                </div>
            </div>
            
            <!-- Combobox pour afficher tous les sectors d\'une startup -->
            <div class="form-group row">
                <label for="sector" class="col-sm-4 col-form-label">Sectors <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                    <select class="form-control" class="selectpicker" data-dropup-auto="true" name="sector" id="sector" required>
                        <option name="NULL" value="" disabled selected>Select a sector</option>';
                        $sectors_data = $db-> query('SELECT sectors FROM sectors');
                        $data_sectors = $sectors_data -> fetchAll();
                        foreach ($data_sectors as $sectors)
                        {
                            echo '<option value="'.$sectors['sectors'].'">'.$sectors['sectors'].'</option>';
                        }
                    echo '
                    </select>
                </div>
            </div>
            <!-- Champ pour les keys words de la startup -->
            <div class="form-group row">
                <label for="key_words" class="col-sm-4 col-form-label">Key words</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" name="key_words" id="key_words" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,500}" title="Minimum 2 characters and maximum 500. Special characters allowed are &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                </div>
            </div>
            <!-- Champ pour le laboratoire de la startup -->
            <div class="form-group row">
                <label for="laboratory" class="col-sm-4 col-form-label">Laboratory</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" name="laboratory" id="laboratory" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,500}" title="Minimum 2 characters and maximum 500. Special characters allowed are &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                </div>
            </div>
            <!-- Champ pour la description de la startup -->
            <div class="form-group row">
                <label for="short_description" class="col-sm-4 col-form-label">Short Description</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" name="short_description" id="short_description" pattern="[A-Za-z0-9[\(-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,500}" title="Letters and Numbers are accepted. Minimum 2 characters and maximum 500. The special characters accepted are : &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                </div>
            </div>
            <!-- Champ pour l\'uid de la startup -->
            <div class="form-group row">
                <label for="company_uid" class="col-sm-4 col-form-label">Company UID</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" name="company_uid" id="company_uid" pattern="[A-Za-z0-9[\(-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,500}" title="Letters and Numbers are accepted. Minimum 2 characters and maximum 500. The special characters accepted are : &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                </div>
            </div>
            <!-- Champ pour l\'uid crunchbase de la startup -->
            <div class="form-group row">
                <label for="crunchbase_uid" class="col-sm-4 col-form-label">Crunchbase UID</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" name="crunchbase_uid" id="crunchbase_uid" pattern="[A-Za-z0-9[\(-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,500}" title="Letters and Numbers are accepted. Minimum 2 characters and maximum 500. The special characters accepted are : &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                </div>
            </div>
            <!-- Champ pour le path d\'unité de la startup -->
            <div class="form-group row">
                <label for="unit_path" class="col-sm-4 col-form-label">Unit Path</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" name="unit_path" id="unit_path" pattern="[A-Za-z0-9[\(-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,500}" title="Letters and Numbers are accepted. Minimum 2 characters and maximum 500. The special characters accepted are : &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                </div>
            </div>
            <!-- Champ pour le niveau d\'études du CEO de la startup -->
            <div class="form-group row">
                <label for="ceo_education_level" class="col-sm-4 col-form-label">CEO Education Level <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                    <select class="form-control" class="selectpicker" data-dropup-auto="true" name="ceo_education_level" id="ceo_education_level" required>
                        <option name="NULL" value="" disabled selected>Select a ceo education level</option>';
                        $ceo_education_level_data = $db-> query('SELECT ceo_education_level FROM ceo_education_level');
                        $data_ceo_education_level = $ceo_education_level_data -> fetchAll();
                        foreach ($data_ceo_education_level as $ceo_education_level)
                        {
                            echo '<option value="'.$ceo_education_level['ceo_education_level'].'">'.$ceo_education_level['ceo_education_level'].'</option>';
                        }
                    echo '
                    </select>
                </div>
            </div>
            <!-- Champ pour le pays d\'origine des fondateurs de la startup -->
            <div class="form-group row">
                <label for="founders_country" class="col-sm-4 col-form-label">Founders Country <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                    <select class="form-control" class="selectpicker" data-dropup-auto="true" name="founders_country[]" id="founders_country" multiple="multiple" required>
                        <option name="NULL" value="" disabled selected>Select the countries</option>';
                        $founders_country_data = $db-> query('SELECT founders_country FROM founders_country');
                        $data_founders_country = $founders_country_data -> fetchAll();
                        foreach ($data_founders_country as $founders_country)
                        {
                            echo '<option value="'.$founders_country['founders_country'].'">'.$founders_country['founders_country'].'</option>';
                        }
                    echo '
                    </select>
                </div>
            </div>
            <!-- Champ pour la faculté ou département où appartient la startup-->
            <div class="form-group row">
                <label for="faculty_schools" class="col-sm-4 col-form-label">Faculty / Schools <small class="text-danger"> *</small></label>
                <div class="col-sm-6">
                    <select class="form-control" class="selectpicker" data-dropup-auto="true" name="faculty_schools[]" id="faculty_schools" multiple="multiple" required>
                        <option name="NULL" value="" disabled selected>Select the faculty school</option>';
                        $faculty_schools_data = $db-> query('SELECT faculty_schools FROM faculty_schools');
                        $data_faculty_schools = $faculty_schools_data -> fetchAll();
                        foreach ($data_faculty_schools as $faculty_schools)
                        {
                            echo '<option value="'.$faculty_schools['faculty_schools'].'">'.$faculty_schools['faculty_schools'].'</option>';
                        }
                    echo '
                    </select>
                </div>
            </div>
            <!-- Champ pour l\'impact de la startup -->
            <div class="form-group row">
                <label for="impact_sdg" class="col-sm-4 col-form-label">Impact <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                <select class="form-control" class="selectpicker" data-dropup-auto="true" name="impact_sdg[]" id="impact_sdg" multiple="multiple" required>
                    <option name="NULL" value="" disabled selected>Select the impacts</option>';
                    $impact_sdg_data = $db-> query('SELECT impact_sdg FROM impact_sdg');
                    $data_impact_sdg = $impact_sdg_data -> fetchAll();
                    foreach ($data_impact_sdg as $impact_sdg)
                    {
                        echo '<option value="'.$impact_sdg['impact_sdg'].'">'.$impact_sdg['impact_sdg'].'</option>';
                    }
                echo '
                </select>
                </div>
            </div>';
            
            //Boucle pour afficher 3 fois la combobox avec les personnes et avec la fonction des personnes
            for ($x = 1; $x <= 3; $x++) {
                display_people($x);
                display_people_function($x);
            }

            echo '
            <button class="btn btn-outline-secondary my-5" id="submit_new_company" name="submit_new_company" type="submit">Submit</button>
        </form>
    </div>';

    require 'tools/disconnection_db.php';
    require 'footer.php';
}
//Si l'utilisateur a seulement le droit de lecture, alors il n'a pas le droit de voir cette page
elseif($_SESSION['TequilaPHPRead'] == "TequilaPHPReadtrue")
{
    $_SESSION['flash_message'] = array();
    $_SESSION['flash_message']['message'] = "You don't have enough rights to access this page.";
    $_SESSION['flash_message']['type'] = "warning";
    header('Location: /');
    exit;
}
?>