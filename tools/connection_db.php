<?php

require 'env.php';

//Permet de faire se connecter à la base de données pour faire les requêtes
$db_name=getenv("DB_NAME");
$servername = getenv("DB_HOST");
$username = getenv("DB_USERNAME");
$port = getenv("DB_PORT");
$password = getenv("DB_PASSWORD");


//Si la connexion n'est pas réussie, alors il affiche un message de connection failed
try 
{
  $db = new PDO("mysql:host=$servername;port=$port;dbname=$db_name;charset=utf8", $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch(PDOException $e) 
{
  echo "Connection failed: " . $e->getMessage();
}

?>