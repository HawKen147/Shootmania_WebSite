<?php
include_once ("action.php");

// Clé d'API Challonge
$api_key = "DcUmhuk5UPFjdhuLXw0wAv3uAGN6XC0g7Jr2DXuM";
global $api_key;

//url pour recuperer le tournois en passant par l'api challonge
$url_challonge = "https://HawKen147:" . $api_key . "@api.challonge.com/v1/tournaments";
global $url_challonge;


// URL de l'API de Challonge pour obtenir la liste des tournois
// $tournament = "/speedball-speedballfuncup205.json";

//function qui initialise la table
function init_funcup (){
    $url = "/speedball-speedballfuncup212.json";
    $id = 212;
    $sql = "INSERT INTO `funcup`(`id_funcups`, `funcups`) VALUES (? , ?)";
    $resultat = sql_request($sql, [$id, $url]);
    if ($resultat){
        test_url();
    }
}

//function qui recupere le numero de la funcup
function get_nbr_funcup(){
    $sql = 'SELECT * FROM `funcup`';
    $resultat = sql_request($sql, []);
    $row = $resultat -> fetch(PDO::FETCH_ASSOC);
    if ($row){
        return $row; // objet contenent 'id_funcups' et 'funcups' (url)
    } else {
        init_funcup ();  
    }
  
}

//met a jour la base de donnée
function update_funcup($url){
    $row = get_nbr_funcup();
    $old_id = $row['id_funcups'];
    $id = $old_id + 1;
    $sql = "UPDATE `funcup` SET `id_funcups`= ? ,`funcups` = ? WHERE `id_funcups` = ? ";
    $resultat = sql_request($sql, [$id, $url, $old_id]);
    if ($resultat){
       test_url();
    }
}

function change_url(){
    $row = get_nbr_funcup();
    if ($row == null){
        test_url();
    }
    $url = $row['funcups'];
    $id = $row['id_funcups'];
    $new_id = $id + 1;
    $new_url = str_replace( $id, $new_id, $url);
    return $new_url;    
}

//fonction qui afficher le challonge
function print_challonge($id){
    $url = "https://speedball.challonge.com/fr/speedballfuncup" . $id . "/module";
    return $url;
}

function curl_api($url){
    global $api_key;
    global $url_challonge;
    $new_url = $url_challonge . $url;
    // Créez une session cURL
    $ch = curl_init();
    // Configurez les options cURL
    curl_setopt($ch, CURLOPT_URL, $new_url);
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
    $data = json_decode($response, true); // transforme le tableau en json.
    return $data;
}

//function qui test l'url, si l'url est bon affiche le challonge
function test_url(){
    get_nbr_funcup();
    $new_url = change_url();
    $data = curl_api($new_url);
    //var_dump($data);
    //echo $data['tournament']['state'];
    if (isset($data['tournament']['state']) && $data['tournament']['state'] == 'complete' ){
        update_funcup($new_url);
    } else {
        $row =  get_nbr_funcup();
        $id = $row['id_funcups'];
        $challonge = print_challonge($id);
        return $challonge;
    }
}

?>