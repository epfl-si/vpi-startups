<?php

//Importer les fichiers
require './classes/class.intermediate_data.php';

//Ajouter une nouvelle donnée
if($method=="add")
{
    
        //Faire appel à la classe fund
        $intermediate_data = new Intermediate_data();

        //Donner un titre au formulaire qui correspond
        $option_type_of_form = "Add New ";
        $option_title = str_replace ( "_", " ", $controller);

        $option_name_post = "add_new_".$controller;

        //Si le bouton submit a été cliqué
        if(isset($_POST['submit_btn_intermediate']))
        {
            //Il fait appel à la fonction pour insérer les nouvelles données. En paramètre, il a tout les données du formulaire passées en POST
            if($intermediate_data->insert_new_data($_POST, $controller))
            {
                //Texte pour le log
                $after = "$controller : ".$_POST["add_new_$controller"];
                $action = "Add new $controller";

                //Additionner le log à la base de données (le before est vide car pour un ajout, il n'y a pas d'avant)
                add_logs($_SESSION['uniqueid'],"",$after,$action);

                //Flash message pour dire que le fond a été ajouté à la base de données
                $_SESSION['flash_message']['message'] = "The $controller was added";
                $_SESSION['flash_message']['type'] = "success";

                //Rediriger l'utilisateur vers la même page pour qu'il puisse voir le flash message
                //header("Location: /type_startup/add");

            }
            
        }

        //Importer le formulaire
        require_once("./pages/intermediate_tables/form_intermediate_data.html");
    
}
//Modifier un fond si la méthode est égale à modify
elseif($method=="modify" && is_numeric($param) && !empty($param))
{
    
    //Faire appel à la classe fund
    $intermediate_data = new Intermediate_data();

    //Donner un titre au formulaire qui correspond 
    $option_type_of_form = "Modify ";
    $option_title = str_replace ( "_", " ", $controller);
    $option_name_post = "modify_$controller";

    //Récupérer la valeur qui correspond à l'id qui est un paramètre
    $option_data = $intermediate_data->get_data_by_id($param, $controller);

    //Mettre dans une variable session la valeur déjà existante dans la db pour l'id en paramètre
    $get_data_to_modify = $intermediate_data->get_data_to_modify($param, $controller);

    if(isset($_POST['submit_btn_intermediate']))
    {
        //Cette condition permet de vérifier si un champ a été changé
        if(intermediate_data_has_been_modify($param, $controller))
        {
            //S'il y a un changement, il fait l'update
            if($intermediate_data->update_data($_POST, $param, $controller))
            {   
                //Texte des logs
                $before = "$controller : ".$get_data_to_modify["$controller"];
                $after = "$controller : ".$_POST["modify_$controller"];
                $action = "Modify $controller";
                
                //Ajouter les logs avec l'avant et l'après
                add_logs($_SESSION['uniqueid'],$before,$after,$action);

                $_SESSION['flash_message']['message'] = "The $controller was changed";
                $_SESSION['flash_message']['type'] = "success";
                //header("Location: /type_startup/modify/$param");
            }
        }
    }

    //Importer le formulaire
    require_once("./pages/intermediate_tables/form_intermediate_data.html");
}

//S'il n'y pas de methode, alors il affiche le tableau avec tous les fonds de toutes les startups
elseif($method=="modify")
{
    require 'pages/intermediate_tables/intermediate_display_table.php';

    
    $filename_queries_db = "intermediate_db.php";
    $type_data = $controller;

    intermediate_table($filename_queries_db, $type_data);
    

}
?>