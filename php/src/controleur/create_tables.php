<?php

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
	$sql = "CREATE TABLE IF NOT EXISTS Users (
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
		CONSTRAINT FK_id_nom FOREIGN KEY (`nom`) REFERENCES Users(`login`))";
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
		CONSTRAINT FK_login_player FOREIGN KEY (`login_player`) REFERENCES Users(`logins`) ,
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
