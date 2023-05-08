<?php
include_once("action.php");
//this page get the tournament that are outated
//they will be displayed on the home.php page
if(isset($_SESSION['utilisateur'])){
    $user = $_SESSION['utilisateur'];
} else {
    $user = '';
}

date_default_timezone_set('Europe/Paris');
$dt = new \DateTime();
$resultat = affiche_tournois();
$day = $dt->format('d m Y H i');
global $bdd;
global $database_shootmania;
$i = 0;
mysqli_select_db($bdd, $database_shootmania);
$bdd->set_charset("utf8");
$requete = "SELECT * FROM tournois ORDER BY time_tournament DESC";
$resultat = $bdd->query($requete);
if($resultat){
    while ($ligne = $resultat->fetch_assoc()) {
        $date = $ligne['time_tournament'];
        if ($date <= $day ){
            echo '<tr><td><a href=Tournament.php?id=' . $ligne['id_tournois'] . '>' . 
            $ligne['nom_tournois'] .'</a></td> <td> ' . $ligne['nombre_player'] . '<td>' .
            $ligne['mode'] . '</td> <td>' . $ligne['time_tournament'] . '</td></tr>';              
        }
    }
}
