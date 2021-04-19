<?php


//Détruire la session, le cookie de la session et ses variables
session_start();

// Unset toutes les variables de session
$_SESSION = array();

// Détruire la le cookie de session
if (ini_get("session.use_cookies")) 
{
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruire la session
session_destroy();


//Logout de tequila
require_once ("tools/tequila.php");
$oClient = new TequilaClient();
$oClient-> Logout ($redirectUrl=$_SERVER['HTTP_REFERER']);



?>