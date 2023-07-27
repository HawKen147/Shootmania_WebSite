<?php
if (!isset($_SESSION)) {
    session_start();
    if (!isset($_SESSION["utilisateur"])) {
        header("Location:../view/index.php");
    }
};

include_once('action.php');


final_call();

//final function: wrap everything
function final_call(){
    $id_tournament = htmlspecialchars($_POST['id_tournois']);
    $id_team = htmlspecialchars($_POST['Team']);
    $players = $_POST['player'];
    if(check_player_team($id_team, $players)){          // verifie si les joueurs font bien partie la leurs team
        if(!check_signed_up_team($id_team, $id_tournament)){         //verifie si l'equipe est deja inscrite
            if (!check_players_registered($players, $id_tournament)){        //verifie si un joueur est deja inscrit
                if (sign_up_the_team($id_tournament, $id_team, $players)){          //inscrit l'equipe et les joueurs  
                    $_SESSION['err'] = "Your team '" . get_team_name($id_team) . "' has been registered ";
                    header("Location:../view/tournament.php?id=" . $id_tournament);
                    exit;
                } 
            }
        }   
    header("Location:../view/tournament.php?id=" . $id_tournament);
    exit;
    }
}

//sign up the team to the tournament
function sign_up_the_team($id_tournament, $id_team, $players){
    $resultat = sql_querry_team_tournament($id_tournament, $id_team, $players);
    return $resultat;
}

//check if the players belongs to the team 
//return true if the player is not a part of the team
function check_player_team($id_team, $players){
    foreach($players as $player){
        $requete = "SELECT `login_player` FROM `player_teams` WHERE `id_player_teams` = ? AND `login_player` = ?";
        $resultat = sql_request($requete, [$id_team, $player]);
        $ligne['player'] = $resultat -> fetch(PDO::FETCH_ASSOC);
        if ($ligne['player'] == null){
            $_SESSION['err'] = "The player '" . $player . "' is not a team member";
            return false;
        }
    }
    return true;
}

//verifie si la team est pas deja inscrite
//check if the team has not sign up already
function check_signed_up_team($id_team, $id_tournament){
    $requete = "SELECT `id_team_tournois` FROM `tournament_team_player` WHERE `id_tournois_tournois` = ? AND `id_team_tournois` = ?";
    $resultat = sql_request($requete, [$id_tournament, $id_team]);
    $ligne = $resultat -> fetch(PDO::FETCH_ASSOC);
    if(isset($ligne['id_team_tournois'])){
        if($ligne['id_team_tournois'] == null){
            $_SESSION['err'] = 'Your team is already sign up' .  get_team_name($id_team);
            return true;
        }
        $_SESSION['err'] = 'Your team is already sign up' .  get_team_name($id_team);
        return true;
    }
    return false;
}

//verifie si les joueurs sont deja enregistrer dans le tournois
//check if players are already signed up to the tournament
function check_players_registered($players, $id_tournament){
    $requete = "SELECT `user_login` FROM `tournament_team_player` WHERE `id_tournois_tournois` = ?";
    $resultat = sql_request($requete, [$id_tournament]);
    while ($ligne = $resultat -> fetch(PDO::FETCH_ASSOC)){
        foreach ($players as $player){
            if ($ligne['user_login'] == $player){
                $_SESSION['err'] = "A player is already register for this tournament '" . $ligne['user_login'] . "'";
                return true;
            }
        }
    }
    return false;
}

// create the SQL query wich depends of the number of player required (5 max)
function sql_querry_team_tournament($id_tournament, $id_team, $players){
    $nb_players = count($players);
    switch ($nb_players){
        case -1:
            return False;
        case 1:
            $player1 = $players[0];
            $requete = "INSERT INTO `tournament_team_player` (`id_tournois_tournois`, `id_team_tournois`, `user_login`) VALUES ( ?, ?, ?)";
            $resultat = sql_request($requete,[$id_tournament, $id_team, $player1]);
            return $resultat;
        case 2:
            $player1 = $players[0];
            $player2  = $players[1];
            $requete = "INSERT INTO `tournament_team_player` (`id_tournois_tournois`, `id_team_tournois`, `user_login`) VALUES ( ?, ?, ?),( ?, ?, ?)";
            $resultat = sql_request($requete,[$id_tournament, $id_team, $player1, $id_tournament, $id_team, $player2]);
            return $resultat;
        case 3:
            $player1 = $players[0];
            $player2  = $players[1];
            $player3  = $players[2];
            $requete = "INSERT INTO `tournament_team_player` (`id_tournois_tournois`, `id_team_tournois`, `user_login`) VALUES ( ?, ?, ?),( ?, ?, ?),( ?, ?, ?)";
            $resultat = sql_request($requete,[$id_tournament, $id_team, $player1, $id_tournament, $id_team, $player2, $id_tournament, $id_team, $player3]);
            return $resultat;
        case 4:
            $player1 = $players[0];
            $player2  = $players[1];
            $player3  = $players[2];
            $player4 = $players[3];
            $requete = "INSERT INTO `tournament_team_player` (`id_tournois_tournois`, `id_team_tournois`, `user_login`) VALUES ( ?, ?, ?),( ?, ?, ?),( ?, ?, ?),( ?, ?, ?)";
            $resultat = sql_request($requete,[$id_tournament, $id_team, $player1, $id_tournament, $id_team, $player2, $id_tournament, $id_team, $player3, $id_tournament, $id_team, $player4]);
            return $resultat;
        case 5:
            $player1 = $players[0];
            $player2  = $players[1];
            $player3  = $players[2];
            $player4 = $players[3];
            $player5 = $players[4];
            $requete = "INSERT INTO `tournament_team_player` (`id_tournois_tournois`, `id_team_tournois`, `user_login`) VALUES ( ?, ?, ?),( ?, ?, ?),( ?, ?, ?),( ?, ?, ?),( ?, ?, ?)";
            $resultat = sql_request($requete,[$id_tournament, $id_team, $player1, $id_tournament, $id_team, $player2, $id_tournament, $id_team, $player3, $id_tournament, $id_team, $player4, $id_tournament, $id_team, $player5]);
            return $resultat;
    }
}

//recupere le nom de l'equipe
function get_team_name($id_team){
    $requete = "SELECT nom_team FROM teams WHERE id_teams = ?";
    $resultat = sql_request($requete, [$id_team]);
    $ligne = $resultat -> fetch(PDO::FETCH_ASSOC);
    return $ligne['nom_team'];
}