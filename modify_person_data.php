<?php

  
//S'il n'appartient pas au groupe TequilaPHPWrite, alors il n'a pas le droit de regarder le contenu de cette page
if($_SESSION['TequilaPHPWrite'] == "TequilaPHPWritetrue")
{   
    
    //Récupérer le nom de la startup qui est en paramètre sur l'url du site
    $id_person = $param;

    //Récupérer les données de la startup pour les afficher sur les champs
    $persons_data = $db -> query('SELECT * FROM person WHERE id_person="'.$id_person.'"');
    $person_data = $persons_data -> fetch();

    //Enregistrer ce qui est dans la base de données pour l'id de personne dans une variable SESSION PHP
    $_SESSION['person_data'] = $person_data;
    
    echo '

    <div class="container">
        <form method="post" id="form_change_person" name="form_change_person" class="form_change_person col-12 col-sm-12 col-lg-8 col-xl-8 mx-auto" action="'; echo '/'.$controller.'/'.$method.'/'.$param; echo'">
            <legend class="font-weight-bold my-3"> Modify Person Data</legend>
            <small class="text-danger my-3 row col-12"> * Fields Required </small>
            <input type="hidden" id="action" name="action" value="'.$method." ".$controller.' : '.$person_data['sciper_number'].'"">
        
            <!-- Numero de sciper -->
            <div class="form-group row">
                <label for="sciper_number" class="col-sm-4 col-form-label">Sciper Number</label>
                <div class="col-sm-6">
                    <input type="number" min="100000" max="999999" value="'.$person_data['sciper_number'].'" class="form-control" name="sciper_number" id="sciper_number" disabled>
                </div>
            </div>
            <!-- Nom -->
            <div class="form-group row">
                <label for="name" class="col-sm-4 col-form-label">Name <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                    <input type="text" value="'.$person_data['name'].'" class="form-control" name="name" id="name" required>
                </div>
            </div>
            <!-- Prénom -->
            <div class="form-group row">
                <label for="firstname" class="col-sm-4 col-form-label">Firstname <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                    <input type="text" value="'.$person_data['firstname'].'" class="form-control" name="firstname" id="firstname" required>
                </div>
            </div>
            <!-- Fonction de la personne -->
            <div class="form-group row">
                <label for="person_function" class="col-sm-4 col-form-label">Person function <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                    <input type="text" value="'.$person_data['person_function'].'" class="form-control" name="person_function" id="person_function" required>
                </div>
            </div>
            <!-- Email -->
            <div class="form-group row">
                <label for="email_person" class="col-sm-4 col-form-label">Email <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                    <input type="email" value="'.$person_data['email'].'" class="form-control" name="email_person" id="email_person" required>
                </div>
            </div>
            <!-- Champ pour choisir si la personne est professeure -->
            <div class="form-group row">
                <label for="prof_as_founder" class="col-sm-4 col-form-label">Prof as founder <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                <select class="form-control" class="selectpicker" data-dropup-auto="true" name="prof_as_founder" id="prof_as_founder" required>';
                    
                    //Condition pour selectionner d'abord si la personne est un professeur fondateur et ensuite laisser l'utilisateur le modifier
                    if($person_data['prof_as_founder'] == "no")
                    {
                        echo '
                        <option name="no" value="'.$person_data['prof_as_founder'].'" selected>No</option>
                        <option name="yes" value="yes">Yes</option>';
                    }
                    else
                    {
                        echo ' 
                        <option name="yes" value="'.$person_data['prof_as_founder'].'" selected>Yes</option>
                        <option name="no" value="no">No</option>';
                    }

                    echo '
                </select>
                </div>
            </div>
            <!-- Champ pour choisir si la personne est un homme ou une femme -->
            <div class="form-group row">
                <label for="gender" class="col-sm-4 col-form-label">Gender <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                <select class="form-control" class="selectpicker" data-dropup-auto="true" name="gender" id="gender" required>';

                //Condition pour selectionner d'abord le genre de la personne et ensuite laisser l'utilisateur le modifier
                if($person_data['gender'] == "man")
                {
                    echo '
                    <option name="no" value="'.$person_data['gender'].'" selected>Man</option>
                    <option name="yes" value="woman">Women</option>';
                }
                else
                {
                    echo ' 
                    <option name="yes" value="'.$person_data['gender'].'" selected>Woman</option>
                    <option name="no" value="man">Man</option>';
                }

                echo '
                </select>
                </div>
            </div>
            <button class="btn btn-outline-secondary my-5" id="change_person_data" name="change_person_data" type="submit">Submit</button>
        </form>
    </div>';

    require 'tools/disconnection_db.php';
    require 'footer.php';
}

//Si l'utilisateur n'a pas le droit d'écriture
elseif($_SESSION['TequilaPHPRead'] == "TequilaPHPReadtrue")
{
    //Un flash message est affiché
    $_SESSION['flash_message'] = array();
    $_SESSION['flash_message']['message'] = "You don't have enough rights to access this page";
    $_SESSION['flash_message']['type'] = "warning";
    header('Location: /');
}




?>