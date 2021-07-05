<?php

class Type_of_startup
{
    function get_all_type_of_startup()
    {
        require './tools/connection_db.php';
        $stmt = $db->query("SELECT * FROM type_startup");
        $type_startup=$stmt->fetchAll();
        return $type_startup;
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

  /*   function get_startup_by_id($id)
    {
        $found=array_filter($this->startups, function ($var) use ($id){
            return ($var['id_startup'] == $id);
        });
        return $found[0];
   
    }

    function get_startup_by_id_funding($id)
    {
        require './tools/connection_db.php';
        $stmt = $db->query("SELECT id_startup FROM startup LEFT JOIN funding ON startup.id_startup = funding.fk_startup WHERE id_funding = '".$id."'");
        return $stmt->fetch();
   
    }

    function select_all_startups($selected=null)
    {
        $startups = $this->get_all_startup();
        foreach($startups as $startup)
        {
            $selected_startup =($startup['id_startup'] == $selected )?"selected":"";
            $html_startup .= '<option value="'.$startup['id_startup'].'" '.$selected_startup.'>'.$startup['company'].'</option>';
        }
        return $html_startup;
    }

    function get_startup_by_id_startup($post)
    {
        require './tools/connection_db.php';
        $stmt = $db->query("SELECT company FROM startup WHERE id_startup = '".$post."'");
        return $stmt->fetch();
    } */
    

    
}

?>