<?php
include_once("action.php");


if(isset($_POST['team'])){
    $nom_team = htmlspecialchars($_POST['team']);
    if ($nom_team == ''){
        echo('');
        return 0;
    } else {
        global $database_shootmania;
        $id_team = recupere_id_team($nom_team);
	    $requete = "SELECT `login_player` FROM `player_teams` WHERE `id_player_teams` = '$id_team'";
	    $resultat = sql_request($database_shootmania, $requete);
   	    if ($resultat){
            $i = 1;
		    while ($ligne = $resultat->fetch_assoc()) {
                echo ('<input type="checkbox" name="player"  id="' . $ligne['login_player'] . '" value="' . $ligne['login_player'] .  '"/><label for=' . $ligne['login_player'] . 
                '>' . $ligne['login_player'] . '</label><br />');
                $i++;
		    }
		}
	}
}