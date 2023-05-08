<?php if(!isset($_SESSION)){
    session_start();
}
include("action.php");

///////////////////////////////////////////////////////////////////////////
////////////////// formulaire pour la connexion ///////////////////////////
///////////////////////////////////////////////////////////////////////////

if (isset($_POST['login']) && isset($_POST['password'])){
    $logins = htmlspecialchars($_POST['login']);
    $mot_de_passe = htmlspecialchars($_POST['password']);
    if (connecte_utilisateur($logins, $mot_de_passe) === TRUE){
        $_SESSION ["utilisateur"]= $logins;
        header('Location:/view/home.php');
    } else {
        $_SESSION ['connexion'] = 1;
        header('Location:/view/index.php');
    }
};
