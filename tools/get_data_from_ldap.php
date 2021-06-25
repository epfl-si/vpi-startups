<?php

//Prendre le numero de sciper
$sciper = (int)$_POST['sciper'];

// LDAP serveur de l'EPFL
$ldapuri = "ldap://ldap.epfl.ch:389";

// Connexion à LDAP
$ldapconn = ldap_connect($ldapuri) or die("That LDAP-URI was not parseable");

//Distinguished name
$dn = "o=epfl, c=CH";

//Filtre pour prendre les données de seulement le numero sciper spécifique
$filter="(uniqueIdentifier=$sciper)";

//Prendre seulement l'OU, le SN (nom), le givenname(prénom), le mail, le title(fonction à l'EPFL) du numéro de sciper
$justthese = array("ou", "sn", "givenname", "mail", "title");

//Faire la recherche dans LDAP, en passant les paramètres nécessaires 
$sr=ldap_search($ldapconn, $dn, $filter, $justthese);

//Prendre les données obtenues
$info = ldap_get_entries($ldapconn, $sr);

//Condition pour vérifier s'il a trouvé quelque chose
if($info["count"])
{
    //Prendre les données du serveur LDAP 
    $email = $info[0]["mail"][0];
    $firstname = $info[0]["givenname"][0];
    $name = $info[0]["sn"][0];
    
    //Condition pour vérifier si existe la fonction de la personne
    if(isset($info[0]["title"][0]))
    {
        $person_function = $info[0]["title"][0];
    }
    else
    {
        $person_function = "";
    }
    
    //Mettre toutes les données dans un array
    $output[] = array 
    (
        'name'=> $name,
        'firstname'=> $firstname,
        'email'=> $email,
        'person_function'=> $person_function,

    );

    //Envoyer les données
    echo json_encode($output);
}


?>
