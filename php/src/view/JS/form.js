document.forms["discord-id"].addEventListener("submit", function(e){
    var inputs = this;
    var discord = inputs["discord"].value;

   if(!isNaN(discord) == false){   // ne contient que des chiffres
        erreur = "You can use only numbers";      
   } else {
    return true;
}
    
    if (erreur) {
        e.preventDefault();
        document.getElementById("erreur").innerHTML = erreur;
        return false;
    };

 /*
    if(!pseudo.value){
        e.preventDefault(); // empeche le rechargement de la page
        erreur ="Please enter your id before validation";
        document.getElementById("erreur").innerHTML = erreur; // integre le code pour l'erreur dans la page web
        objectJavascript.style.borderColor = "red";
    } if (discord.value) {
        objectJavascript.style.borderColor = "green";
    }
    if(!.value){
        e.preventDefault(); // empeche le rechargement de la page
        erreur ="veuillez renseigner un email";
        document.getElementById("erreur").innerHTML = erreur; // integre le code pour l'erreur dans la page web
        document.getElementById("email").style.borderColor = "red";
    } else {
        document.getElementById("email").style.borderColor = "green";
    }
    if(!mdp.value){
        e.preventDefault(); // empeche le rechargement de la page
        erreur ="veuillez renseigner un mdp";
        document.getElementById("erreur").innerHTML = erreur; // integre le code pour l'erreur dans la page web
        document.getElementById("mdp").style.borderColor = "red"; // change la couleur en rouge
    } else {
        document.getElementById("mdp").style.borderColor = "green"; // change la couleur en vert
    }
*/
});