<?php
if(!isset($_SESSION)){
    session_start();
}
require("BDD.php");


////////////////////////////////////////////////////////////////////////////////////////////////
///// creer des divs puis rentrer les fonctions pour afficher les tournois /////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////

//send a sql querry
function sql_request($requete, $parametres = []) {
	$pdo = seConnecterBDD(); 
	// Préparer la requête
	$stmt = $pdo->prepare($requete);
	// Exécuter la requête avec les paramètres fournis (s'il y en a)
	$stmt->execute($parametres);
 	// Renvoyer le résultat de la requête
	return $stmt;
}

// verifie si l'utilisateur est deja dans la base de donnée
function login_existe_dans_la_BDD($login){
    // Requête pour vérifier si le login existe déjà
    $requete = "SELECT logins FROM users WHERE logins = ?";
    // Exécuter la requête avec le login fourni en tant que paramètre
    $resultat = sql_request($requete, [$login]);
    if ($resultat) {
        // Récupérer la première ligne de résultat
        $row = $resultat->fetch(PDO::FETCH_ASSOC);
		if ($row) {
            // Le login existe déjà dans la base de données
            $_SESSION['err'] = 'Sorry, this login is already taken: ' . $login;
            return true;
        } else {
            // Le login n'existe pas encore dans la base de données
            return false;
        }
    }
}

// check if the adresse mail is already in the table
function mail_existe_dans_la_BDD($email){
	$requete = "SELECT mail FROM `users` WHERE `mail` = ? " ;
	$resultat = sql_request($requete, [$email]);
	if ($resultat){
		$row = $resultat->fetch(PDO::FETCH_ASSOC);
		if ($row == 0){
			return false;
		} else {
			// le mail existe dans la bdd
			$_SESSION['err'] = 'Sorry, this email already exist : ' . $email;
			return true;
		}
	}
};

// verify that password and password confirm are the same
function password_confirm($mot_de_passe, $confirmation){
	$res = TRUE;
	if ($mot_de_passe === $confirmation){
		return $res;
	} else {
		$_SESSION['err'] = 'Sorry, password and confirmation password are differents';
		$res = FALSE;
		return $res;
	}
};

// ajoute un utilisateur a la base 
function inscrit_utilisateur($logins, $password, $confirmation, $email) {
if (login_existe_dans_la_BDD($logins) == FALSE && mail_existe_dans_la_BDD($email) == FALSE && password_confirm($password, $confirmation) == TRUE){     // verify that mail, login are not already taken and password / password confirm are not differents
	$password_hash = password_hash($password, PASSWORD_BCRYPT);
	$requete = "INSERT INTO  `users`(`logins`, `mdp`, `mail`) VALUES (?, ?, ?)";
	$resultat = sql_request($requete, [$logins, $password_hash, $email]); 
	return $resultat;
	}
};

//connect un utilisateur au site.
function connecte_utilisateur($logins, $password){
	$requete = "SELECT mdp FROM `users` WHERE `logins` = ?";
	$resultat = sql_request($requete, [$logins]);
	if ($resultat){
		$row = $resultat->fetch(PDO::FETCH_ASSOC);
		if (password_verify($password, $row['mdp'])){
			return true;
		}
	}
}


// fonction qui change le mot de passe apres recuperation de ce dernier
function change_pwd($logins,$password){
	$password_hash = password_hash($password, PASSWORD_BCRYPT);
	$requete = "SELECT logins, mdp FROM `users` WHERE `logins` = ? AND `mdp` = ?" ;
	$resultat = sql_request($requete, [$password_hash, $logins]);
	return $resultat;
}


// function which add the discord id to the DB
function ajoute_discord($discord){
	$user = $_SESSION ["utilisateur"];
	$requete = "UPDATE `users` SET `id_discord` = ? WHERE `logins` =  ? ";
	$resultat = sql_request($requete, [$discord, $user]);
	if($resultat){
		return TRUE;
	} else {
		return FALSE;
	}
}

// verifie si l'id discord existe ou pas
function id_discord(){
	$user = $_SESSION["utilisateur"];
	$requete = "SELECT id_discord FROM `users` WHERE `logins` = ? " ;
	$resultat = sql_request($requete, [$user]);
	if($resultat){
		$ligne = $resultat->fetch(PDO::FETCH_ASSOC);
		return ($ligne['id_discord']);
	}
};

// recupere id du dernier tournois
function get_last_id_tournament() {
	$requete = "SELECT id_tournois FROM tournois ORDER BY id_tournois DESC LIMIT 1";
	$resultat = sql_request($requete);
	if ($resultat){
		$ligne = $resultat->fetch(PDO::FETCH_ASSOC);
		return $ligne['id_tournois'];;
	}
};

//get the number of player for a specified tournament
function nb_player_tounament($id){
	$id = htmlspecialchars($id);
	$requete = "SELECT nombre_player FROM tournois WHERE id_tournois = ? ";
	$resultat = sql_request($requete, [$id]);
	if($resultat){
		$ligne = $resultat->fetch(PDO::FETCH_ASSOC);
		return $ligne['nombre_player'];
	}
};

// recupere l'id du tournois passé dans l'url 
function get_id_url(){
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
    	$url = "https";
	} else {
    	$url = "http";
	}
	$url .= $_SERVER['REQUEST_URI'];
    $components = parse_url($url);
    parse_str($components['query'], $resultat);
	$id = $_GET['id'];
	return $id;
}


// recupere le pseudo passer en parametre dans l'url
function get_user_url(){
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
    	$url = "https";
	} else {
    	$url = "http";
	}
	$url .= $_SERVER['REQUEST_URI'];
    $components = parse_url($url);
    parse_str($components['query'], $resultat);
	$name = $_GET['name'];
return $name;
}


// affiche l'email de l'utilisateur
function email(){
	$user = $_SESSION["utilisateur"];
	$requete = "SELECT mail FROM `users` WHERE `logins` = ?" ;
	$resultat = sql_request($requete, [$user]);
	if($resultat){
		while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
			return $ligne['mail'];
		}
	}
}


// affiche le tournois avec l'id du tournois passer en parametre dans l'url
function affiche_tournois_url(){
	$id = get_id_url();
	$requete = "SELECT * FROM tournois WHERE id_tournois = ?";
	$resultat = sql_request($requete, [$id]);
	if ($resultat){
		while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
			echo '<div class="affiche-url">' . '<div class="tournois-url">' . '<div class="title-url">' .  $ligne['nom_tournois'] . ' by ' .  $ligne['createur'] 
			. '<img class="image-lim-url" src= '. $ligne['image'] . '>' . '</div>' . '<br>' .  'Mode : ' . $ligne['mode'] 
			. '<br>' . 'Time : ' . $ligne['time_tournament'] . '<br>' . '<br>' . $ligne['description'] . '<br>' . '<br>' .'Link of the server for the cup : ' . $ligne['link_serv'] . '</a>' . '<br>' . '<br>' . '</div>' . '</div>';
		}
	}
	
}

// recupere les tournois et les affiches sur la page Home.php
function affiche_tournois(){
	$requete = "SELECT * FROM tournois ORDER BY time_tournament DESC"; // changer le time dans la creation de la table tournois
	$resultat = sql_request($requete);
	return $resultat;
};

// affiche les tournois crées par l'utilisateur
function affiche_tournois_profile() {
	$user = $_SESSION["utilisateur"];
	$requete = "SELECT * FROM tournois WHERE createur = ? ORDER BY id_tournois DESC";
	$resultat = sql_request($requete, [$user]);
	while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
		echo '<div class="affiche-url">' . '<div class="tournois-url">' . '<div class="title-url">' .  $ligne['nom_tournois'] . ' by ' .  $ligne['createur'] 
		. '<img class="image-lim-url" src= '. $ligne['image'] . '>' . '</div>' . '<br>' .  'Mode : ' . $ligne['mode'] 
		. '<br>' . '<br>' . 'Description : ' . $ligne['description'] . '<br>' . '<br>' . $ligne['link_serv'] . '<br>' . '<br>' .  '</div>' . '</div>';
	}
	return $ligne;
};

/////////////////////////////////////////////////////////////////////
// 					a changer -> meme fonction 					   //
/////////////////////////////////////////////////////////////////////

// recupere le nom du tournois
function affiche_nom_tournois() {
	$user = $_SESSION["utilisateur"];
	$requete = "SELECT * FROM tournois WHERE createur = ? ORDER BY id_tournois DESC";
	$resultat = sql_request($requete, [$user]);
	while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
		echo '<div class="affiche-url">' . '<div class="tournois-url">' . '<div class="title-url">' .  $ligne['nom_tournois'] . ' by ' .  $ligne['createur'] 
		. '<img class="image-lim-url" src= '. $ligne['image'] . '>' . '</div>' . '<br>' .  'Mode : ' . $ligne['mode'] 
		. '<br>' . '<br>' . 'Description : ' . $ligne['description'] . '<br>' . '<br>' . $ligne['link_serv'] . '<br>' . '<br>' .  '</div>' . '</div>';
	}
	return $ligne;
};


// verifie si l'utilisateur est un administrateur
function est_admin() {
	$user = $_SESSION["utilisateur"];
	$requete = "SELECT Administrator FROM `users` WHERE `logins` = ? "; 
	$resultat = sql_request($requete, [$user]);
	$ligne = $resultat->fetch(PDO::FETCH_ASSOC);
	if ($ligne ['Administrator'] == '1' ) {
		return TRUE;
		}
	return FALSE;
};


// affiche les utilisateurs qui ne sont pas admin
// ajouté une fonction pour verifier si la personne est deja admin ou pas 
function affiche_user_no_admin(){
	$requete = "SELECT logins FROM `users` WHERE Administrator = 0"; 
	$resultat = sql_request($requete, [NULL]);
	while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
		echo '<option value="' . $ligne['logins'] . '">' . $ligne['logins'] . '</option>';
	}
	return $ligne;
};

// affiche les utlilsiateur qui sont admnistrateur sur le site
function affiche_user_admin(){
	$requete = "SELECT logins FROM `users` WHERE Administrator = 1"; 
	$resultat = sql_request($requete);
	while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
		echo '<option value="' . $ligne['logins'] . '">' . $ligne['logins'] . '</option>';
	}
	return $ligne;
};

/////////////////////////////////////////////////////////////////////
// 							a verifier							   //
/////////////////////////////////////////////////////////////////////

//ajoute un admin
function add_admin($user){
	$requete = "UPDATE `users` SET `Administrator`= '1' WHERE `logins` = ?"; 
	$resultat = sql_request($requete, [$user]);
	$_SESSION['add_admin'] = "user has been added as admin";
	return $resultat;
};

//supprime un administrateur
function del_admin($user){
	$requete = "UPDATE `users` SET `Administrator`='0' WHERE `logins` = ? "; 
	$resultat = sql_request($requete, [$user]);
	$_SESSION['del_admin'] = "user has been deleted from admin";
	return $resultat;
};

// ban des joueurs du site web
// rajouter une colonne dans la BDD pour dire si le joueur est banni ou pas
// ou alors creer une table banni pour tous les joueurs qui sont bannis

function ban_player($user){
}


// function qui verifie si la personne est le createur du tournois
function est_createur_tournois(){
	$user = $_SESSION['utilisateur'];
	$id = $_GET['id'];
 	$requete = "SELECT id_tournois, createur FROM tournois WHERE `createur` = ? AND `id_tournois` = ?";
	$resultat = sql_request($requete, [$user, $id]);
	if ($resultat){
		while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
			if (isset($ligne['createur']) === $user ){
				return true;
			}
		}
	}
	return false;
}

// fonction qui supprime un tournois 
function del_tournament($id_tournois){
 	$requete = "DELETE FROM tournois WHERE `id_tournois` = ? ";
	$resultat = sql_request($requete, [$id_tournois]);
	return $resultat;
}

// affiche les equipes auxquels appartiens le joueur
function affiche_team_joueur(){
	$requete = "SELECT	`id_teams`,
						`id_player_teams`,
						`login_player`,
						`nom_team`,
						`images`
				FROM
					`player_teams`
				INNER JOIN 
					`teams` 
				ON player_teams.id_player_teams = teams.id_teams";
	$resultat = sql_request($requete);
	if ($resultat != null){
		return $resultat;
	}
}

// affiche la team selectionné
function affiche_team(){
	$id = htmlspecialchars($_GET['id_teams']);
	$requete = "SELECT * FROM `teams` WHERE `id_teams` = ?";
	$resultat = sql_request($requete, [$id]);
	if ($resultat){
		return $resultat;
	}
}	

//recupere les joueurs d'une equipe avec id passe dans l'url
function affiche_joueur_team(){
	$id = htmlspecialchars($_GET['id_teams']);
	$requete = "SELECT `login_player` FROM `player_teams` WHERE `id_player_teams` = ? ";
	$resultat = sql_request($requete, [$id]);
	return $resultat;
}

//ajoute un joueur dans une team et le createur quand il cree la team
function ajoute_joueur($user, $id){
	$requete = "INSERT INTO player_teams VALUES ( ? , ? )";
	$resultat = sql_request($requete, [$id, $user]);
	return $resultat;
}

//fonction qui creer le lien pour ajouter des joueurs a sa team
function create_url_team(){
	$id = htmlspecialchars($_GET['id_teams']);
	$invite = parse_the_team_invite($id);
	$limit = parse_the_limit_date($id);
	$link = '?id_teams=' . $id . '&invite=' . $invite . '&limit=' . $limit ; 
	return $link;
}


function parse_the_team_invite($id_teams){
	$salt = '1&°(çé=7858è(&é"*µ';
	$invite = md5($id_teams . $salt);
	return $invite;
}


function parse_the_limit_date($name_team){
	$day = date('d');
	$year = date('Y');
	$end = md5($name_team . $day . $year);
	return ($end);
}


// function qui recupere les teams en fonction de l'utilisateurs
function show_teams(){
	$user = $_SESSION['utilisateur'];
 	$requete = "SELECT `id_teams`, `nom_team` FROM `teams` WHERE `createur` = ? ";
	$resultat = sql_request($requete, [$user]);
	if ($resultat){
		while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)){
			$id = $ligne['id_teams'];
			$name = $ligne['nom_team'];
			$teams[] = array(
				"id" => $id,
				"name" => $name
			);
		}
	} 	
	if (isset($teams)){
		return $teams;
	}
}

//recupere la date actuelle
function get_date(){
	date_default_timezone_set('Europe/Paris');
  	$dt = new \DateTime();
	$day = $dt->format('d/m/Y H:i');
	return $day;
}

//return the status of the tournament
function get_tournament_status($id_tournament){
    $requete = "SELECT `status` FROM `tournament_status` WHERE `id_tournament_status` = ? ";
    $resultat = sql_request($requete, [$id_tournament]);
    if ($resultat){
        $res = $resultat -> fetch(PDO::FETCH_ASSOC);
        return $res;
    }
}

//get the signed teams
function print_team_signed_up($id){
	$requete = "SELECT DISTINCT tournament_team_player.id_team_tournois, teams.nom_team
	FROM tournament_team_player
	INNER JOIN teams ON tournament_team_player.id_team_tournois = teams.id_teams
	WHERE tournament_team_player.id_tournois_tournois = ?";
	$resultat = sql_request($requete, [$id]);
	if ($resultat){
		while ($ligne = $resultat -> fetch(PDO::FETCH_ASSOC)){
			$id = $ligne['id_team_tournois'];
			$name = $ligne['nom_team'];
			$teams[] = array(
				"id" => $id,
				"name" => $name
			);
		}
	}
	if (isset($teams)){
		return $teams;
	}
}


//return the teams where the user is the creator of the team
function print_teams($user, $id){
	$requete = "SELECT teams.id_teams, teams.nom_team
	FROM teams
	LEFT JOIN tournament_team_player ON teams.id_teams = tournament_team_player.id_team_tournois AND tournament_team_player.id_tournois_tournois = ?
	WHERE teams.createur = ? AND tournament_team_player.id_team_tournois IS NULL";
	$resultat = sql_request($requete, [$id, $user]);
	if($resultat){
		while ($ligne = $resultat -> fetch(PDO::FETCH_ASSOC)){
			$id = $ligne['id_teams'];
			$name = $ligne['nom_team'];
			$teams[] = array(
				"id" => $id,
				"name" => $name
			);
		}
	}
	if (isset($teams)){
		return $teams;
	}
}


