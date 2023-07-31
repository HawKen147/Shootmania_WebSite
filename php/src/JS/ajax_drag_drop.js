// Fonction pour gérer le clic sur le bouton "Enregistrer"
document.getElementById("btn_drag_drop").addEventListener("click", function() {
    saveAssociations();
});

// Fonction pour récupérer les associations entre les éléments draggable et les éléments droppable
function getAssociations() {
    const associations = {};
    const droppableElements = document.querySelectorAll(".droppable");

    droppableElements.forEach((droppable) => {
        const droppableID = droppable.id;
        const draggableElements = droppable.querySelectorAll(".draggable");
        const teamData = [];

        draggableElements.forEach((draggable) => {
            const teamName = draggable.getAttribute("data-team");
            teamData.push(teamName);
            // Remplacer l'ID de l'élément draggable par l'ID de l'élément droppable
            draggable.setAttribute("id", droppableID);
            associations[droppableID] = { id: droppableID, teamName: teamName };
        });
    });
    return associations;
}

// Fonction pour envoyer les données au serveur via AJAX
function saveAssociations() {
    const associations = getAssociations();
    // Convertir les données en chaîne JSON
    const jsonData = JSON.stringify(associations);
    // Créer une requête XMLHttpRequest
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../controleur/ajax_drag_drop.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    // Gérer l'événement onload pour traiter la réponse du serveur
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            console.log(response);
            if(response['message'] === true){
                window.location.href = '../view/tournament.php?' + resultat['id_tournament'];
            }
        } else {
            console.error('Erreur lors de la requête AJAX :', xhr.status);
        }
    };
    // Gérer l'événement onerror pour gérer les erreurs de la requête
    xhr.onerror = function() {
        console.error('Erreur lors de la requête AJAX.');
    };
    // Envoyer la requête avec les données JSON
    xhr.send(jsonData);
}

