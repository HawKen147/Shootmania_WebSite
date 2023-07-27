<?php
include("action.php");

///////////////////////////////////////////////////////////////////////////
//////////////////  Crate a new Tournament  ///////////////////////////////
///////////////////////////////////////////////////////////////////////////


if (isset($_POST['Tournament_Name']) && isset($_POST['Tournament_Desc']) && isset($_POST['Tournament_mode'])){
    $Name = htmlspecialchars($_POST['Tournament_Name']);
    $Desc = htmlspecialchars($_POST['Tournament_Desc']);
    $nb_player = htmlspecialchars($_POST['Tournament_nb_player']);
    $Mode = htmlspecialchars($_POST['Tournament_mode']);
    $Image = htmlspecialchars($_POST['Image_Tournament']);
    $Date = htmlspecialchars($_POST['time']);
    $Serv = htmlspecialchars($_POST['Serv_Link']);
    $Createur = htmlspecialchars($_SESSION["utilisateur"]);
    $Date = replace_char($Date);
    $Date = date_in_good_order($Date);

    if (Create_Tournament($Name, $Desc,$nb_player, $Mode, $Image, $Date, $Serv, $Createur)){
        $id_tournament = get_last_id_tournament();
        $resultat = init_status($id_tournament);
        $_SESSION['tournois'] = "your tournament has been created";
        header('Location:../view/home.php');
    }  else {
        $_SESSION["tournois"] = 'Something went wrong, try again';
        header('Location:../view/new_tournament.php');
    }
}

// create a new tournament
function Create_Tournament($Name, $Desc, $nb_player, $Mode, $Image, $Date, $Serv, $Createur) {
    if($Image){
        $requete = "INSERT INTO `tournois` VALUES (`id_tournois`, ?, ?, ?, ?, ?, ?, ?, ?)";
        $resultat = sql_request($requete, [$Name, $Desc, $nb_player, $Mode, $Image, $Serv, $Date, $Createur]);
    } else {
        $requete = "INSERT INTO `tournois` VALUES (`id_tournois`, ?, ?, ?, ?, DEFAULT, ?, ?, ? )";
        $resultat = sql_request($requete, [$Name, $Desc, $nb_player, $Mode, $Serv, $Date, $Createur]);
    }
	return $resultat;
};

//replace special character for the date
function replace_char($string){
    $string = str_replace(str_split('# :/;.,?&~"{(-|è`_\'ç^à@)]°=+}*µ$£¨ù%§<>%ùT'), '', $string);
    return $string;
}

//change the date format
function date_in_good_order ($dateString){
    $year = substr($dateString, 0, 4);
    $month = substr($dateString, 4, 2);
    $day = substr($dateString, 6, 2);
    $hour = substr($dateString, 8, 2);
    $minute = substr($dateString, 10, 2);
    $dateStringFormatted = $day . '/' . $month . '/' . $year . ' ' . $hour . ':' . $minute;
    return $dateStringFormatted;
}

//function qui initialise le status du tournois
function init_status($id_tournament){
	$requete = "INSERT INTO `tournament_status`(`id_tournament_status`, `status`) VALUES ( ? ,'incoming')";
	$resultat = sql_request($requete, [$id_tournament]);
	return $resultat;
}
