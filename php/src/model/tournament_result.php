<?php
include_once('../controleur/action.php');


function get_team_result($id_tournament){
    $requete = "SELECT tr.`id_team_result`, tr.`place`, t.`nom_team`, t.`images` 
                FROM `tournament_result` tr 
                INNER JOIN `teams` t 
                ON tr.`id_team_result` = t.`id_teams` 
                WHERE tr.`id_tournament_result` = ? 
                ORDER BY tr.`place`";
    $resultat = sql_request($requete, [$id_tournament]);
    return $resultat;
}

function get_team_result_teams($id_tournament){
    $resultat = get_team_result($id_tournament);
    while ($ligne = $resultat -> fetch(PDO::FETCH_ASSOC)){
        $place = $ligne['place'];
        $id_team = $ligne['id_team_result'];
        $nom_team = $ligne['nom_team'];
        $image = $ligne['images'];
        $place_teams [] = array(
            'place' => $place,
            'id_team' => $id_team,
            'nom_team' => $nom_team,
            'image' => $image
        );
    }
    return $place_teams;
}


$id_tournament = $_SESSION['id_tournament'];
$teams = get_team_result_teams($id_tournament);
for ($i = 1; $i < count($teams) + 1; $i++){

    if ($i == 1){
        ?>
        <div id="1st_place">
            <img src="https://www.aht.li/3792243/1st_place.png" alt="1st_place" class="image_result"></img>
            <img src="<?php echo $teams[0]['image'];  ?>" class="image_team"></img>
            <span><a href="../view/team.php?id_teams=<?php echo $teams[0]['id_team']; ?>" alt="<?php echo 'logo' . $teams[0]['nom_team']; ?>"><?php echo $teams[0]['nom_team'];?></a></span>
        </div>

        <?php
    }
    if ($i == 2){
        ?>
        <div id="2nd_place">
            <img src="https://www.aht.li/3792242/2nd_place.png" alt="2nd_place" class="image_result"></img>
            <img src="<?php echo $teams[0]['image'];  ?>" class="image_team"></img>
            <span><a href="../view/team.php?id_teams=<?php echo $teams[0]['id_team']; ?>" alt="<?php echo 'logo' . $teams[0]['nom_team']; ?>"><?php echo $teams[0]['nom_team'];?></a></span>
        </div>
        <?php
    }
    if ($i == 3){
        ?>
        <div id="3rd_place">
            <img src="https://www.aht.li/3792225/3rd_place.png" alt="3rd_place" class="image_result"></img>
            <img src="<?php echo $teams[0]['image'];  ?>" class="image_team"></img>
            <span><a href="../view/team.php?id_teams=<?php echo $teams[0]['id_team']; ?>" alt="<?php echo 'logo' . $teams[0]['nom_team']; ?>"><?php echo $teams[0]['nom_team'];?></a></span>
        </div>

        <?php
    
    } else {
        ?>
        <div id="<?php echo $i . '_place'; ?>">
            <span><?php echo $i . 'th'; ?></span>
            <img src="<?php echo $teams[0]['image'];  ?>" class="image_team"></img>
            <span><a href="../view/team.php?id_teams=<?php echo $teams[0]['id_team']; ?>" alt="<?php echo 'logo' . $teams[0]['nom_team']; ?>"><?php echo $teams[0]['nom_team'];?></a></span>
        </div>

        <?php
    }
}
?>


