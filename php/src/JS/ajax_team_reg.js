function getSelectValue(selectValue) {
    /**On récupère l'élement html <select>*/
    var selVal = selectValue.value;
    makeRequest('../controleur/ajax_team.php', selVal);
}

function makeRequest(url, userName) {
    httpRequest = new XMLHttpRequest();
    if (!httpRequest) {
        alert('Abandon :( Impossible de créer une instance de XMLHTTP');
        return false;
    }
    httpRequest.onreadystatechange = alertContents;
    httpRequest.open('POST', url);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send('team=' + encodeURIComponent(userName));
}

function alertContents() {
    if (httpRequest.readyState === XMLHttpRequest.DONE) {
        if (httpRequest.status === 200) {
            var response = httpRequest.responseText;
            document.getElementById("team_player").innerHTML = response;
        } else {
            alert('Un problème est survenu avec la requête.');
        }
    }
}