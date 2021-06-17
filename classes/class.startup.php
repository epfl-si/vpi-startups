<?php


class Startup
{
    public $startups;
    function get_all_startup()
    {
        require './tools/connection_db.php';
        $stmt = $db->query("SELECT * FROM startup");
        $this->startups=$stmt->fetchAll();
        return $this->startups;
    }

    function get_startup_by_id($id)
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
    }
    

    
}


?>