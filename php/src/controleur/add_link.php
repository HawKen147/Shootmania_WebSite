<?php
if (!isset($_SESSION)){
    session_start();
}

include_once('../controleur/action.php');


if (!est_admin($_SESSION['utilisateur'])){
    header('Location:../view/home.php');
}

if (isset($_POST['media_type']) && isset($_POST['link']) && isset($_POST['media_name'])){
    $requete = "INSERT INTO `links`(`media_type`, `link`, `media_name`) VALUES (? , ?, ?)";
    $resultat = sql_request($requete, [$_POST['media_type'], $_POST['link'], $_POST['media_name']] );
    if ($resultat){
        $_SESSION['link'] = "The link has been added";
        header('Location:../view/admin.php');
    } else {
        $_SESSION['link'] = "somthing went wrong, impossible to add the link";
        header('Location:../view/admin.php');
    }
}