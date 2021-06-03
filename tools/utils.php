<?php

//Fonction pour empêcher les attaques XSS et injections SQL
function security_text($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//flash message
function do_i_need_to_display_flash_message() 
{
  session_start();
  if (isset($_SESSION['flash_message']) && count($_SESSION['flash_message']) && $_SESSION['flash_message']['message'] != '') {
    $fm = flash_message($_SESSION['flash_message']['message'], $_SESSION['flash_message']['type']);
    unset($_SESSION['flash_message']);
    return $fm;
  }
}

//modifier les données des personnes
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

//modifier les données des startups
function startup_data_has_been_modify($param){
  if($_SESSION['startup_data']['id_startup'] != $param){
    die("hackeur");
  }

  if($_SESSION['startup_data']['company'] != $_POST['company']) {
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
  if($_SESSION['startup_data']['prof_as_founder'] != $_POST['prof_as_founder']) {
    return true;
  }
  if($_SESSION['startup_data']['gender'] != $_POST['gender']) {
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