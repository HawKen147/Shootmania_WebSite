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
    if (!check_name_team($name)){  // si le nom de la team n'est pas deja pris
        new_team($name, $image, $createur, $date);
        $requete = "SELECT `id_teams` FROM `teams` WHERE `createur` = '$createur' ORDER BY `id_teams` DESC limit 1";
        $resultat = sql_request($database_shootmania, $requete);
        $ligne = $resultat->fetch_assoc();
        $id = $ligne['id_teams'];
        ajoute_joueur($createur, $id);
    } else {
        $_SESSION['err'] = "the name of the team \"" . $name . "\" is already taken";
    }
    header('Location:../view/my_teams.php');
}


// creer une team 
function new_team($name, $image, $Createur, $date){
	global $database_shootmania;
    if($image){
        $requete = "INSERT INTO `teams` VALUES (`id_teams`, '$name', '$image', '$date', '$Createur')";
    } else {
        $requete = "INSERT INTO `teams` VALUES (`id_teams`, '$name', DEFAULT, '$date', '$Createur')";
    }
	$resultat = sql_request($database_shootmania, $requete);
	return $resultat;
};


//check if the name of the team already exist
function check_name_team($name_team){
    global $database_shootmania;
    $requete = "SELECT `nom_team` from `teams` WHERE `nom_team` = '$name_team'";
    $resultat = sql_request($database_shootmania, $requete);
    if($resultat){
        $ligne = $resultat -> fetch_assoc();
    }
    return $ligne;
}
