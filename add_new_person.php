<?php

    require 'header.php';
    require 'tools/connection_db.php';
    require 'tools/logs_function.php';

    //Si l'utilisateur n'a pas la session user active, alors il est redirigé vers la page de login
    if(isset($_SESSION['user']))
    {   
        //S'il n'appartient pas au groupe TequilaPHPWrite, alors il n'a pas le droit de regarder le contenu de cette page
        if($_SESSION['TequilaPHPWrite'] == "TequilaPHPWritetrue")
        {   
            echo '
            <div class="container">
                <h5 class="font-weight-bold my-3"> Add new person</h5>
                <small class="text-danger my-3 row col-12"> * Fields Required </small>
                <form method="post" id="form_add_new_company" class="form_add_new_company col-12 col-sm-12 col-lg-8 col-xl-8 my-5" action="'; echo security_text($_SERVER["PHP_SELF"]); echo'">
                    <!-- Champ pour ajouter une personne lier à un numero de sciper -->
                    <div class="form-group row">
                        <label for="sciper_number" class="col-sm-4 col-form-label">Sciper Number <small class="text-danger"> *</small> </label>
                        <div class="col-sm-6">
                            <input type="number" min="100000" max="999999" class="form-control" name="sciper_number" id="sciper_number" required>
                        </div>
                    </div>
                    <!-- Champ pour choisir si la personne est professeur -->
                    <div class="form-group row">
                        <label for="prof_as_founder" class="col-sm-4 col-form-label">Prof as founder <small class="text-danger"> *</small> </label>
                        <div class="col-sm-6">
                        <select class="form-control" class="selectpicker" data-dropup-auto="true" name="prof_as_founder" id="prof_as_founder" required>
                            <option name="NULL" value="" disabled selected>Select an option</option>
                            <option name="yes" value="1">Yes</option>
                            <option name="no" value="0">No</option>
                        </select>
                        </div>
                    </div>
                    <!-- Champ pour choisir si la personne est un homme ou une femme -->
                    <div class="form-group row">
                        <label for="gender" class="col-sm-4 col-form-label">Gender <small class="text-danger"> *</small> </label>
                        <div class="col-sm-6">
                        <select class="form-control" class="selectpicker" data-dropup-auto="true" name="gender" id="gender" required>
                            <option name="NULL" value="" disabled selected>Select an option</option>
                            <option name="yes" value="1">Yes</option>
                            <option name="no" value="0">No</option>
                        </select>
                        </div>
                    </div>
                    <!-- Champ pour choisir une startup -->
                    <div class="form-group row">
                        <label for="startup" class="col-sm-4 col-form-label">Type of Person <small class="text-danger"> *</small> </label>
                        <div class="col-sm-6">
                        <select class="form-control" class="selectpicker" data-dropup-auto="true" name="type_of_person" id="type_of_person" required>
                            <option name="NULL" value="" disabled selected>Select a type of person</option>';
                            $type_of_person_data = $db-> query('SELECT type_of_person FROM type_of_person');
                            $data_type_of_person = $type_of_person_data -> fetchAll();
                            foreach ($data_type_of_person as $type_of_person)
                            {
                                echo '<option value="'.$type_of_person['type_of_person'].'">'.$type_of_person['type_of_person'].'</option>';
                            }
                        echo '
                        </select>
                        </div>
                    </div>
                    <button class="btn btn-outline-secondary mt-5" id="submit_new_person" name="submit_new_person" type="submit">Submit</button>
                </form>
            </div>';

            if(isset($_POST['submit_new_person']))
            {
                $sciper = (int)$_POST['sciper_number'];
                $startup = $_POST['startup'];
                $prof_as_founder = $_POST['prof_as_founder'];
                $gender = $_POST['gender'];
                $type_of_person = $_POST['type_of_person'];

                // LDAP variables
                $ldapuri = "ldap://ldap.epfl.ch:389";

                // Connecting to LDAP
                $ldapconn = ldap_connect($ldapuri)
                        or die("That LDAP-URI was not parseable");

                $dn = "o=epfl, c=CH";
                $filter="(uniqueIdentifier=$sciper)";
                $justthese = array("ou", "sn", "givenname", "mail", "title");

                $sr=ldap_search($ldapconn, $dn, $filter, $justthese);

                $info = ldap_get_entries($ldapconn, $sr);

                if($info["count"])
                {
                    $email = $info[0]["mail"][0];
                    $firstname = $info[0]["givenname"][0];
                    $name = $info[0]["sn"][0];
                    $person_function = $info[0]["title"][0];
                    
                    $persons = $db ->query('SELECT sciper_number FROM persons WHERE sciper_number = "'.$sciper.'"');
                    $person = $persons -> fetch();


                    if($person != "")
                    {
                   
                        $add_new_person = $db ->prepare('INSERT INTO person(name,firstname,person_function,email,prof_as_founder,gender,sciper_number) VALUES("'.$name.'","'.$firstname.'","'.$person_function.'","'.$email.'","'.$prof_as_founder.'","'.$gender.'","'.$sciper.'")');
                        $add_new_person -> execute();

                        //Ecrire les données dans la table logs pour dire que l'utilisateur à fait un export
                        $before = "";
                        $after = "Name : ".$name." Fistname : ".$firstname." Person Function : ".$person_function." Email : ".$email." Prof as founder : ".$prof_as_founder." Gender : ".$gender." sciper_number : ".$sciper;
                        $action="Add new person";

                        add_logs($sciper_number,$before,$after,$action);
                    }
                    else
                    {
                        echo '
                        <script> 
                            alert("The person already exist in database"); 
                        </script>
                        ';
                    }
                
                }
                else
                {
                    echo "
                    <script>
                        alert('Sciper number not found');
                    </script> ";
                }

                
                
            }
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