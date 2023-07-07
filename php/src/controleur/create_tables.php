<?php

include_once ("BDD.php");
include_once ("action.php");

// create the DB Shootmania
function create_DB_shootmania(){
    global $bdd;
	global $database_shootmania;
    $sql = "CREATE DATABASE IF NOT EXISTS $database_shootmania";
    $result = $bdd->query($sql);
    return $result;
}

// create the tournament DATABASE
function create_DB_tournament(){
    global $bdd;
	global $database_tournament;
    $sql = "CREATE DATABASE IF NOT EXISTS $database_tournament";
    $result = $bdd->query($sql);
    return $result;
}


// creer la table utilisateur 
function create_table_utilisateur() {
	global $database_shootmania;
	$sql = "CREATE TABLE IF NOT EXISTS users (
		`logins` VARCHAR(50) NOT NULL ,
		`mdp` VARCHAR(50) NOT NULL ,
		`mail` VARCHAR(250) NOT NULL ,
		`id_discord`  BIGINT NULL DEFAULT NULL ,
		`Administrator`  INT NULL DEFAULT 0 ,
		PRIMARY KEY (`logins`))";
	$result = sql_request($database_shootmania, $sql);
	return $result;
};

// cree la table funcup
function create_table_funcup() {
	global $database_shootmania;
	$sql = "CREATE TABLE IF NOT EXISTS funcup (
		`id_funcups` INT NOT NULL,
		`funcups` TEXT ,
		PRIMARY KEY (`id_funcups`))";
	$result = sql_request($database_shootmania, $sql);
	return $result;
};

// creer la table Tournois
function create_table_tournois() {
	global $database_shootmania;
	$sql = "CREATE TABLE IF NOT EXISTS tournois ( 
	 `id_tournois` INT NOT NULL AUTO_INCREMENT ,
	 `nom_tournois` VARCHAR(50) NOT NULL , 
	 `description` TEXT NOT NULL ,
	 `nombre_player` INT NOT NULL ,
	 `mode` TEXT NOT NULL ,  
	 `image` VARCHAR(16000) DEFAULT 'https://www.aht.li/3715849/shootmania_banniere.png',
	 `link_serv` TEXT NULL DEFAULT NULL ,
	 `time_tournament` VARCHAR(20) NOT NULL ,
	 `createur` VARCHAR(50) NOT NULL ,
	 PRIMARY KEY (`id_tournois`))";
	$result = sql_request($database_shootmania, $sql);
	return $result;	
};

// creer la table teams
function create_table_team() {
	global $database_shootmania;
	$sql = "CREATE TABLE IF NOT EXISTS teams ( 
	 `id_teams` INT NOT NULL AUTO_INCREMENT ,
	 `nom_team` VARCHAR(50) NOT NULL , 
	 `images` VARCHAR(16000) DEFAULT 'https://www.aht.li/3733312/default.png',
	 `creation_date` VARCHAR(50) NOT NULL,
	 `createur` VARCHAR(50) NOT NULL ,
	 PRIMARY KEY (`id_teams`))";
	$result = sql_request($database_shootmania, $sql);
	return $result;	
};

// creer la table joueur joue au tournois
function create_table_players_plays() {
	global $database_shootmania;
	$sql = "CREATE TABLE IF NOT EXISTS player_teams ( 
			`login_player` VARCHAR(50) NOT NULL , 
			`id_player_teams` INT NOT NULL ,
			CONSTRAINT FK_login_player_teams FOREIGN KEY (`login_player`) REFERENCES users(`logins`) ,
			CONSTRAINT FK_nom_team FOREIGN KEY (`id_player_teams`) REFERENCES teams(`id_teams`))";
	$result = sql_request($database_shootmania, $sql);
	return $result;	
};

// creer la table des joueurs qui sont dans une teams
function create_table_player_teams(){
	global $database_shootmania;
	$sql = "CREATE TABLE IF NOT EXISTS player_teams (
		`login_player`  VARCHAR(50) NOT NULL ,
		`id_player_teams` INT NOT NULL ,
		CONSTRAINT FK_login_player FOREIGN KEY (`login_player`) REFERENCES users(`logins`) ,
		CONSTRAINT FK_nom_team FOREIGN KEY (`id_player_teams`) REFERENCES teams(`id_teams`))";
	$result = sql_request($database_shootmania, $sql);
	return $result;
}

//creer la table player_tournois qui inscrit les teams dans un tournois
function create_table_player_tournois(){
	global $database_shootmania;
	$sql = "CREATE TABLE IF NOT EXISTS player_tournois (
		`id_team_tournois`  INT NOT NULL ,
		`id_tournois_tournois` INT NOT NULL ,
		CONSTRAINT FK_login_player FOREIGN KEY (`id_team_tournois`) REFERENCES teams(`id_teams`) ,
		CONSTRAINT FK_id_teams FOREIGN KEY (`id_tournois_tournois`) REFERENCES tournois(`id_tournois`) )";
	$result = sql_request($database_shootmania, $sql);
	return $result;
}

// creer la table recuperation des mots de passe
function create_table_recuperation() {
	global $database_shootmania;
	$sql = "CREATE TABLE IF NOT EXISTS recuperation ( 
	 `id_recuperation` INT NOT NULL AUTO_INCREMENT ,
	 `logins` VARCHAR(50) NOT NULL , 
	 `code` TEXT  ,
	 PRIMARY KEY (`id_recuperation`))";
		$result = sql_request($database_shootmania, $sql);
	return $result;	
};

#############################################################
#################### appel toutes les fonctions #############
#############################################################
create_DB_shootmania();
create_DB_tournament();
create_table_tournois();
create_table_team ();
create_table_players_plays();
create_table_player_teams();
create_table_funcup();
create_table_player_tournois();
create_table_recuperation();
create_table_utilisateur();