<?php

require './classes/class.fund.php';
require './classes/class.startup.php';

if($method == "add" && is_numeric($param) && !empty($param))
{
    $investment_date=date("Y-m-d");
    $fund = new Fund();
    $option_stage_of_investment = $fund->select_option_stage_of_investment();
    $option_type_of_investment = $fund->select_option_type_of_investment();

    $startup = new Startup();
    $option_startup = $startup->select_all_startups($param);

    require_once("./pages/funds/form_funds.html");
}
elseif($method=="add")
{
    $fund = new Fund();
    $option_stage_of_investment = $fund->select_option_stage_of_investment();
    $option_type_of_investment = $fund->select_option_type_of_investment();

    $startup = new Startup();
    $option_startup = $startup->select_all_startups();
    $investment_date=date("Y-m-d");
    if(isset($_POST['submit_btn_funds']))
    {
        if($fund->insert_new_funds($_POST))
        {
            $type_of_investment = $fund->get_type_of_investment_by_id_type_of_investment($_POST['fk_type_of_investment']);
            $stage_of_investment = $fund->get_stage_of_investment_by_id_stage_of_investment($_POST['fk_stage_of_investment']);
            $startup_name = $startup->get_startup_by_id_startup($_POST['fk_startup']);

            $after = "amount : ".$_POST['amount'].", investment date : ".$_POST['investment_date'].", investors : ".$_POST['investors'].", stage of investment : ".$stage_of_investment['stage_of_investment'].", type_of_investment : ".$type_of_investment['type_of_investment'].", startup : ".$startup_name['company'];
            $action = "Add new fund";

            add_logs($_SESSION['uniqueid'],"",$after,$action); 

            $_SESSION['flash_message']['message'] = "The fund was added to startup : ".$startup->get_startup_by_id($_POST['fk_startup'])['company'];
            $_SESSION['flash_message']['type'] = "success";
            header('Location: /funds/add');

        }
        
    }
    require_once("./pages/funds/form_funds.html");
}
elseif($method=="modify")
{
    
    $fund = new Fund();
    $get_funds_by_id = $fund->get_funds_by_id($param);
    $amount = $get_funds_by_id['amount'];
    $investment_date = $get_funds_by_id['investment_date'];
    $investors = $get_funds_by_id['investors'];

    $id_stage_of_investment = $fund->get_stage_of_investment_by_id($param);
    $option_stage_of_investment = $fund->select_option_stage_of_investment($id_stage_of_investment['id_stage_of_investment']);

    $id_type_of_investment = $fund->get_type_of_investment_by_id($param);
    $option_type_of_investment = $fund->select_option_type_of_investment($id_type_of_investment['id_type_of_investment']);
   
    $startup = new Startup();
    $get_startup_id = $startup->get_startup_by_id_funding($param);
    $option_startup = $startup->select_all_startups($get_startup_id['id_startup']);
    $get_all_funds_by_id = $fund->get_funds_to_modify($param);

    if(isset($_POST['submit_btn_funds']))
    {
        if(funds_data_has_been_modify($param))
        {
            if($fund->update_funds($_POST, $param))
            {   
                $type_of_investment_before= $fund->get_type_of_investment_by_id_type_of_investment($get_all_funds_by_id['fk_type_of_investment']);
                $stage_of_investment_before= $fund->get_stage_of_investment_by_id_stage_of_investment($get_all_funds_by_id['fk_stage_of_investment']);
                $startup_name_before= $startup->get_startup_by_id_startup($get_all_funds_by_id['fk_startup']);
                
                $type_of_investment_after= $fund->get_type_of_investment_by_id_type_of_investment($_POST['fk_type_of_investment']);
                $stage_of_investment_after= $fund->get_stage_of_investment_by_id_stage_of_investment($_POST['fk_stage_of_investment']);
                $startup_name_after= $startup->get_startup_by_id_startup($_POST['fk_startup']);
    
                $before = "amount : ".$get_all_funds_by_id['amount'].", investment date : ".$get_all_funds_by_id['investment_date'].", investors : ".$get_all_funds_by_id['investors'].", stage of investment : ".$stage_of_investment_before['stage_of_investment'].", type_of_investment : ".$type_of_investment_before['type_of_investment'].", startup : ".$startup_name_before['company'];
                $after = "amount : ".$_POST['amount'].", investment date : ".$_POST['investment_date'].", investors : ".$_POST['investors'].", stage of investment : ".$stage_of_investment_after['stage_of_investment'].", type_of_investment : ".$type_of_investment_after['type_of_investment'].", startup : ".$startup_name_after['company'];
                $action = "Modify fund";
    
                add_logs($_SESSION['uniqueid'],$before,$after,$action);

                $_SESSION['flash_message']['message'] = "The fund was changed to startup : ".$startup_name_after['company'];
                $_SESSION['flash_message']['type'] = "success";
                header("Location: /funds/modify/$param");
            }
        }
    }
    
    require_once("./pages/funds/form_funds.html");

}
else
{
    require 'pages/funds/funds_table.php';
    //Il affiche le menu aux utilisateurs qui ont le droit d'écrire
    if($_SESSION['TequilaPHPWrite'] == "TequilaPHPWritetrue")
    {
        funds_table($id_startup = "none");
    }

}
?>