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
        $id_tournois = get_last_id_tournament();
        create_table_tournament_playable($nb_player, $id_tournois); //creer la table avec le nom du tournois.
        $_SESSION["tournament"] = true;
        header('Location:../view/home.php');
    }  else {
        $_SESSION["tournament"] = false;
        header('Location:../view/new_tournament.php');
    }
}

// create a new tournament
function Create_Tournament($Name, $Desc, $nb_player, $Mode, $Image, $Date, $Serv, $Createur) {
	global $database_shootmania;
    if($Image){
        $requete = "INSERT INTO `tournois` VALUES (`id_tournois`, '$Name', '$Desc', '$nb_player', '$Mode', '$Image', '$Serv', '$Date', '$Createur' )";
    } else {
        $requete = "INSERT INTO `tournois` VALUES (`id_tournois`, '$Name', '$Desc', '$nb_player', '$Mode', DEFAULT, '$Serv', '$Date', '$Createur' )";
    }
	$resultat = sql_request($database_shootmania,$requete);
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

//create the table where the player will register
function create_table_tournament_playable($nb_players, $id_tournois){
	global $database_tournament;
    $str_id = intval($id_tournois);
    	$sql = "CREATE TABLE IF NOT EXISTS `$str_id` (
		`id_team_tournois_playable` INT NOT NULL, ";
		for($i = 1; $i <= $nb_players; $i++){
			$sql .= "`player_$i` VARCHAR(50) NOT NULL, "; //depends of the number of players
		}
	$sql .= "PRIMARY KEY (`id_team_tournois_playable`))";
	$result = sql_request($database_tournament, $sql);
	return $result;
}