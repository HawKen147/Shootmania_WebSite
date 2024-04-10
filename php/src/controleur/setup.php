<?php

// Connexion à la base de données
    $dbhost = 'db';
    $dbuser = 'root';
    $dbpass = 'MYSQL_ROOT_PASSWORD';
    $dbname = 'shootmania';

ajoute_joueurs($dbhost, $dbuser,$dbpass, $dbname);
ajoute_equipes($dbhost, $dbuser,$dbpass, $dbname);
lie_joueur_equipe($dbhost, $dbuser,$dbpass, $dbname);


function ajoute_joueurs($dbhost, $dbuser,$dbpass, $dbname){
    try {
        $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $joueur1 = "test";
        $joueur2 = "joueur2";
        $joueur3 = "joueur3";
        $joueur4 = "joueur4";
        $joueur5 = "joueur5";
    
        // Requête SQL avec des paramètres
        $requete = "INSERT INTO `users` (`logins`, `mdp`, `mail`, `id_discord`, `Administrator`) VALUES (?, ?, '', NULL, '0'), (?, ?, '', NULL, '0'), (?, ?, '', NULL, '0'), (?, ?, '', NULL, '0'), (?, ?, '', NULL, '0')";
        
        // Préparation de la requête
        $stmt = $pdo->prepare($requete);
    
        // Liaison des valeurs aux paramètres
        $stmt->bindParam(1, $joueur1);
        $stmt->bindParam(2, $joueur1);
        $stmt->bindParam(3, $joueur2);
        $stmt->bindParam(4, $joueur2);
        $stmt->bindParam(5, $joueur3);
        $stmt->bindParam(6, $joueur3);
        $stmt->bindParam(7, $joueur4);
        $stmt->bindParam(8, $joueur4);
        $stmt->bindParam(9, $joueur5);
        $stmt->bindParam(10, $joueur5);
    
        // Exécution de la requête
        $stmt->execute();
    
        echo "Requête exécutée avec succès.";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

function ajoute_equipes($dbhost, $dbuser,$dbpass, $dbname){
    try {
        $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // Requête SQL avec des paramètres
        $requete = "INSERT INTO `teams` (`id_teams`, `nom_team`, `images`, `creation_date`, `createur`) VALUES (NULL, ?, ?, '', ?), (NULL, ?, ?, '', ?)";
        
        // Préparation de la requête
        $stmt = $pdo->prepare($requete);
    
        // Paramètres
        $nom_team1 = 'team1';
        $image_url1 = 'https://www.aht.li/3733312/default.png';
        $createur1 = 'test';
        $nom_team2 = 'team2';
        $image_url2 = 'https://www.aht.li/3733312/default.png';
        $createur2 = 'test';
    
        // Liaison des valeurs aux paramètres
        $stmt->bindParam(1, $nom_team1);
        $stmt->bindParam(2, $image_url1);
        $stmt->bindParam(3, $createur1);
        $stmt->bindParam(4, $nom_team2);
        $stmt->bindParam(5, $image_url2);
        $stmt->bindParam(6, $createur2);
    
        // Exécution de la requête
        $stmt->execute();
    
        echo "Requête exécutée avec succès.";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

function lie_joueur_equipe($dbhost, $dbuser,$dbpass, $dbname){
    try {
        $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // Requête SQL avec des paramètres
        $requete = "INSERT INTO `player_teams`(`id_player_teams`, `login_player`) VALUES (?,?), (?,?), (?,?), (?,?), (?,?), (?,?), (?,?), (?,?), (?,?), (?,?)";
        
        // Préparation de la requête
        $stmt = $pdo->prepare($requete);
    
        // Paramètres
        $joueur1 = "test";
        $joueur2 = "joueur2";
        $joueur3 = "joueur3";
        $joueur4 = "joueur4";
        $joueur5 = "joueur5";
        $id_team1 = '1';
        $id_team2 = '2';
       
    
        // Liaison des valeurs aux paramètres
        $stmt->bindParam(1, $id_team1);
        $stmt->bindParam(2, $joueur1);
        $stmt->bindParam(3, $id_team1);
        $stmt->bindParam(4, $joueur2);
        $stmt->bindParam(5, $id_team1);
        $stmt->bindParam(6, $joueur3);
        $stmt->bindParam(7, $id_team1);
        $stmt->bindParam(8, $joueur4);
        $stmt->bindParam(9, $id_team1);
        $stmt->bindParam(10, $joueur5);
        $stmt->bindParam(11, $id_team2);
        $stmt->bindParam(12, $joueur1);
        $stmt->bindParam(13, $id_team2);
        $stmt->bindParam(14, $joueur2);
        $stmt->bindParam(15, $id_team2);
        $stmt->bindParam(16, $joueur3);
        $stmt->bindParam(17, $id_team2);
        $stmt->bindParam(18, $joueur4);
        $stmt->bindParam(19, $id_team2);
        $stmt->bindParam(20, $joueur5);
    
        // Exécution de la requête
        $stmt->execute();
    
        echo "Requête exécutée avec succès.";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
