<?php

//Importer les fichiers
require './classes/class.type_of_startup.php';

//Ajouter une nouvelle donnée
if($method=="add")
{
    //Ajouter un nouveau type de startup
    if($controller == "type_startup")
    {
        //Faire appel à la classe fund
        $type_startup = new Type_of_startup();

        //Donner un titre au formulaire qui correspond 
        $option_type_of_form = "Add New ";
        $option_title = "Type of Startup";
        $option_name_post = "add_new_type_of_startup";

        //Si le bouton submit a été cliqué
        if(isset($_POST['submit_btn_intermediate']))
        {
            //Il fait appel à la fonction pour insérer les nouvelles données. En paramètre, il a tout les données du formulaire passées en POST
            if($type_startup->insert_new_type_of_startup_data($_POST))
            {
                //Texte pour le log
                $after = "type_startup : ".$_POST['add_new_type_of_startup'];
                $action = "Add new type of startup";

                //Additionner le log à la base de données (le before est vide car pour un ajout, il n'y a pas d'avant)
                add_logs($_SESSION['uniqueid'],"",$after,$action);

                //Flash message pour dire que le fond a été ajouté à la base de données
                $_SESSION['flash_message']['message'] = "The type of startup was added";
                $_SESSION['flash_message']['type'] = "success";

                //Rediriger l'utilisateur vers la même page pour qu'il puisse voir le flash message
                //header("Location: /type_startup/add");

            }
            
        }

        //Importer le formulaire
        require_once("./pages/intermediate_tables/form_intermediate_data.html");
    }
}
//Modifier un fond si la méthode est égale à modify
elseif($method=="modify" && is_numeric($param) && !empty($param))
{
    if($controller == "type_startup")
    {
        //Faire appel à la classe fund
        $type_startup = new Type_of_startup();

        //Donner un titre au formulaire qui correspond 
        $option_type_of_form = "Modify ";
        $option_title = "Type of Startup";
        $option_name_post = "modify_type_of_startup";
    }
    
    /* //Cette partie correspond à l'affichage des données sur les champs du formulaire
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
        //Cette condition permet de vérifier si un champ a été changé
        if(funds_data_has_been_modify($param))
        {
            //S'il y a un changement, il fait l'update
            if($fund->update_funds($_POST, $param))
            {   
                //Changer les id par leurs noms pour l'avant dans les logs
                $type_of_investment_before= $fund->get_type_of_investment_by_id_type_of_investment($get_all_funds_by_id['fk_type_of_investment']);
                $stage_of_investment_before= $fund->get_stage_of_investment_by_id_stage_of_investment($get_all_funds_by_id['fk_stage_of_investment']);
                $startup_name_before= $startup->get_startup_by_id_startup($get_all_funds_by_id['fk_startup']);
                
                //Changer les id par leurs noms pour l'après dans les logs
                $type_of_investment_after= $fund->get_type_of_investment_by_id_type_of_investment($_POST['fk_type_of_investment']);
                $stage_of_investment_after= $fund->get_stage_of_investment_by_id_stage_of_investment($_POST['fk_stage_of_investment']);
                $startup_name_after= $startup->get_startup_by_id_startup($_POST['fk_startup']);
    
                //Texte des logs
                $before = "amount : ".$get_all_funds_by_id['amount'].", investment date : ".$get_all_funds_by_id['investment_date'].", investors : ".$get_all_funds_by_id['investors'].", stage of investment : ".$stage_of_investment_before['stage_of_investment'].", type_of_investment : ".$type_of_investment_before['type_of_investment'].", startup : ".$startup_name_before['company'];
                $after = "amount : ".$_POST['amount'].", investment date : ".$_POST['investment_date'].", investors : ".$_POST['investors'].", stage of investment : ".$stage_of_investment_after['stage_of_investment'].", type_of_investment : ".$type_of_investment_after['type_of_investment'].", startup : ".$startup_name_after['company'];
                $action = "Modify fund";
                
                //Ajouter les logs avec l'avant et l'après
                add_logs($_SESSION['uniqueid'],$before,$after,$action);

                $_SESSION['flash_message']['message'] = "The fund was changed to startup : ".$startup_name_after['company'];
                $_SESSION['flash_message']['type'] = "success";
                header("Location: /funds/modify/$param");
            }
        }
    }
    
    require_once("./pages/funds/form_funds.html"); */

}

//S'il n'y pas de methode, alors il affiche le tableau avec tous les fonds de toutes les startups
elseif($method=="modify")
{
    require 'pages/intermediate_tables/intermediate_display_table.php';

    if($controller == "type_startup")
    {
        $filename_queries_db = "type_startup_db.php";
        $type_data = "type_startup";

        intermediate_table($filename_queries_db, $type_data);
    }

    /*
    Condition qui permet de vérifier si l'utisateur a cliquer sur le bouton d'exporter les fonds. 
    Si la variable est initialisée, il n'importe pas le tableau et permet de télécharger seulement les données de la base de données et va supprimer la variable pour permettre aux utilisateur de voir le tableau des fonds.
    Si la variable n'est pas initialisé, il affiche le tableau avec les fonds (cela veut dire que l'utilisateur n'a pas cliqué sur le bouton export funds)
    */
    /* if(!isset($_SESSION['export_funds']))
    {
        require 'pages/funds/funds_table.php';

        //Il affiche le tableau si les utilisateurs ont le droit d'écriture sur le site
        if($_SESSION['TequilaPHPWrite'] == "TequilaPHPWritetrue")
        {
            //Faire appel à la fonction qui fait et affiche le tableau, en ne passant rien comme id
            funds_table($id_startup = "none");
        }
    }
    else
    {
        //Supprimer la varaible de SESSION pour l'export des fonds
        unset($_SESSION['export_funds']);
    } 
 */
}
?>