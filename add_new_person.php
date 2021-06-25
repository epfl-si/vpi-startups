<?php

      
//S'il n'appartient pas au groupe TequilaPHPWrite, alors il n'a pas le droit de regarder le contenu de cette page
if($_SESSION['TequilaPHPWrite'] == "TequilaPHPWritetrue")
{   
    echo '
    <div class="container">
        <form method="post" id="form_add_new_company" class="form_add_new_company col-12 col-sm-12 col-lg-8 col-xl-8 mx-auto" action="'; echo '/'.$controller.'/'.$method; echo'">
            <!-- Champ pour ajouter une personne lier à un numero de sciper -->
            <legend class="font-weight-bold my-3"> Add new person</legend>
            <small class="text-danger my-3 row col-12"> * Fields Required </small>
            <div class="form-group row">
                <label for="sciper_number" class="col-sm-4 col-form-label">Sciper Number</label>
                <div class="col-sm-6">
                    <input type="number" min="100000" max="999999" class="form-control" name="sciper_number" onchange="get_data()" id="sciper_number">
                </div>
            </div>
            <!-- Champ pour ajouter un nom -->
            <div class="form-group row">
                <label for="name" class="col-sm-4 col-form-label">Name <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>
            </div>
            <!-- Champ pour ajouter un prénom -->
            <div class="form-group row">
                <label for="firstname" class="col-sm-4 col-form-label">Firstname <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="firstname" id="firstname" required>
                </div>
            </div>
            <!-- Champ pour ajouter une fonction -->
            <div class="form-group row">
                <label for="person_function" class="col-sm-4 col-form-label">Person function <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="person_function" id="person_function" required>
                </div>
            </div>
            <!-- Champ pour ajouter un email -->
            <div class="form-group row">
                <label for="email_person" class="col-sm-4 col-form-label">Email <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                    <input type="email" class="form-control" name="email_person" id="email_person" required>
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
            <!-- 0 = Homme ; 1 = Femme -->
            <div class="form-group row">
                <label for="gender" class="col-sm-4 col-form-label">Gender <small class="text-danger"> *</small> </label>
                <div class="col-sm-6">
                <select class="form-control" class="selectpicker" data-dropup-auto="true" name="gender" id="gender" required>
                    <option name="NULL" value="" disabled selected>Select an option</option>
                    <option name="yes" value="1">Woman</option>
                    <option name="no" value="0">Man</option>
                </select>
                </div>
            </div>
            <button class="btn btn-outline-secondary my-5" id="submit_new_person" name="submit_new_person" type="submit">Submit</button>
        </form>
    </div>
    
    <script>

    //Fonction pour prendre le sciper saisi par l\'utilisateur et remplir les champs avec ce qui dans LDAP
    function get_data()
    {
        //Récupérer le sciper saisi
        var sciper = document.getElementById("sciper_number").value;

        //Prendre, avec ajax, les données nécessaires de l\'utilisateur pour remplir les champs
        $.ajax
        ({  
            //Chemin vers la page qui contient les requêtes SQL
            url:"/tools/get_data_from_ldap.php",
            method:"POST",
            dataType:"JSON",
            data: 
            {
                //Envoyer le sciper à la page PHP ci-dessus
                sciper : sciper,
            },
            //Si tout s\'est bien passé, il remplit les champs avec les données de l\'utilisateur
            success:function(data)
            {
                //Données récupérer de LDAP
                document.getElementById("name").value = data[0]["name"];
                document.getElementById("firstname").value = data[0]["firstname"];
                document.getElementById("email_person").value = data[0]["email"];
                document.getElementById("person_function").value = data[0]["person_function"];
            },
            error:function()
            {
                //Pop-up d\'avertissement si le sciper n\'existe pas
                alert("The sciper doesn\'t exist");
            }
        });
    }

    </script>';
}

//Condition pour empêcher les utilisateurs qui n'ont pas le droit d'accéder à cette page
elseif($_SESSION['TequilaPHPRead'] == "TequilaPHPReadtrue")
{

    //Flash message avec un message d'erreur
    $_SESSION['flash_message'] = array();
    $_SESSION['flash_message']['message'] = "You don't have enough rights to access this page.";
    $_SESSION['flash_message']['type'] = "warning";
    header('Location: /');
    exit;
}


?>