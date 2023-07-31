<?php

function seConnecterBDD(){
    $dbhost = 'db';
    $dbuser = 'root';
    $dbpass = 'MYSQL_ROOT_PASSWORD';
    $dbname = 'shootmania';

    try {
        // Créer une instance PDO pour la connexion
        $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);

        // Définir le mode d'erreur de PDO sur Exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     
        return $pdo; // Retourner l'objet PDO
    } catch (PDOException $e) {
        // En cas d'erreur de connexion, afficher l'erreur
        echo "Erreur de connexion : " . $e->getMessage();
    }
}

$database_shootmania = 'shootmania';


