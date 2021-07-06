<?php

class Intermediate_data
{
    //Fonction pour mettre les données de la table intermediaire choisie dans une variable de SESSION pour ensuite vérifier si les données ont été changés
    function get_data_to_modify($id, $controller)
    {
        require './tools/connection_db.php';
        $stmt = $db->query("SELECT * FROM $controller WHERE id_$controller = '".$id."'");
        $intermediate_data=$stmt->fetch();
        $_SESSION["data_$controller"] = $intermediate_data;
        return $_SESSION["data_$controller"];
    }

    //Fonction pour obtenir les données de la table intermediaire choisie par rapport à son id
    function get_data_by_id($id, $controller)
    {
        require './tools/connection_db.php';
        $stmt = $db->query("SELECT $controller FROM $controller WHERE id_$controller = '".$id."'");
        $intermediate_data=$stmt->fetch();
        return $intermediate_data["$controller"];
    }

    //Fonction pour valider les données reçues des formulaires
    function validate_data($data)
    {
        return $data;
    }

    //Fonction pour insérer une nouvelle donnée 
    function insert_new_data($data, $controller)
    {
        require './tools/connection_db.php';
        $data = $this->validate_data($data);
        $add_new_data = $db -> prepare("INSERT INTO $controller ($controller) VALUES ('".$data["add_new_$controller"]."')");
        $add_new_data -> execute();
        return $data;
    }

    //Fonction pour faire l'update de données dans une table intermediaire
    function update_data($data, $id, $controller)
    {
        require './tools/connection_db.php';
        $data = $this->validate_data($data);
        $update_data = $db -> prepare("UPDATE $controller SET $controller = '".$data["modify_$controller"]."' WHERE id_$controller ='".$id."'");
        $update_data -> execute();
        return $data;
    }
    
}

?>