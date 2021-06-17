<?php

if(isset($_POST['submit_new_person']))
{
    $sciper = (int)$_POST['sciper_number'];
    $name = security_text($_POST['name']);
    $firstname = security_text($_POST['firstname']);
    $email = security_text($_POST['email_person']);
    $person_function = security_text($_POST['person_function']);
    $prof_as_founder = $_POST['prof_as_founder'];
    $gender = $_POST['gender'];

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
        $persons = $db ->query('SELECT sciper_number FROM person WHERE sciper_number = "'.$sciper.'"');
        $person = $persons -> fetch();

        if($person == "")
        {
            $add_new_person = $db ->prepare('INSERT INTO person(name,firstname,person_function,email,prof_as_founder,gender,sciper_number) VALUES("'.$name.'","'.$firstname.'","'.$person_function.'","'.$email.'","'.$prof_as_founder.'","'.$gender.'","'.$sciper.'")');
            $add_new_person -> execute();

            //Ecrire les données dans la table logs pour dire que l'utilisateur à fait un export
            $before = "";
            $after = "Name : ".$name." Fistname : ".$firstname." Person Function : ".$person_function." Email : ".$email." Prof as founder : ".$prof_as_founder." Gender : ".$gender." sciper_number : ".$sciper;
            $action="Add new person";

            add_logs($_SESSION['uniqueid'],$before,$after,$action);

            $_SESSION['flash_message'] = array();
            $_SESSION['flash_message']['message'] = "The person ".$firstname." ".$name." was added in database";
            $_SESSION['flash_message']['type'] = "success";
            header("Location: /$controller/$method");
        }
        else
        {   
            $_SESSION['flash_message'] = array();
            $_SESSION['flash_message']['message'] = "The person already exist in database";
            $_SESSION['flash_message']['type'] = "warning";
            header("Location: /$controller/$method");
            
        }

    }
    else
    {

        $_SESSION['flash_message'] = array();
        $_SESSION['flash_message']['message'] = "Sciper number not found";
        $_SESSION['flash_message']['type'] = "warning";
        header("Location: /$controller/$method");
    }


    
}


?>