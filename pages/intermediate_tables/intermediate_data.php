<?php

//Importer les fichiers
require './classes/class.intermediate_data.php';

//Ajouter une nouvelle donnée
if($method=="add")
{
    
        //Faire appel à la classe intermediate data
        $intermediate_data = new Intermediate_data();

        //Donner un titre et nom au champ du formulaire
        $option_type_of_form = "Add New ";

        //Remplacer la valeur du controller qui contient des underscore par des espaces pour l'affichage
        $option_title = str_replace ( "_", " ", $controller);

        //Donner un nom à l'input du formulaire pour l'utiliser avec le POST
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

                //Flash message pour dire que les données a été ajoutées à la base de données
                $_SESSION['flash_message']['message'] = "The $controller was added";
                $_SESSION['flash_message']['type'] = "success";

                //Rediriger l'utilisateur vers la même page pour qu'il puisse voir le flash message
                header("Location: /$controller/add");

            }
            
        }

        //Importer le formulaire
        require_once("./pages/intermediate_tables/form_intermediate_data.html");
    
}
//Modifier les données si la méthode est égale à modify et il y a un id dans l'url
elseif($method=="modify" && is_numeric($param) && !empty($param))
{
    
    //Faire appel à la classe intermediate
    $intermediate_data = new Intermediate_data();

    //Donner un titre et nom au champ du formulaire
    $option_type_of_form = "Modify ";

    //Remplacer la valeur du controller qui contient des underscore par des espaces pour l'affichage
    $option_title = str_replace ( "_", " ", $controller);

    //Donner un nom à l'input du formulaire pour l'utiliser avec le POST
    $option_name_post = "modify_$controller";

    //Récupérer la valeur qui correspond à l'id qui est dans la base de données
    $option_data = $intermediate_data->get_data_by_id($param, $controller);

    //Mettre dans une variable session la valeur déjà existante dans la db pour l'id en paramètre
    $get_data_to_modify = $intermediate_data->get_data_to_modify($param, $controller);

    //Si le bouton submit a été cliqué
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
                
                //Ajouter les logs avec l'avant et l'après dans la base de données
                add_logs($_SESSION['uniqueid'],$before,$after,$action);

                //Flash message
                $_SESSION['flash_message']['message'] = "The $controller was changed";
                $_SESSION['flash_message']['type'] = "success";

                //Redirection vers la meme page pour que l'utilisateur puisse voir le flash message
                header("Location: /$controller/modify/$param");
            }
        }
    }

    //Importer le formulaire
    require_once("./pages/intermediate_tables/form_intermediate_data.html");
}

//S'il n'y pas de methode, alors il affiche le tableau avec toutes les données correspondantes à la table intermediaire choisie par l'utilisateur
elseif($method=="modify")
{
    //Importer la page qui affiche le tableau
    require 'pages/intermediate_tables/intermediate_display_table.php';

    //Donner le nom du fichier qui contient les requêtes SQL qui vont chercher les données correspondantes à la table intermediaire
    $filename_queries_db = "intermediate_db.php";
    $type_data = $controller;

    //Appeller la fonction qui construit et affiche le tableau avec les données
    intermediate_table($filename_queries_db, $type_data);
    

}
?>