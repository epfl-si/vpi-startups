<?php

require_once("tools/tequila.php");

$oClient = new TequilaClient();

//Nom du service quand le login tequila apparaît
$oClient->SetApplicationName('Gestion des startups');

//Variables demandées au serveur par rapport à la personne qui se connecte avec tequila
$oClient->SetWantedAttributes(array('uniqueid','name','firstname','unit', 'unitid', 'where', 'group'));
$oClient->SetWishedAttributes(array('email', 'title'));

//URL de redirection quand le login est bien fait
//$oClient->SetApplicationURL('/');

//Utilisateurs doivent être dans EPFL et être dans le groupe startups_read ou startups_write (permet de gérer les droits suivant l'utilsateur)
$oClient->SetCustomFilter('org=EPFL&group=startups_read|group=startups_write');

//1 jour de cookie
$oClient->SetTimeout('86400');

//Appeler la fenêtre d'authentication de Tequila
$oClient->Authenticate();

//Récupérer tous les groups où est l'utilisateur
$group  = $oClient->getValue('group');

//Permet de savoir si parmis les groupes où l'utilisateur est insérer, il est dans startups_read ou startups_write
$word = "startups_write";
if(strpos($group, $word) !== false)
{
    
    //Initialiser une variable session pour les utilisateurs read
    $_SESSION['TequilaPHPWrite'] = "TequilaPHPWritetrue";
    
    //Redirection vers la page d'acceuil pour finalisé la connexion à Tequila
    header('Location: index.php');	 
}
else
{
    //Initialiser une variable session pour les utilisateurs read
    $_SESSION['TequilaPHPRead'] = "TequilaPHPReadtrue";
    
    //Redirection vers la page d'acceuil pour finalisé la connexion à Tequila
    header('Location: index.php');
}

?>
