<?php
if(!isset($_SESSION)){
    session_start();
}
include_once ("action.php");

///////////////////////////////////////////////////////////////////////////
///////// formulaire pour l'ajout d'une team dans un tournois /////////////
///////////////////////////////////////////////////////////////////////////
if ($_POST['add_team_tournament'] == 'send') {      
    $team = $_POST['team']; 
    $id_tounrois = $_POST['id_tournois'];
    $requete = "INSERT INTO `player_tournois`(`id_team_tournois`, `id_tournois_tournois`) VALUES ('$team','$id_tounrois')";
    
}
header('Location:/view/tournament.php?id=' . $id_tounrois);

// il faut gerer les erreurs si il y en a / dire si l'utilisateur a bien ete ajouter en tant que admin ou suppr
