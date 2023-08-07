<?php
include_once('../controleur/action.php');

$tournament = get_tournament_info($_SESSION['id_tournament']);
if ($_POST['Tournament_Name'] != $tournament['nom_tournois']){
    $tournament_name = $_POST['Tournament_Name'];
} else {
    $tournament_name = $tournament['nom_tournois'];
}

if ($_POST['Image_Tournament'] != $tournament['image']){
    $image = $_POST['Image_Tournament'];
} else {
    $image = $tournament['image'];
}

if ($_POST['Serv_Link'] != $tournament['link_serv']){
    $link = $_POST['Serv_Link'];
} else {
    $link = $tournament['link_serv'];
}

if ($_POST['time'] != $tournament['time_tournament']){
    $time = $_POST['time'];
} else {
    $time = $tournament['time_tournament'];
}

if ($_POST['Tournament_Desc'] != $tournament['description']){
    $desc = $_POST['Tournament_Desc'];
} else {
    $desc = $tournament['description'];
}

var_dump(check_time_format($time));
var_dump($tournament_name, $image, $link, $time, $desc);

function check_time_format($date){
    // Définir le format attendu
    $format = "d/m/Y H:i";
    // Créer un objet DateTime à partir de la chaîne
    $date = DateTime::createFromFormat($format, $date);
    // Vérifier si la date est au bon format
    if ($date !== false && !array_sum($date->getLastErrors())) {
        // La date est au bon format
        return true;
    }
}