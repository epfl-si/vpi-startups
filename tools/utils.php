<?php

function utils_charts()
{
  echo "
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css'>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js'></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js'></script>
  <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
  ";
}

//Fonction pour empêcher les attaques XSS et injections SQL
function security_text($data)
{
  $data = trim($data);
  $data = addslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//Fonction pour afficher le flash message
function do_i_need_to_display_flash_message() 
{
  //Si le flash message est écrit et n'est pas vide
  if (isset($_SESSION['flash_message']) && count($_SESSION['flash_message']) && $_SESSION['flash_message']['message'] != '') 
  {
    //Il fait appel à la fonction qui contient le texte du flash message et du type
    $fm = flash_message($_SESSION['flash_message']['message'], $_SESSION['flash_message']['type']);

    //Il le supprime pour qu'après le rafraichissement de la page, il ne s'affiche plus
    unset($_SESSION['flash_message']);

    //retourne le flash message
    return $fm;
  }
}

//Fonction pour vérifier si un champ du formulaire a été changé (Formulaire de modification des données pour les personnes)
function data_has_been_modify($param)
{
  //Vérifie que l'id de l'utilisateur qui est dans la variable session correspond à l'id de l'url
  if($_SESSION['person_data']['id_person'] != $param)
  {
    //Si non, il arrête
    die("hackeur");
  }
  
  //Vérifie que le nom de la personne est different du nom saisi par l'utilisateur
  if($_SESSION['person_data']['name'] != $_POST['name']) 
  {
    return true;
  }

  //Vérifie que le prénom de la personne est different du prénom saisi par l'utilisateur
  if($_SESSION['person_data']['firstname'] != $_POST['firstname']) 
  {
    return true;
  }

  //Vérifie que la fonction de la personne est different de la fonction saisi par l'utilisateur
  if($_SESSION['person_data']['person_function'] != $_POST['person_function']) 
  {
    return true;
  }

  //Vérifie que l'email de la personne est different d'email saisi par l'utilisateur
  if($_SESSION['person_data']['email'] != $_POST['email_person']) 
  {
    return true;
  }

  //Vérifie que la valeur du champ prof_as_founder est different de la valeur saisie par l'utilisateur
  if($_SESSION['person_data']['prof_as_founder'] != $_POST['prof_as_founder'])
  {
    return true;
  }

  //Vérifie que la valeur du champ genre est different de la valeur saisie par l'utilisateur
  if($_SESSION['person_data']['gender'] != $_POST['gender']) 
  {
    return true;
  }
  
  //S'il n'y a rien qui a été changé, il retourne false pour qu'il n'y ait pas de changement dans les formulaires
  return false;
}

//Fonction pour vérifier si un champ du formulaire a été changé (Formulaire de modification des données pour les startups). Même principe que la fonction ci-dessus
function startup_data_has_been_modify($param)
{
  if($_SESSION['startup_data']['id_startup'] != $param)
  {
    die("hackeur");
  }

  if($_SESSION['startup_data']['company'] != $_POST['company_name']) 
  {
    return true;
  }

  if($_SESSION['startup_data']['web'] != $_POST['web']) 
  {
    return true;
  }

  if($_SESSION['startup_data']['founding_date'] != $_POST['founding_date']) 
  {
    return true;
  }

  if($_SESSION['startup_data']['rc'] != $_POST['rc']) 
  {
    return true;
  }

  if($_SESSION['startup_data']['exit_year'] != $_POST['exit_year'])
  {
    return true;
  }

  if($_SESSION['startup_data']['status'] != $_POST['status_selectBox']) 
  {
    return true;
  }

  if($_SESSION['startup_data']['epfl_grant'] != $_POST['epfl_grant']) 
  {
    return true;
  }

  if($_SESSION['startup_data']['awards_competitions'] != $_POST['awards_competitions']) 
  {
    return true;
  }

  if($_SESSION['startup_data']['key_words'] != $_POST['key_words']) 
  {
    return true;
  }
  
  if($_SESSION['startup_data']['laboratory'] != $_POST['laboratory']) 
  {
    return true;
  }

  if($_SESSION['startup_data']['short_description'] != $_POST['short_description']) 
  {
    return true;
  }

  if($_SESSION['startup_data']['company_uid'] != $_POST['company_uid']) 
  {
    return true;
  }

  if($_SESSION['startup_data']['crunchbase_uid'] != $_POST['crunchbase_uid']) 
  {
    return true;
  }

  if($_SESSION['startup_data']['unit_path'] != $_POST['unit_path']) 
  {
    return true;
  }

  if($_SESSION['startup_data']['type_startup'] != $_POST['type_startup_selectBox']) 
  {
    return true;
  }

  if($_SESSION['startup_data']['ceo_education_level'] != $_POST['ceo_education_level_selectBox']) 
  {
    return true;
  }

  if($_SESSION['startup_data']['sectors'] != $_POST['sectors_selectBox']) 
  {
    return true;
  }  

  if($_SESSION['startup_data']['category'] != $_POST['category']) 
  {
    return true;
  }  

  if($_SESSION['startup_data']['schools'] != implode(";",$_POST['faculty_schools'])) 
  {
    return true;
  }  

  if($_SESSION['startup_data']['impact'] != implode(";",$_POST['impact_sdg_selectBox'])) 
  {
    return true;
  } 

  if($_SESSION['startup_data']['country'] != implode(";",$_POST['founders_country_selectBox'])) 
  {
    return true;
  }  

  if($_SESSION['startup_data']['id_person1'] != $_POST['person1']) 
  {
    return true;
  } 

  if($_SESSION['startup_data']['id_person2'] != $_POST['person2']) 
  {
    return true;
  }  

  if($_SESSION['startup_data']['id_person3'] != $_POST['person3']) 
  {
    return true;
  }  

  if($_SESSION['startup_data']['id_type_of_person1'] != $_POST['function_type_of_person1']) 
  {
    return true;
  }

  if($_SESSION['startup_data']['id_type_of_person2'] != $_POST['function_type_of_person2']) 
  {
    return true;
  }

  if($_SESSION['startup_data']['id_type_of_person3'] != $_POST['function_type_of_person3']) 
  {
    return true;
  }  
  
  return false;
}

//Fonctions qui vérifient si un changement a été fait pour les champs multicritère
function startup_faculty_data_has_been_modify()
{

  if($_SESSION['startup_data']['schools'] != implode(";",$_POST['faculty_schools'])) 
  {
    return true;
  }
  return false;  
}

function startup_country_data_has_been_modify()
{
  if($_SESSION['startup_data']['country'] == implode(";",$_POST['founders_country_selectBox']) || ($_SESSION['startup_data']['country'] == "" && $_POST['founders_country_selectBox'][0] == "NULL") && strlen($_POST['founders_country_selectBox'][1]) < 1 ) 
  {
    return false;
  }
  return true;  
}

function startup_impact_data_has_been_modify()
{
  if($_SESSION['startup_data']['impact'] == implode(";",$_POST['impact_sdg_selectBox']) || ($_SESSION['startup_data']['impact'] == "" && $_POST['impact_sdg_selectBox'][0] == "NULL")) 
  {
    return false;
  }
  return true;  
}

//Fonction qui vérifie s'il y a eu un chamgement sur la personne (formulaire de modification des startups)
function startup_person_data_has_been_modify($number_of_person)
{
  if($_SESSION['startup_data']["id_person$number_of_person"] != $_POST["person$number_of_person"]) 
  {
    return true;
  }
  return false;  
}

//Fonction qui vérifie s'il y a eu un chamgement sur la fonction de la personne (formulaire de modification des startups)
function startup_type_of_person_data_has_been_modify($number_of_types_of_person)
{
  if($_SESSION['startup_data']["id_type_of_person$number_of_types_of_person"] != $_POST["function_type_of_person$number_of_types_of_person"]) 
  {
    return true;
  }
  return false;  
}


//Fonction qui vérifie s'il y a eu un changement sur le formulaire de changement des fonds
function funds_data_has_been_modify($param)
{
  if($_SESSION['funds_data']['id_funding'] != $param)
  {
    die("hackeur");
  }

  if($_SESSION['funds_data']['amount'] != $_POST['amount']) 
  {
    return true;
  }

  if($_SESSION['funds_data']['investment_date'] != $_POST['investment_date']) 
  {
    return true;
  }

  if($_SESSION['funds_data']['investors'] != $_POST['investors']) 
  {
    return true;
  }

  if($_SESSION['funds_data']['fk_stage_of_investment'] != $_POST['fk_stage_of_investment']) 
  {
    return true;
  }

  if($_SESSION['funds_data']['fk_type_of_investment'] != $_POST['fk_type_of_investment']) 
  {
    return true;
  }
  
  if($_SESSION['funds_data']['fk_startup'] != $_POST['fk_startup']) 
  {
    return true;
  }
  
  return false;
}

//Fonction pour vérifier s'il y a eu un changement de valeurs pour les formulaires des tables intermediaires
function intermediate_data_has_been_modify($param, $controller)
{
  if($_SESSION["data_$controller"]["id_$controller"] != $param)
  {
    die("hackeur");
  }

  if($_SESSION["data_$controller"]["$controller"] != $_POST["modify_$controller"]) 
  {
    return true;
  }

  return false;
}


/**
 * Return a bootstrap flash message
 * @param String $message: the message to be displayed
 * @param String $type: one of "primary, secondary, success, danger, warning, info, light, dark"
 *
 * @return String The HTML div of the flash message
 */

//Fonction qui affiche le flash message
function flash_message($message, $type = 'warning')
{
  //Div qui contiendra le message
  $msg = <<<EOT
  <div class="alert alert-$type alert-dismissible fade show" role="alert">
    $message
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
EOT;

  return $msg;
}

?>