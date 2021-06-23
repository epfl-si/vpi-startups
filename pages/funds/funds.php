<?php

//Importer les fichiers
require './classes/class.fund.php';
require './classes/class.startup.php';

/*Fonction pour ajouter des fonds. Dans les paramètres de la fonction il y a :
* $startup = Faire appel à la classe startup
* $option_startup = Ce qui va être affiché sur le form 
* $method = Quelle est la méthode sur l'url
* $param = Quel est le paramètre dans l'url (Par défaut il est vide)
*/
function add_funds($startup, $option_startup, $method, $param="")
{
    //Permet de prendre la date du jour et la mettre comme date par défaut dans le formulaire
    $investment_date=date("Y-m-d");

    //Faire appel à la classe fund
    $fund = new Fund();

    //Selectionner les stages et types d'investissement pour les afficher dans le formulaire
    $option_stage_of_investment = $fund->select_option_stage_of_investment();
    $option_type_of_investment = $fund->select_option_type_of_investment();

    //Si le bouton submit a été cliqué
    if(isset($_POST['submit_btn_funds']))
    {
        //Il fait appel à la fonction pour insérer les nouvelles données. En paramètre, il a tout les données du formulaire passées en POST
        if($fund->insert_new_funds($_POST))
        {
            //Remplacer les id par leurs noms
            $type_of_investment = $fund->get_type_of_investment_by_id_type_of_investment($_POST['fk_type_of_investment']);
            $stage_of_investment = $fund->get_stage_of_investment_by_id_stage_of_investment($_POST['fk_stage_of_investment']);
            $startup_name = $startup->get_startup_by_id_startup($_POST['fk_startup']);

            //Texte pour le log
            $after = "amount : ".$_POST['amount'].", investment date : ".$_POST['investment_date'].", investors : ".$_POST['investors'].", stage of investment : ".$stage_of_investment['stage_of_investment'].", type_of_investment : ".$type_of_investment['type_of_investment'].", startup : ".$startup_name['company'];
            $action = "Add new fund";

            //Additionner le log à la base de données (le before est vide car pour un ajout, il n'y a pas d'avant)
            add_logs($_SESSION['uniqueid'],"",$after,$action); 

            //Flash message pour dire que le fond a été ajouté à la base de données

            if($param != "")
            {
                $_SESSION['flash_message']['message'] = "The fund was added to startup : ".$startup_name['company'];
                $_SESSION['flash_message']['type'] = "success";
            }
            else
            {
                $_SESSION['flash_message']['message'] = "The fund was added";
                $_SESSION['flash_message']['type'] = "success";
            }

            //Rediriger l'utilisateur vers la même page pour qu'il puisse voir le flash message
            header("Location: /funds/add/$param");

        }
        
    }

    //Importer le formulaire
    require_once("./pages/funds/form_funds.html");
}

//Condition pour vérifier s'il y a un id sur l'url
if($method == "add" && is_numeric($param) && !empty($param))
{
    //Ajouter un fond lier à la startup
    $startup = new Startup();
    $option_startup = $startup->select_all_startups($param);

    add_funds($startup, $option_startup, $method, $param);
    
}

//Ajouter un fond s'il n'y a pas d'id sur l'url
elseif($method=="add")
{

    $startup = new Startup();
    $option_startup = $startup->select_all_startups();

    add_funds($startup, $option_startup, $method);
    
}

//Modifier un fond si la méthode est égale à modify
elseif($method=="modify")
{
    //Cette partie correspond à l'affichage des données sur les champs du formulaire
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
    
    require_once("./pages/funds/form_funds.html");

}

//S'il n'y pas de methode, alors il affiche le tableau avec tous les fonds de toutes les startups
else
{
    require 'pages/funds/funds_table.php';

    //Il affiche le tableau si les utilisateurs ont le droit d'écriture sur le site
    if($_SESSION['TequilaPHPWrite'] == "TequilaPHPWritetrue")
    {
        //Faire appel à la fonction qui fait et affiche le tableau, en ne passant rien comme id
        funds_table($id_startup = "none");
    }

}
?>