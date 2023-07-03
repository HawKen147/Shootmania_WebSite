<?php if(!isset($_SESSION)){
    session_start();
    if (!isset($_SESSION["utilisateur"])){
        header("Location:../view/index.php");
    }
}
include("action.php");

///////////////////////////////////////////////////////////////////////////
////////////////// formulaire pour ajouter un id discord //////////////////
///////////////////////////////////////////////////////////////////////////
if (isset($_POST['discord'])){
    $discord = htmlspecialchars($_POST['discord']);
    if (id_discord() == FALSE){ // faire fonction pour chercher l'id discord
        ajoute_discord($discord);
        header('Location:../view/profile.php');
    } else {
        $_SESSION['discord-err'] = "you already have a discord id.";
        header('Location:../view/discord_reg.php');
    }
};
