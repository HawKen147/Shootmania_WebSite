<?php
if (!isset($_SESSION)) {
    session_start();
    if (!isset($_SESSION["utilisateur"])) {
        header("Location:../view/index.php");
    }
};

include_once('action.php');


final_call();

//final function: wrap everythings
function final_call(){
    $id_tournament = htmlspecialchars($_GET['id_tournois']);
    $team_name = htmlspecialchars($_GET['Team']);
    $nb_player = nb_player_tounament($id_tournament);
    $players = get_players();
    check_player_team($team_name, $players);
    $id_team = recupere_id_team($team_name);
    check_signed_up_team($id_team, $id_tournament);
    if (check_players_registered($team_name, $id_tournament, $nb_player) == 0){
        if (sign_up_the_team($id_tournament, $id_team, $players)){
            header("Location:../view/tournament.php?id=" . $id_tournament);
        } 
    } else {
            $_SESSION['err'] = "something went wrong";
            header("Location:../view/tournament.php?id=" . $id_tournament);
    }
}

//sign up the team to the tournament
function sign_up_the_team($id_tournament, $id_team, $players){
    global $database_tournament;
    $requete = sql_querry_team_tournament($id_tournament, $id_team, $players);
    $resultat = sql_request($database_tournament, $requete);
    return $resultat;
}

//get the player that are going to register
function get_players(){
    $url = $_SERVER['REQUEST_URI'];
    $player = str_replace("&player=", " ", $url);
    $player = explode(" ", $player);
    array_shift($player);
    return $player;
}

//check if the players belongs to the team 
function check_player_team($team_name, $players){
    $nb = 0;
    $player_team = get_player_team($team_name); // all players of the team
    for($i = 1; $i <= count($player_team); $i++){
        for ($j = 0; $j < count($players); $j++){
            if ($player_team[$i] == $players[$j]){
                $nb ++;
            }
        }
    }
    if ($nb == count($players)){
        return TRUE;
    } else {
        return FALSE;
    }
}

//get players from a specific team and returns the players
function get_player_team($team_name){
    global $database_shootmania;
    $i = 1;
    $id_team = recupere_id_team($team_name);
    $requete = "SELECT `login_player` from `player_teams` WHERE `id_player_teams` = '$id_team'";
    $resultat = sql_request($database_shootmania, $requete);
    if ($resultat){
        while ($ligne = $resultat -> fetch_assoc()){
            $player[$i] = $ligne['login_player'];
            $i ++;
        }
    return $player;
    }
}

//verifie si la team est pas deja inscrite
//check if the team has not sign up already
function check_signed_up_team($id_team, $id_tournament){
    global $database_tournament;
    $requete = "SELECT `id_team_tournois_playable` FROM `$id_tournament` WHERE `id_team_tournois_playable` = '$id_team'";
    $resultat = sql_request($database_tournament, $requete);
    return $resultat;
}

//gets the players of a specific team registered on the tournament
function get_player_team_tournament($id_tournament, $nb_player){
    global $database_tournament;
    $requete = "SELECT * FROM `$id_tournament`";
    $resultat = sql_request($database_tournament, $requete);
    if($resultat){
        while ($ligne = $resultat -> fetch_assoc()){
            for ($i = 1; $i <= $nb_player; $i++){
                $player[$i] = $ligne['player_'.$i];
            }
        }
        if(isset($player)){
            return $player;
        }
    } else {
        return $resultat;
    }
}

//verifie si les joueurs sont deja enregistrer dans le tournois
//check if players are already signed up to the tournament
function check_players_registered($team_name, $id_tournament, $nb_player){
    $nb = 0;
    $player_sign_up_team = get_player_team_tournament($id_tournament, $nb_player); //player signed up
    $player_team = get_player_team($team_name);
    if (isset($player_sign_up_team) AND isset($player_team)){
        for($i = 1; $i <= count($player_team); $i++){
            for ($j = 1; $j <= count($player_sign_up_team); $j++){
                if ($player_team[$i] == $player_sign_up_team[$j]){
                    $nb ++;
                }
            }
        }
        return $nb;
    }
}

// create the SQL query wich depends of the number of player required (5 max)
function sql_querry_team_tournament($id_tournament, $id_team, $player){
    $nb_player = count($player);
    switch ($nb_player) {
        case -1:
            return False;
        case 1:
            $player_1 = $player[0];
            $requete = "INSERT INTO `$id_tournament` VALUES ('$id_team', '$player_1')";
            return $requete;
        case 2:
            $player_1 = $player[0];
            $player_2 = $player[1];
            $requete = "INSERT INTO `$id_tournament` VALUES ('$id_team', '$player_1', '$player_2')";
            return $requete;
        case 3:
            $player_1 = $player[0];
            $player_2 = $player[1];
            $player_3 = $player[2];
            $requete = "INSERT INTO `$id_tournament` VALUES ('$id_team', '$player_1', '$player_2', '$player_3')";
            return $requete;
        case 4:
            $player_1 = $player[0];
            $player_2 = $player[1];
            $player_3 = $player[2];
            $player_4 = $player[3];
            $requete = "INSERT INTO `$id_tournament` VALUES ('$id_team', '$player_1', '$player_2', '$player_3', '$player_4')";
            return $requete;
        case 5:
            $player_1 = $player[0];
            $player_2 = $player[1];
            $player_3 = $player[2];
            $player_4 = $player[3];
            $player_5 = $player[4];
            $requete = "INSERT INTO `$id_tournament` VALUES ('$id_team', '$player_1', '$player_2', '$player_3', '$player_4', '$player_5')";
            return $requete;
    }
}