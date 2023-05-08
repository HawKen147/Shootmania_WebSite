<?php
if(!isset($_SESSION)){
    session_start();
}
include_once ("action.php");

///////////////////////////////////////////////////////////////////////////
////////////////// formulaire pour l'ajout d'un admin /////////////////////
///////////////////////////////////////////////////////////////////////////

$name = htmlspecialchars($_POST['Team_name']);
$image = htmlspecialchars($_POST['Image_team']);
$createur = $_SESSION['utilisateur'];
$id = get_last_id_from_teams();
$id ++;

if(isset($name) && isset($createur)){
    if($image == '' ){
        $image = "https://www.aht.li/3733312/default.png";
    }
    new_team($name, $image, $createur, $id);
    ajoute_joueur($createur,$name);
}
header('Location:/view/my_teams.php');

// il faut gerer les erreurs si il y en a / dire si l'utilisateur a bien ete ajouter en tant que admin ou suppr
