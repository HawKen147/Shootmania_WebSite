<?php

include_once('action.php');

if(isset($_POST['id_tournois']) && isset($_POST['start_tournament'])){
    $id_tournament = htmlspecialchars($_POST['id_tournois']);
    if($id_tournament == $_SESSION['id_tournament']){
        if (update_tournament_status ($id_tournament)){
            $_SESSION['tournois'] = "Tournament has started";
            header("Location:../view/Tournament.php?id=" . $id_tournament);
        }  
    } else {
        $_SESSION['tournois'] = "Something went wrong, tournament can't start";
        header("Location:../view/Tournament.php?id=" . $id_tournament);
    }
    
}

//update the status of the tournament
function update_tournament_status ($id_tournament){
    $requete = "UPDATE `tournament_status` SET `status`='underway' WHERE `id_tournament_status` = ?";
    $resultat = sql_request($requete, [$id_tournament]);
    return $resultat;
}


