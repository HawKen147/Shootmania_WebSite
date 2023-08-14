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
    $res = connecte_utilisateur($logins, $mot_de_passe);
    if (isset($_POST['link']) ){
        $link = $_POST['link'];
        if ($res === true){
            $_SESSION["utilisateur"] = $logins;
             header('Location:../view/team.php'. $link);
        } else if (!$res){
            $_SESSION['log'] = 'Wrong password or login.';
            header('Location:.../index.php' . $link);
        }
    } else if ($res === true){
        $_SESSION["utilisateur"] = $logins;
        header('Location:../view/home.php');
    } else {
        $_SESSION['log'] = 'Wrong password or login.';
        header('Location:../index.php');
    }     
};
