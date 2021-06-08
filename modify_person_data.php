<?php

//Si l'utilisateur n'a pas la session user active, alors il est redirigé vers la page de login
if(isset($_SESSION['user']))
{   
    //S'il n'appartient pas au groupe TequilaPHPWrite, alors il n'a pas le droit de regarder le contenu de cette page
    if($_SESSION['TequilaPHPWrite'] == "TequilaPHPWritetrue")
    {   
        
        //Récupérer le nom de la startup qui est en paramètre dans le site
        $id_person = $param;

        //Récupérer les données de la startup pour les afficher sur les champs
        $persons_data = $db -> query('SELECT * FROM person WHERE id_person="'.$id_person.'"');
        $person_data = $persons_data -> fetch();

        $_SESSION['person_data'] = $person_data;
        
        echo '

        <div class="container">
            <h5 class="font-weight-bold my-3"> Modify Person Data</h5>
            <small class="text-danger my-3 row col-12"> * Fields Required </small>
            <form method="post" id="form_change_person" name="form_change_person" class="form_change_person col-12 col-sm-12 col-lg-8 col-xl-8 my-5" action="'; echo '/'.$controller.'/'.$method.'/'.$param; echo'">

                <input type="hidden" id="action" name="action" value="'.$method." ".$controller.' : '.$person_data['sciper_number'].'"">
            
                <!-- Champ pour ajouter une personne lier à un numero de sciper -->
                <div class="form-group row">
                    <label for="sciper_number" class="col-sm-4 col-form-label">Sciper Number</label>
                    <div class="col-sm-6">
                        <input type="number" min="100000" max="999999" value="'.$person_data['sciper_number'].'" class="form-control" name="sciper_number" id="sciper_number" disabled>
                    </div>
                </div>
                <!-- Champ pour ajouter une personne lier à un numero de sciper -->
                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label">Name <small class="text-danger"> *</small> </label>
                    <div class="col-sm-6">
                        <input type="text" value="'.$person_data['name'].'" class="form-control" name="name" id="name" required>
                    </div>
                </div>
                <!-- Champ pour ajouter une personne lier à un numero de sciper -->
                <div class="form-group row">
                    <label for="firstname" class="col-sm-4 col-form-label">Firstname <small class="text-danger"> *</small> </label>
                    <div class="col-sm-6">
                        <input type="text" value="'.$person_data['firstname'].'" class="form-control" name="firstname" id="firstname" required>
                    </div>
                </div>
                <!-- Champ pour ajouter une personne lier à un numero de sciper -->
                <div class="form-group row">
                    <label for="person_function" class="col-sm-4 col-form-label">Person function <small class="text-danger"> *</small> </label>
                    <div class="col-sm-6">
                        <input type="text" value="'.$person_data['person_function'].'" class="form-control" name="person_function" id="person_function" required>
                    </div>
                </div>
                <!-- Champ pour ajouter une personne lier à un numero de sciper -->
                <div class="form-group row">
                    <label for="email_person" class="col-sm-4 col-form-label">Email <small class="text-danger"> *</small> </label>
                    <div class="col-sm-6">
                        <input type="email" value="'.$person_data['email'].'" class="form-control" name="email_person" id="email_person" required>
                    </div>
                </div>
                <!-- Champ pour choisir si la personne est professeur -->
                <div class="form-group row">
                    <label for="prof_as_founder" class="col-sm-4 col-form-label">Prof as founder <small class="text-danger"> *</small> </label>
                    <div class="col-sm-6">
                    <select class="form-control" class="selectpicker" data-dropup-auto="true" name="prof_as_founder" id="prof_as_founder" required>';

                        if($person_data['prof_as_founder'] == "0")
                        {
                            echo '
                            <option name="no" value="'.$person_data['prof_as_founder'].'" selected>No</option>
                            <option name="yes" value="1">Yes</option>';
                        }
                        else
                        {
                            echo ' 
                            <option name="yes" value="'.$person_data['prof_as_founder'].'" selected>Yes</option>
                            <option name="no" value="0">No</option>';
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
                      
                    if($person_data['gender'] == "0")
                    {
                        echo '
                        <option name="no" value="'.$person_data['gender'].'" selected>No</option>
                        <option name="yes" value="1">Yes</option>';
                    }
                    else
                    {
                        echo ' 
                        <option name="yes" value="'.$person_data['gender'].'" selected>Yes</option>
                        <option name="no" value="0">No</option>';
                    }

                    echo '
                    </select>
                    </div>
                </div>
                <button class="btn btn-outline-secondary mt-5" id="change_person_data" name="change_person_data" type="submit">Submit</button>
            </form>
        </div>';

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