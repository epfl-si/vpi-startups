<?php

//Si le bouton submit a été cliqué
if(isset($_POST['submit_new_person']))
{
    //Prendre les champs du formulaire

    //Prendre le numero de sciper, en testant si c'est un int
    $sciper = (int)$_POST['sciper_number'];
    $name = security_text($_POST['name']);
    $firstname = security_text($_POST['firstname']);
    $email = security_text($_POST['email_person']);
    $person_function = security_text($_POST['person_function']);
    $prof_as_founder = $_POST['prof_as_founder'];
    $gender = $_POST['gender'];
                    
    //Prendre le numero de sciper suivant le sciper ou le nom et prenom saisis
    $persons = $db ->query('SELECT sciper_number FROM person WHERE (sciper_number = "'.$sciper.'") OR (name = "'.$name.'" AND firstname = "'.$firstname.'")');
    $person = $persons -> fetch();

    //Condition si la personne saisi existe déjà dans la base de données
    if($person == "")
    {
        //S'il n'existe pas, il l'insère dans la base de données
        $add_new_person = $db ->prepare('INSERT INTO person(name,firstname,person_function,email,prof_as_founder,gender,sciper_number) VALUES("'.$name.'","'.$firstname.'","'.$person_function.'","'.$email.'","'.$prof_as_founder.'","'.$gender.'","'.$sciper.'")');
        $add_new_person -> execute();

        //Ecrire les données dans la table logs
        $before = "";
        $after = "Name : ".$name." Fistname : ".$firstname." Person Function : ".$person_function." Email : ".$email." Prof as founder : ".$prof_as_founder." Gender : ".$gender." sciper_number : ".$sciper;
        $action="Add new person";

        add_logs($_SESSION['uniqueid'],$before,$after,$action);

        //Flash message pour avertir l'utilisateur que la personne a été ajoutée
        $_SESSION['flash_message'] = array();
        $_SESSION['flash_message']['message'] = "The person ".$firstname." ".$name." was added in database";
        $_SESSION['flash_message']['type'] = "success";

        //Rediriger l'utilisateur vers la même page pour afficher le flash message
        header("Location: /$controller/$method");
    }
    else
    {   
        //Flash message pour dire que la personne existe déjà dans la base de données
        $_SESSION['flash_message'] = array();
        $_SESSION['flash_message']['message'] = "The person already exist in database";
        $_SESSION['flash_message']['type'] = "warning";
        header("Location: /$controller/$method");
        
    }   
}

?>