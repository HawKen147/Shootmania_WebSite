<?php
session_start();
include("action.php");
include("send_mail.php");

///////////////////////////////////////////////////////////////////////////
////////////////// formulaire pour la recuperation de mdp /////////////////
///////////////////////////////////////////////////////////////////////////

//chiffre le code dans l'url
global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
function chiffre($code){
    $chiffrage = 'atgune';
    $code = md5($code . $chiffrage);
    return $code;
}

//recupere l'email de l'utilisateur et le retourne
function recupere_email($users){
    global $bdd;
    $email = "SELECT mail FROM users WHERE logins = '$users'";
    $resultat = $bdd->query($email);
    $ligne = $resultat -> fetch_assoc(); 
    $email = $ligne['mail'];
    return $email;
}


// gere les formulaires avec le login, code et email
if(isset($_POST['recup_logins'])){
    if (isset($_POST['login'])){
        $login = htmlspecialchars($_POST['login']);
        if(login_existe_dans_la_BDD($login) == TRUE){    //verifie si il y a un utilisateur qui a cette adresse email
            $_SESSION['recup_logins'] = $login;
            $email = recupere_email($login);
            $recup_code = "";
            for($i=0; $i < 8; $i++){
                $recup_code .=mt_rand(0,9);
            }
            $_SESSION['recup_code'] = $recup_code;
            $recup_code = chiffre($recup_code);
            $requete = "SELECT `id_recuperation` FROM `recuperation` WHERE `logins` = '$login'";
            $result = $bdd->query($requete);
            $ligne = $result -> fetch_assoc(); 
            if($ligne != NULL) {
                $requete = "UPDATE `recuperation` SET `code`='$recup_code' WHERE `logins` = '$login'";
                $resultat = $bdd->query($requete);
            } else {
                $requete = "INSERT INTO recuperation(logins,code) VALUES ('$login','$recup_code')";
                $resultat = $bdd->query($requete);
            }
            if(envoi_mail($email,$recup_code)){
                header('Location:/view/email_send.php');
            } else if (!envoi_mail($email,$recup_code)) {
                echo("erreur, the email has not been sent");
            }
        } 
    }
}

//l'utilisateur rentre son code et est rediriger sur la page sinon affiche une erreur
if(isset($_POST['recup_code'])){
    $login = $_POST['logins'];
    $email = recupere_email($login);
    $recup_code = htmlspecialchars($_POST['verif_code']);
    $requete = "SELECT `logins`,`code` FROM `recuperation` WHERE `code` = '$recup_code'";
    $resultat = $bdd->query($requete);
    $ligne = $resultat -> fetch_assoc(); 
    if($ligne != NULL){
        if($ligne['logins'] == $_SESSION['recup_logins']){
            header('Location:/view/password_recover.php?everif=logins&mail='.$email.'&verif=code&code='.$recup_code.'&logins='.$login);
        }
    } else {
        $erreur = "wrong code try again";
    }
}

//l'utilisateur entre son nouveau mdp.
if(isset($_POST['new_password'])){
    $login = htmlspecialchars($_POST['logins']);
    $recup_code = htmlspecialchars($_POST['code']);
    $new_pass = htmlspecialchars($_POST['new_pass']);
    if(change_pwd($login,$new_pass)){
        $_SESSION['$success'] = "password has been successfully updated";
        header('Location:/view/index.php');
    } else {
        $success = "something went wrong try again";
    }
}
