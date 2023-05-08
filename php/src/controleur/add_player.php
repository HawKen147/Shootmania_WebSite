<?php if(!isset($_SESSION)){
    session_start();
    if (!isset($_SESSION["utilisateur"])){
        header("Location://test-site/Site/view/index.php");
    }
}
include("action.php");

///////////////////////////////////////////////////////////////////////////
//////////// formulaire pour ajouter un joueur dans une team //////////////
///////////////////////////////////////////////////////////////////////////
$id_team = $_GET['id_team'];
var_dump($id_team);
exit;

/*if (isset($_POST[''])){
    $discord = htmlspecialchars($_POST['discord']);
    if (id_discord() == FALSE){ // faire fonction pour chercher l'id discord
        ajoute_discord($discord);
        header('Location:http:/php/view/profile.php');
    } else {
        $_SESSION['discord-err'] = "you already have a discord id.";
        header('/php/view/discord_reg.php');
    }
};*/
