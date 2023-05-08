<?php
if(!isset($_SESSION)){
    session_start();
}
include_once ("action.php");

///////////////////////////////////////////////////////////////////////////
////////////////// formulaire pour l'ajout d'un admin /////////////////////
///////////////////////////////////////////////////////////////////////////

if (isset($_POST['login'])) {      
    $user = $_POST['login'];                // si un utilisateur est rentré
    if (isset($_POST['add_admin'])){                // verifie quelle form est utlisé (add ou del admin)
        add_admin($user);
    }
    if(isset($_POST['del_admin'])){
        del_admin($user);
    }
}
header('Location:/view/admin.php');

// il faut gerer les erreurs si il y en a / dire si l'utilisateur a bien ete ajouter en tant que admin ou suppr
