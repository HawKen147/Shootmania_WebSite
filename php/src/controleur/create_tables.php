<?php

require_once("BDD.php");

// create the DB Shootmania
function create_DB_shootmania(){
	$username = 'root';
	$password = 'MYSQL_ROOT_PASSWORD';
	// Se connecter au serveur MySQL (sans sélectionner de base de données pour le moment)
	$pdo = new PDO("mysql:host=db;charset=utf8", $username, $password);

	// Définir le mode d'erreur de PDO sur Exception
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// Nom de la base de données à créer
	global $database_shootmania;

	try {
	    // Exécuter la requête de création de base de données
	    $pdo->exec("CREATE DATABASE IF NOT EXISTS `shootmania`");
		$bool = true;
	} catch (PDOException $e) {
	    // En cas d'erreur lors de l'exécution de la requête, afficher l'erreur
		$bool = false;
	    echo "Erreur lors de la création de la base de données : " . $e->getMessage();
	}
    return $bool;
}

// creer la table utilisateur 
function create_table_utilisateur() {
	$sql = "CREATE TABLE IF NOT EXISTS users (
		`logins` VARCHAR(50) NOT NULL ,
		`mdp` VARBINARY(60) NOT NULL ,
		`mail` VARCHAR(250) NOT NULL ,
		`id_discord` BIGINT NULL DEFAULT NULL ,
		`Administrator` INT NULL DEFAULT 0 ,
		PRIMARY KEY (`logins`))";
	$result = sql_request_table_database($sql);
	return $result;
};

// cree la table funcup
function create_table_funcup() {
	$sql = "CREATE TABLE IF NOT EXISTS funcup (
		`id_funcups` INT NOT NULL,
		`funcups` TEXT ,
		PRIMARY KEY (`id_funcups`))";
	$result = sql_request_table_database($sql);
	return $result;
};

// creer la table Tournois
function create_table_tournois() {
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
	$result = sql_request_table_database($sql);
	return $result;	
};

// creer la table teams
function create_table_team() {
	$sql = "CREATE TABLE IF NOT EXISTS teams ( 
		`id_teams` INT NOT NULL AUTO_INCREMENT ,
		`nom_team` VARCHAR(50) NOT NULL , 
		`images` VARCHAR(16000) DEFAULT 'https://www.aht.li/3733312/default.png',
		`creation_date` VARCHAR(50) NOT NULL,
		`createur` VARCHAR(50) NOT NULL ,
		PRIMARY KEY (`id_teams`))";
	$result = sql_request_table_database($sql);
	return $result;	
};

//creer la table player_tournois qui inscrit les teams dans un tournois
function create_table_player_tournois(){
	$sql = "CREATE TABLE IF NOT EXISTS tournament_team_player (
		`id_tournois_tournois` INT NOT NULL ,
		`id_team_tournois`  INT NOT NULL ,
		`user_login` VARCHAR (50) NOT NULL,
		CONSTRAINT FK_id_team_tournois FOREIGN KEY (`id_team_tournois`) REFERENCES teams(`id_teams`) ,
		CONSTRAINT FK_id_teams FOREIGN KEY (`id_tournois_tournois`) REFERENCES tournois(`id_tournois`),
		CONSTRAINT FK_user_login FOREIGN KEY (`user_login`) REFERENCES users(`logins`))";
	$result = sql_request_table_database($sql);
	return $result;
}

// creer la table recuperation des mots de passe
function create_table_recuperation() {
	$sql = "CREATE TABLE IF NOT EXISTS recuperation ( 
	 `id_recuperation` INT NOT NULL AUTO_INCREMENT ,
	 `logins` VARCHAR(50) NOT NULL , 
	 `code` TEXT  ,
	 PRIMARY KEY (`id_recuperation`))";
	$result = sql_request_table_database($sql);
	return $result;	
};

// creer la table pour stocker le status d'un tournois
// incoming, underway, over
function create_table_tournament_status() {
	$sql = "CREATE TABLE IF NOT EXISTS tournament_status ( 
		`id_tournament_status` INT NOT NULL ,
		`status` VARCHAR(50) NOT NULL DEFAULT 'underway',
		CONSTRAINT FK_id_tournament_status FOREIGN KEY (`id_tournament_status`) REFERENCES tournois(`id_tournois`))";
	$result = sql_request_table_database($sql);
	return $result;	
};

// creer la table de resultat pour les tournois
function create_table_tournament_result() {
	$sql = "CREATE TABLE IF NOT EXISTS tournament_result ( 
		`id_tournament_result` INT NOT NULL ,
		`id_team_result` INT NOT NULL,
		`place` INT NOT NULL,
		CONSTRAINT FK_id_tournament_result FOREIGN KEY (`id_tournament_result`) REFERENCES tournois(`id_tournois`) ,
		CONSTRAINT FK_id_team_result FOREIGN KEY (`id_team_result`) REFERENCES teams(`id_teams`))";
	$result = sql_request_table_database($sql);
	return $result;	
};


function create_table_player_team(){
	$sql = "CREATE TABLE IF NOT EXISTS player_teams (
		`id_player_teams` INT NOT NULL,
		`login_player` VARCHAR (50) NOT NULL,
		CONSTRAINT FK_id_player_teams FOREIGN KEY (`id_player_teams`) REFERENCES teams(`id_teams`) ,
		CONSTRAINT FK_login_player FOREIGN KEY (`login_player`) REFERENCES users(`logins`))";
	$result = sql_request_table_database($sql);
	return $result;
}

//stock les liens pour la page links.php
function create_table_links(){
	$sql = "CREATE TABLE IF NOT EXISTS `links` 
	(`media_type` VARCHAR(50) NOT NULL ,
	 `link` VARCHAR(50) NOT NULL,
	 `media_name` VARCHAR(50) NOT NULL)";
	$result = sql_request_table_database($sql);
	return $result;
}

// envoie les requetes de creations de tables / base de données
function sql_request_table_database($sql){
	// Se connecter au serveur MySQL (sans sélectionner de base de données pour le moment)
	$pdo = seConnecterBDD();

	// Définir le mode d'erreur de PDO sur Exception
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	try {
	    // Exécuter la requête de création de base de données
	    $pdo->exec($sql);
		return true;
	} catch (PDOException $e) {
	    // En cas d'erreur lors de l'exécution de la requête, afficher l'erreur
	    echo "Erreur lors de la création de la base de données : " . $e->getMessage();
		return false;
	}
}


####################################################################
#################### appel toutes les fonctions ####################
####################################################################
create_DB_shootmania();
create_table_tournois();
create_table_utilisateur();
create_table_team ();
create_table_funcup();
create_table_player_tournois();
create_table_recuperation();
create_table_tournament_status();
create_table_tournament_result();
create_table_player_team();
create_table_links();