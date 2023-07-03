document.getElementById("btn_copy").addEventListener("click", function() {

    var url = document.getElementById("url_invite").textContent;


    // Créer un élément de texte temporaire
    var tempInput = document.createElement("input");
    tempInput.setAttribute("value", url);

    // Ajouter l'élément au corps de la page
    document.body.appendChild(tempInput);

    // Sélectionner le contenu de l'élément de texte temporaire
    tempInput.select();

    // Copier le contenu sélectionné dans le presse-papier
    document.execCommand("copy");

    // Supprimer l'élément de texte temporaire
    document.body.removeChild(tempInput);
});