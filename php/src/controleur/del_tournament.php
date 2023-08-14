<?php
if(!isset($_SESSION)){
    session_start();
}

include_once('../controleur/action.php');

///////////////////////////////////////////////////////////////////////////
////////////////// formulaire pour supprimer un tournois //////////////////
///////////////////////////////////////////////////////////////////////////

$id = $_SESSION['id_tournament'];
if(del_tournament_status($id) && del_tournament_player_team($id) && del_tournament($id)){
    header('Location:../view/home.php');
}


// fonction qui supprime un tournois de la table tournament
function del_tournament($id_tournois){
    $requete = "DELETE FROM `tournois` WHERE `id_tournois` = ?";
   $resultat = sql_request($requete, [$id_tournois]);
   return $resultat;
}

function del_tournament_status($id_tournament){
    $requete = "DELETE FROM `tournament_status` WHERE `id_tournament_status` = ?";
    $resultat = sql_request($requete, [$id_tournament]);
    return $resultat;
}

function del_tournament_player_team($id_tournament){
    $requete = "DELETE FROM `tournament_team_player` WHERE `id_tournois_tournois` = ?";
    $resultat = sql_request($requete, [$id_tournament]);
    return $resultat;
}
