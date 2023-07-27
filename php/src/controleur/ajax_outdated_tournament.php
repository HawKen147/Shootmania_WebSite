<?php
include_once("../controleur/action.php");



print_score_board();

function get_tournament_result(){
    $requete = "SELECT tr.place, t.nom_team, tn.nom_tournois, tn.id_tournois, tn.mode
                FROM tournament_result tr
                INNER JOIN teams t ON tr.id_team_result = t.id_teams
                INNER JOIN tournois tn ON tr.id_tournament_result = tn.id_tournois
                INNER JOIN tournament_status ts on ts.id_tournament_status = tn.id_tournois
                WHERE ts.status = 'over'
                ORDER BY tn.id_tournois DESC";
    $resultat = sql_request($requete, [NULL]);
    while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
        $id_tournament = $ligne['id_tournois'];
        $nom_tournois = $ligne['nom_tournois'];
        $nom_team = $ligne['nom_team'];
        $place = $ligne['place'];
        $mode = $ligne['mode'];
        $result_tournament[] = array(
            "id_tournament" => $id_tournament,
            "nom_tournois" => $nom_tournois,
            "nom_team" => $nom_team,
            "place" => $place,
            "mode" => $mode
        );
    }
    return $result_tournament;
}

function print_tournament_results(){
    $tab_tournois_team_place = get_tournament_result();
    $first ='';
    $second ='';
    $third ='';
    $j = 0;
    while (isset($tab_tournois_team_place[$j]['id_tournament'])){
        if($tab_tournois_team_place[$j]['place'] == 1){
            $first = $tab_tournois_team_place[$j]['nom_team'];
        }
        if($tab_tournois_team_place[$j]['place'] == 2){
            $second = $tab_tournois_team_place[$j]['nom_team'];
        }
        if($tab_tournois_team_place[$j]['place'] == 3){
            $third = $tab_tournois_team_place[$j]['nom_team'];
        }
        if($first && $second && $third){
            $table[] = '  <tr><td><a href=Tournament.php?id=' . $tab_tournois_team_place[$j]['id_tournament'] . '>' . $tab_tournois_team_place[$j]['nom_tournois'] .'</a>
                    </td>
                    <td> ' .$tab_tournois_team_place[$j]['mode']  . '</td> 
                    <td>' . $first . '</td> 
                    <td>' . $second . '</td>
                    <td>' . $third  . '</td></tr>';
            $first ='';
            $second ='';
            $third ='';
        }
        $j++;
    }
    return $table;
}

function print_score_board(){
    $tables = print_tournament_results();
    foreach($tables as $table){
        echo $table;
    }
}