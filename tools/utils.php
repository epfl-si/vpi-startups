<?php

//Fonction pour empêcher les attaques XSS et injections SQL
function security_text($data)
{
  $data = trim($data);
  $data = addslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//flash message
function do_i_need_to_display_flash_message() 
{
  if (isset($_SESSION['flash_message']) && count($_SESSION['flash_message']) && $_SESSION['flash_message']['message'] != '') {
    $fm = flash_message($_SESSION['flash_message']['message'], $_SESSION['flash_message']['type']);
    unset($_SESSION['flash_message']);
    return $fm;
  }
}

//modifier les données des personnes en regardant si un champ a été modifié
function data_has_been_modify($param){
  if($_SESSION['person_data']['id_person'] != $param){
    die("hackeur");
  }

  if($_SESSION['person_data']['name'] != $_POST['name']) {
    return true;
  }

  if($_SESSION['person_data']['firstname'] != $_POST['firstname']) {
    return true;
  }

  if($_SESSION['person_data']['person_function'] != $_POST['person_function']) {
    return true;
  }

  if($_SESSION['person_data']['email'] != $_POST['email_person']) {
    return true;
  }
  if($_SESSION['person_data']['prof_as_founder'] != $_POST['prof_as_founder']) {
    return true;
  }
  if($_SESSION['person_data']['gender'] != $_POST['gender']) {
    return true;
  }
  
  return false;
}

//modifier les données des startups en regardant si un champ a été modifié
function startup_data_has_been_modify($param){
  if($_SESSION['startup_data']['id_startup'] != $param){
    die("hackeur");
  }
  if($_SESSION['startup_data']['company'] != $_POST['company_name']) {
    return true;
  }
  if($_SESSION['startup_data']['web'] != $_POST['web']) {
    return true;
  }
  if($_SESSION['startup_data']['founding_date'] != $_POST['founding_date']) {
    return true;
  }
  if($_SESSION['startup_data']['rc'] != $_POST['rc']) {
    return true;
  }
  if($_SESSION['startup_data']['exit_year'] != $_POST['exit_year']) {
    return true;
  }
  if($_SESSION['startup_data']['status'] != $_POST['status']) {
    return true;
  }
  if($_SESSION['startup_data']['epfl_grant'] != $_POST['epfl_grant']) {
    return true;
  }
  if($_SESSION['startup_data']['awards_competitions'] != $_POST['awards_competitions']) {
    return true;
  }
  if($_SESSION['startup_data']['key_words'] != $_POST['key_words']) {
    return true;
  }
  if($_SESSION['startup_data']['laboratory'] != $_POST['laboratory']) {
    return true;
  }
  if($_SESSION['startup_data']['short_description'] != $_POST['short_description']) {
    return true;
  }
  if($_SESSION['startup_data']['type_startup'] != $_POST['type_startup']) {
    return true;
  }
  if($_SESSION['startup_data']['ceo_education_level'] != $_POST['ceo_education_level']) {
    return true;
  }
  if($_SESSION['startup_data']['sectors'] != $_POST['sectors']) {
    return true;
  }  
  if($_SESSION['startup_data']['category'] != $_POST['category']) {
    return true;
  }  
  if($_SESSION['startup_data']['schools'] != implode(";",$_POST['faculty_schools'])) {
    return true;
  }  
  if($_SESSION['startup_data']['impact'] != implode(";",$_POST['impact_sdg'])) {
    return true;
  }  
  if($_SESSION['startup_data']['country'] != implode(";",$_POST['founders_country'])) {
    return true;
  }  
  if($_SESSION['startup_data']['id_person1'] != $_POST['person1']) {
    return true;
  }  
  if($_SESSION['startup_data']['id_person2'] != $_POST['person2']) {
    return true;
  }  
  if($_SESSION['startup_data']['id_person3'] != $_POST['person3']) {
    return true;
  }  
  if($_SESSION['startup_data']['id_type_of_person1'] != $_POST['function_type_of_person1']) {
    return true;
  }
  if($_SESSION['startup_data']['id_type_of_person2'] != $_POST['function_type_of_person2']) {
    return true;
  }
  if($_SESSION['startup_data']['id_type_of_person3'] != $_POST['function_type_of_person3']) {
    return true;
  }  
  
  return false;
}

//modifier les données multicritère
function startup_faculty_data_has_been_modify()
{
  if($_SESSION['startup_data']['schools'] != implode(";",$_POST['faculty_schools'])) {
    return true;
  }
  return false;  
}

function startup_country_data_has_been_modify()
{
  if($_SESSION['startup_data']['country'] != implode(";",$_POST['founders_country'])) {
    return true;
  }
  return false;  
}

function startup_impact_data_has_been_modify()
{
  if($_SESSION['startup_data']['impact'] != implode(";",$_POST['impact_sdg'])) {
    return true;
  }
  return false;  
}

function startup_person_data_has_been_modify($number_of_person)
{
  if($_SESSION['startup_data']["id_person$number_of_person"] != $_POST["person$number_of_person"]) {
    return true;
  }
  return false;  
}

function startup_type_of_person_data_has_been_modify($number_of_types_of_person)
{
  if($_SESSION['startup_data']["id_type_of_person$number_of_types_of_person"] != $_POST["function_type_of_person$number_of_types_of_person"]) {
    return true;
  }
  return false;  
}


//modifier les données des personnes en regardant si un champ a été modifié
function funds_data_has_been_modify($param){
  if($_SESSION['funds_data']['id_funding'] != $param){
    
    die("hackeur");
  }

  if($_SESSION['funds_data']['amount'] != $_POST['amount']) {
    return true;
  }

  if($_SESSION['funds_data']['investment_date'] != $_POST['investment_date']) {
    return true;
  }

  if($_SESSION['funds_data']['investors'] != $_POST['investors']) {
    return true;
  }

  if($_SESSION['funds_data']['fk_stage_of_investment'] != $_POST['fk_stage_of_investment']) {
    return true;
  }
  if($_SESSION['funds_data']['fk_type_of_investment'] != $_POST['fk_type_of_investment']) {
    return true;
  }
  if($_SESSION['funds_data']['fk_startup'] != $_POST['fk_startup']) {
    return true;
  }
  
  return false;
}



/**
 * Return a bottstrap flash message
 * @param String $message: the message to be displayed
 * @param String $type: one of "primary, secondary, success, danger, warning, info, light, dark"
 *
 * @return String The HTML div of the flash message
 */
function flash_message($message, $type = 'warning')
{
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