<?php
include_once("action.php");


if (isset($_POST['team'])) {
    $id_team = htmlspecialchars($_POST['team']);
    $id_tournament = $_SESSION['id_tournament'];

    if ($id_team == '') {
        $_SESSION['err'] = 'Impossible to sign up your team';
        return 0;
    } else {
        $logins = player_team($id_team);

        foreach ($logins as $login) {
            $player = get_players_registered($login, $id_tournament);

            if ($player) {
                // Case à cocher désactivée
                echo '<input type="checkbox" name="player[]" id="' . $login . 
                    '" value="' . $login .  '" disabled/>';
                echo '<label for="' . $login . '">' . $login . '</label><br />';
            } else {
                // Case à cocher activée
                echo '<input type="checkbox" name="player[]" id="' . $login . 
                    '" value="' . $login .  '"/>';
                echo '<label for="' . $login . '">' . $login . '</label><br />';
            }
        }
    }
}


//return the player of the team
function player_team($id_team) {
    $requete = "SELECT `login_player` FROM `player_teams` WHERE `id_player_teams` = ?";
    $resultat = sql_request($requete, [$id_team]);
    $logins = array();
    while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
        $logins[] = $ligne['login_player'];
    }
    return $logins;
}

//verifie si les joueurs sont deja enregistrer dans le tournois
//check if players are already signed up to the tournament
function get_players_registered($player, $id_tournament){
    $requete = "SELECT * FROM `tournament_team_player` WHERE `id_tournois_tournois` = ? and `user_login` = ?";
    $resultat = sql_request($requete, [$id_tournament, $player]);
    while ($ligne = $resultat -> fetch(PDO::FETCH_ASSOC)){
        if ($ligne['user_login'] == $player){
            return $ligne['user_login'];
        }
    }
    return false;
}