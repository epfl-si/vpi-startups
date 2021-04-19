<?php

session_start();

//Initialiser les modules nécessaires pour le site (bootstrap, ajax, google charts)
echo '
<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <title> Project Startups </title>
    </head>
    <body>
        <script>
            /*
                Script qui empêche l\historique sur les pages. 
                Surtout utilisé pour les formulaires, si l\'utilisateur rafraichi la page, il ne soumet pas les anciens données
            */
            if ( window.history.replaceState ) 
            {
            window.history.replaceState( null, null, window.location.href );
            }
        </script>

        <!-- L\'en-tête du site -->
        <nav class="navbar navbar-expand-lg navbar-white bg-white mb-3">
            <a class="navbar-brand" href="https://www.epfl.ch">
                <img src="medias/epfl_logo.png" alt="epfl" width="100" height="50">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">';
                    //Il affiche seulement le menu si l'utilisateur est connecté
                    if(isset($_SESSION['user']))
                    {
                        //Il affiche le menu aux utilisateurs qui ont le droit d'écrire
                        if($_SESSION['TequilaPHPWrite'] == "TequilaPHPWritetrue")
                        {
                            /*
                                Menu déroulant avec les pages du site. 
                                Il n'y pas la page de modifications des données car cette page doit être seulement accéssible si l'utilisateur clique sur une startup, 
                                vu que les données sont seulement affichées s'il y a le nom de la startup en paramètre dans l'url.
                            */
                            echo '
                            <li class="nav-item dropdown">
                                <a class="nav-link text-danger dropdown-toggle " id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Pages </a>
                                <div class="dropdown-menu dropdown-warning" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item dropdown-item-danger text-danger" href="index.php">Homepage</a>
                                    <a class="dropdown-item text-danger" href="add_new_company.php">Add New Company</a>
                                    <a class="dropdown-item text-danger" href="import_from_csv.php">Import CSV</a>
                                </div>
                            </li>';
                        }  
                    }
                    echo '
                </ul>
                <ul class="navbar-nav text-right">
                    <li class="nav-item">';
                    /*
                    Si l'utilisateur est connecté, sur l'en-tête, il y a le lien de logout
                    Si l'utilisateur est deconnecté, sur l'en-tête, il y a le lien de login 
                    */
                    if(isset($_SESSION['user']))
                    {
                        echo '
                        <a class="nav-link text-danger" href="logout.php">Logout</a>';
                    }
                    else
                    {
                        echo '
                        <a class="nav-link text-danger" href="login.php">Login</a>';
                    }
                    echo '
                    </li>
                </ul>
            </div>
        </nav>';
    
        //Fonction pour empêcher les attaques XSS et injections SQL
        function security_text($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

?>