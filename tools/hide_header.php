<?php

//Masquer le header s'il y a header=false dans les paramètres de l'url
if($_GET['header'] == 'false' && isset($_GET['header']))
{
    echo '<style>#header {display:none;}</style>';
}
?>
