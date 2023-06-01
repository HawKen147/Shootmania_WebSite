<?php
if(!isset($_SESSION)){
    session_start();
}
include_once ("action.php");

///////////////////////////////////////////////////////////////////////////
////////////////// formulaire pour l'inscription ///////////////////////////
///////////////////////////////////////////////////////////////////////////

if (isset($_POST['login']) && isset($_POST['mot_de_passe']) && isset($_POST['confirmation']) && isset($_POST['email'])){
    $logins = htmlspecialchars($_POST['login']);
    $mot_de_passe = htmlspecialchars($_POST['mot_de_passe']);
    $confirmation = htmlspecialchars($_POST['confirmation']);
    $email = htmlspecialchars($_POST['email']);

// test si l'utilisateur est deja dans la base de donnée puis inscrit l'utilisateur et l'envoie dans la page de connexion.
if (inscrit_utilisateur($logins, $mot_de_passe, $confirmation, $email) === TRUE){
       header('Location:../view/index.php');
} else {
    header('Location:../view/register.php');
}
}
/*if (
    (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
     )
    echo('Il faut un email valide pour soumettre le formulaire.');
{
    return;
}*/
