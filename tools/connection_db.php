<?php

//Importer la page qui contient les données pour la connection à la base de données
require 'env.php';

//Permet de se connecter à la base de données, en prennant les variables d'environnement
$db_name=getenv("DB_NAME");
$servername = getenv("DB_HOST");
$username = getenv("DB_USERNAME");
$port = getenv("DB_PORT");
$password = getenv("DB_PASSWORD");


//Si la connexion n'est pas réussie, alors il affiche un message de connection failed
try 
{
  //Connection PHP à la base de données avec la méthode PDO
  $db = new PDO("mysql:host=$servername;port=$port;dbname=$db_name;charset=utf8mb4", $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch(PDOException $e) 
{
  echo "Connection failed: " . $e->getMessage();
}

?>
