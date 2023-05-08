<?php

use LDAP\Result;

 if(!isset($_SESSION)){
    session_start();
}
include("BDD.php");
$database_shootmania = "ShootMania";
$database_tournament = "tournament";

////////////////////////////////////////////////////////////////////////////////////////////////
///// creer des divs puis rentrer les fonctions pour afficher les tournois /////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////

// create the DB Shootmania
function create_DB_shootmania(){
    global $bdd;
	global $database_shootmania;
    $sql = "CREATE DATABASE IF NOT EXISTS $database_shootmania";
    $result = $bdd->query($sql);
    return $result;
}
if($bdd->connect_errno ) {
    exit();
}
// create the tournament DATABASE
function create_DB_tournament(){
    global $bdd;
	global $database_tournament;
    $sql = "CREATE DATABASE IF NOT EXISTS $database_tournament";
    $result = $bdd->query($sql);
    return $result;
}
if($bdd->connect_errno ) {
    exit();
}

// creer la table utilisateur 
function create_table_utilisateur() {
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$sql = "CREATE TABLE IF NOT EXISTS users (
		`logins` VARCHAR(50) NOT NULL ,
		`mdp` VARCHAR(50) NOT NULL ,
		`mail` VARCHAR(250) NOT NULL ,
		`id_discord`  BIGINT NULL DEFAULT NULL ,
		`Administrator`  INT NULL DEFAULT 0 ,
		PRIMARY KEY (`logins`))";
	$result = mysqli_query($bdd, $sql);
	return $result;
	if($bdd->connect_errno) {
		exit();
	}
};

// cree la table funcup
function create_table_funcup() {
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$sql = "CREATE TABLE IF NOT EXISTS funcup (
		`id_funcups` INT NOT NULL,
		`funcups` TEXT ,
		PRIMARY KEY (`id_funcups`))";
	$result = mysqli_query($bdd, $sql);
	return $result;
	if($bdd->connect_errno) {
		exit();
	}
};

// creer la table Tournois
function create_table_tournois() {
	global $bdd;
	global $database_shootmania; 
	mysqli_select_db($bdd,$database_shootmania);
	$sql = "CREATE TABLE IF NOT EXISTS tournois ( 
	 `id_tournois` INT NOT NULL AUTO_INCREMENT ,
	 `nom_tournois` VARCHAR(50) NOT NULL , 
	 `description` TEXT NOT NULL ,
	 `nombre_player` INT NOT NULL ,
	 `mode` TEXT NOT NULL ,  
	 `image` TEXT NULL DEFAULT NULL ,
	 `link_serv` TEXT NULL DEFAULT NULL ,
	 `time_tournament` VARCHAR(20) NOT NULL,
	 `createur` VARCHAR(50) NOT NULL ,
	 PRIMARY KEY (`id_tournois`))";
	$result = mysqli_query($bdd, $sql);
	return $result;	
};

// creer la table teams
function create_table_team() {
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$sql = "CREATE TABLE IF NOT EXISTS teams ( 
	 `id_teams` INT NOT NULL AUTO_INCREMENT ,
	 `nom_team` VARCHAR(50) NOT NULL , 
	 `images` TEXT  ,
	 `createur` VARCHAR(50) NOT NULL ,
	 PRIMARY KEY (`id_teams`))";
	$result = mysqli_query($bdd, $sql);
	return $result;	
};

// creer la table joueur joue au tournois
function create_table_players_plays() {
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$sql = "CREATE TABLE IF NOT EXISTS Player_Play (
		`id_tournois` INT NOT NULL ,
		`nom` VARCHAR(50) NOT NULL ,
		`description` TEXT NOT NULL ,
		PRIMARY KEY (`id_tournois`) ,
		CONSTRAINT FK_id_tournois FOREIGN KEY (`id_tournois`) REFERENCES tournois(`id_tournois`) ,
		CONSTRAINT FK_id_nom FOREIGN KEY (`nom`) REFERENCES users(`login`))";
	$result = mysqli_query($bdd, $sql);
	return $result;	
};

// creer la table des joueurs qui sont dans une teams
function create_table_player_teams(){
	global $bdd;
	mysqli_select_db($bdd,"ShootMania");
	$sql = "CREATE TABLE IF NOT EXISTS Player_teams (
		`login_player`  VARCHAR(50) NOT NULL ,
		`team_name` VARCHAR(50) NOT NULL ,
		CONSTRAINT FK_login_player FOREIGN KEY (`login_player`) REFERENCES users(`logins`) ,
		CONSTRAINT FK_nom_team FOREIGN KEY (`team_name`) REFERENCES teams(`nom_team`))";
	$result = mysqli_query($bdd, $sql);
	return $result;
}

//creer la table player_tournois qui inscrit les teams dans un tournois
function create_table_player_tournois(){
	global $bdd;
	mysqli_select_db($bdd,"ShootMania");
	$sql = "CREATE TABLE IF NOT EXISTS player_tournois (
		`id_team_tournois`  INT NOT NULL ,
		`id_tournois_tournois` INT NOT NULL ,
		CONSTRAINT FK_login_player FOREIGN KEY (`id_team_tournois`) REFERENCES teams(`id_teams`) ,
		CONSTRAINT FK_id_teams FOREIGN KEY (`id_tournois_tournois`) REFERENCES tournois(`id_tournois`) )";
	$result = mysqli_query($bdd, $sql);
	return $result;
}

//create the table where the player will register
function create_table_tournament_playable($nb_players, $Name_table, $name){
	global $bdd;
	global $database_tournament;
	mysqli_select_db($bdd,$database_tournament);
	$sql = "CREATE TABLE IF NOT EXISTS $Name_table (
		`name_tournament` VARCHAR(50) NOT NULL ,
		`id_tournois` INT NOT NULL,
		`team` VARCHAR(50) NOT NULL, ";
		for($i = 1; $i <= $nb_players; $i++){
			$sql .= "`player_$i` VARCHAR(50) NOT NULL, "; //depends of the number of players
		}
	$sql .= " PRIMARY KEY (`id_tournois`))";
	$result = mysqli_query($bdd, $sql);
	return $result;
}


// creer la table recuperation des mots de passe
function create_table_recuperation() {
	global $bdd;
	mysqli_select_db($bdd,"ShootMania");
	$sql = "CREATE TABLE IF NOT EXISTS recuperation ( 
	 `id_recuperation` INT NOT NULL AUTO_INCREMENT ,
	 `logins` VARCHAR(50) NOT NULL , 
	 `code` TEXT  ,
	 PRIMARY KEY (`id_recuperation`))";
	$result = mysqli_query($bdd, $sql);
	return $result;	
};

// verifie si l'utilisateur est deja dans la base de donnée
function login_existe_dans_la_BDD($logins){
	global $bdd;
	$res = TRUE;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
    $bdd->set_charset("utf8");
	$requete = "SELECT logins FROM users WHERE `logins` = '$logins'" ;
	$resultat = $bdd->query($requete);
	$row = $resultat->fetch_row();
	if ($row > 0){
		$_SESSION['erreur_login'] = $logins;
		return $res;
	} else {
		$res = FALSE;
		return $res;
	}
	if($bdd->connect_errno ) {
		exit();
	}
};



// check if the adresse mail is already in the table
function mail_existe_dans_la_BDD($email){
	global $bdd;
	$res = TRUE;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
    $bdd->set_charset("utf8");
	$requete = "SELECT mail FROM users WHERE `mail` = '$email'" ;
	$resultat = $bdd->query($requete);
	$row = $resultat->fetch_row();
	if ($row == 0){
		$res = FALSE;
	} else {
		$_SESSION['erreur_mail'] = $email;
		$res = TRUE;
	}
	return $res;
};


// verify that password and password confirm are the same
function password_confirm($mot_de_passe, $confirmation){
	$res = TRUE;
	if ($mot_de_passe === $confirmation){
		return $res;
	} else {
		$_SESSION['erreur_mdp_conf'] = "erreur";
		$res = FALSE;
		return $res;
	}
};

// ajoute un utilisateur a la base 
function inscrit_utilisateur($logins, $mot_de_passe, $confirmation, $email) {
if (login_existe_dans_la_BDD($logins) == FALSE && mail_existe_dans_la_BDD($email) == FALSE && password_confirm($mot_de_passe, $confirmation) == TRUE){     // verify that mail, login are not already taken and password / password confirm are not differents
	$salt= "@|-°+==00001ddQ";
	$md5 = md5($mot_de_passe . $salt . $logins .  $salt . $logins . $logins); // cache le mdp dans la base de donnée
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "INSERT INTO users VALUES ('$logins','$md5','$email', NULL, '0')" ;
	$resultat = $bdd->query($requete); /////////////////////////////////////////////////?
	$res = TRUE;
	} else {
		header('Location:formulaire_reg.php');
	}
	return $res;
};

//connect un utilisateur au site.
function connecte_utilisateur($logins, $mot_de_passe){
	$res = NULL;
	$salt= "@|-°+==00001ddQ";
	$md5 = md5( $mot_de_passe . $salt . $logins .  $salt . $logins . $logins  ); // cache le mdp dans la base de donnée
 	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
    $bdd->set_charset("utf8");
	$requete = "SELECT logins, mdp FROM users WHERE `logins` = '$logins' AND `mdp` = '$md5'" ;
	$resultat = $bdd->query($requete);
	$row = $resultat->fetch_row();
	if ($row > 0){
		if ($row[0] === $logins && $row[1] === $md5){
			$res = TRUE;
			return ($res);
		} else {
			return ($res);
		}
	}
};

// fonction qui change le mot de passe apres recuperation de ce dernier
function change_pwd($logins,$mot_de_passe){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$salt= "@|-°+==00001ddQ";
	$md5 = md5($mot_de_passe . $salt . $logins .  $salt . $logins . $logins);
	$requete = "UPDATE `users` SET `mdp`='$md5' WHERE `logins`= '$logins'";
	$resultat = $bdd->query($requete);
	return $resultat;
}


// function which add the discord id to the DB
function ajoute_discord($discord){
	global $bdd;
	$user = $_SESSION ["utilisateur"];
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$requete = "UPDATE users SET `id_discord` = $discord WHERE `logins` =  '$user'";
	$resultat = $bdd->query($requete);
	if($resultat){
		return TRUE;
	} else {
		return FALSE;
	}
}

// verifie si l'id discord existe ou pas
function id_discord(){
	global $bdd;
	$user = $_SESSION["utilisateur"];
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$requete = "SELECT id_discord FROM users WHERE `logins` = '$user'" ;
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		if($ligne['id_discord'] == NULL){
			return FALSE;
		} else {
			return ($ligne['id_discord']);
		}	
	}
};

// create a new tournament
function Create_Tournament($Name, $Desc,$nb_player, $Mode, $Image, $Date, $Serv, $Createur) {
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$id = get_last_id_tournament();
	$id ++;
	$requete = "INSERT INTO tournois VALUES ('$id','$Name','$Desc','$nb_player', '$Mode', '$Image','$Serv', '$Date', '$Createur')" ;
	$resultat = $bdd->query($requete);
	return $resultat;
};

// recupere id du dernier tournois
function get_last_id_tournament() {
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$requete = "SELECT id_tournois FROM tournois ORDER BY id_tournois DESC LIMIT 1";
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		$res = $ligne['id_tournois'];		
		$res = intval($res);
	}
	if(!isset($res)){
		$res = 0;
	} 
	return $res;
};

//get the number of player for a specified tournament
function nb_player_tounament($id){
	global $bdd;
	$id = htmlspecialchars($id);
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$requete = "SELECT nombre_player FROM tournois WHERE id_tournois = '$id'";
	$resultat = $bdd->query($requete);
	$ligne = $resultat->fetch_assoc();
	if( $ligne['nombre_player'] > 1 ){
		echo($ligne['nombre_player'] . ' players for this tournament');
	} else {
		echo($ligne['nombre_player'] . ' player for this tournament');
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
};


// recupere le nom de l'utilisateur
function User(){
	global $bdd;
	$user = $_SESSION["utilisateur"];
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "SELECT logins FROM users WHERE `logins` = '$user'" ;
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		echo $ligne['logins'] ;
	}
	return $ligne;
};

// affiche l'email de l'utilisateur
function email(){
	global $bdd;
	$user = $_SESSION["utilisateur"];
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "SELECT mail FROM users WHERE `logins` = '$user'" ;
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		echo $ligne['mail'] ;
	}
	return $ligne;
};


// affiche le tournois avec l'id du tournois passer en parametre dans l'url
function affiche_tournois_url(){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$id = get_id_url();
	$requete = "SELECT * FROM tournois WHERE id_tournois = $id";
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		echo '<div class="affiche-url">' . '<div class="tournois-url">' . '<div class="title-url">' .  $ligne['nom_tournois'] . ' by ' .  $ligne['createur'] 
		. '<img class="image-lim-url" src= '. $ligne['image'] . '>' . '</div>' . '<br>' .  'Mode : ' . $ligne['mode'] 
		. '<br>' . 'Time : ' . $ligne['time_tournament'] . '<br>' . '<br>' . $ligne['description'] . '<br>' . '<br>' .'Link of the server for the cup : ' . $ligne['link_serv'] . '</a>' . '<br>' . '<br>' . '</div>' . '</div>';
	}
};

// recupere les tournois et les affiches sur la page Home.php
function affiche_tournois(){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "SELECT * FROM tournois ORDER BY time_tournament DESC"; // changer le time dans la creation de la table tournois
	$resultat = $bdd->query($requete);
	return $resultat;
};

// affiche les tournois crées par l'utilisateur
function affiche_tournois_profile() {
	global $bdd;
	$user = $_SESSION["utilisateur"];
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "SELECT * FROM tournois WHERE createur = '$user' ORDER BY id_tournois DESC";
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		echo '<div class="affiche-url">' . '<div class="tournois-url">' . '<div class="title-url">' .  $ligne['nom_tournois'] . ' by ' .  $ligne['createur'] 
		. '<img class="image-lim-url" src= '. $ligne['image'] . '>' . '</div>' . '<br>' .  'Mode : ' . $ligne['mode'] 
		. '<br>' . '<br>' . 'Description : ' . $ligne['description'] . '<br>' . '<br>' . $ligne['link_serv'] . '<br>' . '<br>' .  '</div>' . '</div>';
	}
	return $ligne;
};

// recupere le nom du tournois
function affiche_nom_tournois() {
	global $bdd;
	$user = $_SESSION["utilisateur"];
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "SELECT * FROM tournois WHERE createur = '$user' ORDER BY id_tournois DESC";
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		echo '<div class="affiche-url">' . '<div class="tournois-url">' . '<div class="title-url">' .  $ligne['nom_tournois'] . ' by ' .  $ligne['createur'] 
		. '<img class="image-lim-url" src= '. $ligne['image'] . '>' . '</div>' . '<br>' .  'Mode : ' . $ligne['mode'] 
		. '<br>' . '<br>' . 'Description : ' . $ligne['description'] . '<br>' . '<br>' . $ligne['link_serv'] . '<br>' . '<br>' .  '</div>' . '</div>';
	}
	return $ligne;
};


// verifie si l'utilisateur est un administrateur
function est_admin() {
	$user = $_SESSION['utilisateur'];
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "SELECT * FROM `users` WHERE logins = '$user'";
	$resultat = $bdd->query($requete);
	if ($resultat){
		while ($ligne = $resultat->fetch_assoc()) {
			if ($ligne["Administrator"] == '1') {
				return TRUE;
			}
		}
	}
}

// affiche les utilisateurs qui ne sont pas admin
// ajouté une fonction pour verifier si la personne est deja admin ou pas 
function affiche_user_no_admin(){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "SELECT logins, Administrator FROM `users`"; 
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		if ($ligne["Administrator"] != '1') {
		 	echo '<option value=' . $ligne['logins'] . '>' . $ligne['logins'] . '</option>';
	}
}
	return $ligne;
};

// affiche les utlilsiateur qui sont admnistrateur sur le site
function affiche_user_admin(){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "SELECT logins, Administrator FROM `users`"; 
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		if ($ligne["Administrator"] == '1') {
		 	echo '<option value=' . $ligne['logins'] . '>' . $ligne['logins'] . '</option>';
	}
}
	return $ligne;
};

//ajoute un admin
function add_admin($user){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "UPDATE `users` SET `Administrator`='1' WHERE `logins` = '$user'"; 
	$resultat = $bdd->query($requete);
	$_SESSION['add_admin'] = "user has been added as admin";
	return $resultat;
};

//supprime un administrateur
function del_admin($user){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "UPDATE `users` SET `Administrator`='0' WHERE `logins` = '$user'"; 
	$resultat = $bdd->query($requete);
	$_SESSION['del_admin'] = "user has been deleted from admin";
	return $resultat;
};

//verifie le createur du site est bien HawKen pour delete un admin
function est_HawKen(){
	$user = $_SESSION["utilisateur"];
	if ($user === "HawKen"){
		if (!est_admin()){
			global $bdd;
			global $database_shootmania;
			mysqli_select_db($bdd, $database_shootmania);
   			$bdd->set_charset("utf8");
			$requete = "UPDATE `users` SET `Administrator` = '1' WHERE `users`.`logins` = 'HawKen'"; 
			$resultat = $bdd->query($requete);
			var_dump($resultat);
		}
		return TRUE;
	} else {
		return FALSE;
	}
};


// ban des joueurs du site web
// rajouter une colonne dans la BDD pour dire si le joueur est banni ou pas
// ou alors creer une table banni pour tous les joueurs qui sont bannis

function ban_player($user){
}

// recupere le dernier id de la table teams
function get_last_id_from_teams(){
	global $bdd;
	$res = 0;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "SELECT id_teams FROM teams ORDER BY id_teams DESC LIMIT 1";
	$resultat = $bdd->query($requete);
	if ($resultat != ''){
		while ($ligne = $resultat->fetch_assoc()) {
	   		$res = $ligne['id_teams'];
		}
	} 
	return $res;
}

// creer une team 
function new_team($name, $image, $Createur,$id){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "INSERT INTO teams VALUES ('$id' , '$name', '$image', '$Createur')";
	$resultat = $bdd->query($requete);
	return $resultat;
};

// function qui recupere les teams en fonction de l'utilisateurs
function show_teams(){
	global $bdd;
	$teams = [];
	$i = 0;
	$user = $_SESSION['utilisateur'];
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
 	$requete = "SELECT nom_team FROM teams WHERE `createur` = '$user'";
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()){
		$teams[$i] = $ligne['nom_team'];
		$i++;
	}
	return $teams;
}

// function qui verifie si la personne est une admin ou si c'est le createur du tournois
function est_createur_tournois(){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$user = $_SESSION['utilisateur'];
	$id = $_GET['id'];
 	$requete = "SELECT id_tournois, createur FROM tournois WHERE `createur` = '$user' AND `id_tournois` = '$id'";
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		if ($ligne ==''){
			return FALSE;
		}
	}
	if (isset($ligne['createur']) === $user ){
		return TRUE;
	}
}

// fonction qui supprime un tournois 
function del_tournament($id_tournois){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
 	$requete = "DELETE FROM tournois WHERE `id_tournois` = '$id_tournois'";
	$resultat = $bdd->query($requete);
	return $resultat;
}

// affiche les equipes auxquels appartiens le joueur
function affiche_team_joueur(){
	global $bdd;
	$ligne = "";
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$user = $_SESSION['utilisateur'];
	$requete = "SELECT
    	login_player,
    	team_name,
    	nom_team,
    	images
		FROM
    	player_teams
	INNER JOIN teams ON player_teams.team_name = teams.nom_team";
	$resultat = $bdd->query($requete);
	if ($resultat != null){
		while ($ligne = $resultat->fetch_assoc()) {
			if ($ligne !='' && $ligne['login_player'] === $user){
				echo ( '<a href=team.php?name_team=' . $ligne['nom_team'] . '&amp;name=' . $user .'>' . $ligne['nom_team'] . '<br>' 
				. '<br>' . '<img src=' .  $ligne['images'] . '>' . '</a>' . '<br>' .   '<br>'. '<br>');
			}
		}
	}
	//return $ligne;
}

// affiche la team selectionné
function affiche_team(){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$nom_team = htmlspecialchars($_GET['name_team']);
	$requete = "SELECT * FROM `teams` WHERE `nom_team` = '$nom_team'";
	$resultat = $bdd->query($requete);
	if ($resultat != null){
		while ($ligne = $resultat->fetch_assoc()) {
			echo ( $ligne['nom_team'] . '<br>' . $ligne['createur'] . '<br>' .
			'<br>' . '<img src=' .  $ligne['images'] . '>'. '<br>' .  '<br>');
		}
		return $ligne;
	}
}

//recupere les joueurs d'une equipe avec id passe dans l'url
function affiche_joueur_team(){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$nom_team = htmlspecialchars($_GET['name_team']);
	$requete = "SELECT `login_player` FROM `player_teams` WHERE `team_name` = '$nom_team'";
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		echo ( $ligne['login_player'] . '<br>');
	}
	return $resultat;
}

//ajoute un joueur dans une team et le createur quand il cree la team
function ajoute_joueur($user,$id){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$requete = "INSERT INTO player_teams VALUES ('$user','$id')";
	$resultat = $bdd->query($requete);
	return $resultat;
}

//fonction qui creer le lien pour ajouter des joueurs a sa team
function create_url_team(){
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
    	$url = "https";
	} else {
    	$url = "http";
	}
	$url .= $_SERVER['REQUEST_URI'];
    $components = parse_url($url);
    parse_str($components['query'], $resultat);
	$salt = '1&°(çé=';
	$user = htmlspecialchars($_GET['name']);
	$name_team = htmlspecialchars($_GET['name_team']);
	$invite = md5($user . $salt);
	$day = date('d');
	$year = date('Y');
	$end = md5($user . $day . $year);
	//$link = $components['path'] . '?id_team=' . $id .  '&name=' . $user . '&invite=' . $invite . '&limit=' . $end; a voir si ca marche quand le site sera en ligne
	$link = '?name_team=' . $name_team .  '&name=' . $user . '&invite=' . $invite . '&limit=' . $end ;
	return $link;
}

//retourne le numero de la funcup
function numero_funcup(){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$requete = "SELECT funcups FROM funcup WHERE id_funcups = 1";
	$resultat = $bdd->query($requete);
	$ligne = $resultat -> fetch_assoc(); 
	if($ligne != NULL) {
		$url = implode(" ",$ligne);  // transforme le tableau en string
		$num_cup = substr($url,-3,strpos($url,'cup')); // recupere les 3 derniers chiffres de l'url -> correspond au numero de la funcup
		$num_cup = intval($num_cup); // transforme le string en int
		return $num_cup;
	} else {
		return false;
	}
}

//affiche le challonge
function affiche_challonge($url){
	$num_cup = numero_funcup();
	$url = trim($url, '1234567890');
	//$iframe = "<h3>SpeedBall Funcups n° " . $num_cup . "</h3>" . "<br>" . 
	//	"<iframe src=" . "$url" . "$num_cup" . "/module" . " width=" . "75%" .
	//	" height=" . "510" . " frameborder=" . "0" . " scrolling=" . "auto" . " allowtransparency=" . "false" . "></iframe>";
	//return $iframe;
	//var_dump($url);	
	return array($url, $num_cup);
}

//recupere l'url funcup + 1
function test_funcup_url($url){
	$num_cup = numero_funcup();
	$num_cup = $num_cup + 1;
	$url =  trim($url, '1234567890');   	//supprime les numeros de l'url
	$url = $url . $num_cup;
	return $url;
	}


// recupere le challonge actuelle et si nouveau challonge alors on change dans la DB (table funcup)
function update_funcup($url){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$num_cup = numero_funcup();
	if($num_cup != NULL){
		$num_cup = $num_cup + 1;
		$url = trim($url, '1234567890');
		$url = $url . $num_cup;
		$requete = "UPDATE funcup SET funcups = ('$url') WHERE id_funcups = 1";
		$resultat = $bdd->query($requete);
		return $resultat;
	} else {
		table_funcup_vide();
	}
}

// recupere la page source web 
function recupere_page($url){
	//Code d'un scraper avec Curl réalisé par Insimule.com
	//permet de récupérer le contenu d'une page
	// User Agent
	// recupere la page html de challonge et garde si erreur 404 dans la page source
	$ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:97.0) Gecko/20100101 Firefox/97.0';
	$ch = curl_init();
	if (preg_match('`^https://`i', $url)) {					//pour les URLs en HTTPS
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	}
	curl_setopt($ch, CURLOPT_USERAGENT, $ua);
	curl_setopt($ch, CURLOPT_URL, $url );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
	// le scraper suit les redirections
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	$result = curl_exec($ch);
	curl_close ($ch);
	return $result;
}

// test si la page est la bonne ou pas
function bonne_page($url){
	$invalide = "0 Joueur";
	$invalide_404 = "(404)";
	$result = recupere_page($url);
	$err_404 = substr($result,0, strpos($result, $invalide_404));
	$Y_est = substr($result,0, strpos($result, $invalide));
	if($Y_est =='' && $err_404 ==''){
		return TRUE;  					// c'est la bonne page
	} else {
		return FALSE;
	}
}

// ajoute l'adresse https si la bdd est vide 
// ajoute l'indice 1 qui sert de reference pour le afficher le challonge
function table_funcup_vide(){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	if(numero_funcup() == false){
		$url = "https://speedball.challonge.com/fr/speedballfuncup195";
		$requete = "INSERT INTO funcup VALUE (1,'$url')";
		$resultat = $bdd->query($requete);
	}
	return $resultat;
}

// retourne la derniere ligne de la table
function derniere_ligne(){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$requete = "SELECT funcups FROM funcup WHERE `id_funcups` = 1";
	$resultat = $bdd->query($requete);
	$ligne = $resultat -> fetch_assoc();
	if($ligne == null){
		table_funcup_vide();
	}
	return $ligne;
}

// test si le challong est actif ou pas
function test_url(){
	$url = derniere_ligne(); //recupere le dernier lien de la bdd
	$url = implode(" ",$url);  // array to string
	$url_1 = test_funcup_url($url);    // url funcup numero fun cup +1
	if(bonne_page($url_1) == TRUE){
		$url_1 = test_funcup_url($url);
		update_funcup($url_1);
		test_url();
	} else {
		return affiche_challonge($url);
	}
}

////////////////////////////////////////////////////////////////////////////
/////////////////// function for the database tournament ///////////////////
////////////////////////////////////////////////////////////////////////////


// get the name of the tournamant thanks to the id
function get_name_tournament($id){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$requete = "SELECT nom_tournois FROM tournois WHERE `id_tournois` = $id";
	$resultat = $bdd->query($requete);
	$ligne = $resultat -> fetch_assoc();
	if($ligne != null){
		$name = $ligne['nom_tournois'];
	}
	//gestion erreur a faire
	if(isset($name)){
		$name = str_replace(' ', '_',$name);
		return $name;
	}
	return $ligne;
}

//get all the time registered for the tournament
//return teams name or false
function check_team_register_tournament ($id_tournament){
	global $bdd;
	global $database_tournament;
	$name = get_name_tournament($id_tournament);
	$name = str_replace(str_split('# :/;.,?&~"{(-|è`_\'ç^à@)]°=+}*µ$£¨ù%§<>%ù'), '_', $name);
	mysqli_select_db($bdd, $database_tournament);
	$bdd->set_charset("utf8");
	$requete = "SELECT team FROM $name ";
	$resultat = $bdd->query($requete);
	if($resultat){
		$ligne = $resultat->fetch_assoc();
		return $ligne;
	} else {
	return false; 
	}
}

//compare and return the team that are not registered
function team_registered($id_tournament){
	$check = check_team_register_tournament ($id_tournament); //get every team registered for the tournament
    $teams = show_teams();
    $teams = [];
    if($check != false){
        foreach ($check as $team){
            $teams[] = $team;
        }
    }
    return $teams;
}

//print the team in the select
function print_teams($id_tournament){
	$reg_team = team_registered($id_tournament);
	$teams = show_teams();
	$is_registered = False;
	for ($i = 0; $i < count($teams); $i++){
		for ($j = 0; $j < count($reg_team); $j++){
			if($teams[$i] == $reg_team[$j]){
				$is_registered = true;
			}
		}
		if(!$is_registered){
			echo '<option value=' . $teams[$i] . '>' .$teams[$i] . '</option>';
			
		}
		$is_registered = false;
	}
}


//get the name of the team for a specific tournament -> ici l'id du tournois

//print every team that is participating in the tournament
function print_team_signed_up($id_tournament){
	global $bdd;
	global $database_tournament;
	$name = get_name_tournament($id_tournament);
	$name = str_replace(str_split('# :/;.,?&~"{(-|è`_\'ç^à@)]°=+}*µ$£¨ù%§<>%ù'), '_', $name);
	mysqli_select_db($bdd, $database_tournament);
	$bdd->set_charset("utf8");
	$requete = "SELECT team FROM $name";
	$resultat = $bdd->query($requete);
	$ligne = $resultat -> fetch_assoc();
	return $ligne;
}


// get the month and return the month by the name of the month
// ex 01 -> return january
/*
function transform_date($month){
	switch ($month) {
		case 01:
			$month = "january";
			break;
		case 02:
			$month = "february";
			break;
		case 03:
			$month = "march";
			break;
		case 04:
			$month = "april";
			break;
		case 05:
			$month = "may";
			break;
		case 06:
			$month = "june";
			break;
		case 07:
			$month = "jully";
			break;
		case 08:
			$month = "august";
			break;
		case 09:
			$month = "september";
			break;
		case 10:
			$month = "october";
			break;
		case 11:
			$month = "november";
			break;
		case 12:
			$month = "december";
			break;
	}
	return $month;
}*/
