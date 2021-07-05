<?php

class Intermediate_data
{
    function get_data_to_modify($id, $controller)
    {
        require './tools/connection_db.php';
        $stmt = $db->query("SELECT * FROM $controller WHERE id_$controller = '".$id."'");
        $intermediate_data=$stmt->fetch();
        $_SESSION["data_$controller"] = $intermediate_data;
        return $_SESSION["data_$controller"];
    }

    function get_data_by_id($id, $controller)
    {
        require './tools/connection_db.php';
        $stmt = $db->query("SELECT $controller FROM $controller WHERE id_$controller = '".$id."'");
        $intermediate_data=$stmt->fetch();
        return $intermediate_data["$controller"];
    }

    function validate_data($data)
    {
        return $data;
    }

    function insert_new_data($data, $controller)
    {
        require './tools/connection_db.php';
        $data = $this->validate_data($data);
        $add_new_data = $db -> prepare("INSERT INTO $controller ($controller) VALUES ('".$data["add_new_$controller"]."')");
        $add_new_data -> execute();
        return $data;
    }

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