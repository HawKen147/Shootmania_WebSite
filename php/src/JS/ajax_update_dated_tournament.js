//the page is called thanks to ajax_update_outdated_tournament.js
//cuz there is a problem with the window.onload function. doesn't work
//maybe create a script with a "window.onload" function and call every function that need this
//set a timer and recharge the page every 5 minuts
function refresh_page_dated(timeout) {
    make_request_tournament_dated('../controleur/ajax_dated_tournament.php');
    //console.log('dated');
    wait_for_next_exec_dated(timeout);
}

function wait_for_next_exec_dated(timeout) {
    setTimeout(() => {
        refresh_page_dated(timeout);
    }, timeout);
}

function make_request_tournament_dated(url) {
    httpRequest = new XMLHttpRequest();
    if (!httpRequest) {
        alert('Abandon :( Impossible de créer une instance de XMLHTTP');
        return false;
    }
    httpRequest.onreadystatechange = alert_content_dated;
    httpRequest.open('POST', url);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send();
}

function alert_content_dated() {
    if (httpRequest.readyState === XMLHttpRequest.DONE) {
        if (httpRequest.status === 200) {
            var response = httpRequest.responseText;
            document.getElementById("affiche_tournois_dated").innerHTML = response;
        } else {
            alert('Un problème est survenu avec la requête.');
        }
    }
}