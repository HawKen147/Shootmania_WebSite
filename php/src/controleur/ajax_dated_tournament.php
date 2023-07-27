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
$requete = "SELECT tn.nom_tournois, tn.id_tournois, tn.mode, tn.time_tournament, tn.nombre_player
            FROM tournois tn
            INNER JOIN tournament_status ts on ts.id_tournament_status = tn.id_tournois
            WHERE ts.status = 'incoming'
            ORDER BY tn.time_tournament DESC";
$resultat = sql_request($requete, [NULL]);
if($resultat){
    while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
        $date = $ligne['time_tournament'];
        $date = DateTime::createFromFormat('d/m/Y H:i', $date);
        echo '  <tr><td><a href=Tournament.php?id=' . $ligne['id_tournois'] . '>' . $ligne['nom_tournois'] .'</a></td>
                <td> ' . $ligne['mode']  . '</td> 
                <td>' . $ligne['nombre_player'] . '</td>
                <td>' . $ligne['time_tournament'] . '</td></tr>';              
    }
}
