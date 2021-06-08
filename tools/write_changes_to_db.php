<?php


//Récupérer les champs et les données de la page de modifications des personnes
$before_changes = $_SESSION['person_data'];
$after_changes = $_POST;
$action = security_text($_POST['action']);

$before = "name : ".$before_changes['name'].", firstname : ".$before_changes['firstname'].", person function : ".$before_changes['person_function'].", email : ".$before_changes['email'].", prof as founder : ".$before_changes['prof_as_founder'].", gender : ".$before_changes['gender'];
$after = "name : ".$after_changes['name'].", firstname : ".$after_changes['firstname'].", person function : ".$after_changes['person_function'].", email : ".$after_changes['email_person'].", prof as founder : ".$after_changes['prof_as_founder'].", gender : ".$after_changes['gender'];

$data = [

    "name"=> $_POST['name'],
    "firstname"=> $_POST['firstname'],
    "person_function"=> $_POST['person_function'],
    "email_person"=> $_POST['email_person'],
    "prof_as_founder"=> $_POST['prof_as_founder'],
    "gender"=> $_POST['gender'],
];
$sql = "UPDATE person SET name=:name, firstname=:firstname, person_function=:person_function, email=:email_person, prof_as_founder=:prof_as_founder, gender=:gender WHERE id_person=$param";
$stmt= $db->prepare($sql);

if($stmt->execute($data)){
    $_SESSION['flash_message']['message'] = $_POST['firstname']. " ".$_POST['name']. " was changed";
    $_SESSION['flash_message']['type'] = "success";

    add_logs($_SESSION['uniqueid'],$before,$after,$action);
} else {
    $_SESSION['flash_message']['message'] = "An unexpected error occured";
    $_SESSION['flash_message']['type'] = "danger";
}
header("Location: /$controller/$method/$param");

?>