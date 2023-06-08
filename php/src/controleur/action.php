<?php
if(!isset($_SESSION)){
    session_start();
}
include("BDD.php");
$database_shootmania = "ShootMania";
$database_tournament = "tournament";

////////////////////////////////////////////////////////////////////////////////////////////////
///// creer des divs puis rentrer les fonctions pour afficher les tournois /////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////


//envoie une la requete sql
function sql_request ($database_name, $sql_request){
	global $bdd;
	mysqli_select_db($bdd, $database_name);
	$resultat = $bdd -> query($sql_request);
	return $resultat;
}

// verifie si l'utilisateur est deja dans la base de donnée
function login_existe_dans_la_BDD($logins){
	global $bdd;
	$res = TRUE;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
    $bdd->set_charset("utf8");
	$requete = "SELECT logins FROM Users WHERE `logins` = '$logins'" ;
	$resultat = $bdd->query($requete);
	$row = $resultat->fetch_row();
	if ($row > 0){
		$_SESSION['erreur_login'] = $logins;
		return $res;
	} else {
		$res = FALSE;
		return $res;
	}
	if($bdd->connect_errno ) {
		exit();
	}
};



// check if the adresse mail is already in the table
function mail_existe_dans_la_BDD($email){
	global $bdd;
	$res = TRUE;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
    $bdd->set_charset("utf8");
	$requete = "SELECT mail FROM Users WHERE `mail` = '$email'" ;
	$resultat = $bdd->query($requete);
	$row = $resultat->fetch_row();
	if ($row == 0){
		$res = FALSE;
	} else {
		$_SESSION['erreur_mail'] = $email;
		$res = TRUE;
	}
	return $res;
};


// verify that password and password confirm are the same
function password_confirm($mot_de_passe, $confirmation){
	$res = TRUE;
	if ($mot_de_passe === $confirmation){
		return $res;
	} else {
		$_SESSION['erreur_mdp_conf'] = "erreur";
		$res = FALSE;
		return $res;
	}
};

// ajoute un utilisateur a la base 
function inscrit_utilisateur($logins, $mot_de_passe, $confirmation, $email) {
if (login_existe_dans_la_BDD($logins) == FALSE && mail_existe_dans_la_BDD($email) == FALSE && password_confirm($mot_de_passe, $confirmation) == TRUE){     // verify that mail, login are not already taken and password / password confirm are not differents
	$salt= "@|-°+==00001ddQ";
	$md5 = md5($mot_de_passe . $salt . $logins .  $salt . $logins . $logins); // cache le mdp dans la base de donnée
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "INSERT INTO Users VALUES ('$logins','$md5','$email', NULL, '0')" ;
	$resultat = $bdd->query($requete); /////////////////////////////////////////////////?
	$res = TRUE;
	} else {
		header('Location:formulaire_reg.php');
	}
	return $res;
};

//connect un utilisateur au site.
function connecte_utilisateur($logins, $mot_de_passe){
	$res = NULL;
	$salt= "@|-°+==00001ddQ";
	$md5 = md5( $mot_de_passe . $salt . $logins .  $salt . $logins . $logins  ); // cache le mdp dans la base de donnée
 	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
    $bdd->set_charset("utf8");
	$requete = "SELECT logins, mdp FROM Users WHERE `logins` = '$logins' AND `mdp` = '$md5'" ;
	$resultat = $bdd->query($requete);
	$row = $resultat->fetch_row();
	if ($row > 0){
		if ($row[0] === $logins && $row[1] === $md5){
			$res = TRUE;
			return ($res);
		} else {
			return ($res);
		}
	}
};

// fonction qui change le mot de passe apres recuperation de ce dernier
function change_pwd($logins,$mot_de_passe){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$salt= "@|-°+==00001ddQ";
	$md5 = md5($mot_de_passe . $salt . $logins .  $salt . $logins . $logins);
	$requete = "UPDATE `users` SET `mdp`='$md5' WHERE `logins`= '$logins'";
	$resultat = $bdd->query($requete);
	return $resultat;
}


// function which add the discord id to the DB
function ajoute_discord($discord){
	global $bdd;
	$user = $_SESSION ["utilisateur"];
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$requete = "UPDATE Users SET `id_discord` = $discord WHERE `logins` =  '$user'";
	$resultat = $bdd->query($requete);
	if($resultat){
		return TRUE;
	} else {
		return FALSE;
	}
}

// verifie si l'id discord existe ou pas
function id_discord(){
	global $bdd;
	$user = $_SESSION["utilisateur"];
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$requete = "SELECT id_discord FROM Users WHERE `logins` = '$user'" ;
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		if($ligne['id_discord'] == NULL){
			return FALSE;
		} else {
			return ($ligne['id_discord']);
		}	
	}
};

// create a new tournament
function Create_Tournament($Name, $Desc,$nb_player, $Mode, $Image, $Date, $Serv, $Createur) {
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$id = get_last_id_tournament();
	$id ++;
	$requete = "INSERT INTO tournois VALUES ('$id','$Name','$Desc','$nb_player', '$Mode', '$Image','$Serv', '$Date', '$Createur')" ;
	$resultat = $bdd->query($requete);
	return $resultat;
};

// recupere id du dernier tournois
function get_last_id_tournament() {
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$requete = "SELECT id_tournois FROM tournois ORDER BY id_tournois DESC LIMIT 1";
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		$res = $ligne['id_tournois'];		
		$res = intval($res);
	}
	if(!isset($res)){
		$res = 0;
	} 
	return $res;
};

//get the number of player for a specified tournament
function nb_player_tounament($id){
	global $bdd;
	$id = htmlspecialchars($id);
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$requete = "SELECT nombre_player FROM tournois WHERE id_tournois = '$id'";
	$resultat = $bdd->query($requete);
	$ligne = $resultat->fetch_assoc();
	if( $ligne['nombre_player'] > 1 ){
		echo($ligne['nombre_player'] . ' players for this tournament');
	} else {
		echo($ligne['nombre_player'] . ' player for this tournament');
	}
	
};
// recupere l'id du tournois passé dans l'url 
function get_id_url(){
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
    	$url = "https";
	} else {
    	$url = "http";
	}
	$url .= $_SERVER['REQUEST_URI'];
    $components = parse_url($url);
    parse_str($components['query'], $resultat);
	$id = $_GET['id'];
	return $id;
}


// recupere le pseudo passer en parametre dans l'url
function get_user_url(){
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
    	$url = "https";
	} else {
    	$url = "http";
	}
	$url .= $_SERVER['REQUEST_URI'];
    $components = parse_url($url);
    parse_str($components['query'], $resultat);
	$name = $_GET['name'];
return $name;
};


// recupere le nom de l'utilisateur
function User(){
	global $bdd;
	$user = $_SESSION["utilisateur"];
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "SELECT logins FROM Users WHERE `logins` = '$user'" ;
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		echo $ligne['logins'] ;
	}
	return $ligne;
};

// affiche l'email de l'utilisateur
function email(){
	global $bdd;
	$user = $_SESSION["utilisateur"];
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "SELECT mail FROM Users WHERE `logins` = '$user'" ;
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		echo $ligne['mail'] ;
	}
	return $ligne;
};


// affiche le tournois avec l'id du tournois passer en parametre dans l'url
function affiche_tournois_url(){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$id = get_id_url();
	$requete = "SELECT * FROM tournois WHERE id_tournois = $id";
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		echo '<div class="affiche-url">' . '<div class="tournois-url">' . '<div class="title-url">' .  $ligne['nom_tournois'] . ' by ' .  $ligne['createur'] 
		. '<img class="image-lim-url" src= '. $ligne['image'] . '>' . '</div>' . '<br>' .  'Mode : ' . $ligne['mode'] 
		. '<br>' . 'Time : ' . $ligne['time_tournament'] . '<br>' . '<br>' . $ligne['description'] . '<br>' . '<br>' .'Link of the server for the cup : ' . $ligne['link_serv'] . '</a>' . '<br>' . '<br>' . '</div>' . '</div>';
	}
};

// recupere les tournois et les affiches sur la page Home.php
function affiche_tournois(){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "SELECT * FROM tournois ORDER BY time_tournament DESC"; // changer le time dans la creation de la table tournois
	$resultat = $bdd->query($requete);
	return $resultat;
};

// affiche les tournois crées par l'utilisateur
function affiche_tournois_profile() {
	global $bdd;
	$user = $_SESSION["utilisateur"];
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "SELECT * FROM tournois WHERE createur = '$user' ORDER BY id_tournois DESC";
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		echo '<div class="affiche-url">' . '<div class="tournois-url">' . '<div class="title-url">' .  $ligne['nom_tournois'] . ' by ' .  $ligne['createur'] 
		. '<img class="image-lim-url" src= '. $ligne['image'] . '>' . '</div>' . '<br>' .  'Mode : ' . $ligne['mode'] 
		. '<br>' . '<br>' . 'Description : ' . $ligne['description'] . '<br>' . '<br>' . $ligne['link_serv'] . '<br>' . '<br>' .  '</div>' . '</div>';
	}
	return $ligne;
};

// recupere le nom du tournois
function affiche_nom_tournois() {
	global $bdd;
	$user = $_SESSION["utilisateur"];
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "SELECT * FROM tournois WHERE createur = '$user' ORDER BY id_tournois DESC";
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		echo '<div class="affiche-url">' . '<div class="tournois-url">' . '<div class="title-url">' .  $ligne['nom_tournois'] . ' by ' .  $ligne['createur'] 
		. '<img class="image-lim-url" src= '. $ligne['image'] . '>' . '</div>' . '<br>' .  'Mode : ' . $ligne['mode'] 
		. '<br>' . '<br>' . 'Description : ' . $ligne['description'] . '<br>' . '<br>' . $ligne['link_serv'] . '<br>' . '<br>' .  '</div>' . '</div>';
	}
	return $ligne;
};


// verifie si l'utilisateur est un administrateur
function est_admin() {
	global $bdd;
	$user = $_SESSION["utilisateur"];
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "SELECT Administrator FROM `users` WHERE `logins` = '$user'"; 
	$resultat = $bdd->query($requete);
	$ligne = $resultat -> fetch_assoc();
	if ($ligne ['Administrator'] == '1' ) {
		return TRUE;
		}
	return FALSE;
};


// affiche les utilisateurs qui ne sont pas admin
// ajouté une fonction pour verifier si la personne est deja admin ou pas 
function affiche_user_no_admin(){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "SELECT logins, Administrator FROM `users`"; 
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		if ($ligne["Administrator"] != '1') {
		 	echo '<option value=' . $ligne['logins'] . '>' . $ligne['logins'] . '</option>';
	}
}
	return $ligne;
};

// affiche les utlilsiateur qui sont admnistrateur sur le site
function affiche_user_admin(){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "SELECT logins, Administrator FROM `users`"; 
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		if ($ligne["Administrator"] == '1') {
		 	echo '<option value=' . $ligne['logins'] . '>' . $ligne['logins'] . '</option>';
	}
}
	return $ligne;
};

//ajoute un admin
function add_admin($user){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "UPDATE `users` SET `Administrator`='1' WHERE `logins` = '$user'"; 
	$resultat = $bdd->query($requete);
	$_SESSION['add_admin'] = "user has been added as admin";
	return $resultat;
};

//supprime un administrateur
function del_admin($user){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "UPDATE `users` SET `Administrator`='0' WHERE `logins` = '$user'"; 
	$resultat = $bdd->query($requete);
	$_SESSION['del_admin'] = "user has been deleted from admin";
	return $resultat;
};

//verifie le createur du site est bien HawKen pour delete un admin
function est_HawKen(){
	$user = $_SESSION["utilisateur"];
	if ($user === "HawKen"){
		return TRUE;
	} else {
		return FALSE;
	}
};


// ban des joueurs du site web
// rajouter une colonne dans la BDD pour dire si le joueur est banni ou pas
// ou alors creer une table banni pour tous les joueurs qui sont bannis

function ban_player($user){
}

// recupere le dernier id de la table teams
function get_last_id_from_teams(){
	global $bdd;
	$res = 0;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "SELECT id_teams FROM teams ORDER BY id_teams DESC LIMIT 1";
	$resultat = $bdd->query($requete);
	if ($resultat != ''){
		while ($ligne = $resultat->fetch_assoc()) {
	   		$res = $ligne['id_teams'];
		}
	} 
	return $res;
}

// creer une team 
function new_team($name, $image, $Createur,$id){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$requete = "INSERT INTO teams VALUES ('$id' , '$name', '$image', '$Createur')";
	$resultat = $bdd->query($requete);
	return $resultat;
};

// function qui recupere les teams en fonction de l'utilisateurs
function show_teams(){
	global $bdd;
	$teams = [];
	$i = 0;
	$user = $_SESSION['utilisateur'];
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
 	$requete = "SELECT nom_team FROM teams WHERE `createur` = '$user'";
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()){
		$teams[$i] = $ligne['nom_team'];
		$i++;
	}
	return $teams;
}

// function qui verifie si la personne est une admin ou si c'est le createur du tournois
function est_createur_tournois(){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$user = $_SESSION['utilisateur'];
	$id = $_GET['id'];
 	$requete = "SELECT id_tournois, createur FROM tournois WHERE `createur` = '$user' AND `id_tournois` = '$id'";
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		if ($ligne ==''){
			return FALSE;
		}
	}
	if (isset($ligne['createur']) === $user ){
		return TRUE;
	}
}

// fonction qui supprime un tournois 
function del_tournament($id_tournois){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
 	$requete = "DELETE FROM tournois WHERE `id_tournois` = '$id_tournois'";
	$resultat = $bdd->query($requete);
	return $resultat;
}

// affiche les equipes auxquels appartiens le joueur
function affiche_team_joueur(){
	global $bdd;
	$ligne = "";
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$user = $_SESSION['utilisateur'];
	$requete = "SELECT
    	login_player,
    	team_name,
    	nom_team,
    	images
		FROM
    	player_teams
	INNER JOIN teams ON player_teams.team_name = teams.nom_team";
	$resultat = $bdd->query($requete);
	if ($resultat != null){
		while ($ligne = $resultat->fetch_assoc()) {
			if ($ligne !='' && $ligne['login_player'] === $user){
				echo ( '<a href=team.php?name_team=' . $ligne['nom_team'] . '&amp;name=' . $user .'>' . $ligne['nom_team'] . '<br>' 
				. '<br>' . '<img src=' .  $ligne['images'] . '>' . '</a>' . '<br>' .   '<br>'. '<br>');
			}
		}
	}
	//return $ligne;
}

// affiche la team selectionné
function affiche_team(){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
   	$bdd->set_charset("utf8");
	$nom_team = htmlspecialchars($_GET['name_team']);
	$requete = "SELECT * FROM `teams` WHERE `nom_team` = '$nom_team'";
	$resultat = $bdd->query($requete);
	if ($resultat != null){
		while ($ligne = $resultat->fetch_assoc()) {
			echo ( $ligne['nom_team'] . '<br>' . $ligne['createur'] . '<br>' .
			'<br>' . '<img src=' .  $ligne['images'] . '>'. '<br>' .  '<br>');
		}
		return $ligne;
	}
}

//recupere les joueurs d'une equipe avec id passe dans l'url
function affiche_joueur_team(){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$nom_team = htmlspecialchars($_GET['name_team']);
	$requete = "SELECT `login_player` FROM `player_teams` WHERE `team_name` = '$nom_team'";
	$resultat = $bdd->query($requete);
	while ($ligne = $resultat->fetch_assoc()) {
		echo ( $ligne['login_player'] . '<br>');
	}
	return $resultat;
}

//ajoute un joueur dans une team et le createur quand il cree la team
function ajoute_joueur($user,$id){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$requete = "INSERT INTO player_teams VALUES ('$user','$id')";
	$resultat = $bdd->query($requete);
	return $resultat;
}

//fonction qui creer le lien pour ajouter des joueurs a sa team
function create_url_team(){
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
    	$url = "https";
	} else {
    	$url = "http";
	}
	$url .= $_SERVER['REQUEST_URI'];
    $components = parse_url($url);
    parse_str($components['query'], $resultat);
	$salt = '1&°(çé=';
	$user = htmlspecialchars($_GET['name']);
	$name_team = htmlspecialchars($_GET['name_team']);
	$invite = md5($user . $salt);
	$day = date('d');
	$year = date('Y');
	$end = md5($user . $day . $year);
	//$link = $components['path'] . '?id_team=' . $id .  '&name=' . $user . '&invite=' . $invite . '&limit=' . $end; a voir si ca marche quand le site sera en ligne
	$link = '?name_team=' . $name_team .  '&name=' . $user . '&invite=' . $invite . '&limit=' . $end ;
	return $link;
}

////////////////////////////////////////////////////////////////////////////
/////////////////// function for the database tournament ///////////////////
////////////////////////////////////////////////////////////////////////////


// get the name of the tournamant thanks to the id
function get_name_tournament($id){
	global $bdd;
	global $database_shootmania;
	mysqli_select_db($bdd, $database_shootmania);
	$bdd->set_charset("utf8");
	$requete = "SELECT nom_tournois FROM tournois WHERE `id_tournois` = $id";
	$resultat = $bdd->query($requete);
	$ligne = $resultat -> fetch_assoc();
	if($ligne != null){
		$name = $ligne['nom_tournois'];
	}
	//gestion erreur a faire
	if(isset($name)){
		$name = str_replace(' ', '_',$name);
		return $name;
	}
	return $ligne;
}

//get all the time registered for the tournament
//return teams name or false
function check_team_register_tournament ($id_tournament){
	global $bdd;
	global $database_tournament;
	$name = get_name_tournament($id_tournament);
	$name = str_replace(str_split('# :/;.,?&~"{(-|è`_\'ç^à@)]°=+}*µ$£¨ù%§<>%ù'), '_', $name);
	mysqli_select_db($bdd, $database_tournament);
	$bdd->set_charset("utf8");
	$requete = "SELECT team FROM $name ";
	$resultat = $bdd->query($requete);
	if($resultat){
		$ligne = $resultat->fetch_assoc();
		return $ligne;
	} else {
	return false; 
	}
}

//compare and return the team that are not registered
function team_registered($id_tournament){
	$check = check_team_register_tournament ($id_tournament); //get every team registered for the tournament
    $teams = show_teams();
    $teams = [];
    if($check != false){
        foreach ($check as $team){
            $teams[] = $team;
        }
    }
    return $teams;
}

//print the team in the select
function print_teams($id_tournament){
	$reg_team = team_registered($id_tournament);
	$teams = show_teams();
	$is_registered = False;
	for ($i = 0; $i < count($teams); $i++){
		for ($j = 0; $j < count($reg_team); $j++){
			if($teams[$i] == $reg_team[$j]){
				$is_registered = true;
			}
		}
		if(!$is_registered){
			echo '<option value=' . $teams[$i] . '>' .$teams[$i] . '</option>';
			
		}
		$is_registered = false;
	}
}


//get the name of the team for a specific tournament -> ici l'id du tournois

//print every team that is participating in the tournament
function print_team_signed_up($id_tournament){
	global $bdd;
	global $database_tournament;
	$name = get_name_tournament($id_tournament);
	$name = str_replace(str_split('# :/;.,?&~"{(-|è`_\'ç^à@)]°=+}*µ$£¨ù%§<>%ù'), '_', $name);
	mysqli_select_db($bdd, $database_tournament);
	$bdd->set_charset("utf8");
	$requete = "SELECT team FROM $name";
	$resultat = $bdd->query($requete);
	$ligne = $resultat -> fetch_assoc();
	return $ligne;
}


// get the month and return the month by the name of the month
// ex 01 -> return january
/*
function transform_date($month){
	switch ($month) {
		case 01:
			$month = "january";
			break;
		case 02:
			$month = "february";
			break;
		case 03:
			$month = "march";
			break;
		case 04:
			$month = "april";
			break;
		case 05:
			$month = "may";
			break;
		case 06:
			$month = "june";
			break;
		case 07:
			$month = "jully";
			break;
		case 08:
			$month = "august";
			break;
		case 09:
			$month = "september";
			break;
		case 10:
			$month = "october";
			break;
		case 11:
			$month = "november";
			break;
		case 12:
			$month = "december";
			break;
	}
	return $month;
}*/
