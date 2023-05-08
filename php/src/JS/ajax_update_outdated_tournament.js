window.onload = function () {
    timeout = 10000;   //5 min 
    refresh_page_dated(timeout);
    setTimeout(() => {
        refresh_page_outdated(timeout);
    }, 1000);
}

//set a timer and recharge the page every 5 minuts
function refresh_page_outdated(timeout) {
    make_request_tournament_outdated('../controleur/ajax_outdated_tournament.php');
    //console.log('abcdefhvpqjbfvopbv');
    wait_for_next_exec_outdated(timeout);
}

function wait_for_next_exec_outdated(timeout) {
    setTimeout(() => {
        refresh_page_outdated(timeout);
    }, timeout);
}

function make_request_tournament_outdated(url) {
    httpRequest = new XMLHttpRequest();
    if (!httpRequest) {
        alert('Abandon :( Impossible de créer une instance de XMLHTTP');
        return false;
    }
    httpRequest.onreadystatechange = alert_content_outdated;
    httpRequest.open('POST', url);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send();
}

function alert_content_outdated() {
    if (httpRequest.readyState === XMLHttpRequest.DONE) {
        if (httpRequest.status === 200) {
            var response = httpRequest.responseText;
            document.getElementById("affiche_tournois_outdated").innerHTML = response;
        } else {
            console.log(response);
            alert('Un problème est survenu avec la requête.');
        }
    }
}