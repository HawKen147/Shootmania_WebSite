<?php
include_once('../controleur/action.php');
include_once('../controleur/update_tournament_status.php');

// Vérifier si la requête est effectuée en méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_tournament = $_SESSION['id_tournament'];
    // Récupérer les données envoyées via la requête AJAX
    $jsonData = file_get_contents('php://input');
    $associations = json_decode($jsonData, true);

    // Vérifier que les données ont été reçues avec succès
    if ($associations !== null) {
        $i = 1;
        // Traiter les données (par exemple, les enregistrer dans la base de données)
        foreach ($associations as $droppableID => $associationData) {
            // Récupérer l'ID de l'élément droppable et le nom de l'équipe
            $id_team_result = $associationData['id']; // ID de l'élément droppable
            $teamName = $associationData['teamName']; // Nom de l'équipe
    
            // Insérer les associations dans la base de données en utilisant $id_tournament, $id_team_result et $droppableID
            $requete = "INSERT INTO tournament_result (id_tournament_result, id_team_result, place) VALUES (?, ?, ?)";
            $resultat = sql_request($requete, [$id_tournament, $teamName, $id_team_result]);
            $i++;
        }
        if (update_tournament_over($id_tournament)){
            // Envoyer une réponse JSON au client pour indiquer que les données ont été traitées avec succès
            $response = array("status" => "success", "message" => true, "id_tournament" => $id_tournament);
            echo json_encode($response);
        }
    } else {
        // Envoyer une réponse JSON au client en cas d'erreur lors de la réception des données
        $response = array("status" => "error", "message" => "Error, data does not exists.");
        echo json_encode($response);
    }
}
?>
