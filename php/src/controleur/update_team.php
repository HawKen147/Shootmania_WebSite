<?php
if(!isset($_SESSION)){
    session_start();
}
include_once('../controleur/action.php');
if (isset($_POST['team_name']) && isset($_POST['team_image'])){
    $name = htmlspecialchars($_POST['team_name']);
    $image = htmlspecialchars($_POST['team_image']);
    $id_team = $_SESSION['id_team'];
    if(update_team($name, $image, $id_team)){
        $_SESSION['err'] = 'Your team has been updated';
        header('Location:../view/team.php?id_teams=' . $id_team);
    } else {
        $_SESSION['err'] = 'Impossible to update. Please try later again';
        header('Location:../view/update_team.php?id_teams=' . $id_team);
    }
}


function update_team($name, $image, $id_team){
    $requete = "UPDATE `teams` SET `nom_team`= ?,`images`= ? WHERE `id_teams` = ?";
    $resultat = sql_request($requete, [$name, $image, $id_team]);
    return $resultat;
}