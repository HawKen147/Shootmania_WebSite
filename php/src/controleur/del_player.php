<?php
if(!isset($_SESSION)){
    session_start();
}
include_once ("action.php");

if(isset($_POST['Delet_a_user_from_your_team'])){
    $id_team = $_SESSION['id_team'];
    remove_player_team($_POST['Delet_a_user_from_your_team'], $id_team);
    $_SESSION['err'] = 'The player ' . $_POST['Delet_a_user_from_your_team'] . ' has been removed from your team'; 
    header('Location:../view/team.php?id_teams=' . $id_team);
}


function remove_player_team($user, $id_team){
    $requete = "DELETE FROM `player_teams` WHERE  `login_player` = ? AND `id_player_teams` = ?";
    $resultat = sql_request($requete, [$user, $id_team]);
    return $resultat;
}


