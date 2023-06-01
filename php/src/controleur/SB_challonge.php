<?php

include("BDD.php");

// Clé d'API Challonge
$api_key = "DcUmhuk5UPFjdhuLXw0wAv3uAGN6XC0g7Jr2DXuM";

// URL de l'API de Challonge pour obtenir la liste des tournois
// $url = "https://api.challonge.com/v1/tournaments/speedball-speedballfuncup203.json"; l'url pour acceder au site web
$url = "https://api.challonge.com/v1/tournaments/speedball-speedballfuncup";  // l'url qui est a modifier ( a prendre exemple sur celle haut dessus. manque numero funcup et .json)


//return the json format of the cup
function api_challonge ($url){
    // Créez une session cURL
    $ch = curl_init();

    // Configurez les options cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // Exécutez la requête cURL
    $response = curl_exec($ch);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode($api_key)
    ]);
    // Exécutez la requête cURL
    $response = curl_exec($ch);
    if(curl_errno($ch)) {
        echo 'Erreur cURL : ' . curl_error($ch);    
    }

    // Fermez la session cURL
    curl_close($ch);
    return $response;
}

//recupere url du fichier json 
function get_json_url ($url){
    $json_url = api_challonge ($url);
    $data = json_decode($json_url, true);
    if (isset($data['tournament']['url'])) {
        $url_tournois = $data['tournament']['url'];
        return $url_tournois;
    } else {
        return false;
    }
}

//recupere les infos de la funcup (numero)
function get_funcup_id () {
    global $bdd;
    global $database_shootmania;
    mysqli_select_db($bdd, $database_shootmania);
    $bdd->set_charset("utf8");
    $requete = "SELECT * FROM `funcup`";
    $resultat = $bdd->query($requete);
    // Vérifier s'il y a au moins une ligne de résultat
    if ($resultat != NULL) {
        // Récupérer la première ligne de résultat
        $row = $resultat->fetch_assoc();
    } else {
        add_url_funcup_table();
    }
    return $row;
}

// ajoute une ligne si la table funcup est vide
function add_url_funcup_table () {
    global $bdd;
    global $database_shootmania;
    $id = 203;
    $url = "https://api.challonge.com/v1/tournaments/speedball-speedballfuncup203.json";
    mysqli_select_db($bdd, $database_shootmania);
    $bdd->set_charset("utf8");
    $requete = "INSERT INTO `funcup`(`id_funcups`, `funcups`) VALUES ('$id','$url')";
    $resultat = $bdd->query($requete);
    return $resultat;
}

// ajoute une ligne si la table funcup est vide
function upadate_url_funcup_table ($new_url, $id) {
    global $bdd;
    global $database_shootmania;
    $new_id = $id + 1;
    mysqli_select_db($bdd, $database_shootmania);
    $bdd->set_charset("utf8");
    $requete = "UPDATE `funcup` SET `id_funcups`='$new_id',`funcups`='$new_url' WHERE `id_funcups` = '$id'; ";
    $resultat = $bdd->query($requete);
    return $resultat;
}

function affiche_challonge($url){
	$num_cup = numero_funcup();
	$url = trim($url, '1234567890');
	return array($url, $num_cup);
}

// test si le numero de funcup +1 existe ou non
function test_url (){
    $funcup_row = get_funcup_id();
    $id = $funcup_row['id_funcups'];
    $url = $funcup_row['funcups'];
    $newUrl = str_replace( $id, $id + 1, $url);
    if (get_json_url ($newUrl)) {
        upadate_url_funcup_table ($newUrl, $id);
        test_url ();
    } else {
        affiche_challonge($url);
    };
}


//////////////////////////////////////////////////////
/////////////////// Test Zone ////////////////////////
//////////////////////////////////////////////////////


//var_dump (add_url_funcup_table());
test_url();