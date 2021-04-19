<?php

require 'header.php';
require 'tools/connection_db.php';

if(isset($_SESSION['user']))
{
    if($_SESSION['TequilaPHPWrite'] == "TequilaPHPWritetrue")
    {
        if(isset($_GET['id']))
        {
            //Récupérer le nom de la startup qui est en paramètre dans le site
            $id_startup = security_text($_GET['id']);

            //Récupérer les données de la startup pour les afficher sur les champs
            $startups_data = $db -> query('SELECT * FROM startup WHERE id_startup="'.$id_startup.'"');
            $startup_data = $startups_data -> fetch();

            //Champs avec les données de la startup et possibilité de changement de ces données
            echo '
            <div class="container">
                <h5 class="font-weight-bold my-3"> Company information / modification</h5>
                <small class="text-danger my-3 row col-12"> * Fields Required </small>
                <form method="post" id="form_change_startup" class="form_change_startup col-12 col-sm-12 col-lg-8 col-xl-8 my-5" action="'; echo security_text($_SERVER["PHP_SELF"])."?id=".security_text($_GET["id"]); echo'">
                    <!-- Champ pour le nom de la startup -->
                    <div class="form-group row">
                        <label for="company_name" class="col-sm-4 col-form-label">Company name<small class="text-danger"> *</small> </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" value="'.$startup_data['company'].'" name="company_name" id="company_name" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,300}" title="Letters and Numbers are accepted. Minimum 2 characters and maximum 300. The special characters accepted are : &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;" required>
                        </div>
                    </div>
                    <!-- Champ pour l\'année de création de la startup -->
                    <div class="form-group row">
                        <label for="founding_year" class="col-sm-4 col-form-label">Founding Year<small class="text-danger"> *</small> </label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" value="'.$startup_data['founding_year'].'" name="founding_year" id="founding_year" pattern="[0-9]{4}" title="Only numbers, 4 numbers required." required>
                        </div>
                    </div>
                    <!-- Champ pour l\'url de la startup -->
                    <div class="form-group row">
                        <label for="web" class="col-sm-4 col-form-label">Web</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" value="'.$startup_data['web'].'" name="web" id="web" pattern="((https://)|(http://)|(www)).*" title="Your url must begin by &quot;www&quot;,&quot;http://&quot; or &quot;https://&quot;.">
                        </div>
                    </div>
                    <!--  -->
                    <div class="form-group row">
                        <label for="rc" class="col-sm-4 col-form-label">RC</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" value="'.$startup_data['rc'].'" name="rc" id="rc" pattern="[A-Za-z0-9[\-\.\] ]{2,300}" title="Minimum 2 characters and maximum 300. Special characters allowed are &quot; -. &quot;">
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
                            <input type="number" class="form-control" value="'.$startup_data['exit_year'].'" name="exit_year" id="exit_year" pattern="[0-9]{4}" title="Only numbers, 4 numbers required.">
                        </div>
                    </div>
                    <!-- Champ pour le temps de sortie de la startup -->
                    <div class="form-group row">
                        <label for="time_to_exit" class="col-sm-4 col-form-label">Time to exit</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" value="'.$startup_data['time_to_exit'].'" name="time_to_exit" id="time_to_exit" pattern="[0-9]{1,5}" title="Only numbers, 1 minimum and 5 maximum.">
                        </div>
                    </div>
                    <!-- Combobox pour afficher tout les types d\'une startup -->
                    <div class="form-group row">
                        <label for="type" class="col-sm-4 col-form-label">Type<small class="text-danger"> *</small> </label>
                        <div class="col-sm-6">
                            <select class="form-control" class="selectpicker" data-dropup-auto="true" name="type" id="type" required>
                                <option name="none" value="None">None</option>';
                                
                                //Récupérer le type de la startup et l'afficher sur la combobox, mais afficher les autres possibilités si l'utilisateur veut changer le type de la startup
                                $type_data_startups = $db-> query('SELECT type FROM type INNER JOIN startup ON type.id_type = startup.fk_type WHERE id_startup = "'.$id_startup.'"');
                                $type_data_startup = $type_data_startups -> fetch();

                                $type_data = $db-> query('SELECT type FROM type');
                                $data_type = $type_data -> fetchAll();
                                foreach ($data_type as $type)
                                {
                                    if($type['type'] == $type_data_startup['type'])
                                    {
                                        echo '<option value="'.$type_data_startup['type'].'" selected>'.$type_data_startup['type'].'</option>';
                                    }
                                    else
                                    {
                                        echo '<option value="'.$type['type'].'">'.$type['type'].'</option>';
                                    }
                                }
                            echo '
                            </select>
                        </div>
                    </div>
                    <!-- Champ pour le capital de la startup -->
                    <div class="form-group row">
                        <label for="capital" class="col-sm-4 col-form-label">Capital</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['capital'].'" name="capital" id="capital" pattern="[A-Za-z0-9 ]{1,30}" title="Minimum 1 character and maximum 30 characters.">
                        </div>
                    </div>
                    <!-- Champ pour le investor platform de la startup -->
                    <div class="form-group row">
                        <label for="investor_platform" class="col-sm-4 col-form-label">Investor Platform</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['investor_platform'].'" name="investor_platform" id="investor_platform" pattern="[A-Za-z0-9 ]{1,100}" title="Minimum 1 character and maximum 100 characters.">
                        </div>
                    </div>
                    <!-- Champ pour l\'epfl grant de la startup -->
                    <div class="form-group row">
                        <label for="epfl_grant" class="col-sm-4 col-form-label">EPFL Grant</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['epfl_grant'].'" name="epfl_grant" id="epfl_grant" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,100}" title="Minimum 2 characters and maximum 100. Special characters allowed are &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                        </div>
                    </div>
                    <!-- Champ pour le prix hors epfl de la startup -->
                    <div class="form-group row">
                        <label for="prix_hors_epfl" class="col-sm-4 col-form-label">Prix hors EPFL</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['prix_hors_epfl'].'" name="prix_hors_epfl" id="prix_hors_epfl" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,300}" title="Minimum 2 characters and maximum 300. Special characters allowed are &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                        </div>
                    </div>
                    <!-- Champ pour l\'impact de la startup -->
                    <div class="form-group row">
                        <label for="impact" class="col-sm-4 col-form-label">Impact</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['impact'].'" name="impact" id="impact" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,30}" title="Minimum 2 characters and maximum 30. Special characters allowed are &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                        </div>
                    </div>
                    <!-- Combobox pour afficher tout les sectors d\'une startup -->
                    <div class="form-group row">
                        <label for="sectors" class="col-sm-4 col-form-label">Field / Sectors<small class="text-danger"> *</small> </label>
                        <div class="col-sm-6">
                        <select class="form-control" class="selectpicker" data-dropup-auto="true" name="sector" id="sector" required>';
                            //Récupérer le sectors de la startup et l'afficher sur la combobox, mais afficher les autres possibilités si l'utilisateur veut changer le sectors de la startup
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
                        <input type="text" class="form-control" value="'.$startup_data['key_words'].'" name="key_words" id="key_words" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,500}" title="Minimum 2 characters and maximum 500. Special characters allowed are &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                        </div>
                    </div>
                    <!-- Champ pour le ba, ma, phd, @EPFL de la startup -->
                    <div class="form-group row">
                        <label for="ba_ma_phd_epfl" class="col-sm-4 col-form-label">ba, ma, phd, @EPFL</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['ba_ma_phd_epfl'].'" name="ba_ma_phd_epfl" id="ba_ma_phd_epfl" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,30}" title="Minimum 2 characters and maximum 30. Special characters allowed are &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                        </div>
                    </div>
                    <!-- Champ pour l\'origine des fondateurs de la startup -->
                    <div class="form-group row">
                        <label for="founders_origin" class="col-sm-4 col-form-label">Founders origin</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['founders_origin'].'" name="founders_origin" id="founders_origin" pattern="[A-Za-z[\-\/\] ]{2,300}" title="Only letters allowed. Minimum 2 characters and maximum 300. Special characters allowed are Special characters allowed are &quot; -/ &quot;">
                        </div>
                    </div>
                    <!-- Champ pour le pays d\'origine des fondateurs de la startup -->
                    <div class="form-group row">
                        <label for="founders_country" class="col-sm-4 col-form-label">Founders Country</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['founders_country'].'" name="founders_country" id="founders_country" pattern="[A-Za-z[\-\/\] ]{2,300}" title="Only letters allowed. Minimum 2 characters and maximum 300. Special characters allowed are &quot; -/ &quot;">
                        </div>
                    </div>
                    <!-- Champ pour le nom des fondateurs de la startup -->
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label">Name</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['name'].'" name="name" id="name" pattern="[A-Za-z[\-\] ]{2,30}" title="Only letters allowed. Minimum 2 characters and maximum 30. Special characters allowed are &quot; -/ &quot;">
                        </div>
                    </div>
                    <!-- Champ pour le prénom des fondateurs de la startup -->
                    <div class="form-group row">
                        <label for="firstname" class="col-sm-4 col-form-label">Firstname</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['firstname'].'" name="firstname" id="firstname" pattern="[A-Za-z[\-\] ]{2,30}" title="Only letters allowed. Minimum 2 characters and maximum 30. Special characters allowed are &quot; - &quot;">
                        </div>
                    </div>
                    <!-- Champ pour la fonction des fondateurs de la startup -->
                    <div class="form-group row">
                        <label for="function1" class="col-sm-4 col-form-label">Function</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['function'].'" name="function1" id="function1" pattern="[A-Za-z[\-\/&\] ]{2,30}" title="Only letters allowed. Minimum 2 characters and maximum 30. Special characters allowed are &quot; -/& &quot;">
                        </div>
                    </div>
                    <!-- Champ pour email-->
                    <div class="form-group row">
                        <label for="email1" class="col-sm-4 col-form-label">Email 1</label>
                        <div class="col-sm-6">
                        <input type="email" class="form-control" value="'.$startup_data['email1'].'" name="email1" id="email1" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}" title="Write an valid email address.">
                        </div>
                    </div>
                    <!-- Champ pour un autre email-->
                    <div class="form-group row">
                        <label for="email2" class="col-sm-4 col-form-label">Email 2 </label>
                        <div class="col-sm-6">
                        <input type="email" class="form-control" value="'.$startup_data['email2'].'" name="email2" id="email2" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}" title="Write an valid email address.">
                        </div>
                    </div>
                    <!-- Champ pour le deuxième nom-->
                    <div class="form-group row">
                        <label for="name2" class="col-sm-4 col-form-label">Name2</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['name2'].'" name="name2" id="name2" pattern="[A-Za-z[\-\] ]{2,100}" title="Only letters allowed. Minimum 2 characters and maximum 100. Special characters allowed are &quot; - &quot;">
                        </div>
                    </div>
                    <!-- Champ pour le deuxième prénom-->
                    <div class="form-group row">
                        <label for="firstname2" class="col-sm-4 col-form-label">Firstname2</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['firstname2'].'" name="firstname2" id="firstname2" pattern="[A-Za-z[\-\] ]{2,30}" title="Only letters allowed. Minimum 2 characters and maximum 30. Special characters allowed are &quot; - &quot;">
                        </div>
                    </div>
                    <!-- Champ pour autres fonctions-->
                    <div class="form-group row">
                        <label for="function2" class="col-sm-4 col-form-label">Function2</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['function2'].'" name="function2" id="function2" pattern="[A-Za-z[\-\] ]{2,100}" title="Only letters allowed. Minimum 2 characters and maximum 100. Special characters allowed are &quot; - &quot;">
                        </div>
                    </div>
                    <!-- Champ pour le nom du professeur fondateur-->
                    <div class="form-group row">
                        <label for="prof_as_founder" class="col-sm-4 col-form-label">Prof. as Founder</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['prof_as_founder'].'" name="prof_as_founder" id="prof_as_founder" pattern="[a-zA-Z[\.\] ]{2,100}" title="Only letters allowed. Minimum 2 characters and maximum 100. Special characters allowed are &quot; . &quot;">
                        </div>
                    </div>
                    <!-- Champ pour le ratio de femmes/hommes dans la startup-->
                    <div class="form-group row">
                        <label for="gender_female_ratio" class="col-sm-4 col-form-label">Gender female Ratio<small class="text-danger"> *</small> </label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['gender_female_ratio'].'" name="gender_female_ratio" id="gender_female_ratio" pattern="[0-9[\/%\] ]{1,20}" title="Only numbers allowed. Minimum 1 characters and maximum 20. Special characters allowed are &quot; /% &quot;" required>
                        </div>
                    </div>
                    <!-- Champ pour le nombre de femmes dans la startup-->
                    <div class="form-group row">
                        <label for="gender_female_number" class="col-sm-4 col-form-label">Gender female number<small class="text-danger"> *</small> </label>
                        <div class="col-sm-6">
                        <input type="number" class="form-control" value="'.$startup_data['gender_female_number'].'" name="gender_female_number" id="gender_female_number" pattern="[0-9]{1,20}" title="Only numbers allowed. Minimum 1 characters and maximum 20." required>
                        </div>
                    </div>
                    <!-- Champ pour la faculté ou département où appartient la startup-->
                    <div class="form-group row">
                        <label for="fac_dpt" class="col-sm-4 col-form-label">fac / dpt</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['fac_dpt'].'" name="fac_dpt" id="fac_dpt" pattern="[a-zA-Z[()\/\] ]{2,30}" title="Only letters allowed. Minimum 2 characters and maximum 30. Special characters allowed are &quot; ()/ &quot;">
                        </div>
                    </div>
                    <!-- Champ pour le nom du laboratoire-->
                    <div class="form-group row">
                        <label for="laboratory" class="col-sm-4 col-form-label">Laboratory</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['laboratory'].'" name="laboratory" id="laboratory" pattern="[a-zA-Z[()\/\] ]{2,100}" title="Only letters allowed. Minimum 2 characters and maximum 100. Special characters allowed are &quot; ()/ &quot;">
                        </div>
                    </div>
                    <!-- Champ pour le nom du prof-->
                    <div class="form-group row">
                        <label for="prof" class="col-sm-4 col-form-label">Prof</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['prof'].'" name="prof" id="prof" pattern="[a-zA-Z[\.\] ]{2,100}" title="Only letters allowed. Minimum 2 characters and maximum 100. Special characters allowed are &quot; . &quot;">
                        </div>
                    </div>
                    <!-- Champ pour le s\'il y a eu des investissement en 2020-->
                    <div class="form-group row">
                        <label for="investment_2020" class="col-sm-4 col-form-label">2020 investment</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['investment_2020'].'" name="investment_2020" id="investment_2020" pattern="[A-Za-z0-9 ]{1,30}" title="Letters and numbers allowed. Minimum 1 character and maximum 30 characters.">
                        </div>
                    </div>
                    <!-- Champ pour le nom de l\investisseur-->
                    <div class="form-group row">
                        <label for="investor_2020" class="col-sm-4 col-form-label">2020 Investor</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" value="'.$startup_data['investor_2020'].'" name="investor_2020" id="investor_2020" pattern="[a-zA-Z ]{2,300}" title="Only letters allowed. Minimum 2 characters and maximum 300.">
                        </div>
                    </div>
                    <!-- Champ pour une description de la startup-->
                    <div class="form-group row">
                        <label for="description" class="col-sm-4 col-form-label">Short description</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" value="'.$startup_data['description'].'" name="description" id="description" pattern="[A-Za-z0-9[\(-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,500}" title="Letters and Numbers are accepted. Minimum 2 characters and maximum 500. The special characters accepted are : &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                        </div>
                    </div>
                    <!-- Champ pour un commentaire de la startup-->
                    <div class="form-group row">
                        <label for="comments" class="col-sm-4 col-form-label">Comments</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" value="'.$startup_data['comments'].'" name="comments" id="comments" pattern="[A-Za-z0-9[\(-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,500}" title="Letters and Numbers are accepted. Minimum 2 characters and maximum 500. The special characters accepted are : &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                        </div>
                    </div>
                    <div class ="form-group row col-12">
                        <button class="btn btn-outline-secondary mt-5 mr-5" id="submit_changes_company" onclick="after_click()" name="submit_changes_company" type="submit">Change</button>
                        <button class="btn btn-outline-secondary mt-5 mx-auto" id="submit_delete_company" onclick="company_delete()" name="submit_delete_company" type="button">DELETE</button>
                    </div>
                </form>
            </div>
            <script>

                var get = "'.$id_startup.'";
                //Récupérer la valeur du champ "exit year" pour savoir si l\'entreprise a déjà une date de fin
                var delete_company = document.getElementById("exit_year").value;

                //Si l\'entreprise a une date de fin, alors je désactive le button "Delete"
                if(delete_company != "")
                {
                    document.getElementById("submit_delete_company").disabled = true;
                }
                
                //Mettre dans des variables les valeurs des comboboxes
                var status = document.getElementById("status").value;
                var type = document.getElementById("type").value;
                var sector = document.getElementById("sector").value;

                //Initialiser une variable false pour ne pas écrire dans la base de données avant les tests des regex
                var valid = "false";

                /*Variable "arr" est un tableau avec les id\'s nécessaires pour pouvoir ensuite faire une comparaison entre
                les messages avant le clique et après le clique.
                Variable "get" est le paramètre qui est passé sur l\'url
                Variable filename est le nom du fichier nécessaire pour traiter les 2 variables mencionnées avant
                
                Ces variables sont utilisées sur le fichier "functions_changes.php" */
                var arr = ["company_name", "founding_year", "web", "rc", "status", "exit_year", "time_to_exit", "type", "capital", "investor_platform", "epfl_grant", "prix_hors_epfl", "impact", "sector", "key_words", "ba_ma_phd_epfl", "founders_origin", "founders_country", "name", "firstname", "function1", "email1", "email2", "name2","firstname2", "function2", "prof_as_founder", "gender_female_ratio", "gender_female_number","fac_dpt", "laboratory", "prof","investment_2020", "investor_2020", "description", "comments"];
                var get = "'.security_text($_GET['id']).'";
                var filename = "company_information_modification_db.php";
                ';

                //Importer le fichier nécessaire pour traiter les variables ci-dessus
                require 'tools/functions_changes.php';

                echo '
            </script>';
        }
        else
        {
            echo '<meta http-equiv="Refresh" content="0; URL=index.php">';
        }
        require 'tools/disconnection_db.php';
        require 'footer.php';
    }
    elseif($_SESSION['TequilaPHPRead'] == "TequilaPHPReadtrue")
    {
        echo "
        <script>
            alert('You don\'t have enough rights to access this page.');
            window.location.replace('index.php');
        </script>";
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
