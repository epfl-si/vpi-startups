<?php

class Type_of_startup
{
    
    function get_type_of_startup_to_modify($id)
    {
        require './tools/connection_db.php';
        $stmt = $db->query("SELECT * FROM type_startup WHERE id_type_startup = '".$id."'");
        $type_startup=$stmt->fetch();
        $_SESSION['type_startup_data'] = $type_startup;
        return $_SESSION['type_startup_data'];
    }

    function get_type_of_startup_by_id($id)
    {
        require './tools/connection_db.php';
        $stmt = $db->query("SELECT type_startup FROM type_startup WHERE id_type_startup = '".$id."'");
        $type_startup=$stmt->fetch();
        return $type_startup['type_startup'];
    }

    function validate_type_of_startup_data($data)
    {
        return $data;
    }

    function insert_new_type_of_startup_data($data)
    {
        require './tools/connection_db.php';
        $data = $this->validate_type_of_startup_data($data);
        $add_new_type_of_startup = $db -> prepare("INSERT INTO type_startup (type_startup) VALUES ('".$data['add_new_type_of_startup']."')");
        $add_new_type_of_startup -> execute();
        return $data;
    }

    function update_type_of_startup_data($data, $id)
    {
        require './tools/connection_db.php';
        $data = $this->validate_type_of_startup_data($data);
        $update_type_of_startup = $db -> prepare("UPDATE type_startup SET type_startup = '".$data['modify_type_of_startup']."' WHERE id_type_startup ='".$id."'");
        $update_type_of_startup -> execute();
        return $data;
    }
    
}

?>