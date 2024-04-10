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
});