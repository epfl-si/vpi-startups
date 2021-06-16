<?php

class Fund {
    
    function get_funds_by_id($id)
    {
        require './tools/connection_db.php';
        $stmt = $db->query("SELECT * FROM funding WHERE id_funding = '".$id."'");
        return $stmt->fetch();
    }

    function get_stage_of_investment()
    {
        require './tools/connection_db.php';
        $stmt = $db->query("SELECT id_stage_of_investment,stage_of_investment FROM stage_of_investment");
        return $stmt->fetchAll();
    }

    function get_stage_of_investment_by_id($id)
    {
        require './tools/connection_db.php';
        $stmt = $db->query("SELECT id_stage_of_investment FROM stage_of_investment LEFT JOIN funding ON funding.fk_stage_of_investment = stage_of_investment.id_stage_of_investment WHERE id_funding ='".$id."'");
        return $stmt->fetch();
    }

    function select_option_stage_of_investment($selected=null)
    {
        $stages = $this->get_stage_of_investment();
        foreach($stages as $stage)
        {
            $selected_stage =($stage['id_stage_of_investment'] == $selected )?"selected":"";
            $html_stage .= '<option value="'.$stage['id_stage_of_investment'].'" '.$selected_stage.'>'.$stage['stage_of_investment'].'</option>';
        }
        return $html_stage;
    }

    function get_type_of_investment()
    {
        require './tools/connection_db.php';
        $stmt = $db->query("SELECT id_type_of_investment,type_of_investment FROM type_of_investment");
        return $stmt->fetchAll();
    }

    function get_stage_of_investment_by_id_stage_of_investment($post)
    {
        require './tools/connection_db.php';
        $stmt = $db->query("SELECT stage_of_investment FROM stage_of_investment WHERE id_stage_of_investment = '".$post."'");
        return $stmt->fetch();
    }

    function get_type_of_investment_by_id_type_of_investment($post)
    {
        require './tools/connection_db.php';
        $stmt = $db->query("SELECT type_of_investment FROM type_of_investment WHERE id_type_of_investment = '".$post."'");
        return $stmt->fetch();
    }

    function get_type_of_investment_by_id($id)
    {
        require './tools/connection_db.php';
        $stmt = $db->query("SELECT id_type_of_investment FROM type_of_investment LEFT JOIN funding ON funding.fk_type_of_investment = type_of_investment.id_type_of_investment WHERE id_funding ='".$id."'");
        return $stmt->fetch();
    }

    function select_option_type_of_investment($selected=null)
    {
        $types = $this->get_type_of_investment();
        foreach($types as $type)
        {
            $selected_type =($type['id_type_of_investment'] == $selected )?"selected":"";
            $html_type .= '<option value="'.$type['id_type_of_investment'].'" '.$selected_type.'>'.$type['type_of_investment'].'</option>';
        }
        return $html_type;
    }

    function validate_funds_data($data)
    {
        return $data;
    }

    function insert_new_funds($data)
    {
        require './tools/connection_db.php';
        $data = $this->validate_funds_data($data);
        $add_new_funds = $db -> prepare("INSERT INTO funding (amount, investment_date, investors, fk_stage_of_investment, fk_type_of_investment, fk_startup) VALUES (".$data['amount'].", '".$data['investment_date']."', '".$data['investors']."', ".$data['fk_stage_of_investment'].", ".$data['fk_type_of_investment'].", ".$data['fk_startup'].")");
        $add_new_funds -> execute();
        return $data;
    }

    function update_funds($data)
    {
        require './tools/connection_db.php';
        $data = $this->validate_funds_data($data);
        $update_funds = $db -> prepare("INSERT INTO funding (amount, investment_date, investors, fk_stage_of_investment, fk_type_of_investment, fk_startup) VALUES (".$data['amount'].", '".$data['investment_date']."', '".$data['investors']."', ".$data['fk_stage_of_investment'].", ".$data['fk_type_of_investment'].", ".$data['fk_startup'].")");
        return $update_funds -> execute();
    }


}

?>