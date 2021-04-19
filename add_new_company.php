<?php

require 'header.php';
require 'tools/connection_db.php';

if(isset($_SESSION['user']))
{
    if($_SESSION['TequilaPHPWrite'] == "TequilaPHPWritetrue")
    {
        //Formulaire pour ajouter une nouvelle startup
        echo '
        <div class="container">
            <h5 class="font-weight-bold my-3"> Add new company</h5>
            <small class="text-danger my-3 row col-12"> * Fields Required </small>
            <form method="post" id="form_add_new_company" class="form_add_new_company col-12 col-sm-12 col-lg-8 col-xl-8 my-5" action="'; echo security_text($_SERVER["PHP_SELF"]); echo'">
                <!-- Champ pour le nom de la startup -->
                <div class="form-group row">
                    <label for="company_name" class="col-sm-4 col-form-label">Company name <small class="text-danger"> *</small> </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="company_name" id="company_name" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,300}" title="Letters and Numbers are accepted. Minimum 2 characters and maximum 300. The special characters accepted are : &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;" required>
                    </div>
                </div>
                <!-- Champ pour l\'année de création de la startup -->
                <div class="form-group row">
                    <label for="founding_year" class="col-sm-4 col-form-label">Founding Year <small class="text-danger"> *</small></label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" name="founding_year" id="founding_year" pattern="[0-9]{4}" title="Only numbers, 4 numbers required." required>
                    </div>
                </div>
                <!-- Champ pour l\'url de la startup -->
                <div class="form-group row">
                    <label for="web" class="col-sm-4 col-form-label">Web</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="web" id="web" pattern="((https://)|(http://)|(www)).*" title="Your url must begin by &quot;www&quot;,&quot;http://&quot; or &quot;https://&quot;.">
                    </div>
                </div>
                <!--  -->
                <div class="form-group row">
                    <label for="rc" class="col-sm-4 col-form-label">RC</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="rc" id="rc" pattern="[A-Za-z0-9[\-\.\] ]{2,300}" title="Minimum 2 characters and maximum 300. Special characters allowed are &quot;-.&quot;">
                    </div>
                </div>
                <!-- Combobox pour afficher tout les status d\'une startup -->
                <div class="form-group row">
                    <label for="status" class="col-sm-4 col-form-label">Status <small class="text-danger"> *</small></label>
                    <div class="col-sm-6">
                        <select class="form-control" name="status" id="status" required>
                            <option name="default" value="default" disabled selected>Select a status</option>';
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
                        <input type="number" class="form-control" name="exit_year" id="exit_year" pattern="[0-9]{4}" title="Only numbers, 4 numbers required.">
                    </div>
                </div>
                <!-- Champ pour le temps de sortie de la startup -->
                <div class="form-group row">
                    <label for="time_to_exit" class="col-sm-4 col-form-label">Time to exit</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" name="time_to_exit" id="time_to_exit" pattern="[0-9]{1,5}" title="Only numbers, 1 minimum and 5 maximum.">
                    </div>
                </div>
                <!-- Combobox pour afficher tout les types d\'une startup -->
                <div class="form-group row">
                    <label for="type" class="col-sm-4 col-form-label">Type <small class="text-danger"> *</small></label>
                    <div class="col-sm-6">
                        <select class="form-control" class="selectpicker" data-dropup-auto="true" name="type" id="type" required>
                            <option name="default" value="default" disabled selected>Select a type</option>
                            <option name="none" value="None">None</option>';
                            $type_data = $db-> query('SELECT type FROM type');
                            $data_type = $type_data -> fetchAll();
                            foreach ($data_type as $type)
                            {
                                echo '<option value="'.$type['type'].'">'.$type['type'].'</option>';
                            }
                        echo '
                        </select>
                    </div>
                </div>
                <!-- Champ pour le capital de la startup -->
                <div class="form-group row">
                    <label for="capital" class="col-sm-4 col-form-label">Capital</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="capital" id="capital" pattern="[A-Za-z0-9 ]{1,30}" title="Minimum 1 character and maximum 30 characters.">
                    </div>
                </div>
                <!-- Champ pour l\'investor platform de la startup -->
                <div class="form-group row">
                    <label for="investor_platform" class="col-sm-4 col-form-label">Investor Platform</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="investor_platform" id="investor_platform" pattern="[A-Za-z0-9 ]{1,100}" title="Minimum 1 character and maximum 100 characters.">
                    </div>
                </div>
                <!-- Champ pour l\'epfl grant de la startup -->
                <div class="form-group row">
                    <label for="epfl_grant" class="col-sm-4 col-form-label">EPFL Grant</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="epfl_grant" id="epfl_grant" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,100}" title="Minimum 2 characters and maximum 100. Special characters allowed are &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                    </div>
                </div>
                <!-- Champ pour le prix hors epfl de la startup -->
                <div class="form-group row">
                    <label for="prix_hors_epfl" class="col-sm-4 col-form-label">Prix Hors EPFL</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="prix_hors_epfl" id="prix_hors_epfl" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,300}" title="Minimum 2 characters and maximum 300. Special characters allowed are &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                    </div>
                </div>
                <!-- Champ pour l\'impact de la startup -->
                <div class="form-group row">
                    <label for="impact" class="col-sm-4 col-form-label">Impact</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="impact" id="impact" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,30}" title="Minimum 2 characters and maximum 30. Special characters allowed are &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                    </div>
                </div>
                <!-- Combobox pour afficher tout les sectors d\'une startup -->
                <div class="form-group row">
                    <label for="sectors" class="col-sm-4 col-form-label">Field / Sectors <small class="text-danger"> *</small></label>
                    <div class="col-sm-6">
                    <select class="form-control" class="selectpicker" data-dropup-auto="true" name="sector" id="sector" required>
                        <option name="default" value="default" disabled selected>Select a sector</option>';
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
                <!-- Champ pour le ba, ma, phd, @EPFL de la startup -->
                <div class="form-group row">
                    <label for="ba_ma_phd_epfl" class="col-sm-4 col-form-label">ba, ma, phd, @EPFL</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="ba_ma_phd_epfl" id="ba_ma_phd_epfl" pattern="[A-Za-z0-9[\(\-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,30}" title="Minimum 2 characters and maximum 30. Special characters allowed are &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                    </div>
                </div>
                <!-- Champ pour l\'origine des fondateurs de la startup -->
                <div class="form-group row">
                    <label for="founders_origin" class="col-sm-4 col-form-label">Founders origin</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="founders_origin" id="founders_origin" pattern="[A-Za-z[\-\/\] ]{2,300}" title="Only letters allowed. Minimum 2 characters and maximum 300. Special characters allowed are Special characters allowed are &quot; -/ &quot;">
                    </div>
                </div>
                <!-- Champ pour le pays d\'origine des fondateurs de la startup -->
                <div class="form-group row">
                    <label for="founders_country" class="col-sm-4 col-form-label">Founders Country</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="founders_country" id="founders_country" pattern="[A-Za-z[\-\/\] ]{2,300}" title="Only letters allowed. Minimum 2 characters and maximum 300. Special characters allowed are &quot; -/ &quot;">
                    </div>
                </div>
                <!-- Champ pour le nom des fondateurs de la startup -->
                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label">Name</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" id="name" pattern="[A-Za-z[\-\] ]{2,30}" title="Only letters allowed. Minimum 2 characters and maximum 30. Special characters allowed are &quot; -/ &quot;">
                    </div>
                </div>
                <!-- Champ pour le prénom des fondateurs de la startup -->
                <div class="form-group row">
                    <label for="firstname" class="col-sm-4 col-form-label">Firstname</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="firstname" id="firstname" pattern="[A-Za-z[\-\] ]{2,30}" title="Only letters allowed. Minimum 2 characters and maximum 30. Special characters allowed are &quot; - &quot;">
                    </div>
                </div>
                <!-- Champ pour la fonction des fondateurs de la startup -->
                <div class="form-group row">
                    <label for="function1" class="col-sm-4 col-form-label">Function</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="function1" id="function1" pattern="[A-Za-z[\-\/&\] ]{2,30}" title="Only letters allowed. Minimum 2 characters and maximum 30. Special characters allowed are &quot; -/& &quot;">
                    </div>
                </div>
                <!-- Champ pour email-->
                <div class="form-group row">
                    <label for="email1" class="col-sm-4 col-form-label">Email 1</label>
                    <div class="col-sm-6">
                    <input type="email" class="form-control" name="email1" id="email1" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}" title="Write an valid email address.">
                    </div>
                </div>
                <!-- Champ pour un autre email-->
                <div class="form-group row">
                    <label for="email2" class="col-sm-4 col-form-label">Email 2</label>
                    <div class="col-sm-6">
                    <input type="email" class="form-control" name="email2" id="email2" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}" title="Write an valid email address.">
                    </div>
                </div>
                <!-- Champ pour le deuxième nom-->
                <div class="form-group row">
                    <label for="name2" class="col-sm-4 col-form-label">Name2</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="name2" id="name2" pattern="[A-Za-z[\-\] ]{2,100}" title="Only letters allowed. Minimum 2 characters and maximum 100. Special characters allowed are &quot; - &quot;">
                    </div>
                </div>
                <!-- Champ pour le deuxième prénom-->
                <div class="form-group row">
                    <label for="firstname2" class="col-sm-4 col-form-label">Firstname2</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="firstname2" id="firstname2" pattern="[A-Za-z[\-\] ]{2,30}" title="Only letters allowed. Minimum 2 characters and maximum 30. Special characters allowed are &quot; - &quot;">
                    </div>
                </div>
                <!-- Champ pour autres fonctions-->
                <div class="form-group row">
                    <label for="function2" class="col-sm-4 col-form-label">Function2</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="function2" id="function2" pattern="[A-Za-z[\-\] ]{2,100}" title="Only letters allowed. Minimum 2 characters and maximum 100. Special characters allowed are &quot; - &quot;">
                    </div>
                </div>
                <!-- Champ pour le professeur comme fondateur-->
                <div class="form-group row">
                    <label for="prof_as_founder" class="col-sm-4 col-form-label">Prof. as Founder</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="prof_as_founder" id="prof_as_founder" pattern="[a-zA-Z[\.\] ]{2,100}" title="Only letters allowed. Minimum 2 characters and maximum 100. Special characters allowed are &quot; . &quot;">
                    </div>
                </div>
                <!-- Champ pour le ratio de femmes/hommes dans la startup-->
                <div class="form-group row">
                    <label for="gender_female_ratio" class="col-sm-4 col-form-label">Gender female Ratio <small class="text-danger"> *</small></label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="gender_female_ratio" id="gender_female_ratio" pattern="[0-9[\/%\] ]{1,20}" title="Only numbers allowed. Minimum 1 characters and maximum 20. Special characters allowed are &quot; /% &quot;" required>
                    </div>
                </div>
                <!-- Champ pour le nombre de femmes dans la startup-->
                <div class="form-group row">
                    <label for="gender_female_number" class="col-sm-4 col-form-label">Gender female number <small class="text-danger"> *</small></label>
                    <div class="col-sm-6">
                    <input type="number" class="form-control" name="gender_female_number" id="gender_female_number" pattern="[0-9]{1,20}" title="Only numbers allowed. Minimum 1 characters and maximum 20." required>
                    </div>
                </div>
                <!-- Champ pour la faculté ou département où appartient la startup-->
                <div class="form-group row">
                    <label for="fac_dpt" class="col-sm-4 col-form-label">fac / dpt</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="fac_dpt" id="fac_dpt" pattern="[a-zA-Z[()\/\] ]{2,30}" title="Only letters allowed. Minimum 2 characters and maximum 30. Special characters allowed are &quot; ()/ &quot;">
                    </div>
                </div>
                <!-- Champ pour le nom du laboratoire-->
                <div class="form-group row">
                    <label for="laboratory" class="col-sm-4 col-form-label">Laboratory</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="laboratory" id="laboratory" pattern="[a-zA-Z[()\/\] ]{2,100}" title="Only letters allowed. Minimum 2 characters and maximum 100. Special characters allowed are &quot; ()/ &quot;">
                    </div>
                </div>
                <!-- Champ pour le nom du prof-->
                <div class="form-group row">
                    <label for="prof" class="col-sm-4 col-form-label">Prof.</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="prof" id="prof" pattern="[a-zA-Z[\.\] ]{2,100}" title="Only letters allowed. Minimum 2 characters and maximum 100. Special characters allowed are &quot; . &quot;">
                    </div>
                </div>
                <!-- Champ pour le s\'il y a eu des investissement en 2020-->
                <div class="form-group row">
                    <label for="investment_2020" class="col-sm-4 col-form-label">2020 investment</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="investment_2020" id="investment_2020" pattern="[A-Za-z0-9 ]{1,30}" title="Letters and numbers allowed. Minimum 1 character and maximum 30 characters.">
                    </div>
                </div>
                <!-- Champ pour le nom de l\investisseur-->
                <div class="form-group row">
                    <label for="investor_2020" class="col-sm-4 col-form-label">2020 Investor</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="investor_2020" id="investor_2020" pattern="[a-zA-Z ]{2,300}" title="Only letters allowed. Minimum 2 characters and maximum 300.">
                    </div>
                </div>
                <!-- Champ pour une description de la startup-->
                <div class="form-group row">
                    <label for="description" class="col-sm-4 col-form-label">Short description</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="description" id="description" pattern="[A-Za-z0-9[\(-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,500}" title="Letters and Numbers are accepted. Minimum 2 characters and maximum 500. The special characters accepted are : &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                    </div>
                </div>
                <!-- Champ pour une commentaire de la startup-->
                <div class="form-group row">
                    <label for="comments" class="col-sm-4 col-form-label">Comments</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="comments" id="comments" pattern="[A-Za-z0-9[\(-\+éöïçàäèüãáñâôé,()\.@#\+&=!$£?\'\/<>:;^`~\|*_\] ]{2,500}" title="Letters and Numbers are accepted. Minimum 2 characters and maximum 500. The special characters accepted are : &quot; (-+éöïçàäèüãáñâôé,().@#+&=!$£?\'/<>:;^`~|*_ &quot;">
                    </div>
                </div>
                <button class="btn btn-outline-secondary mt-5" id="submit_new_company" name="submit_new_company" type="submit">Submit</button>
            </form>
        </div>
        <script>
            
            /*
                Le but de cette partie du script est de quand l\'utilisateur clique sur le bouton, 
                si les regex ont été respectés, il va récupérer les valeurs et les écrire 
                dans la base de données.
            */
                      
            $("#submit_new_company").click(function() 
            {
                //Initialiser une variable valid à false pour tester les regex avant d\'écrire dans la base de données
                var valid="false";

                //Récuperer la valeur du champs avec l\'id company_name
                var company_name_after_check = document.getElementById("company_name").value;
                
                //Récuperer la valeur du champs avec l\'id founding_year
                var founding_year_after_check = document.getElementById("founding_year").value;
                
                //Récuperer la valeur du champs avec l\'id web
                var web_after_check = document.getElementById("web").value;  
                
                //Récuperer la valeur du champs avec l\'id rc
                var rc_after_check = document.getElementById("rc").value;
                
                //Récuperer la valeur du champs avec l\'id exit_year
                var exit_year_after_check = document.getElementById("exit_year").value;  
                
                //Récuperer la valeur du champs avec l\'id time_to_exit
                var time_to_exit_after_check = document.getElementById("time_to_exit").value; 
                
                //Récuperer la valeur du champs avec l\'id capital
                var capital_after_check = document.getElementById("capital").value;
                
                //Récuperer la valeur du champs avec l\'id investor platform
                var investor_platform_after_check = document.getElementById("investor_platform").value;
                
                //Récuperer la valeur du champs avec l\'id epfl grant
                var epfl_grant_after_check = document.getElementById("epfl_grant").value;  
                
                //Récuperer la valeur du champs avec l\'id prix hors epfl
                var prix_hors_epfl_after_check = document.getElementById("prix_hors_epfl").value;  
                
                //Récuperer la valeur du champs avec l\'id impact
                var impact_after_check = document.getElementById("impact").value; 
                
                //Récuperer la valeur du champs avec l\'id key_words
                var key_words_after_check = document.getElementById("key_words").value;  
                
                //Récuperer la valeur du champs avec l\'id ba_ma_phd_epfl
                var ba_ma_phd_epfl_after_check = document.getElementById("ba_ma_phd_epfl").value;  
                
                //Récuperer la valeur du champs avec l\'id founders_origin
                var founders_origin_after_check = document.getElementById("founders_origin").value; 
                
                //Récuperer la valeur du champs avec l\'id founders_country
                var founders_country_after_check = document.getElementById("founders_country").value;   
                
                //Récuperer la valeur du champs avec l\'id name
                var name_after_check = document.getElementById("name").value;  
                
                //Récuperer la valeur du champs avec l\'id firstname
                var firstname_after_check = document.getElementById("firstname").value;
                
                //Récuperer la valeur du champs avec l\'id function1
                var function1_after_check = document.getElementById("function1").value;
                
                //Récuperer la valeur du champs avec l\'id email1
                var email1_after_check = document.getElementById("email1").value;
                
                //Récuperer la valeur du champs avec l\'id email2
                var email2_after_check = document.getElementById("email2").value;  
                  
                //Récuperer la valeur du champs avec l\'id name2
                var name2_after_check = document.getElementById("name2").value;  
                
                //Récuperer la valeur du champs avec l\'id firstname2
                var firstname2_after_check = document.getElementById("firstname2").value;
                
                //Récuperer la valeur du champs avec l\'id function2
                var function2_after_check = document.getElementById("function2").value;

                //Récuperer la valeur du champs avec l\'id prof as founder
                var prof_as_founder_after_check = document.getElementById("prof_as_founder").value;  
                
                //Récuperer la valeur du champs avec l\'id gender_female_ratio
                var gender_female_ratio_after_check = document.getElementById("gender_female_ratio").value;  
                
                //Récuperer la valeur du champs avec l\'id gender_female_number
                var gender_female_number_after_check = document.getElementById("gender_female_number").value;  

                //Récuperer la valeur du champs avec l\'id fac_dpt
                var fac_dpt_after_check = document.getElementById("fac_dpt").value;  
                
                //Récuperer la valeur du champs avec l\'id laboratory
                var laboratory_after_check = document.getElementById("laboratory").value;
                
                //Récuperer la valeur du champs avec l\'id prof
                var prof_after_check = document.getElementById("prof").value;  
                
                //Récuperer la valeur du champs avec l\'id investment_2020
                var investment_2020_after_check = document.getElementById("investment_2020").value;  
                
                //Récuperer la valeur du champs avec l\'id investor_2020
                var investor_2020_after_check = document.getElementById("investor_2020").value;  
                
                //Récuperer la valeur du champs avec l\'id description
                var description_after_check = document.getElementById("description").value; 
                
                //Récuperer la valeur du champs avec l\'id commentaires
                var comments_after_check = document.getElementById("comments").value; 
                
                //Si les regex ont été respectées, alors il démarre l\'écriture des données dans la base de données
                
                //Mettre dans des variables les valeurs des comboboxes
                var status = document.getElementById("status").value;
                var type = document.getElementById("type").value;
                var sector = document.getElementById("sector").value;

                //Tester si toutes les regex du formulaire ont été respectées
                var resultat_form = form_add_new_company.checkValidity();
                
                //Si les regex ont été respectées
                if(resultat_form == true)
                {
                    //Il initialise la variable à true pour valider l\'écriture
                    var valid="true";
                    
                    if (valid == "true")
                    {
                        //Ecrire des données saisies par l\'utilisateur dans la base de données
                        $.ajax
                        ({
                            url:"tools/add_new_company_db.php",
                            method:"POST",
                            dataType:"text",
                            data:
                            {
                                company_name : company_name_after_check,
                                founding_year : founding_year_after_check,
                                web : web_after_check,
                                rc : rc_after_check,
                                status : status,
                                exit_year : exit_year_after_check,
                                time_to_exit : time_to_exit_after_check,
                                type : type,
                                capital : capital_after_check,
                                investor_platform : investor_platform_after_check,
                                epfl_grant : epfl_grant_after_check,
                                prix_hors_epfl : prix_hors_epfl_after_check,
                                impact : impact_after_check,
                                sector : sector,
                                key_words : key_words_after_check,
                                ba_ma_phd_epfl : ba_ma_phd_epfl_after_check,
                                founders_origin : founders_origin_after_check,
                                founders_country : founders_country_after_check,
                                name : name_after_check,
                                firstname : firstname_after_check,
                                function1 : function1_after_check,
                                email1 : email1_after_check,
                                email2 : email2_after_check,
                                name2 : name2_after_check,
                                firstname2 : firstname2_after_check,
                                function2 : function2_after_check,
                                prof_as_founder : prof_as_founder_after_check,
                                gender_female_ratio : gender_female_ratio_after_check,
                                gender_female_number : gender_female_number_after_check,
                                fac_dpt : fac_dpt_after_check,
                                laboratory : laboratory_after_check,
                                prof : prof_after_check,
                                investment_2020 : investment_2020_after_check,
                                investor_2020 : investor_2020_after_check,
                                description : description_after_check,
                                comments : comments_after_check,
                            },
                            success:function(data)
                            {
                                alert("You have added a new startup");
                                window.location.replace("add_new_company.php");
                            },
                            error:function()
                            {
                                alert("Something went wrong, please try again.");
                            }
                        });
                    }
                } 
            });
        </script>';

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