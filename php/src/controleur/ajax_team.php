<?php
include_once("action.php");

if(isset($_POST['team'])){
    $nom_team = htmlspecialchars($_POST['team']);
    if ($nom_team == ''){
        echo('');
        return 0;
    }
    global $bdd;
    global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$requete = "SELECT `login_player` FROM `player_teams` WHERE `team_name` = '$nom_team'";
	$resultat = $bdd->query($requete);
	if ($resultat != null){
        $i = 0;
		while ($ligne = $resultat->fetch_assoc()) {
            echo ('<input type="checkbox" name="player"  id=' . $ligne['login_player'] . ' value=' . $ligne['login_player'] .  '/><label for=' . $ligne['login_player'] . 
            '>' . $ligne['login_player'] . '</label><br />');
            $i++;
		}
		return $i;
	}
}
