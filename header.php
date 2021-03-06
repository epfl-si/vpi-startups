<?php

//Condition pour vérifier si l'utilisateur est connecté à l'application via Tequila
if(isset($_SESSION['user']))
{
    //Ignorer les erreurs NOTICE
    error_reporting(E_ALL & ~E_NOTICE);

    //Mettre le sciper de l'utilisateur connecté dans une variable
    $sciper_number = $_SESSION['uniqueid'];

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
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <link rel="stylesheet" type="text/css" href="/css/style.css"/>
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
    <nav id="header" class="navbar navbar-expand-lg navbar-white bg-white mb-5">
        <a class="navbar-brand" href="https://www.epfl.ch">
            <img src="/medias/epfl_logo.png" alt="epfl" width="100" height="50">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto">';
                
                //Il affiche le menu aux utilisateurs qui ont le droit d'écrire
                if($_SESSION['TequilaPHPWrite'] == "TequilaPHPWritetrue")
                {
                    //Menu du site web
                    echo '
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="/">Homepage</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link text-danger dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Add </a>
                        <div class="dropdown-menu dropdown-warning" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/startup/add">Add New Startup</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/person/add">Add New Person</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/funds/add">Add New Funds</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link text-danger dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Modify </a>
                        <div class="dropdown-menu dropdown-warning" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/">Modify Startup</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/persons">Modify Person</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/funds">Modify Funds</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="/import">Import CSV</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link text-danger dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Charts </a>
                        <div class="dropdown-menu dropdown-warning" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/charts/number_of_startups_by_year">Number of startups by year</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/charts/startups_by_sectors">Startups by sector</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/charts/funds_by_sector">Funds by sector</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="/logs">Logs</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link text-danger dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Admin </a>
                        <div class="dropdown-menu dropdown-warning" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/type_startup/add">Add New Type of Startup</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/type_startup/modify">Modify Type of Startup</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/type_of_person/add">Add New Type of Person</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/type_of_person/modify">Modify Type of Person</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/status/add">Add New Status</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/status/modify">Modify Status</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/sectors/add">Add New Sector</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/sectors/modify">Modify Sector</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/category/add">Add New Category</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/category/modify">Modify Category</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/ceo_education_level/add">Add New Ceo Education Level</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/ceo_education_level/modify">Modify Ceo Education Level</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/stage_of_investment/add">Add New Stage of Invesmtent</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/stage_of_invesment/modify">Modify Stage of Invesmtent</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/type_of_investment/add">Add New Type of Invesmtent</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/type_of_investment/modify">Modify Type of Invesmtent</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/impact_sdg/add">Add New Impact SDG</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/impact_sdg/modify">Modify Impact SDG</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/founders_country/add">Add New Founders Country</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/founders_country/modify">Modify Founders Country</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/faculty_schools/add">Add New Faculty Schools</a>
                            <a class="dropdown-item dropdown-item-danger text-danger" href="/faculty_schools/modify">Modify Faculty Schools</a>
                        </div>
                    </li>
                    ';
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
                    <a class="nav-link text-danger" href="/logout">Logout</a>';
                }
                else
                {
                    echo '
                    <a class="nav-link text-danger" href="/login">Login</a>';
                }
                echo '
                </li>
            </ul>
        </div>
    </nav>';

    //Affichage des flash messages
    echo do_i_need_to_display_flash_message();
}

//Si l'utilisateur n'est pas connecté, il le redirige vers la page de login pour que l'utilisateur puisse se connecter
else
{
    header('Location: /login');
}     

?>