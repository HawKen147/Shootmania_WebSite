<?php
if(!isset($_SESSION)){
    session_start();
}
include_once ("action.php");

///////////////////////////////////////////////////////////////////////////
////////////////// formulaire pour l'ajout d'un admin /////////////////////
///////////////////////////////////////////////////////////////////////////

if(isset($_POST['Team_name'])){
    $name = htmlspecialchars($_POST['Team_name']);
    $image = htmlspecialchars($_POST['Image_team']);
    $createur = $_SESSION['utilisateur'];
    $date = get_date();
    if (new_team($name, $image, $createur, $date)){  // si le nom de la team n'est pas deja pris
        $requete = "SELECT `id_teams` FROM `teams` WHERE `createur` = ? ORDER BY `id_teams` DESC limit 1";
        $resultat = sql_request($requete, [$createur]); 
        $ligne = $resultat->fetch(PDO::FETCH_ASSOC);
        $id = $ligne['id_teams'];
        ajoute_joueur($createur, $id);
        header('Location:../view/team.php?id_teams=' . $id);
    } else {
        $_SESSION['err'] = 'something went wrong, impossible to create your team';
        header('Location:../view/my_teams.php');
    }
}


// creer une team 
function new_team($name, $image, $createur, $date){
    if($image){
        $requete = "INSERT INTO `teams` VALUES (`id_teams`, ? , ? , ? , ?)";
        $resultat = sql_request($requete, [$name, $image, $date, $createur]);
    } else {
        $requete = "INSERT INTO `teams` VALUES (`id_teams`, ? , DEFAULT, ? , ?)";
        $resultat = sql_request($requete, [$name, $date, $createur]);
    }
	return $resultat;
};
