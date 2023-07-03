<?php
include_once("action.php");
//this page get the tournament that are outated
//they will be displayed on the home.php page
if(isset($_SESSION['utilisateur'])){
    $user = $_SESSION['utilisateur'];
} else {
    $user = '';
}

global $database_shootmania;    
$day = get_date();
$resultat = affiche_tournois();
$requete = "SELECT * FROM tournois ORDER BY time_tournament DESC";
$resultat = sql_request($database_shootmania, $requete);

if($resultat){
    while ($ligne = $resultat->fetch_assoc()) {
        $date = $ligne['time_tournament'];
        if ($date > $day){
            echo '<tr><td><a href=Tournament.php?id=' . $ligne['id_tournois'] . '>' . 
            $ligne['nom_tournois'] .'</a></td> <td> ' . $ligne['nombre_player'] . '<td>' .
            $ligne['mode'] . '</td> <td>' . $ligne['time_tournament'] . '</td></tr>';              
        }
    }
}
