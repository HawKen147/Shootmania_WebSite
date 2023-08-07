<?php
include_once('../controleur/action.php');


get_post_update();

//compare the different elements to update them if they are updated.
function get_post_update(){
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
    if (check_time_format($time)){
        update_tournament($tournament_name, $desc, $image, $link, $time);
        header('Location:../view/tournament.php?id=' . $_SESSION['id_tournament']);
    }
    else {
        $_SESSION['err'] = 'impossible to update the tournament, check if eveything is fine';
        header('Location:../view/new_tournament.php?id=' . $_SESSION['id_tournament'] . '&edit');
    }
}

//check if the time is in the good format
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

//send the sql request to update the tournament
function update_tournament($tournament_name, $desc, $image, $link, $time){
    $requete = "UPDATE `tournois` SET `nom_tournois`=?,`description`= ?, `image`=?, `link_serv`= ?,`time_tournament`= ? WHERE id_tournois = ?";
    $resultat = sql_request($requete, [$tournament_name, $desc, $image, $link, $time, $_SESSION['id_tournament']]);
    return $resultat;
}