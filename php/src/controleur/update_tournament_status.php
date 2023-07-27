<?php
include_once('../controleur/action.php');


function update_tournament_over($id_tournament){
    $requete = "UPDATE `tournament_status` SET `status`= 'over' WHERE `id_tournament_status` = ? ";
    $resultat = sql_request($requete, [$id_tournament]);
    if($resultat){
        $_SESSION['err'] = 'The tournament is over, GG everyone';
        return true;
    } else {
        $_SESSION['err'] = 'Can\'t update the tournament status';
        return false;
    }
}

?>