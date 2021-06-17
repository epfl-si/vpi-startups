<?php

//Si l'utilisateur a le droit d'écrire
if($_SESSION['TequilaPHPWrite'] == "TequilaPHPWritetrue")
{
    echo '
    <div class="container my-5">
        <form method="post" id="form_csv_upload" class="form_csv_upload col-12 col-sm-12 col-lg-8 col-xl-8 mx-auto" enctype="multipart/form-data" action="'; echo '/'.$controller; echo'">
            <legend class="font-weight-bold my-5 pl-0"> Import from CSV to database </legend>    
            <div>
                <!-- input type="file" permet d\'aller chercher sur le disque de l\'utilisateur, le csv qu\'il veut ajouter-->
                <input type="file" class="form-control-file border" name="fileToUpload" id="fileToUpload">  
            </div>
            <div class="form-check mt-5">
                <input class="form-check-input" type="radio" value="import_new_overwrite_old" name="data_imported" id="identical_data">
                <label class="form-check-label" for="identical_data">
                    Import new data and overwrite old data
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" value="only_new_keep_old" name="data_imported" id="only_different_data" checked>
                <label class="form-check-label" for="only_different_data">
                    Import only new data and keep old data as is
                </label>
            </div>
            <div>
                <button class="btn btn-outline-secondary my-5" id="import" name="import" type="submit">Import</button>
            </div>
        </form>
        <div id="echo_result"></div>
    </div>';


    require 'tools/disconnection_db.php';
    require 'footer.php';
}

//Si l'utilisateur n'a pas le droit d'écrire, un pop-up d'avertissement sera affiché et il sera redirigé vers la page d'accueil
elseif($_SESSION['TequilaPHPRead'] == "TequilaPHPReadtrue")
{
    $_SESSION['flash_message'] = array();
    $_SESSION['flash_message']['message'] = "You don't have enough rights to access this page.";
    $_SESSION['flash_message']['type'] = "warning";
    header('Location: /');
}

?>
