<?php
if(!isset($_SESSION)){
    session_start();
    if (!isset($_SESSION["utilisateur"])){
        header("Location://test-site/Site/view/index.php");
    }
};

include_once('action.php');

$id_tournament = htmlspecialchars($_GET['id_tournois']);
$team = htmlspecialchars($_GET['Team']);
$player = [];



if(isset($team)){
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $url = "https"; 
        } else {
            $url = "http"; 
        }
        
    // Ajouter l'emplacement de la ressource demandée à l'URL
    $url .= $_SERVER['REQUEST_URI']; 
    $url = str_replace( array( '%', '@', '\'', ';', '<', '>','&', '?', '=' ), ' ', $url);    
    $url = explode(' ',$url);  // create an array separated with by the spaces
    for($i = 0; $i < count($url); $i++) {
        if ($url[$i] == 'player' ){
            $player[] = $url[$i + 1];
        }
    }

    // creer une fonction pour verifier si le joueur n'est pas en double


    ///////////////////////////////////////////////////////////////


    //Check if the players are a part of the signing up team
    //return false if they are not
    function check_player_team($team, $player, $id_tournament){
        global $bdd;
        global $database_shootmania;
        $player_team = [];
        $i = 0;
        mysqli_select_db($bdd, $database_shootmania);
        $bdd->set_charset("utf8");
        $requete = "SELECT login_player FROM `player_teams` WHERE `team_name` = '$team'"; 
        $resultat = $bdd->query($requete);
        while ($ligne = $resultat->fetch_assoc()){
            $player_team[$i] = $ligne['login_player'];
            $i++;
        }
        for ($i = 0; $i < count($player) ; $i++){
            if($player[$i] === $player_team[$i]){
                var_dump(TRUE);
                return $ligne;
            } else {
                $_SESSION['erreur'] = "something went wrong check player team";
                header("Location://testsite/view/Tournament.php?id=$id_tournament");
            }
        }
    }



    //return the name of the tournament
    function select_name_tournament_by_id($id_tournament){
        global $bdd;
        global $database_shootmania;
        mysqli_select_db($bdd, $database_shootmania);
        $bdd->set_charset("utf8");
        $requete = "SELECT nom_tournois FROM `tournois` WHERE `id_tournois` = '$id_tournament'"; 
        $resultat = $bdd->query($requete);
        $ligne = $resultat -> fetch_assoc();
        $ligne = $ligne['nom_tournois'];
        return $ligne;
    }

    //return the number of player required for the tournament
    function select_nb_player_tournament($id_tournament){
        global $bdd;
        global $database_shootmania;
        mysqli_select_db($bdd, $database_shootmania);
        $bdd->set_charset("utf8");
        $requete = "SELECT nombre_player FROM `tournois` WHERE `id_tournois` = '$id_tournament'"; 
        $resultat = $bdd->query($requete);
        $ligne = $resultat -> fetch_assoc();
        $ligne = intval($ligne['nombre_player']);
        return $ligne;
    }

    //check if the number of player is equal of the nb of player required to play the tournament
    function nb_player($player, $id_tounament){
        $nb_player_tournament = select_nb_player_tournament($id_tounament);
        $nb_player = count($player);
        if($nb_player === $nb_player_tournament){
        return $nb_player;
        } else { 
            return $nb_player = -1;
        }
    }

    // create the SQL query wich depends of the number of player required (5 max)
    function add_team_tournament($id_tournament, $team, $player){
        $name = select_name_tournament_by_id($id_tournament);
        $name_without_space = str_replace(str_split('# :/;.,?&~"{(-|è`_\'ç^à@)]°=+}*µ$£¨ù%§<>%ù'), '_', $name);
        $nb_player = nb_player($player,$id_tournament);
        switch ($nb_player){
            case -1:
                return False;
            case 1:
                $player_1 = $player[0];
                $requete = "INSERT INTO $name_without_space VALUES ('$name' , '$id_tournament', '$team', '$player_1')";
                return $requete;

            case 2:
                $player_1 = $player[0];
                $player_2 = $player[1];
                $requete = "INSERT INTO $name_without_space VALUES ('$name' , '$id_tournament', '$team', '$player_1', '$player_2')";
                return $requete;

            case 3:
                $player_1 = $player[0];
                $player_2 = $player[1];
                $player_3 = $player[2];
                $requete = "INSERT INTO $name_without_space VALUES ('$name' , '$id_tournament', '$team', '$player_1', '$player_2', '$player_3')";
                return $requete;

            case 4:
                $player_1 = $player[0];
                $player_2 = $player[1];
                $player_3 = $player[2];
                $player_4 = $player[3];
                $requete = "INSERT INTO $name_without_space VALUES ('$name' , '$id_tournament', '$team', '$player_1', '$player_2', '$player_3', '$player_4')";
                return $requete;

            case 5:
                $player_1 = $player[0];
                $player_2 = $player[1];
                $player_3 = $player[2];
                $player_4 = $player[3];
                $player_5 = $player[4];
                $requete = "INSERT INTO $name_without_space VALUES ('$name' , '$id_tournament', '$team', '$player_1', '$player_2', '$player_3', '$player_4', '$player_5')";
                return $requete;
        }
    }

    // send the SQL query to the server
    function send_sql_request($id_tournament,$team,$player){
        global $bdd;
        global $database_tournament;
        $sql = add_team_tournament($id_tournament, $team, $player);
        if( $sql == false) {
            $_SESSION['erreur'] = "something went wrong sql requet is wrong error -> can't add team in tournament";
            header("Location://testsite/view/Tournament.php?id=$id_tournament");
        }
        mysqli_select_db($bdd,$database_tournament);
        $bdd->set_charset("utf8");
        $resultat = $bdd->query($sql);
        if($resultat == FALSE){
            $_SESSION['erreur'] = "something went wrong send sql request error -> impossible to send the request";
            header("Location://testsite/view/Tournament.php?id=$id_tournament");
        } else {
            header("Location://testsite/view/Tournament.php?id=$id_tournament");
        }
    }

    

    //////////////////////////////////////////////////
    /////////sending the sql request to the DB////////
    //////////////////////////////////////////////////

    check_player_team($team, $player, $id_tournament);
    if(!send_sql_request($id_tournament,$team,$player)){
        echo ($_SESSION['erreur']);
    };



    
} else {
    $_SESSION['erreur'] = 'no team as been selectioned';
    header("Location://testsite/view/Tournament.php?id=$id_tournament");
}
