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

        //Récupérer la valeur qui correspond à l'id qui est un paramètre
        $option_data = $type_startup->get_type_of_startup_by_id($param);

        //Mettre dans une variable session la valeur déjà existante dans la db pour l'id en paramètre
        $get_type_of_startup_to_modify = $type_startup->get_type_of_startup_to_modify($param);

        if(isset($_POST['submit_btn_intermediate']))
        {
            //Cette condition permet de vérifier si un champ a été changé
            if(type_startup_data_has_been_modify($param))
            {
                //S'il y a un changement, il fait l'update
                if($type_startup->update_type_of_startup_data($_POST, $param))
                {   
                    //Texte des logs
                    $before = "type_startup : ".$get_type_of_startup_to_modify['type_startup'];
                    $after = "type_startup : ".$_POST['modify_type_of_startup'];
                    $action = "Modify type startup";
                    
                    //Ajouter les logs avec l'avant et l'après
                    add_logs($_SESSION['uniqueid'],$before,$after,$action);

                    $_SESSION['flash_message']['message'] = "The type of startup was changed";
                    $_SESSION['flash_message']['type'] = "success";
                    //header("Location: /type_startup/modify/$param");
                }
            }
        }






        //Importer le formulaire
        require_once("./pages/intermediate_tables/form_intermediate_data.html");
    }
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