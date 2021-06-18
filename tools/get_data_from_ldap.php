<?php

$sciper = (int)$_POST['sciper'];

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
    
    if(isset($info[0]["title"][0]))
    {
        $person_function = $info[0]["title"][0];
    }
    else
    {
        $person_function = "";
    }
    
    $output[] = array 
    (
        'name'=> $name,
        'firstname'=> $firstname,
        'email'=> $email,
        'person_function'=> $person_function,

    );
    echo json_encode($output);
}


?>
